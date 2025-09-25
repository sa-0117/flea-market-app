<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>flea-market-app</title>
  <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/common.css')}}">
  @yield('css')
</head>

<body>
  <div class="app">
    <header class="header">
      <div class="header__inner">
        <a href="/" class="header__logo">
          <img src="{{ asset('image/logo.svg') }}" alt="COACHTECH">
        </a>
        @empty($HeaderParts)
        <div class="header__form">
          <form class="header__form-search" action="{{ route('product.index') }}" method="get">
            <input type="text" name="keyword" placeholder="なにをお探しですか？" value="{{ session('key') }}">
          </form>
        </div> 
        <div class="header-nav__group">
          <nav>
            <ul class="header-nav">
              <li class="header-nav__item">
                @if(Auth::check())
                  <form class="header-nav__form" action="{{ route('logout') }}" method="post">
                    @csrf  
                      <button class="header-nav__link logout-button" type="submit">ログアウト</button>
                  </form>
                @else
                  <a class="header-nav__link login-button" href="{{ route('login') }}">ログイン</a>
                @endif
              </li>
              <li class="header-nav__item">
                <a class="header-nav__link" href="/mypage">マイページ</a>
              </li>
              <li class="header-nav__item">
                <a class="header-nav__link is-button" href="/sell">出品</a>
              </li>
            </ul>
          </nav>
        </div>
        @endempty
      </div>
    </header>
    <div class="content">
      @yield('content')
    </div>
  </div>
</body>
</html>