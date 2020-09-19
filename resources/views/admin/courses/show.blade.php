@extends('admin.index')

@section('content')
    <h1>{{$course->name}} ({{$course->code}})</h1>
    <h2>{{$course->faculty->name}}</h2>
{{--    <h2>Kursy:</h2>--}}

{{--    <table>--}}
{{--        <tr>--}}
{{--            <th>Id</th>--}}
{{--            <th>Nazwa</th>--}}
{{--            <th>Code</th>--}}
{{--        </tr>--}}
{{--        @foreach($faculty->courses as $course)--}}
{{--            <tr>--}}
{{--                <td><a href="{{route('admin.courses.show', [$course->id])}}">{{$course->id}}</a></td>--}}
{{--                <td>{{$course->name}}</td>--}}
{{--                <td>{{$course->code}}</td>--}}
{{--            </tr>--}}
{{--        @endforeach--}}
{{--    </table>--}}
@endsection
