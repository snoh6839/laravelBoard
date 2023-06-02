<header>
    <h1>@yield('header', 'header')</h1>
    
</header>
    @auth
    <nav class="nav">
        <a href="{{route('users.logout')}}" class="nav-item is-active" active-color="orange">로그아웃</a>
        <a href="{{route('users.edit')}}" class="nav-item" active-color="green">회원정보 수정</a>
        <span class="nav-indicator"></span>
        <script src="{{asset('/js/app.js')}}"></script>

    </nav>

    @endauth
    @guest
    <nav class="nav">
        <a href="{{route('users.login')}}" class="nav-item is-active" active-color="red">로그인 페이지</a>


        <a href="{{route('users.registration')}}" class="nav-item" active-color="blue">회원가입</a>
        <span class="nav-indicator"></span>
        <script src="{{asset('/js/app.js')}}"></script>

    </nav>
    @endguest


