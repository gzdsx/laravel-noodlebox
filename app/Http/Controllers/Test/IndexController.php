<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Jobs\SyncUsers;
use App\Models\UserAddress;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        //$this->dispatchSync(new SyncUsers(1));
//        $i = 2;
//        while ($i < 150) {
//            $this->dispatch(new SyncUsers($i));
//            $i++;
//        }
//
//        return 'ok';

//        try {
//            $client = new Client();
//            $response = $client->get('https://noodlebox.ie/wp-json/wp/v2/users', [
//                'query' => [
//                    'page' => 1,
//                    'per_page' => 100,
//                    'orderby' => 'id',
//                    'order' => 'asc',
//                ],
//                //'auth' => [env('WC_CONSUMER_KEY'), env('WC_CONSUMER_SECRET')],
//                'headers' => [
//                    'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36 Edg/121.0.0.0',
//                    'Accept' => 'application/json'
//                ],
//            ]);
//
//            $users = json_decode($response->getBody()->getContents());
//
//            return $users;
//        }catch (\Exception $e){
//            return $e->getMessage();
//        }

//        foreach (UserAddress::with(['user'])->get() as $item) {
//            if ($item->user && !$item->user->phone && $item->phone) {
//                $item->user->phone = $item->phone;
//                $item->user->save();
//            }
//        }
//
//        return 'ok';

        return Str::uuid()->toString();
    }

    public function combineAttrs($arr)
    {

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
