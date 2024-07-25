<?php

namespace App\Jobs;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $page;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($page)
    {
        $this->page = $page;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $client = new Client();
            $response = $client->get('https://noodlebox.ie/wp-json/wc/v3/customers', [
                'query' => [
                    'page' => $this->page,
                    'per_page' => 100,
                    'orderby' => 'id',
                    'order' => 'asc',
                ],
                'auth' => [env('WC_CONSUMER_KEY'), env('WC_CONSUMER_SECRET')],
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36 Edg/121.0.0.0',
                    'Accept' => 'application/json'
                ],
            ]);

            $users = json_decode($response->getBody()->getContents());
            foreach ($users as $user) {
                $newuser = User::find($user->id);
                if ($newuser) {
                    $address = [
                        'first_name' => $user->billing->first_name,
                        'phone_number' => $user->billing->phone,
                        'country' => $user->billing->country,
                        'state' => $user->billing->state,
                        'city' => $user->billing->city,
                        'address_line_1' => $user->billing->address_1,
                        'formatted_address' => $user->billing->address_1 . ', ' . $user->billing->city
                            . ', ' . $user->billing->state . ', ' . $user->billing->country . ', ' . $user->billing->postcode
                    ];

                    $newuser->updateMeta('shipping_address', $address);
                    $newuser->updateMeta('billing_address', $address);

                    $metas = collect($user->meta_data)->pluck('value', 'key');
                    $newuser->points = $metas->get('wps_wpr_points',0);
                    $newuser->save();
                }
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
