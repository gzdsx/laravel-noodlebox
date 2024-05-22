<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncProductSku implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $product_data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($product_data)
    {
        $this->product_data = $product_data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $metas = array_filter($this->product_data['meta_data'], function ($m) {
                return $m['key'] == 'tm_meta';
            });
            $metas = array_values($metas);
            if (count($metas) > 0) {
                $meta = $metas[0];
                if ($meta['value'] && $meta['value']['tmfbuilder']) {
                    $product_variations = [];
                    $builder = $meta['value']['tmfbuilder'];
                    foreach ($builder['element_type'] as $k => $element) {
                        if ($element == 'selectbox') {
                            $name = $builder['selectbox_header_title'][$k];
                            $variation = ProductVariation::query()->firstOrCreate(['name' => $name]);
                            $defaultVal = $builder['multiple_selectbox_options_default_value'][$k];
                            $variation_options = [];
                            foreach ($builder['multiple_selectbox_options_title'][$k] as $m => $title) {
                                $price = $builder['multiple_selectbox_options_price'][$k][$m];
                                $option = $variation->options()->updateOrCreate(['title' => $title], ['price' => $price]);
                                $variation_options[] = [
                                    'id' => $option->id,
                                    'title' => $title,
                                    'price' => $price,
                                    'selected' => $defaultVal == $m
                                ];
                            }

                            $product_variations[] = [
                                'name' => $name,
                                'multiple' => false,
                                'options' => $variation_options
                            ];
                        }

                        if ($element == 'radiobuttons') {
                            $name = $builder['radiobuttons_header_title'][$k];
                            $variation = ProductVariation::query()->firstOrCreate(['name' => $name]);
                            $defaultVal = $builder['multiple_radiobuttons_options_default_value'][$k];

                            $variation_options = [];
                            foreach ($builder['multiple_radiobuttons_options_title'][$k] as $m => $title) {
                                $price = $builder['multiple_radiobuttons_options_price'][$k][$m];
                                $option = $variation->options()->updateOrCreate(['title' => $title, 'price' => $price]);
                                $variation_options[] = [
                                    'id' => $option->id,
                                    'title' => $title,
                                    'price' => $price,
                                    'selected' => $defaultVal == $m
                                ];
                            }

                            $product_variations[] = [
                                'name' => $name,
                                'multiple' => false,
                                'options' => $variation_options
                            ];
                        }

                        if ($element == 'checkboxes') {
                            $name = 'With';
                            $defaultVal = $builder['multiple_checkboxes_options_default_value'][$k];
                            $variation_options = [];
                            foreach ($builder['multiple_checkboxes_options_title'][$k] as $m => $title) {
                                $price = $builder['multiple_checkboxes_options_price'][$k][$m];
                                $variation_options[] = [
                                    'id' => 0,
                                    'title' => $title,
                                    'price' => $price,
                                    'selected' => $defaultVal[$m] !== ''
                                ];
                            }

                            $product_variations[] = [
                                'name' => $name,
                                'multiple' => true,
                                'options' => $variation_options
                            ];
                        }
                    }

                    $product = Product::query()->find($this->product_data['id']);
                    $product->variation_list = $product_variations;
                    $product->save();
                }
            }

        } catch (\Exception $exception) {

        }
    }
}
