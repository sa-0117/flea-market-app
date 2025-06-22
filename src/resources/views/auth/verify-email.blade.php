@extends('layouts.app')

@section('css')
<link rel="stylesheet" href=" {{ asset('css/email.css') }}">
@endsection

@php
  $HeaderParts = true;
@endphp

@section('content')
    <div class="container">
        <div class="container__inner">
            <p>登録いただいたメールアドレスに認証メールを送付しました。</p>
            <p>メール認証を完了してください。</p>
        </div>
        <form class="email-certification" action="/email/verify/check" method="get" > 
            <button type="submit" class="email-certification-button">認証はこちらから</button>
        </form>
        <form method="POST" action="/email/verification-notification">
            @csrf
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="submit" class="email-resend-button">認証メールを再送する</button>
        </form>
    </div>
@endsection