@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/transaction.css') }}">
@endsection

@section('content')
<di class="transaction">
    <div class="transactionpage-side-menu">
        <p>その他の取引</p>
        @if($isSeller)
            <div class="side-menu__button__group">
                @forelse ($listings as $otherListing)
                    <div class="side-menu__item">
                        <a href="{{ route('transaction.show', ['listingId' => $otherListing->id]) }}">
                        <div class="side-menu__button" type="submit">{{ $otherListing->product->name }}</div>
                        </a>
                    </div>
                @empty
                    <p>その他の取引</p>
                @endforelse
            </div>
        @endif
    </div>
    <div class="transaction-main">
        <div class="underborder-line">
            <div class="transaction-user__group">
                <div class="transaction-user">
                    <div class="transaction-user-avatar">
                        @if($otherUser->avatar !== null)
                            <img src="{{ asset('storage/image/'. $otherUser->avatar) }}" alt="avatar" class="avatar"> 
                        @else
                            <div class="avatar avatar-placeholder"></div>
                        @endif
                    </div>                         
                    <div class="transaction-user-name">「{{ $otherUser->name }}」さんとの取引画面</div> 
                </div>
                <div class="modal {{ $sellerModal ? 'show' : '' }}" id="modal-{{ $listing->id }}">
                    <div class="modal__inner">
                        <div class="modal-underborder-line">
                        <p class="modal-endmessage">取引が完了しました。</p>
                        </div>

                        <form action="{{ route('rating.store', ['listingId' => $listing->id]) }}" class="form-rating" method="post">
                        @csrf
                            <div class="modal-underborder-line">
                                <p class="form-title">今回の取引相手はどうでしたか？</p>
                                <div class="form-rating-star">
                                    <input class="form-rating__input" id="star5" name="rating" type="radio" value="5">
                                    <label class="form-rating__label" for="star5"><i class="fa-solid fa-star"></i></label>

                                    <input class="form-rating__input" id="star4" name="rating" type="radio" value="4">
                                    <label class="form-rating__label" for="star4"><i class="fa-solid fa-star"></i></label>

                                    <input class="form-rating__input" id="star3" name="rating" type="radio" value="3">
                                    <label class="form-rating__label" for="star3"><i class="fa-solid fa-star"></i></label>

                                    <input class="form-rating__input" id="star2" name="rating" type="radio" value="2">
                                    <label class="form-rating__label" for="star2"><i class="fa-solid fa-star"></i></label>

                                    <input class="form-rating__input" id="star1" name="rating" type="radio" value="1">
                                    <label class="form-rating__label" for="star1"><i class="fa-solid fa-star"></i></label>
                            </div>
                            </div>
                            <div class="modal-rating-send">
                                <button type="submit" class="modal-rating-send__button">送信</button>
                            </div>
                        </form>
                    </div>
                </div>
                @if($buyerButton)
                    <div class="transaction__button">
                        <a href="#modal-{{ $listing->id }}" class="transaction-end__button">取引を完了する</a>
                    </div>
                @endif
            </div>
        </div>
        <div class="transaction-product">
            <div class="underborder-line">
                <div class="product-row">
                    <div class="product-group">
                        <div class="product-preview">
                            <img src="{{ asset('storage/' .$listing->product->image) }}" class="product-image" alt="product-image">
                        </div>
                        <div class="product-info">                   
                            <div class="product-group-price">
                                <h1>{{ $listing->product->name}}</h1>
                                <span>&yen{{ number_format($listing->listing_price) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="transaction-chat">
            <div class="chat-list">
                @foreach($messages as $message)
                    @if($message->user_id === $authUser->id )
                        <div class="chat-message mymessage">
                            <div class="chat-header">
                                <div class="chat-name">{{ $message->user->name }}</div> 
                                @if($authUser->avatar !== null)
                                    <img src="{{ asset('storage/image/' . $message->user->avatar)}}" alt="avatar" class="avatar">
                                @else
                                    <div class="avatar avatar-placeholder"></div>
                                @endif 
                            </div>           
                            @if(request('edit_id') == $message->id)
                                <form class="form-edit" action="{{ route('message.update', $message->id) }}" method="POST" >
                                    @csrf
                                    <textarea name="content" class="form-edit-textarea">{{ old('content', $message->content) }}</textarea>
                                    <button class="form-edit__button"type="submit">更新</button>
                                </form>
                            @else
                                <div class="chat-content">
                                    {{ $message->content }}
                                    @if($message->image)
                                        <img src="{{ asset('storage/' . $message->image) }}" alt="message image">
                                    @endif
                                </div>
                                <div class="chat-action">
                                    <a href="{{ route('transaction.show', ['listingId' => $listing->id, 'edit_id' => $message->id]) }}" class="chat-button-edit">編集</a>
                                    <form action="{{ route('message.destroy', $message->id) }}" method="POST" class="inline-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="chat-button-delete">削除</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="chat-message othermessage">
                            <div class="chat-header">
                                @if($message->user->avatar !== null)
                                    <img src="{{ asset('storage/image/' . $message->user->avatar)}}" alt="avatar" class="avatar">
                                @else
                                    <div class="avatar avatar-placeholder"></div>
                                @endif 
                                <div class="chat-name">{{ $message->user->name }}</div> 
                            </div>
                            <div class="chat-content">
                                {{ $message->content}}
                                @if($message->image)
                                    <img src="{{ asset('storage/' . $message->image) }}" alt="message image">
                                @endif
                            </div> 
                        </div>     
                    @endif
                @endforeach   
            </div>
            <div class="error-message">
                    @error('content')
                        {{ $message }}
                    @enderror
                    @error('image')
                        {{ $message }}
                    @enderror
                </div>
            <form class="form-chat" action="{{ route('transaction.message', $listing->id) }}" method="post"  enctype="multipart/form-data">
                @csrf
                <div class="chat-create__group">
                    <div class="chat-comment">
                        <textarea name="content" class="chat-comment__textarea" placeholder="取引メッセージを記入してください">{{ old('content', session('chat_draft_'.$listing->id)) }}</textarea>
                    </div>
                    <div class="image-button">
                        <input class="image-input" type="file" name="image" id="image" accept="image/*">
                        <label for="image" class="chat-comment-submit">画像を追加</label>
                        <button type="submin" class="send-button">
                            <image src="{{ asset('image/send.svg') }}" alt="send">
                        </button> 
                    </div> 
                </div>
            </form>
        </div>
    </div>
</div>
@endsection