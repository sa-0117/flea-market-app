@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register-form">
  <div class="register-form__heading">
    <h2>会員登録</h2>
  </div>
  <form class="register-form__form">
      @csrf
        <div class="register-form__group">
            <label class="register-form__label" for="email">ユーザー名</label>          
            <input class="register-form__input" type="text" name="name" id="name">
            <p class="register-form__error-message">


            </p>
        </div>

        <div class="register-form__group">
            <label class="register-form__label" for="email">メールアドレス</label>          
            <input class="register-form__input" type="email" name="email" id="email">
            <p class="register-form__error-message">


            </p>
        </div>

        <div class="register-form__group">
            <label class="register-form__label" for="password">パスワード</label>          
            <input class="register-form__input" type="password" name="password" id="password">
            <p class="register-form__error-message">


            </p>
        </div>
        <div class="register-form__group">
            <label class="register-form__label" for="password">確認用パスワード</label>          
            <input class="register-form__input" type="password" name="password_confirmation" id="password_confirmation">
            <p class="register-form__error-message">


            </p>
        </div>

  
        <div class="register-form__button">
          <button class="register-form__button-submit" type="submit">登録する</button>
        </div>
      </form>
      <div class="login-form__link">
        <a class="login-form__button-submit" href="/login">ログインはこちら</a>
      </div>
    </div>
@endsection