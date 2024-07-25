<?php

namespace App\Http\Requests;

use App\Models\Order;
use App\Models\ShippingZone;
use App\Models\UserPhone;
use Illuminate\Foundation\Http\FormRequest;

class OrderCreateRequest extends FormRequest
{
    public $order;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'shipping.first_name' => 'required',
            'shipping.national_number' => 'required',
            'shipping.phone_number' => 'required',
            'shipping_method' => 'required',
            'payment_method' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'shipping.first_name.required' => 'Contact name is required',
            'shipping.phone_number.required' => 'Phone number is required',
            'shipping_method.required' => 'Shipping method is required',
            'payment_method.required' => 'Payment method is required',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $errors = $validator->errors();
            $phone_number = $this->input('shipping.phone_number');
            $national_number = $this->input('shipping.national_number');
            if (!UserPhone::checkPhoneNumber($this->user()->id, $phone_number, $national_number)) {
                $errors->add('shipping.phone_number.verified', 'Phone number not verified');
            }

            $shipping_method  = $this->input('shipping_method');
            if ($shipping_method == Order::SHIPPING_METHOD_FLATRATE){
                $fotmatted_address = $this->input('shipping.formatted_address');
                if (!$fotmatted_address){
                    $errors->add('shipping.formatted_address.required', 'Shipping address is required');
                }

                $zone = ShippingZone::findOrNew($this->input('shipping_zone_id'));
                if (stripos($fotmatted_address, $zone->title) === false) {
                    $errors->add('shipping.formatted_address.invalid', 'The address is not within the delivery range');
                }
            }

            $use_points_value = $this->input('use_points_value', 0);
            if ($use_points_value > $this->user()->points){
                $errors->add('use_points_value.invalid', 'Insufficient points');
            }
        });
    }
}
