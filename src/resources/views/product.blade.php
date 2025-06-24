@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/products.css') }}">
@endsection

@section('content')
    <div class="product">
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

        <div class="product-list">            
            @foreach ($listings as $listing)
                <div class="product-list__item">
                    <div class="product-list__image">
                        <a href="{{ url('item/' . $listing->id) }}">
                            <img src="{{ asset('storage/' .$listing->product->image) }}" alt="{{ $listing->product->name }}">
                        </a>
                    </div>
                    <div class="product-list__image-title">
                        <div class="product-list__name">{{ $listing->product->name }}</div>
                        @if ($listing->buyer_id)
                            <div class="product-status">Sold</div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>         
    </div>
@endsection
