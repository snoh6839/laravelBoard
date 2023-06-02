@extends('layout.layout')

@section('title', 'Edit Page')

@section('header', 'Edit Page')

@section('contents')

    @if(count($errors) > 0)
    @foreach($errors->all() as $error)
    <div class="warning-msg">
        !!! Warning : {{ $error }} !!!
    </div>
    @endforeach
    @endif

    
    <form class="contBox" action="{{route('boards.update',['board'=>$data->id])}}" method="post">


        @csrf
        @method('put')
        <label for="title">제목</label>
        <input type="text" name="title" id="title" value="{{ count($errors) > 0 ? old('title') : $data->title }}">

        <br>
        <label for="content">내용</label>
        <textarea name="content" id="content">{{ count($errors) > 0 ? old('content') : $data->content }}</textarea>




        <br>
        <button class="button" type="submit">수정</button>
        <button class="button" type="button" onclick="location.href='{{Route('boards.show',['board'=>$data->id])}}'">취소</button>
    </form>

@endsection
