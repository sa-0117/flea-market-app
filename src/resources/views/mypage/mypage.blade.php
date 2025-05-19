@extends('layouts.app')

@section('css')
<link rel="stylesheet" href=" {{ asset('css/mypage.css') }}">
@endsection

@section('content')
    <div class="mypage-container">
        <div class="profile-image">
            <div class="profile-image__inner">
                <img src="" alt="profile-image">
            </div>
            <div class="profile-image-edit">
                <input type="file" name="avatar" id="avatar" style="display:none;">
                <label for="avatar" class="profile-image-edit__label">画像を選択する</label>
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
                            <img src="{{ asset('storage/image/' .$product->image) }}" alt="{{ $product->name }}">
                        </div>
                        <div class="product-list__name">{{ $product->name }}</div>
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
