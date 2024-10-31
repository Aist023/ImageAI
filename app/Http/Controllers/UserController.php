<?php
// http://localhost:88/PHP/ImageAI/public/user

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function loginGet(){
        return view('User/login');
    }
    public function loginPost(Request $request){
        $data = $request->all();
        if(isset($data['Login_button']) && $data['Login_button']==='Login'){
            if((!$data['email'])||(!$data['password'])){return view('User/login',['ErrorCode'=>1]);}
            $User=User::where('email',$data['email'])->where('password',$data['password'])->first();
            if(!$User){return view('User/login',['ErrorCode'=>2]);}
            session(['User_Email'=>$User['email'],'User_Login'=>$User['login']]);
            return redirect('image');
        }
        return view('User/login',['ErrorCode'=>3]);
    }

    public function registrGet(){
        return view('User/registr');
    }
    public function registrPost(Request $request){
        $data = $request->all();
        if(isset($data['Registr_button']) && $data['Registr_button']==='Registr'){
            if((!$data['login'])||(!$data['email'])||(!$data['password'])||(!$data['repeat_password'])){return view('User/registr',['ErrorCode'=>1]);}
            if($data['password']!=$data['repeat_password']){return view('User/registr',['ErrorCode'=>2]);}
            $User=User::where('email',$data['email'])->first();
            if($User){return view('User/registr',['ErrorCode'=>3]);}
            $User=User::create([
                'login'=>$data['login'],
                'email'=>$data['email'],
                'password'=>$data['password'],
            ]);
            session(['User_Email'=>$User['email'],'User_Login'=>$User['login']]);
            return redirect('image');
        }
        return view('User/registr',['ErrorCode'=>4]);
    }

    public function exit(){
        session()->forget('User_Email');
        session()->forget('User_Login');
        return redirect('image');
    }
}