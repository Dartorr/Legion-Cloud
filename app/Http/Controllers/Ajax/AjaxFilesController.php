<?php

namespace App\Http\Controllers\Ajax;

use App\File;
use App\Folder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Util\Exception;

class AjaxFilesController extends Controller
{
    function deleteFolder(Request $request){
        try {
        $id=$request->all()['id'];
        if ($id==1) throw new \Exception('Нельзя удалить корневую папку');
        $folder=Folder::find($id);

        $files=File::where('inFolder', $id)->get();
        foreach ($files as $file){
            $this->deleteFileId($file->id);
        }

        $folder->delete();
        return json_encode(['result'=>true]);
        } catch (\Exception $exception){
            return json_encode(['result'=>false, 'error'=>$exception->getMessage()]);
        }
    }

    function addfile(Request $request)
    {
        try {
            $data = $request->all();

            $file = $request->file('file');
            $upload_folder = 'public/files';
            $filename = $file->getClientOriginalName();
            //storage/files/image.jpg

            $exFiles=File::where('fileName',$filename)->get();
            if (!($exFiles->isEmpty()))
                throw new \Exception('Файл с таким именем уже существует. Попробуйте изменить имя.');

            Storage::putFileAs($upload_folder, $file, $filename);

            File::create([
                'url' => '/public/files/' . $filename,
                'fileName' => $filename,
                'ext' => $file->extension(),
                'size' => $file->getSize(),
                'inFolder' => $data['folder']
            ]);

            return json_encode(['result' => true]);
        } catch (\Exception $exception) {
            return json_encode(['result' => false, 'error' => $exception->getMessage()]);
        }

    }

    function addfolder(Request $request)
    {
        try {
            $data = $request->all();
             if ($data['folder_name']==null) throw new \Exception('Имя папки не может быть пустым');

            if (Folder::where('name', $data['folder_name'])->get()->isEmpty()) {
                Folder::create([
                    'name' => $data['folder_name']
                ]);

                return json_encode(['result' => true]);
            } else
                return json_encode(['result' => false, 'error' => 'Такая папка уже существует']);
        } catch (\Exception $exception) {
            return json_encode(['result' => false, 'error' => $exception->getMessage()]);
        }
    }

    function getData()
    {
        $data = [];

        foreach (Folder::all() as $folder) {
            $files = File::where('inFolder', $folder->id)->get();
            $data[$folder->id] = [$folder->name, $files];
        }

        return json_encode(['data' => $data]);
    }

    function getFolders()
    {
        return json_encode(['folders' => Folder::all()]);
    }

    function getFiles(Request $request)
    {
        $data=$request->all();

        $files = File::where('inFolder', $data['folderId'])->get();

        return json_encode(['files' => $files]);
    }

    function getFilesFilter(Request $request)
    {
        $data=$request->all();

        $whereFrom=[];
        $whereUpTo=[];
        $whereExt=[];

        if (isset($data['sizeFrom']))
            array_push($whereFrom, ['size', '>=', $data['sizeFrom']*1024]);
        if (isset($data['dateFrom']))
            array_push($whereFrom, ['created_at', '>=', $data['dateFrom']]);

        if (isset($data['sizeUpTo']))
            array_push($whereUpTo, ['size', '<=', $data['sizeUpTo']*1024]);
        if (isset($data['dateUpTo']))
            array_push($whereUpTo, ['created_at', '<=', $data['dateUpTo']]);

        if (isset($data['ext']))
            array_push($whereExt, ['ext', $data['ext']]);

        $files = File::where($whereFrom)
            ->where($whereUpTo)
            ->where($whereExt)
            ->get();

        return json_encode(['files' => $files]);
    }

    function deleteFile(Request $request){
        try {
            $file=File::find($request->all()['id']);
            if (!Storage::delete($file->url)) throw new Exception('Файл не был удален');
            $file->delete();

            return json_encode(['result'=>true]);
        } catch (\Exception $exception){
            return json_encode(['result'=>false, 'errors'=>$exception]);
        }
    }

    function deleteFileId($id){
        try {
            $file=File::find($id);
            if (!Storage::delete($file->url)) throw new Exception('Файл не был удален');
            $file->delete();

            return json_encode(['result'=>true]);
        } catch (\Exception $exception){
            return json_encode(['result'=>false, 'errors'=>$exception]);
        }
    }

    function getUrl(Request $request){
//        try {
            $data=$request->all();

            return json_encode(['result'=>true, 'url'=>url($data['url'])]);
//        } catch (\Exception $exception){
//            return json_encode(['result'=>false, 'errors'=>$exception]);
//        }
    }

    function downloadFile(Request $request){
        $download_link = link_to_asset($request->all()['url']);
        return $download_link;
    }
}
