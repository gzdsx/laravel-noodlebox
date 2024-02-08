<?php

namespace App\Console\Commands;

use App\Jobs\SyncProductSku;
use App\Models\Product;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class SyncProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return mixed|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        try {
            $client = new Client();
            $response = $client->get('https://noodlebox.ie/wp-json/wc/v3/products', [
                'query' => [
                    'page' => 3,
                    'per_page' => 100,
                    'orderby' => 'id',
                    'order' => 'asc',
                ],
                'auth' => [env('WC_CONSUMER_KEY'), env('WC_CONSUMER_SECRET')],
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36 Edg/121.0.0.0',
                    'Accept' => 'application/json'
                ],
                'proxy' => 'socks5://127.0.0.1:1089'
            ]);

            $statusMap = [
                'publish' => 'onsale',
                'draft' => 'draft',
                'trash' => 'delisted',
                'pending' => 'delisted',
                'private' => 'delisted'
            ];

            $items = json_decode($response->getBody()->getContents(), true);
            foreach ($items as $item) {
                $product = new Product();
                $product->id = $item['id'] ?? 0;
                $product->title = $item['name'] ?? '';
                $product->slug = $item['slug'] ?? '';
                $product->status = $statusMap[$item['status']] ?? 'draft';
                $product->price = $item['price'] ?? 0;
                $product->regular_price = $item['regular_price'] ?? 0;
                $product->sold = $item['total_sales'];
                $product->tax_status = $item['tax_status'];
                $product->image = $item['images'][0]['src'] ?? '';
                $product->stock = $item['stock_quantity'] ?? 1000;
                $product->created_at = $item['date_created'] ?? now();
                $product->updated_at = $item['date_modified'] ?? now();
                $product->user_id = 1000000;
                $product->save();

                $product->content->update(['content' => $item['short_description'] ?? '']);

                foreach ($item['images'] as $k => $image) {
                    $product->images()->create([
                        'thumb' => $image['src'] ?? '',
                        'image' => $image['src'] ?? '',
                        'sort_num' => $k
                    ]);
                }

                if (isset($item['categories'])) {
                    $product->categories()->sync(array_column($item['categories'], 'id'));
                }

                dispatch(new SyncProductSku($item));
            }

            echo count($items);
        } catch (\GuzzleHttp\Exception\GuzzleException $exception) {
            echo $exception->getMessage();
        }

        return 0;
    }
}
