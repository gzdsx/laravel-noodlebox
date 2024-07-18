<?php

namespace App\Http\Controllers\Api\User;

use App\Models\UserPhone;
use App\Traits\RestApis\UserAddressApis;
use App\Http\Controllers\Api\BaseController;

class AddressController extends BaseController
{
    use UserAddressApis;

    public function myaddress()
    {
        $user = auth()->user();
        $default_address = [
            'first_name' => $user->nickname,
            'last_name' => '',
            'phone' => [
                'national_number' => $user->national_number,
                'phone_number' => $user->phone_number,
                'verified' => !empty($user->phone_number)
            ],
            'address_line_1' => '',
            'address_line_2' => '',
            'city' => '',
            'state' => '',
            'country' => '',
            'postal_code' => '',
        ];
        $billing = $user->getMeta('billing_address');
        $shipping = $user->getMeta('shipping_address');

        if (is_array($shipping)) {
            if (isset($shipping['phone'])) {
                if (is_array($shipping['phone'])) {
                    $national_number = $shipping['phone']['national_number'] ?? '';
                    $phone_number = $shipping['phone']['phone_number'] ?? $user->phone_number;
                    if ($national_number && $phone_number) {
                        $verified = UserPhone::where([
                            'national_number' => $national_number,
                            'phone_number' => $phone_number,
                        ])->exists();
                    } else {
                        $verified = false;
                    }
                    $phone = [
                        'national_number' => $national_number,
                        'phone_number' => $phone_number,
                        'verified' => $verified
                    ];
                } else {
                    $phone = [
                        'national_number' => '',
                        'phone_number' => $shipping['phone'],
                        'verified' => false
                    ];
                }
            } else {
                $phone = $default_address['phone'];
            }

            $shipping_address = [
                'first_name' => $shipping['first_name'] ?? '',
                'last_name' => $shipping['last_name'] ?? '',
                'phone' => $phone,
                'address_line_1' => $shipping['address_line_1'] ?? '',
                'address_line_2' => $shipping['address_line_2'] ?? '',
                'city' => $shipping['city'] ?? '',
                'state' => $shipping['state'] ?? '',
                'country' => $shipping['country'] ?? '',
                'postal_code' => $shipping['postal_code'] ?? ($shipping['postalcode'] ?? ''),
            ];
        } else {
            $shipping_address = $default_address;
        }

        return json_success([
            'shipping' => $shipping_address,
            'billing' => $shipping_address
        ]);
    }
}
