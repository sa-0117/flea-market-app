@extends('layouts.app')

@section('css')
<link rel="stylesheet" href=" {{ asset('css/mylist.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="product-index">
            <div class="product-index__item">
                <a href="{{ url('/') }}">おすすめ</a>
            </div>
            <div class="product-index__item">
                <a href="{{ url('/?page=mylist') }}">マイリスト</a>
            </div>
        </div>
        <div class="product-list">            
        @foreach ($products as $product)
            <div class="product-list__item">
                <div class="product-list__card">
                    <a href="">
                        <img src="{{ asset('storage/image/' .$product['image']) }}" alt="{{ $product['name'] }}">
                    </a>
                </div>
                <div class="product-list__card-title">
                    <span class="product-list__name">{{ $product['name'] }}</span>
                </div>
            </div>
        @endforeach
        </div>         
    </div>
@endsection
