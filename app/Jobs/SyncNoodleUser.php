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

class SyncNoodleUser implements ShouldQueue
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
            $response = $client->get('https://noodlebox.ie/wp-json/noodlebox/users', [
                'query' => [
                    'page' => $this->page,
                ],
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36 Edg/121.0.0.0',
                    'Accept' => 'application/json'
                ],
            ]);

            $users = json_decode($response->getBody()->getContents());
            foreach ($users as $user) {
                $newuser = User::findOrNew($user->ID);
                $newuser->id = $user->ID;
                $newuser->email = $user->data->user_email;
                $newuser->nickname = $user->data->display_name;
                $newuser->password = $user->data->user_pass;
                $newuser->created_at = $user->data->user_registered;
                $newuser->updated_at = $user->data->user_registered;
                $newuser->gid = 1;
                $newuser->save();
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
