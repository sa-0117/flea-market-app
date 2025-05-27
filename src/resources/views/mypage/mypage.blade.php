@extends('layouts.app')

@section('css')
<link rel="stylesheet" href=" {{ asset('css/mypage.css') }}">
@endsection

@section('content')
    <div class="mypage-container">
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
                <a href="{{ url('/mypage?page=sell') }}" class="{{ $page === 'sell' ? 'active' : '' }}">出品した商品</a>
            </li>
            <li class="product-tab-name">
                <a href="{{ url('/mypage?page=buy') }}" class="{{ $page === 'buy' ? 'active' : '' }}">購入した商品</a>
            </li>
        </ul>
        <div class="product-list">
            @if ($page === 'sell')            
                @foreach ($products as $product)
                    <div class="product-list__item">
                        <div class="product-list__image">
                            <img src="{{ asset('storage/' .$product->product->image) }}" alt="{{ $product->product->name }}">
                        </div>
                        <div class="product-list__name">{{ $product->product->name }}</div>
                    </div>
                @endforeach
            @elseif ($page === 'buy')
            @foreach ($products as $product)
                    <div class="product-list__item">
                        <div class="product-list__image">
                            <img src="{{ asset('storage/image/' .$product->image) }}" alt="{{ $product->name }}">
                        </div>
                        <div class="product-list__name">{{ $product->name }}</div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
