@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="profile">
    <div class="profile__inner">
        <form class="profile__form" action="/mypage/profile" method="post" enctype="multipart/form-data">
        @csrf
            <div class="profile__heading">
                <div class="profile__heading-ttl">
                    <h2>プロフィール設定</h2>
                </div>
            </div>
            <div class="profile-image">
                <div class="profile-image__inner">
                    <img src="" alt="profile-image">
                </div>
                <div class="profile-image-edit">
                    <input type="file" name="avatar" id="avatar" style="display:none;">
                    <label for="avatar" class="profile-image-edit__label">画像を選択する</label>
                </div>
            </div>
            
  
            <div class="profile-form__group">
                <label class="profile-form__label" for="name">ユーザー名</label>          
                <input class="profile-form__input" type="text" name="name" id="name">
                <p class="profile-form__error-message">


                </p>
            </div>

            <div class="profile-form__group">
                <label class="profile-form__label" for="post_code">郵便番号</label>          
                <input class="profile-form__input" type="text" name="post_code" id="post_code">
                <p class="profile-form__error-message">


                </p>
            </div>

            <div class="profile-form__group">
                <label class="profile-form__label" for="address">住所</label>          
                <input class="profile-form__input" type="text" name="address" id="address">
                <p class="profile-form__error-message">


                </p>
            </div>
            <div class="profile-form__group">
                <label class="profile-form__label" for="building">建物名</label>          
                <input class="profile-form__input" type="text" name="building" id="building">
                <p class="profile-form__error-message">


                </p>
            </div>

    
            <div class="profile-form__button">
            <button class="profile-form__button-submit" type="submit">更新する</button>
            </div>
        </form>
      </div>
    </div>
@endsection