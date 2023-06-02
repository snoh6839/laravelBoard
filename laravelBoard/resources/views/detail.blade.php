@extends('layout.layout')

@section('title', 'Detail Page')

@section('header', 'Detail Page')

@section('contents')

    <div class="contBox">
        

        
        <p>글번호 : {{$data->id}} 조회수 : {{$data->hits}}</p>
        <p>제목 : {{$data->title}}</p>
        <p>등록일자 : {{$data->created_at}} 수정일자 : {{$data->updated_at}}</p>
        <p>내용 : {{$data->content}}</p>
        

            

        <form action="{{route('boards.destroy',['board' => $data->id])}}" method="post">
            @csrf
            @method('delete')
            <button class="button" type="button" onclick="location.href='{{route('boards.edit',['board' => $data->id])}}'">수정하기</button>
            <button class="button" type="submit">삭제하기</button>
        </form>

            
    </div>

@endsection