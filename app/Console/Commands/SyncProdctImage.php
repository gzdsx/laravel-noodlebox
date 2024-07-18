<?php

namespace App\Console\Commands;

use App\Jobs\DownloadProductImage;
use App\Models\Product;
use Illuminate\Console\Command;

class SyncProdctImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync-product-image';

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
        foreach (Product::where('image', 'like', '%noodlebox.ie%')->get() as $product) {
            dispatch(new DownloadProductImage($product));
        }
        return 0;
    }
}
