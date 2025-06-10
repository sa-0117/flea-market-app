@extends('layouts.app')

@section('css')
<link rel="stylesheet" href=" {{ asset('css/purchase.css') }}">
@endsection

@section('content')
    
    <div class="purchase-container">
        <div class="purchase-left">
            <div class="purchase-product">
                <div class="purchase-product__image">
                    <img src="{{ asset('storage/' .$listing->product->image) }}"alt="{{ $listing->product->name }}">
                </div>
                <div class="purchase-detail">
                    <h3>{{$listing->product->name}}</h3>
                    <span>&yen{{ number_format($listing->listing_price) }}</span>
                </div>
            </div>
            <div class="purchase-section">
                <form action="{{ route('purchase.show', ['item_id' => $listing->id]) }}" method="get">
                    <label class="purchase-section__label" for="payment">支払方法</label>  
                    <div class="purchase-section__select-inner">       
                        <select class="purchase-section__select" name="payment" id="payment" onchange="this.form.submit()">          
                            <option disabled {{ request('payment') ? '' : 'selected' }}>選択してください</option>
                            <option value="convenience" {{ request('payment') == 'convenience' ? 'selected' : '' }}>コンビニ払い</option>
                            <option value="credit" {{ request('payment') == 'credit' ? 'selected' : '' }}>カード支払い</option>
                        </select>                    
                    </div>
                    <div class="form__error-message">
                        @error('payment')  
                        {{ $message }}
                        @enderror
                    </div>
                </form>
            </div>              
            <div class="purchase-section">                             
                <div class="purchase-address__header">
                    <span class="purchase-address__label" for="address">配送先</span>
                    <a class="purchase-address__label-edit" href="{{ url('purchase/address/' . $listing->product->id) }}" >変更する</a>
                </div>     
                <div class="purchase-address__list">
                    <span class="purchase-address__list-postcode">〒{{ $user->post_code }}</span>
                    <span class="purchase-address__list-address">{{ $user->address }}</span>
                    <span class="purchase-address__list-building">{{ $user->building }}</span>
                </div>
                <div class="form__error-message">
                    @error('address')
                        {{ $message }}
                    @enderror
                </div>
            </div>
        </div> 

        <div class="purchase-right">
            <form action="{{ route('purchase.pay', ['item_id' => $listing->id]) }}" method="post">
            @csrf
                <input type="hidden" name="post_code" value="{{ $user->post_code }}">
                <input type="hidden" name="address" value="{{ $user->address }}" >
                <input type="hidden" name="address" value="{{ $user->building }}">

                <div class="purchase-summary__list">
                    <div class="purchase-summary__item">
                        <span>商品代金</span>
                        <span>&yen{{ number_format($listing->listing_price) }}</span>
                    </div>
                    <div class="purchase-summary__payment">
                        <div class="purchase-summary__payment-method">
                            <span>支払い方法</span>
                            <div class="purchase-summary__payment-select">
                                @if(request('payment') === 'convenience')
                                    <span>コンビニ払い</span>
                                @elseif(request('payment') === 'credit')
                                    <span>カード支払い</span>
                                @else
                                    <span>コンビニ払い</span>
                                @endif
                            </div>                        
                        </div>                    
                    </div>
                </div>
                <input type="hidden" name="payment" value="{{ request('payment') }}">
                <div class="purchase__button">
                    <button class="purchase__button-submit" type="submit">購入する</button>
                </div>
            </form>
        </div>
    </div> 
@endsection