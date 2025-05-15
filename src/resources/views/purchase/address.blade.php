@extends('layouts.app')

@section('css')
<link rel="stylesheet" href=" {{ asset('css/address.css') }}">
@endsection

@section('content')
    <div class="address-container">
      <div class="address-heading">
        <h2>住所の変更</h2>
      </div>
      <form class="address-form" action="/purchase" method="post" > 
      @csrf
        <div class="address-form__group">
            <label class="address-form__label" for="post_code">郵便番号</label>          
            <input class="address-form__input" type="text" name="post_code" id="post_code">
            <p class="address-form__error-message">


            </p>
        </div>
        <div class="address-form__group">
            <label class="address-form__label" for="address">住所</label>          
            <input class="address-form__input" type="text" name="address" id="address">
            <p class="address-form__error-message">


            </p>
        </div>
        <div class="address-form__group">
            <label class="address-form__label" for="building">建物名</label>          
            <input class="address-form__input" type="text" name="building" id="building">
            <p class="address-form__error-message">


            </p>
        </div>

  
        <div class="address-form__button">
          <button class="address-form__button-submit" type="submit">更新する</button>
        </div>
      </form>
    </div>
@endsection