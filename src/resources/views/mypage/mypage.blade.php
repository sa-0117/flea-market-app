@extends('layouts.app')

@section('css')
<link rel="stylesheet" href=" {{ asset('css/mypage.css') }}">
@endsection

@section('content')
    <div class="mypage-container">
        <div class="mypage__inner">
            <div class="mypage-top">
                <div class="mypage-top__left">
                    @if($user->avatar !== null)
                        <img src="{{ asset('storage/image/'. $user->avatar) }}" alt="avatar" class="avatar">
                    @else
                        <div class="avatar avatar-placeholder"></div>
                    @endif
                </div>
                <div class="mypage-top__middle">{{ $userName }} </div>
                <div class="mypage-top__right-edit">
                    <a href="{{ url('/mypage/profile') }}" class="profile-image-edit__link">プロフィールを編集</a>
                </div>
            </div>
            <ul class="product-tab">
                <li class="product-tab-name">
                    <a href="{{ url('/mypage?tab=sell') }}" class="{{ $tab === 'sell' ? 'active' : '' }}">出品した商品</a>
                </li>
                <li class="product-tab-name">
                    <a href="{{ url('/mypage?tab=buy') }}" class="{{ $tab === 'buy' ? 'active' : '' }}">購入した商品</a>
                </li>
            </ul>
        </div>
        <div class="product-list">
            @if ($tab === 'sell')            
                @foreach ($listings as $listing)
                    <div class="product-list__item">
                        <div class="product-list__image">
                            <img src="{{ asset('storage/' .$listing->product->image) }}" alt="{{ $listing->product->name }}">
                        </div>
                        <div class="product-list__name">{{ $listing->product->name }}</div>
                    </div>
                @endforeach
            @elseif ($tab === 'buy')
                @foreach ($orders as $order)
                    <div class="product-list__item">
                        <div class="product-list__image">
                            <img src="{{ asset('storage/' .$order->listing->product->image) }}" alt="{{ $order->listing->product->name }}">
                        </div>
                        <div class="product-list__name">{{ $order->listing->product->name }}</div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
