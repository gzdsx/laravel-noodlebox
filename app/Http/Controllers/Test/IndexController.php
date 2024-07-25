<?php

namespace App\Http\Controllers\Test;

use App\Jobs\DownloadProductImage;
use App\Jobs\SyncNoodleUser;
use App\Jobs\SyncUsers;
use App\Models\Category;
use App\Models\Product;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    public function index(Request $request)
    {

        return mix_asset('/dist/home/index.css');
    }

    function generateCombinations($options)
    {
        $result = []; // 存放结果的数组

        if (count($options) == 1) {
            foreach ($options[0] as $optionValue) {
                array_push($result, [$optionValue]);
            }

            return $result;
        } else {
            $subOptions = array_slice($options, 1);
            $combinations = $this->generateCombinations($subOptions);

            foreach ($options[0] as $optionValue) {
                foreach ($combinations as &$combination) {
                    array_unshift($combination, $optionValue);

                    array_push($result, $combination);
                }

                unset($combination);
            }

            return $result;
        }
    }

    public function chatapp()
    {
        $platform = '';
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') || strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')) {
            $platform = 'ios';
        } else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) {
            if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')) {
                $platform = 'weixin';
            } else {
                return redirect()->to('https://cugeng.cn/apk/lastest.apk');
            }
        } else {
            return '<h3 style="text-align: center;">请用手机扫码打开此链接</h3>';
        }

        $this->assign(['platform' => $platform]);
        return $this->view('home.app');
    }

    public function table(Request $request)
    {
        $table = $request->input('t');
        return str_replace('"', "'", json_encode(Schema::getColumnListing($table)));
    }
}
