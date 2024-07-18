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
            <input type="button" class="navButton" value="ВОЙТИ" onclick="location.href='{{url('/auth')}}'">
            <input type="button" class="navButtonSelected" value="РЕГИСТРАЦИЯ" onclick="location.href='{{url('/reg')}}'">
        </div>
        <form id="regform">
            <div class="formCont">
                <input type="text" name="name" placeholder="Логин">
                <div id="name_errors"></div>
                <input type="number" name="inv_code" placeholder="Код приглашения">
                <div id="inv_code_errors"></div>
                <input type="password" name="password" placeholder="Пароль">
                <div id="password_errors"></div>
                <input type="password" name="password_confirmation" placeholder="Повторите пароль">
            </div>
            <input type="submit" value="Войти">
        </form>
    </div>
    <script src="{{asset('js/reg.js')}}"></script>
@endsection
