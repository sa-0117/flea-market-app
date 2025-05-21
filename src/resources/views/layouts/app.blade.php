<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>flea-market-app</title>
  <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css" />
  <link rel="stylesheet" href="{{ asset('css/common.css')}}">
  @yield('css')
</head>

<body>
  <div class="app">
    <header class="header">
      <div class="header__inner">
        <div class="header__logo">
          <img src="{{ asset('storage/image/logo.svg') }}" alt="COACHTECH" onclick="location.href='/';">
        </div>
        @empty($HeaderParts)
        <div class="header__form">
          <form class="header__form-search" action="" method="get">
            <input type="text" name="keyword" placeholder="なにをお探しですか？">
          </form>
        </div> 
        <div class="header-nav__group">
          <nav>
            <ul class="header-nav">
              <li class="header-nav__item">
                <form class="header-nav__form" action="/logout" method="post">
                  @csrf  
                  <button class="header-nav__link logout-button" type="submit">ログアウト</button>
                </form>
              </li>
              <li class="header-nav__item">
                <a class="header-nav__link" href="/mypage">マイページ</a>
              </li>
              <li class="header-nav__item">
                <a class="header-nav__link is-button" href="/mypage">出品</a>
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