@extends('layout.layout')

@section('title', 'Registration Page')


@section('header', 'Registration Page')


@section('contents')
    @include('layout.errorsvalidate')

    <form class="contBox" action="{{route('users.registration.post')}}" method="post">
        @csrf
        <label for="name">Name : </label>
        <input type="text" name="name" id="name">
        <br>

        <label for="email">Email : </label>
        <input type="text" name="email" id="email">
        <br>
        <label for="password">Password : </label>
        <input type="password" name="password" id="password">
        <br>
        <label for="passwordchk">Password Check : </label>
        <input type="password" name="passwordchk" id="passwordchk">
        <br>

        <button class="button" type="submit">Registration</button>

        <button class="button" type="button" onclick="location.href='{{Route('users.login')}}'">Cancle</button>

    </form>

@endsection

