@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
    <div class="profile-container">
        <div class="profile__inner">
            <form class="profile__form" action="/mypage/profile" method="post" enctype="multipart/form-data">
            @csrf
                <div class="profile__heading">
                    <div class="profile__heading-title">
                        <h2>プロフィール設定</h2>
                    </div>
                </div>
                <div class="profile-image">
                    <div class="profile-image__inner">
                        @if($user->avatar !== null)
                            <img src="{{ asset('storage/image/'. $user->avatar) }}" alt="avatar" class="avatar">
                        @else
                            <div class="avatar avatar-placeholder"></div>
                        @endif
                    </div>
                    <div class="profile-image-edit">
                        <input type="file" name="avatar" id="avatar" accept="image/*" style="display:none;">
                        <label for="avatar" class="profile-image-edit__label">画像を選択する</label>
                    </div>
                    <div class="form__error-message">
                        @error('avatar')
                            {{ $message }}
                        @enderror
                    </div>
                </div> 
                <div class="profile-form__group">
                    <label class="profile-form__label" for="name">ユーザー名</label>          
                    <input class="profile-form__input" type="text" name="name" id="name" value="{{ old('name', $user->name) }}">
                    <div class="form__error-message">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="profile-form__group">
                    <label class="profile-form__label" for="post_code">郵便番号</label>          
                    <input class="profile-form__input" type="text" name="post_code" id="post_code" value="{{ old('post_code', $user->post_code) }}">
                    <div class="form__error-message">
                        @error('post_code')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="profile-form__group">
                    <label class="profile-form__label" for="address">住所</label>          
                    <input class="profile-form__input" type="text" name="address" id="address" value="{{ old('address', $user->address) }}">
                
                    <div class="form__error-message">
                        @error('address')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="profile-form__group">
                    <label class="profile-form__label" for="building">建物名</label>          
                    <input class="profile-form__input" type="text" name="building" id="building" value="{{ old('building', $user->building) }}">
                </div>
                <div class="profile-form__button">
                    <button class="profile-form__button-submit" type="submit">更新する</button>
                </div>
            </form>
        </div>
    </div>
@endsection