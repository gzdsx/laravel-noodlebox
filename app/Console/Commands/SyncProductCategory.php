<?php

namespace App\Console\Commands;

use App\Models\Category;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class SyncProductCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

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
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $client = new Client();
            $response = $client->get('https://noodlebox.ie/wp-json/wc/v3/products/categories', [
                'query' => [
                    'page' => 1,
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

            $items = json_decode($response->getBody()->getContents(), true);
            foreach ($items as $item) {
                $category = new Category();
                $category->id = $item['id'] ?? 0;
                $category->name = $item['name'] ?? '';
                $category->slug = $item['slug'] ?? '';
                $category->parent_id = $item['parent'] ?? 0;
                $category->description = $item['description'] ?? '';
                $category->sort_num = $item['menu_order'] ?? 0;
                $category->image = $item['image']['src'] ?? '';
                $category->taxonomy = 'product';
                $category->save();
            }

            echo count($items);
        } catch (\GuzzleHttp\Exception\GuzzleException $exception) {
            echo $exception->getMessage();
        }
        return 0;
    }
}
