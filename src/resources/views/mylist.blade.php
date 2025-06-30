@extends('layouts.app')

@section('css')
<link rel="stylesheet" href=" {{ asset('css/mylist.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="product-index__border">
            <div class="product-index__inner">
                <ul class="product-index">
                    <li class="product-index__item">
                        <a href="{{ route('product.index') }}" class="{{ request()->routeIs('product.index') ? 'active' : '' }}">おすすめ</a>
                    </li>
                    <li class="product-index__item">
                        @auth
                            <a href="{{ route('mylist.index') }}" class="{{ request()->routeIs('mylist.index') ? 'active' : '' }}">マイリスト</a>
                        @else
                            <span class="disabled">マイリスト</span>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
        <div class="product-list">            
            @foreach ($products as $product)
                <div class="product-list__item">
                    <div class="product-list__image">
                        <a href="{{ url('item/' . $product->id) }}">
                            <img src="{{ asset('storage/' .$product->image) }}" alt="{{ $product->name }}">
                        </a>
                    </div>
                    <div class="product-list__name">{{ $product->name }}</div>
                    @if ($product->listing && $product->listing->status === 'sold')
                        <div class="product-status">Sold</div>
                    @endif
                </div>
            @endforeach
        </div>         
    </div>  
@endsection
