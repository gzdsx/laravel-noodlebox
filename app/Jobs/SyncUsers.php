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
                $newuser = new User();
                $newuser->id = $user->id;
                $newuser->email = $user->email;
                $newuser->nickname = $user->first_name . $user->username;
                $newuser->avatar = $user->avatar_url;
                $newuser->created_at = $user->date_created;
                $newuser->updated_at = $user->date_modified;
                $newuser->gid = 1;
                $newuser->save();

                $address = $newuser->addresses()->make();
                $address->name = $user->billing->first_name;
                $address->phone = $user->billing->phone;
                $address->country = $user->billing->country;
                $address->state = $user->billing->state;
                $address->city = $user->billing->city;
                $address->address = $user->billing->address_1;
                $address->save();
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
