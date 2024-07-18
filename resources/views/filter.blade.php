@extends('layouts.base')
@section('content')
    @include('layouts.header')
    @include('layouts.preloader')
    <div id="filterCont">
        <form id="filterForm">
            <table>
                <tr>
                    <td>
                        <input type="button" value="Назад" onclick="location.href='{{url('/')}}'">
                    </td>
                    <td>
                        От
                    </td>
                    <td>
                        До
                    </td>
                </tr>
                <tr>
                    <td>
                        Размер (KB)
                    </td>
                    <td>
                        <input type="number" name="sizeFrom" placeholder="0">
                    </td>
                    <td>
                        <input type="number" name="sizeUpTo" placeholder="10">
                    </td>
                </tr>
                <tr>
                    <td>
                        Создан
                    </td>
                    <td>
                        <input type="date" name="dateFrom">
                    </td>
                    <td>
                        <input type="date" name="dateUpTo">
                    </td>
                </tr>
                <tr>
                    <td>
                        Расширение
                    </td>
                    <td colspan="2">
                        <input type="text" name="ext" placeholder=".docx">
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <input type="submit">
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
            </table>
        </form>
        <div id="filesCont">
        </div>
    </div>
    <script src="{{asset('js/file.js')}}"></script>
    <script src="{{asset('js/filter.js')}}">
    </script>
@endsection
