@extends('layout.layout')

@section('title', 'Login Page')

@section('header', 'Login Page')

@section('contents')

@if(session()->has('success'))

    <h2 class="success-msg">{{session('success')}}</h2>

@endif

    {{-- <h2 class="success-msg">{{session()->has('success') ? session('success') : ""}}</h2> --}}
    @include('layout.errorsvalidate')

    <form class="contBox" action="{{route('users.login.post')}}" method="post">
        @csrf
        <label for="email">Email : </label>
        <input type="text" name="email" id="email">
        <br>
        <label for="password">Password : </label>
        <input type="password" name="password" id="password">
        <br>
        <button class="button" type="submit">Login</button>

    </form>

@endsection