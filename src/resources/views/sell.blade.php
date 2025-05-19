@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<div class="sell">
    <div class="sell__inner">
        <form class="sell-form" action="/item" method="post">
        @csrf
            <div class="sell__heading">
                <div class="sell__heading-title">
                    <h2>商品の出品</h2>
                </div>
            </div>
            <div class="sell-form-image">
                <div class="sell-form-image__inner">
                    <label class="sell-form__label" for="image">商品画像</label>
                    <input class="sell-form__input" type="file" name="image" id="image" accept="image/*">
                    <button type="button" class="sell__button">画像を選択する</button>
                </div>
            </div>

            <div class="sell-form__index">
                <div class="sell-form__index-ttl">
                    <h3>商品の詳細</h3>
                </div>
                <label class="sell-form__label" for="category">カテゴリー</label> 
            

                
                <div class="sell-form__group">
                    <label class="sell-form__label" for="condition">商品の状態</label>
                    <div class="sell-form__select-inner">
                        <select class="sell-form__select" name="condition" id="">          
                            <option disabled selected>選択してください</option>
                            <option value="">良好</option>
                            <option value="">目立った傷や汚れなし</option>
                            <option value="">やや傷や汚れあり</option>
                            <option value="">状態が悪い</option>
                        </select>
                    </div>
                    <p class="sell-form__error-message">

                    
                    </p>
                </div>
            </div>  
            <div class="sell-form__index">
                <div class="sell-form__index-ttl">
                    <h3 >商品名と説明</h3>
                </div>
                <div class="sell-form__group">
                    <label class="sell-form__label" for="name">商品名</label>          
                    <input class="sell-form__input" type="text" name="name" id="name">
                    <p class="sell-form__error-message">


                    </p>
                </div>

                <div class="sell-form__group">
                    <label class="sell-form__label" for="brand">ブランド名</label>          
                    <input class="sell-form__input" type="text" name="brand" id="brand">
                    <p class="sell-form__error-message">


                    </p>
                </div>
                <div class="sell-form__group">
                    <label class="sell-form__label" for="description">商品の説明</label>          
                    <textarea class="sell-form__textarea" name="description" id="description"></textarea>
                    <p class="sell-form__error-message">


                    </p>
                </div>
                <div class="sell-form__group">
                    <label class="sell-form__label" for="listing_price">販売価格</label>          
                    <input class="sell-form__input" type="text" name="listing_price" id="listing_price">
                    <p class="sell-form__error-message">


                    </p>
            </div>
            <div class="sell-form__button">
                <button class="sell-form__button-submit" type="submit">出品する</button>
            </div>
        </form>
      </div>
    </div>
@endsection