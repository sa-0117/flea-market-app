@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/transaction.css') }}">
@endsection

@section('content')
<di class="transaction">
    <div class="transactionpage-side-menu">
        @if ($otherUser)
            <p>その他の取引</p>
        @else
            <p>その他の取引</p>
            <div class="side-menu__button__group">
                <button class="side-menu__button" type="submit">商品名</button>
                <button class="side-menu__button" type="submit">商品名</button>
                <button class="side-menu__button" type="submit">商品名</button>     
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
                <div class="transaction-form__button">
                    <button class="transaction-end__button-submit" type="submit">取引を完了する</button>
                </div>
            </div>

            <div></div>


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
                                @if($message->avatar !== null)
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
                                    {{ old('content', $message->content) }}
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
                                @if($message->avatar !== null)
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
                <div class="error-message">
                    @error('content')
                        {{ $message }}
                    @enderror
                    @error('image')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <form class="form-chat" action="{{ route('transaction.message', $listing->id) }}" method="post"  enctype="multipart/form-data">
                @csrf
                <div class="chat-create__group">
                    <div class="chat-comment">
                        <textarea name="content" class="chat-comment__textarea" placeholder="取引メッセージを記入してください">{{ old('comment') }}</textarea>
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