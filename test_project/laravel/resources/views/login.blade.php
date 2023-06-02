@extends('layout.layout')
@section('title', 'Login Page')
@section('contents')
    @include('layout.errors')

    <form action="{{route('user.loginpost')}}" method="post">
    @csrf
        <label for="email">이메일 : </label>
        <input type="text" name="email" id="email">
        <label for="password">비밀번호 : </label>
        <input type="password" name="password" id="password">
        <button type="submit">로그인</button>
    </form>
@endsection