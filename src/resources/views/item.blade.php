@extends('layouts.app')

@section('css')
<link rel="stylesheet" href=" {{ asset('css/item.css') }}">
@endsection

@section('content')
    <div class="item">
    
        <div class="item__inner">
            <div class="item-row">
                <div class="item__group">
                    <div class="item__image-preview"  style="background-image: url('{{ old('image_path') }}')">
                    </div>
                </div>
            </div>
            <div class="item-column">
                <div class="item__group">
                    <div class="item-purchase">
                    @csrf
                        <div class="item__group-index">
                            <h2>{{$product->name}}</h2>
                            <small>ブランド名</small>
                            <div class="item__group-price">
                                <span>&yen{{$product->price}}</span>
                                <span>(税込)</span>
                            </div>
                        </div>
                        <div class="item__iconbutton">
                            <div class="item__iconbutton-container">
                                <button class="item__iconbutton-favorite" type="button" name="favorite" value="">☆</button>
                                <p class="item__iconbutton-text">1</p>
                            </div>
                            <div class="item__iconbutton">
                                <div class="item__iconbutton-container">
                                    <button class="item__iconbutton-comment" type="button" name="favorite" value="">□</button>
                                    <p class="item__iconbutton-text">1</p>
                                </div>
                            </div>
                        </div>
                        <div class="item__button">
                            <a href="{{ url('purchase/' . $product->id) }}" class="item__button-submit">購入手続きへ</a>
                            
                        </div>
                    </div>
                </div>
            
                <div class="item__group">
                    <div class="item__group-index">
                        <h3>商品説明</h3>
                    </div>
                    <textarea class="item-group__textarea" name="description" id="description"></textarea>
                    
                </div>
                <div class="item__group">
                    <div class="item__group-index">
                        <h3>商品の情報</h3>
                    </div>
                
                    <div class="item__group">
                        <label class="item__group__label">カテゴリー</label>
                    
                    </div>
                </div>
                <div class="item__group">
                    <label class="item__group__label" for="condition">商品の状態</label>
                    <div class="item__group-select">
                        
                    </div>
                </div>

                <div class="item__group">
                    <div class="item__group-index-comment">
                        <h3>コメント</h3>
                        <span>(1)</span>
                    </div>
                    <div class="">

                    
                    </div>
                    <form class="form-comment" action="" method="post">
                        @csrf
                        <label class="item__group__label" for="comment">admin</label>
                        <textarea class="item-group__textarea" name="comment" id="comment"></textarea>

                        <div class="item__button">
                            <button class="item__button-submit" type="submit" name="action" value="send">コメントを送信する</button>
                        </div>   
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
