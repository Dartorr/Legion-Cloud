<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\InvitationKey;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AjaxAuthRegController extends Controller
{
    function reg(Request $request)
    {

        try {
        $data = $request->all();

        $valid = Validator::make($request->all(), [
            'name' => ['alpha', 'max:30', 'required'],
            'inv_code'=>['required'],
            'password' => ['confirmed', 'required', 'min:8']
        ]);

        if (count($valid->errors()) != 0)
            return json_encode(['result'=>false, 'error'=>$valid->errors()]);

        if (count(User::where('name', $data['name'])->get())!=0)
            throw new \Exception('Пользователь с таким именем уже существует');

        $where = [
            ['code', $data['inv_code']],
            ['activated', false]
        ];

        $code=InvitationKey::where($where)->get();

        if (count($code) == 0)
            throw new \Exception('Данный код приглашения не найден');

        $user=User::create([
            'name'=>$data['name'],
            'password'=>md5($data['password']),
            'role'=>2
        ]);

        $code=$code[0];
        $code->activated=true;
        $code->save();

        session_start();
        $_SESSION['id']=$user->id;

        return json_encode(['result'=>true, 'url'=>url('/')]);
        }
        catch (\Exception $exception){
            return json_encode(['result'=>false, 'ex'=>$exception->getMessage()]);
        }


    }

    function auth(Request $request)
    {
        $data = $request->all();

        $where = [
            ['name', $data['name']],
            ['password', md5($data['password'])]
        ];

        $users = User::where($where)->get();

        if (count($users) == 0) {
            return json_encode(['result' => false, 'error' => 'Такого сочетания логина и пароля не существует']);
        } else {
            session_start();
            $_SESSION['id'] = $users[0]->id;
            return json_encode(['result' => true, 'url'=>url('/')]);
        }
    }

    function genCode()
    {
        try {

            $code = random_int(0, 10000000);

            while (count(InvitationKey::where('code', $code)->get()) != 0)
                $code = random_int(0, 10000000);

            $invcode = InvitationKey::create([
                'code' => $code,
                'activated' => false
            ]);
            return json_encode(['result' => true, 'code' => $code]);

        } catch (\Exception $exception) {
            return json_encode(['result' => false, 'error' => $exception->getMessage()]);
        }


    }
}
