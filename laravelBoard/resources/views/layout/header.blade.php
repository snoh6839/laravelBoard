<header>
    <h1>@yield('header', 'header')</h1>
</header>

@auth
<nav class="nav">
    
    <a href="{{ route('boards.index') }}" class="nav-item {{ Request::is('users/edit') ? '' : 'is-active' }}" active-color="red">홈으로</a>
    <a href="{{ route('users.edit') }}" class="nav-item {{ Request::is('users/edit') ? 'is-active' : '' }}" active-color="blue">회원정보 수정</a>

    <a href="{{ route('users.logout') }}" class="nav-item {{ Request::is('users/logout') ? 'is-active' : '' }}" active-color="green">로그아웃</a>


    <span class="nav-indicator"></span>
</nav>
@endauth

@guest
<nav class="nav">
    <a href="{{ route('users.login') }}" class="nav-item {{ Request::is('users/login') ? 'is-active' : '' }}" active-color="red">로그인 페이지</a>

    <a href="{{ route('users.registration') }}" class="nav-item {{ Request::is('users/registration') ? 'is-active' : '' }}" active-color="blue">회원가입</a>

    <span class="nav-indicator"></span>
</nav>
@endguest

<script src="{{ asset('/js/app.js') }}"></script>
