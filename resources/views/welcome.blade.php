<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LCloud</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body>
@include('layouts.header')
@include('layouts.preloader')
<div id="logo_main">
    <img src="{{asset('images/Logo.png')}}">
</div>
<div id="filesystem">
    <div id="currentFolderNameCont">
        <div id="currentFolderName">
            Корпоративное
        </div>
        <div class="addFileCont">
            <input type="button" value="Загрузить файл" onclick="showNewFileForm()">
        </div>
        <div class="addFileCont">
            <input type="button" value="Фильтрация" onclick="location.href='{{url('/filter')}}'">
        </div>
        <div id="removeFolderCont">
            <input type="button" value="Удалить папку" onclick="removeFolder()">
        </div>
    </div>
    <div id="folders">
        @foreach(\App\Folder::all() as $folder)
            <input type="button" value="{{$folder->name}}" onclick="refreshFiles({{$folder->id}},'{{$folder->name}}')">
        @endforeach
        <input type="button" value="Добавить папку" onclick="showNewFolderForm()">
    </div>
    <div id="filesCont">
        <table id="filesTable">
            <tr class="fileRow">
                <td class="fileInfo">
                    Имя
                </td>
                <td class="fileInfo">
                    Расширение
                </td>
                <td class="fileInfo">
                    Размер
                </td>
                <td class="fileInfo">
                    Загружен
                </td>
                <td class="fileInfo">

                </td>
                <td class="fileInfo">

                </td>
            </tr>

            @foreach(\App\File::where('inFolder', 1)->get() as $file)
                <tr class="fileRow">
                    <td class="fileInfo">
                        {{$file->fileName}}
                    </td>
                    <td class="fileInfo">
                        {{$file->ext}}
                    </td>
                    <td class="fileInfo">
                        {{$file->size}}
                    </td>
                    <td class="fileInfo">
                        {{$file->created_at}}
                    </td>
                    <td class="fileInfo">
                        <form action="/downloadFile">
                            <input style="display: none" type="text" value="{{$file->url}}" name="url">
                            <input class="downloadButton" type="submit" value="Скачать">
                        </form>
                    </td>
                    <td class="fileInfo">
                        <input type="button" value="Удалить" onclick="deleteFile({{$file->id}})">
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <div id="addFolderFormCont">
        <div>
            <form id="create_folder">
                <input type="text" name="folder_name" placeholder="Имя новой папки">
                <input type="submit" value="Создать">
                <input type="button" value="Отменить" onclick="hideNewFolderForm()">
            </form>
        </div>
    </div>
    <div id="addFileFormCont">
        <div>
            <form id="addForm">
                <input type="file" name="file">
                <input type="submit" value="Загрузить">
                <input type="button" value="Отменить" onclick="hideNewFileForm()">
            </form>
        </div>
    </div>
</div>
@if(isset($_SESSION['canInvite']))
    @if($_SESSION['canInvite']==true)
        @include('layouts.invcode')
    @endif
@endif
</body>
<script src="{{asset('js/file.js')}}">
</script>
</html>
