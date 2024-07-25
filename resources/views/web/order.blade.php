@extends('layouts.default')

@section('title', '订单详情')
@section('body-class','order-detail')

@section('content')
    <section class="page-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col col-md-10">
                    <p class="text-center text-safety-orange">
                        Order #{{$order->order_no}} was placed on {{$order->created_at->format('d/m/Y')}} and is
                        currently {{$order->status}}.
                    </p>
                    <h3>Order details</h3>
                    <div class="order-products">
                        <div class="order-product order-product-header">
                            <div class="order-product__title">Product</div>
                            <div class="order-product__price">Price</div>
                        </div>
                        @foreach($order->items as $item)
                            <div class="order-product">
                                <img src="{{$item->image}}" class="order-product__thumb" alt="">
                                <div class="order-product__title">
                                    <div class="title">{{ $item->title }}</div>
                                    @if(!empty($item->meta_data['options']))
                                        <small class="text-safety-orange">
                                            {{implode(',',array_values($item->meta_data['options']))}}
                                        </small>
                                    @endif
                                </div>
                                <div class="order-product__price">
                                    <strong class="text-turquoise">€{{$item->price}}</strong>
                                    <span class="text-safety-orange">x{{$item->quantity}}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="order-totals">
                        <div class="order-total">
                            <div class="order-total__label">Subtotal</div>
                            <div class="order-total__value">€{{$order->subtotal}}</div>
                        </div>
                        <div class="order-total">
                            <div class="order-total__label">Shipping</div>
                            <div class="order-total__value">+€{{$order->shipping_total}}</div>
                        </div>
                        @foreach($order->fee_lines as $fee)
                            <div class="order-total">
                                <div class="order-total__label">{{$fee['name']??''}}</div>
                                <div class="order-total__value">+€{{$fee['total']??''}}</div>
                            </div>
                        @endforeach
                        @foreach($order->discount_lines as $discount)
                            <div class="order-total">
                                <div class="order-total__label">{{$discount['name']??''}}</div>
                                <div class="order-total__value">-€{{$discount['total']??''}}</div>
                            </div>
                        @endforeach
                        <div class="order-total">
                            <div class="order-total__label">Total</div>
                            <div class="order-total__value">€{{$order->total}}</div>
                        </div>
                    </div>
                    <div class="blank-2"></div>
                    <h3>Shipping Address</h3>
                    <div class="order-shipping">
                        <div>{{$order->shipping['first_name'] ?? ''}}</div>
                        @isset($order->shipping['phone_number'])
                            <div>
                                <span>+{{$order->shipping['national_number'] ?? ''}}</span>
                                <span>{{$order->shipping['phone_number'] ?? ''}}</span>
                            </div>
                        @endisset
                        <div>
                            {{$order->shipping['formatted_address'] ?? ''}}
                        </div>
                        @isset($order->shipping['postal_code'])
                            <div>
                                {{$order->shipping['postal_code'] ?? ''}}
                            </div>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection