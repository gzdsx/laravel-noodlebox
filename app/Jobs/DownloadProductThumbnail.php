<?php

namespace App\Jobs;

use App\Models\ProductImage;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class DownloadProductThumbnail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $image;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ProductImage $image)
    {
        $this->image = $image;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (preg_match('/noodlebox\.ie/is', $this->image->image)) {
            try {
                $client = new Client();
                $response = $client->get($this->image->image, [
                    'headers' => [
                        'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36 Edg/121.0.0.0',
                        'Accept' => 'application/json'
                    ],
                ]);

                $filename = str_replace('https://noodlebox.ie/wp-content/uploads', 'image', $this->image->image);
                Storage::put($filename, $response->getBody()->getContents());

                $this->image->image = $filename;
                $this->image->thumb = $filename;
                $this->image->save();
                return;

            } catch (\Exception $exception) {
                echo $exception->getMessage();
            }
        }
    }
}
