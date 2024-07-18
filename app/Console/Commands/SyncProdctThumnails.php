<?php

namespace App\Console\Commands;

use App\Jobs\DownloadProductThumbnail;
use App\Models\ProductImage;
use Illuminate\Console\Command;

class SyncProdctThumnails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync-product-thumbnails';

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
        foreach (ProductImage::where('image', 'like', '%noodlebox.ie%')->get() as $item) {
            dispatch(new DownloadProductThumbnail($item));
        }
        return 0;
    }
}
