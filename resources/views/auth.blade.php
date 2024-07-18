@extends('layouts.base')
@section('content')
    @php
        session_start();
        session_unset();
        session_destroy();
    @endphp
    <div id="logo">
        <img src="{{asset('images/Logo.png')}}">
    </div>
    <div id="authRegPageCont">
        <div class="navButtonCont">
            <input type="button" class="navButtonSelected" value="ВОЙТИ" onclick="location.href='{{url('/auth')}}'">
            <input type="button" class="navButton" value="РЕГИСТРАЦИЯ" onclick="location.href='{{url('/reg')}}'">
        </div>
        <form id="authForm">
        <div class="formCont">
            <input type="text" name="name" placeholder="Логин">
            <input type="password" name="password" placeholder="Пароль">
        </div>
            <input type="submit" value="Войти">
        </form>
    </div>
    <script src="{{asset('js/auth.js')}}">
    </script>
@endsection
