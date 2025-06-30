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
                        <div class="item-iconbutton-group">
                            <form class="item-iconbutton" action="{{ route('favorite.toggle', $listing->product->id) }}" method="post">
                                @csrf
                                <div class="item-iconbutton-favorite">
                                    <button type="submit" class="icon-button {{ auth()->check() && $listing->product->isFavoritedBy(auth()->user()) ? 'favorited' : '' }}">
                                        <img src="{{ auth()->check() && auth()->user()->favoriteProducts->contains($listing->product->id)
                                            ? asset('image/star-yellow.svg') 
                                            : asset('image/star.svg') }}" alt="star" class="icon-img">
                                    </button>
                                    <p class="icon-text">{{ $listing->product->favoriteBy()->count() }}</p>
                                </div>
                            </form>
                            <div class="item-iconbutton-comment">
                                <button class="icon-button">
                                    <img src="{{ asset('image/comment.svg') }}" alt="comment" class="icon-img">
                                </button>
                                <p class="icon-text">{{ $listing->product->comments->count() }}</p>
                            </div>
                    </div>
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
                        <dd>{{ $listing->product->condition }}</dd>
                    </dl>
                </div>
            </div>
            <div class="item-group">
                <form class="form-comment" action="{{ route('comment.store', $listing->product->id) }}" method="post">
                    @csrf
                    <div class="item-group-index-comment">
                        <h2>コメント({{ $listing->product->comments->count() }})</h2>     
                    </div>
                    <div class="comments-list">
                        @foreach($listing->product->comments as $comment)
                            <div class="comment-item">
                                <div class="comment-user">
                                    @if($comment->user->avatar !== null)
                                        <img src="{{ asset('storage/image/'. $comment->user->avatar) }}" alt="avatar" class="avatar">
                                    @else
                                        <div class="avatar avatar-placeholder"></div>
                                    @endif
                                </div>                                
                                <div class="comment-user-name">{{ $comment->user->name }}</div> 
                            </div>                       
                            <div class="comment-content">{{ $comment->comment }}</div>
                        @endforeach
                    </div>
                    <div class="error-message">
                        @error('comment')  
                            {{ $message }}
                        @enderror
                    </div>
                    <div class="product-comment">
                        <h3>商品へのコメント</h3>
                        <textarea class="product-comment__textarea" name="comment" id="comment">{{ old('comment') }}</textarea>
                    </div>
                    <div class="item-button">
                        <button class="item-button-submit" type="submit" name="action" value="send">コメントを送信する</button>
                    </div>   
                </form>
            </div>
        </div>
    </div>
@endsection
