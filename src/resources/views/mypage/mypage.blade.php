@extends('layouts.app')

@section('css')
<link rel="stylesheet" href=" {{ asset('css/mypage.css') }}">
@endsection

@section('content')
    <div class="mypage-container">
        <div class="mypage__border">
            <div class="mypage__inner">
                <div class="mypage-top">
                    <div class="mypage-top__left">
                        <div class="avatar">
                            @if($user->avatar !== null)
                                <img src="{{ asset('storage/image/'. $user->avatar) }}" alt="avatar" class="avatar">
                            @else
                                <div class="avatar avatar-placeholder"></div>
                            @endif
                        </div>
                        <div class="mypage-top__middle">
                            <div class="mypage-top-username">{{ $user->name }}</div>
                            <div class="mypage-top-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span class="form-rating__label" style="{{ $i <= $averageRating ? 'color: #e5e506ff;' : 'color: #ccc;' }}">★</span>
                                @endfor
                            </div>
                        </div>
                    </div>
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
                    <li class="product-tab-name transaction-tab">
                        <a href="{{ url('/mypage?tab=transaction') }}" class="{{ $tab === 'transaction' ? 'active' : '' }}">取引中の商品</a>
                        @if($newMessageCount > 0)
                            <span class="count">{{ $newMessageCount }}</span>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
        <div class="product-list">
            @if ($tab === 'sell')            
                @foreach ($listings as $listing)
                    <div class="product-list__item">
                        <div class="product-list__image">
                            <img src="{{ asset('storage/' .$listing->product->image) }}" alt="{{ $listing->product->name }}">
                        </div>
                        <div class="product-list__name">{{ $listing->product->name }}</div>
                        @if (in_array($listing->status,['Sold', 'completed']))
                            <div class="product-status">Sold</div>
                        @endif
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
            @elseif ($tab === 'transaction')
                @foreach ($listings as $listing)
                    <div class="product-list__item">
                        <a href="{{ route('transaction.show', ['listingId' => $listing->id]) }}">
                            <div class="product-list__image-wrapper">
                                <img src="{{ asset('storage/' .$listing->product->image) }}" alt="{{ $listing->product->name }}">
                                @if($listing->newMessageCount > 0)
                                    <span class="count-badge">{{ $listing->newMessageCount }}</span>
                                @endif
                            </div>
                        </a>
                        <div class="product-list__name">{{ $listing->product->name }}</div>
                        
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
