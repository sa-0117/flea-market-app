@extends('layouts.app')

@section('css')
<link rel="stylesheet" href=" {{ asset('css/item.css') }}">
@endsection

@section('content')
    <div class="item">    
        <div class="item__inner">
            <div class="item-row">
                <div class="item-group">
                    <div class="item-image-preview">
                        <img src="{{ asset('storage/' .$listing->product->image) }}" class="item-image" alt="{{ $listing->product->name }}">
                    </div>
                </div>
            </div>
            <div class="item-column">
                <div class="item-group">
                    <div class="item-purchase">
                    @csrf
                        <div class="item-group-index">
                            <h1>{{$listing->product->name}}</h1>
                            <small>{{$listing->product->brand}}</small>
                            <div class="item-group-price">
                                <div class="item-group-price-price">
                                    <span>&yen{{ number_format($listing->listing_price) }}</span>
                                </div>
                                <div class="item-group-price-tax">
                                    <span>(税込)</span>
                                </div>
                            </div>
                        </div>
                        <form class="item-iconbutton" action="{{ route('favorite.toggle', $listing->product->id) }}" method="post">
                                @csrf
                            <div class="item-iconbutton-favorite">                           
                                <button type="submit" class="star-button {{ auth()->check() && auth()->user()->favoriteProducts->contains($listing->product->id) ? 'favorited' : '' }}"></button>
                                <p class="item__iconbutton-text">{{ $listing->product->favoriteBy ? $listing->product->favoriteBy->count() : 0 }}</p>
                            </div>
                            <div class="item-iconbutton-comment">
                                <div class="item-iconbutton-container">
                                    <button type="submit" class="comment-button"></button>
                                    <p class="item-iconbutton__text"></p>
                                </div>
                            </div>
                        </form>
                        <div class="item-button">
                            <a href="{{ url('purchase/' . $listing->product->id) }}" class="item-button-submit">購入手続きへ</a>                           
                        </div>
                    </div>
                </div>
           
                <div class="item-group">
                    <div class="item-group-index">
                        <h2>商品説明</h2>
                    </div>
                    <div class="item-group__description">
                        {{ $listing->product->description }}
                    </div>
                    
                </div>
                <div class="item-group">
                    <div class="item-group-index">
                        <h2>商品の情報</h2>
                    </div>
                </div>
                <div class="item-group">
                    <div class="item-group__inner">
                        <dl class="category__list">    
                            <dt>カテゴリー</dt>                            
                                @foreach($listing->product->categories as $category)
                                    <dd>{{ $category->content }}</dd>
                                @endforeach
                        </dl>
                    </div>
                </div>
                <div class="item-group">
                    <div class="item-group__inner">
                        <dl class="condition__list">
                            <dt>商品の状態</dt>
                            <dd>{{ $listing->product->condition }}
                        </dl>
                    </div>
                </div>
                <div class="item-group">
                    <div class="item-group-index-comment">
                        <h2>コメント</h2>
                        <span>(1)</span>
                    </div>
                    <div class="">

                    
                    </div>
                    <form class="form-comment" action="" method="post">
                        @csrf
                        <label class="item-group__label" for="comment">admin</label>
                        <textarea class="item-group__textarea" name="comment" id="comment"></textarea>

                        <div class="item-button">
                            <button class="item-button-submit" type="submit" name="action" value="send">コメントを送信する</button>
                        </div>   
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
