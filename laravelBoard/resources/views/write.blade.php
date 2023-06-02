@extends('layout.layout')

@section('title', 'Write Page')

@section('header', 'Write Page')

@section('contents')

    @include('layout.errorsvalidate')
    <form class="contBox" action="{{route('boards.store')}}" method="post">


        @csrf
        <label for="title">제목</label>
        <input type="text" name="title" id="title" value="{{old('title')}}">

        <br>
        <label for="content">내용</label>
        <textarea name="content" id="content">{{old('content')}}</textarea>


        <br>
        
        <button class="button" type="submit">작성하기</button>

    </form>
@endsection
