<?php
// http://localhost:88/PHP/ImageAI/public/user

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ai_key;

class AiKeyController extends Controller
{
    public function addAiKeyGet(){
        return view('AiKey/addAiKey');
    }

    public function addAiKeyPost(Request $request){
        $data = $request->all();
        if(isset($data['Ai_Key_button']) && $data['Ai_Key_button']==='Exit'){return redirect('');}
        elseif(isset($data['Ai_Key_button']) && $data['Ai_Key_button']==='Save'){
            if((!$data['email'])||(!$data['password'])||(!$data['key'])){return view('AiKey/addAiKey');}
            $Ai_key=Ai_key::where('key',$data['key'])->first();
            if($Ai_key){return view('AiKey/addAiKey');}
            Ai_key::create([
                'email'=>$data['email'],
                'password'=>$data['password'],
                'key'=>$data['key'],
            ]);
            return redirect('');
        }
        return view('AiKey/addAiKey');
    }
}