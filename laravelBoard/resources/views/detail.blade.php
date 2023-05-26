<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Page</title>
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">

</head>
<body>
    <header>
        <h1>BOARD LIST</h1>
    </header>
    <div class="contBox">
        <form action="{{route('boards.destroy',['board' => $data->id])}}" method="post">
            @csrf
            @method('delete')
            <button class="button" type="submit">삭제하기</button>
        </form>

        
        <p>글번호 : {{$data->id}} 조회수 : {{$data->hits}}</p>
        <p>제목 : {{$data->title}}</p>
        <p>등록일자 : {{$data->created_at}} 수정일자 : {{$data->updated_at}}</p>
        <p>내용 : {{$data->content}}</p>
        
        <div class="button-wrap">
            <button class="button" type="button" onclick="location.href='{{route('boards.index')}}'">리스트로</button>
            <button class="button" type="button" onclick="location.href='{{route('boards.edit',['board' => $data->id])}}'">수정하기</button>
        </div>
            
    </div>

</body>
</html>