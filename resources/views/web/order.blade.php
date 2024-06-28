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
                                    <span>x{{$item->quantity}}</span>
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
                            <div class="order-total__value">€{{$order->shipping_total}}</div>
                        </div>
                        @foreach($order->fee_lines as $fee)
                            <div class="order-total">
                                <div class="order-total__label">{{$fee['name']??''}}</div>
                                <div class="order-total__value">€{{$fee['total']??''}}</div>
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
                        <div>
                            {{$order->shipping['address_line_1'] ?? ''}}
                        </div>
                        @if(isset($order->shipping['city']))
                            <div>
                                {{$order->shipping['city'] ?? ''}}
                            </div>
                        @endif
                        @if(isset($order->shipping['state']))
                            <div>
                                {{$order->shipping['state'] ?? ''}}
                            </div>
                        @endif
                        @if(isset($order->shipping['postalcode']))
                            <div>
                                {{$order->shipping['postalcode'] ?? ''}}
                            </div>
                        @endif
                        @if(is_array($order->shipping['phone']))
                            <div>
                                <i class="bi bi-telephone"></i>
                                <span>+{{$order->shipping['phone']['national_number'] ?? ''}}</span>
                                <span>{{$order->shipping['phone']['phone_number'] ?? ''}}</span>
                            </div>
                        @else
                            <div>
                                <i class="bi bi-telephone"></i>
                                {{$order->shipping['phone'] ?? ''}}
                            </div>
                        @endif
                        @if(isset($order->shipping['email']))
                            <div>
                                <i class="bi bi-envelope"></i>
                                {{$order->shipping['email'] ?? ''}}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection