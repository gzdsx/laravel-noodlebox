<?php

namespace App\Traits\RestApis;

use App\Models\Material;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

trait MaterialApis
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|Builder|Material
     */
    protected function repository()
    {
        return Auth::user()->materials();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function upload(Request $request)
    {
        if (!$file = $request->file('file')) {
            return $this->uploadFail($request);
        }

        $ext = strtolower($file->getClientOriginalExtension());
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
            $material = $this->storeImage($request, $file);
        } else {
            $material = $this->storeFile($request, $file);
        }

        return $this->uploadSuccess($request, $material);
    }

    /**
     * @param Request $request
     * @param UploadedFile $file
     * @return Material|Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\HasMany
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function storeImage(Request $request, UploadedFile $file)
    {
        $material = $this->repository()->make();
        $material->type = 'image';
        $material->name = $file->getClientOriginalName();
        $material->extension = $file->getClientOriginalExtension();
        $material->mime = $file->getMimeType();

        $image = Image::make($file->getRealPath());
        if ($image->exif('Orientation')) {
            switch ($image->exif('Orientation')) {
                case 8:
                    $image->rotate(90);
                    break;
                case 3:
                    $image->rotate(180);
                    break;
                case 6:
                    $image->rotate(-90);
                    break;
            }
        }

        //大图
        $hashName = Str::random(40);
        $filePath = 'image/' . date('Y') . '/' . date('m');
        Storage::makeDirectory($filePath);
        $maxWidth = $request->input('width', intval(settings('image_max_width')));

        if ($request->input('fit')) {
            $width = min($maxWidth, $image->width(), $image->height());
            if ($request->has('height')) {
                $height = min($image->height(), $request->input('height', 0));
            } else {
                $height = null;
            }

            $image->fit($width, $height);
        } else {
            if ($image->width() > $maxWidth) {
                $image->resize($maxWidth, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
        }

        //缩略图
        $thumb = clone $image;
        $thumbWidth = intval(settings('image_thumb_width'));
        if ($image->width() > $thumbWidth) {
            $thumb->resize($thumbWidth, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }
        $thumbName = $hashName . '_' . $thumb->width() . 'x' . $thumb->height() . '.' . $file->getClientOriginalExtension();
        $thumb->save(material_path($filePath . '/' . $thumbName), 80);

        //添加水印
        if (settings('water_mark') == '1') {
            $width = $image->width();
            $height = $image->height();
            $x = intval(settings('water_offset_x'));
            $y = intval(settings('water_offset_y'));
            if (settings('water_type') == '1') {
                $water = Image::make(base_path(settings('water_image')));
                $image->insert($water, settings('water_pos'), $x, $y);
            } else {
                $text = settings('water_text');
                $fontSize = intval(settings('water_size'));
                $textWidth = $fontSize * mb_strlen($text);
                switch (settings('water_pos')) {
                    case 'top-left':
                        $tx = $x;
                        $ty = $y;
                        break;
                    case 'top-center':
                        $tx = $width / 2 + $x;
                        $ty = $y;
                        break;
                    case 'top-right':
                        $tx = $width - $textWidth;
                        $ty = $y;
                        break;
                    case 'left':
                        $tx = $x;
                        $ty = ($height - $fontSize) / 2 + $y;
                        break;
                    case 'center':
                        $tx = ($width - $textWidth) / 2 + $x;
                        $ty = ($height - $fontSize) / 2 + $y;
                        break;
                    case 'right':
                        $tx = ($width - $textWidth) + $x;
                        $ty = ($height - $fontSize) / 2 + $y;
                        break;
                    case 'bottom-left':
                        $tx = $x;
                        $ty = ($height - $fontSize) + $y;
                        break;
                    case 'bottom-center':
                        $tx = ($width - $textWidth) / 2 + $x;
                        $ty = ($height - $fontSize) + $y;
                        break;
                    case 'bottom-right':
                        $tx = ($width - $textWidth) + $x;
                        $ty = ($height - $fontSize) + $y;
                        break;
                    default:
                        $tx = $x;
                        $ty = $y;
                }
                $image->text($text, $tx, $ty, function ($font) {
                    $font->file(base_path(settings('water_font')));
                    $font->size(intval(settings('water_size')));
                    $font->color(settings('water_color'));
                    $font->align('left');
                    $font->valign('top');
                });
            }
        }

        $imageName = $hashName . '.' . $file->getClientOriginalExtension();
        $image->save(material_path($filePath . '/' . $imageName), 80);
        $material->size = $image->filesize();
        $material->width = $image->width();
        $material->height = $image->height();
        $material->thumb = $filePath . '/' . $thumbName;
        $material->url = $filePath . '/' . $imageName;
        $material->save();

        return $material;
    }

    /**
     * @param Request $request
     * @param UploadedFile $file
     * @return Material|Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function storeFile(Request $request, UploadedFile $file)
    {
        $material = $this->repository()->make([
            'extension' => $file->getClientOriginalExtension(),
            'size' => $file->getSize(),
            'name' => $file->getClientOriginalName(),
            'mime' => $file->getMimeType(),
        ]);

        $extension = $file->getClientOriginalExtension();
        if (in_array($extension, ['jpg', 'jpeg', 'gif', 'png', 'bmp'])) {
            $material->type = 'image';
        } elseif (in_array($extension, ['mp4', 'mpeg', 'mpg', 'rmvb', 'rm', 'avi', 'wmv', 'mov'])) {
            $material->type = 'video';
        } elseif (in_array($extension, ['mp3', 'midi', 'wav'])) {
            $material->type = 'voice';
        } elseif (in_array($extension, ['doc', 'ppt', 'xls', 'docx', 'pptx', 'xlsx', 'pdf', 'txt'])) {
            $material->type = 'doc';
        } else {
            $material->type = 'file';
        }

        $sourcePath = $material->type . '/' . date('Y') . '/' . date('m');
        Storage::makeDirectory($sourcePath);
        $material->url = $file->store($sourcePath);
        $material->save();

        return $material;
    }

    /**
     * @param Request $request
     * @param $material
     * @return JsonResponse
     */
    protected function uploadSuccess(Request $request, $material)
    {
        return json_success($material);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function uploadFail(Request $request)
    {
        return json_fail('material upload fail');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = $this->repository()->filter($request->all());
        return json_success([
            'total' => $query->count(),
            'items' => $query->offset($request->input('offset', 0))
                ->limit($request->input('limit', 10))
                ->orderByDesc('id')->get()
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $material = $this->repository()->findOrFail($id);
        return json_success($material);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        if ($model = $this->repository()->find($id)) {
            $model->delete();
        }

        return json_success();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchDestroy(Request $request)
    {
        $this->repository()->whereKey($request->input('ids', []))->get()->each->delete();
        return $this->deletedSuccess($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function deletedSuccess(Request $request)
    {
        return json_success();
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $model = $this->repository()->findOrNew($id);
        $model->fill($request->input('material', []))->save();

        return json_success($model);
    }

    /**
     * @return JsonResponse
     */
    public function types()
    {
        return json_success(trans('material.types'));
    }
}