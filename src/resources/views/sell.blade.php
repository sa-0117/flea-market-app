@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<div class="sell">
    <div class="sell__inner">
        <form class="sell-form" action="/sell" method="post" enctype="multipart/form-data">  
        @csrf
            <div class="sell__heading">
                <div class="sell__heading-title">
                    <h2>商品の出品</h2>
                </div>
            </div>
            <div class="sell-form-image">
                <span class="sell-form__label">商品画像</span>
                <div class="sell-form-image__preview-area">
                    <input class="sell-form__input" type="file" name="image" id="image" accept="image/*">
                    <label for="image" class="sell-button">画像を選択する</label>
                </div>
            </div>
            <div class="error-message">  
                @error('image')
                    {{ $message }}
                @enderror
            </div>
            <div class="sell-form__index">
                <div class="sell-form__index-title">
                    <h3>商品の詳細</h3>
                </div>
                <label class="sell-form__label" for="category">カテゴリー</label>
                <div class="category-box">
                    @foreach($categories as $category)
                        <input type="checkbox" class="category-checkbox" name="categories[]" id="category_{{ $category->id }}" value="{{ $category->id }}"{{ is_array(old('categories')) && in_array($category->id, old('categories')) ? 'checked' : '' }}>
                        <label class="category-label" for="category_{{ $category->id }}">{{ $category->content }}</label>
                    @endforeach
                </div> 
                <div class="error-message">  
                    @error('category')
                        {{ $message }}
                    @enderror
                </div>
                <div class="sell-form__group">
                    <label class="sell-form__label" for="condition">商品の状態</label>
                    <div class="sell-form__select-inner">
                        <select class="sell-form__select" name="condition" id="condition">          
                            <option  value="" disabled {{ old('condition') === null ? 'selected' : '' }}>選択してください</option>
                            <option value="良好"{{ old('condition') === '良好' ? 'selected' : '' }}>良好</option>
                            <option value="目立った傷や汚れなし"{{ old('condition') === '目立った傷や汚れなし' ? 'selected' : '' }}>目立った傷や汚れなし</option>
                            <option value="やや傷や汚れあり"{{ old('condition') === 'やや傷や汚れあり' ? 'selected' : '' }}>やや傷や汚れあり</option>
                            <option value="状態が悪い"{{ old('condition') === '状態が悪い' ? 'selected' : '' }}>状態が悪い</option>
                        </select>
                    </div>
                </div>
                <div class="error-message">  
                    @error('condition')
                        {{ $message }}
                    @enderror
                </div>
            </div>  
            <div class="sell-form__index">
                <div class="sell-form__index-title">
                    <h3 >商品名と説明</h3>
                </div>
                <div class="sell-form__group">
                    <label class="sell-form__label" for="name">商品名</label>          
                    <input class="sell-form__input" type="text" name="name" id="name" value="{{ old('name') }}">
                </div>
                <div class="error-message">  
                    @error('name')
                        {{ $message }}
                    @enderror
                </div>
                <div class="sell-form__group">
                    <label class="sell-form__label" for="brand">ブランド名</label>          
                    <input class="sell-form__input" type="text" name="brand" id="brand"  value="{{ old('brand') }}">
                </div>
                <div class="sell-form__group">
                    <label class="sell-form__label" for="description">商品の説明</label>          
                    <textarea class="sell-form__textarea" name="description" id="description">{{ old('description') }}</textarea>
                </div>
                <div class="error-message">  
                    @error('description')
                        {{ $message }}
                    @enderror
                </div>
                <div class="sell-form__group">
                    <label class="sell-form__label" for="listing_price">販売価格</label>          
                    <input class="sell-form__input" type="text" name="listing_price" id="listing_price" placeholder="￥" value="{{ old('listing_price') }}">
                </div>
                <div class="error-message">  
                    @error('listing_price')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="sell-form__button">
                <button class="sell-form__button-submit" type="submit">出品する</button>
            </div>
        </form>
      </div>
    </div>
@endsection