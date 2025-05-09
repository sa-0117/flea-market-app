@extends('layouts.app')

@section('css')
<link rel="stylesheet" href=" {{ asset('css/products.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="profile-image">
            <div class="profile-image__inner">
                <img src="" alt="profile-image">
            </div>
            <div class="profile-image-edit">
                <input type="file" name="avatar" id="avatar" style="display:none;">
                <label for="avatar" class="profile-image-edit__label">画像を選択する</label>
            </div>
        </div>
        <div class="product-index">
            <div class="product-index__item">
                <a href="{{ url('/') }}">おすすめ</a>
            </div>
            <div class="product-index__item">
                @auth
                <a href="{{ url('/?page=mylist') }}">マイリスト</a>
                @else
                <span class="product-index__disabled">マイリスト</span>
                @endauth
            </div>
        </div>
        <div class="product-list">            
        @foreach ($products as $product)
            <div class="product-list__item">
                <div class="product-list__card">
                    <a href="">
                        <img src="{{ asset('storage/image/' .$product->image) }}" alt="{{ $product->name }}">
                    </a>
                </div>
                <div class="product-list__card-title">
                    <span class="product-list__name">{{ $product->name }}</span>
                </div>
            </div>
        @endforeach
        </div>         
    </div>
@endsection
