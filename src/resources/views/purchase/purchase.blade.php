@extends('layouts.app')

@section('css')
<link rel="stylesheet" href=" {{ asset('css/purchase.css') }}">
@endsection

@section('content')
    <div class="purchase-container">
        <div class="purchase-left">
            <div class="purchase-product">
                <div class="purchase-product__image"  style="background-image: url('{{ old('image_path') }}')">
                    <img src="" alt="">
                </div>
                <div class="purchase-detail">
                    <h3>{{$product->name}}</h3>
                    <span>&yen;{{$product->price}}</span>
                </div>
            </div>
            <div class="purchase-section">
                <label class="purchase-section__label" for="payment">支払方法</label>  
                <div class="purchase-section__select-inner">       
                    <select class="purchase-section__select" name="payment" id="payment">          
                        <option disabled selected>選択してください</option>
                        <option value="convenience">コンビニ払い</option>
                        <option value="credit">カード支払い</option>
                    </select>
                </div>
            </div>
            <div class="purchase-section">
                <div class="purchase-address__header">
                    <span class="purchase-address__label" for="address">配送先</span>
                    <a class="purchase-address__label-edit" href="{{ url('purchase/address/' . $product->id) }}" >変更する</a>
                </div>          
                <div class="purchase-address__list">
                    <span class="purchase-address__list-postcode">〒</span>
                    <span class="purchase-address__list-address"></span>
                </div>
            </div>
        </div>
            
        <div class="purchase-right">
            <div class="purchase-summary__list">
                <div class="purchase-summary__item">
                    <span>商品代金</span>
                    <span>&yen;{{$product->price}}</span>
                </div>
                <div class="purchase-summary__payment">
                    <span>支払い方法</span>
                    <span>コンビニ支払い</span>
                </div>
            </div>
            <div class="purchase__button">
                <button class="purchase__button-submit" type="submit">購入する</button>
            </div>
        </div> 
    </div>
@endsection
