@extends('layouts.app')

@section('css')
<link rel="stylesheet" href=" {{ asset('css/address.css') }}">
@endsection

@section('content')
    <div class="address-container">
      <div class="address-heading">
        <h2>住所の変更</h2>
      </div>
      <form class="address-form" method="post" action="{{ route('purchase.address.update', ['item_id' => $item_id]) }}"> 
      @csrf
        <div class="address-form__group">
            <label class="address-form__label" for="post_code">郵便番号</label>          
            <input class="address-form__input" type="text" name="post_code" id="post_code" value="{{ old('post_code', $user->post_code) }}">
            <div class="form__error-message">  
              @error('post_code')
              {{ $message }}
              @enderror
            </div>
        </div>
        <div class="address-form__group">
            <label class="address-form__label" for="address">住所</label>          
            <input class="address-form__input" type="text" name="address" id="address" value="{{ old('address', $user->address) }}">            
            <div class="form__error-message">
              @error('address')
              {{ $message }}
              @enderror
            </div>
        </div>
        <div class="address-form__group">
            <label class="address-form__label" for="building">建物名</label>          
            <input class="address-form__input" type="text" name="building" id="building" value="{{ old('building', $user->building) }}">
        </div>  
        <div class="address-form__button">
          <button class="address-form__button-submit" type="submit">更新する</button>
        </div>
      </form>
    </div>
@endsection