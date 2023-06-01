<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Page</title>
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">

</head>
<body>

    @extends('layout.layout')

    @section('title', 'List Page')

    @section('header', 'List Page')

@section('contents')

        <div class="contBox form">

            <table>



                <tr>
                    <th>글번호</th>
                    <th>제목</th>
                    <th>조회수</th>
                    <th>등록일</th>
                    <th>수정일</th>
                </tr>

                @forelse($data as $item)
                <tr>



                    <td>{{$item->id}}</td>
                    <td><a href="{{route('boards.show', ['board' => $item->id])}}">{{$item->title}}</a></td>


                    <td>{{$item->hits}}</td>
                    <td>{{$item->created_at}}</td>
                    <td>{{$item->updated_at}}</td>


                </tr>


                @empty

                @endforelse
            </table>

            <a class="button" href="{{route('boards.create')}}">글 작성</a>

        </div>
        

@endsection

</body>
</html>