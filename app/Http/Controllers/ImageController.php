<?php
// http://localhost:88/PHP/ImageAI/public/image

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\User;
use App\Models\Ai_key;
use App\Models\Like_image;

class ImageController extends Controller
{
    public function indexGet(){
        $images = Image::select('image.id','image.token','user.login')->join('user','user.id','=','image.user_id')->where('image.visibility','1')->orderBy('image.updated_at')->take(50)->get();
        return view('Image/index',['images'=>$images]);
    }
    public function indexPost(Request $request){
        $data = $request->all();
        $images = Image::select('image.id','image.prompt','image.token','user.login')->join('user','user.id','=','image.user_id')->where('image.visibility','1')->orderBy('image.updated_at')->get();
        if((isset($data['Search_button']) && $data['Search_button']==='Search')&&(isset($data['Text_Search'])&&$data['Text_Search']!='')){
            $substring = $data['Text_Search']; 
            $images=$images->filter(function ($image) use ($substring) {return str_contains($image->prompt, $substring);});
        }
        $images=$images->take(50);
        return view('Image/index',['images'=>$images]);
    }

    public function addImageGet(){
        if(!session('User_Email')){return redirect('user/login');};
        return view('Image/addImage');
    }
    public function addImagePost(Request $request){
        if(!session('User_Email')){return redirect('user/login');};
        $data = $request->all();
        if((isset($data['Generation_button']) && $data['Generation_button']==='Trash')&&(isset($data['ID']) && $data['ID']!='')){
            $image = Image::where('image.id',"{$data['ID']}")->first();
            if(!$image){return view('Image/addImage',['ErrorCode'=>4]);}
            $User=User::where('email',session('User_Email'))->first();
            if($User&&$image['user_id']==$User['id']){
                $image->delete();
            }
            return view('Image/addImage');
        }
        elseif((isset($data['Generation_button']) && $data['Generation_button']==='Download')&&(isset($data['ID']) && $data['ID']!='')){
            $image = Image::where('image.id',"{$data['ID']}")->first();
            if(!$image){return view('Image/addImage',['ErrorCode'=>4]);}
            $path = public_path("Imag/{$image['token']}.png");
            if (file_exists($path)) {return response()->download($path);} 
        }
        elseif(isset($data['Generation_button']) && $data['Generation_button']==='Generation'){
            if((!$data['prompt'])||(!$data['ratio'])||$data['ratio']=='-'){return view('Image/addImage',['ErrorCode'=>1]);}
            $arrChar='aAbBcCdDeEfFjJhHiIgGkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ1234567890';
            $Token='';
            do {
                $Token='';
                for($i=0;$i<32;$i++){
                    $Token.=$arrChar[random_int(0,(strlen($arrChar)-1))];
                }
            } while (!Image::where('token',$Token)->get());
            $prompt=$data['prompt'];
            $gen=false;
            $translation=true;
            $image;
            do {
                $AiKey=Ai_key::where('active',1)->first();
                if(!$AiKey){return view('Image/addImage',['ErrorCode'=>3]);}
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://api.stability.ai/v2beta/stable-image/generate/sd3');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                $post_fields = array(
                    'mode' => 'text-to-image',
                    'prompt' => $prompt,
                    'aspect_ratio' => $data['ratio'],
                    'output_format' => 'png',
                    'model' => 'sd3',
                    'isValidPrompt' => 'true',);
                $headers = array(
                    'authorization: Bearer '.$AiKey['key'],
                    'accept: image/*',);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $response = curl_exec($ch);
                if(json_decode($response)!=null) {
                    $json_response=json_decode($response);
                    if($json_response->name=='payment_required'){
                        $AiKey->update(['active'=>0]);
                    }
                    elseif($json_response->name=='content_moderation'&&$translation){
                        $authKey = env('API_DeepL_KEY');;
                        try {
                            $translator = new \DeepL\Translator($authKey);
                            $result = $translator->translateText($prompt, null, 'en-US');
                            $prompt = $result->text;
                            $translation=false;
                        } catch (\Exception $e) {
                            return view('Image/addImage',['ErrorCode'=>5]);
                        }
                    }
                    else{
                        return view('Image/addImage',['ErrorCode'=>2]);
                    }
                } else {
                    file_put_contents(public_path('Imag/'.$Token.'.png'), $response);
                    $User=User::where('email',session('User_Email'))->first();
                    $image = Image::create([
                        'user_id'=>$User['id'],
                        'prompt'=>$data['prompt'],
                        'ratio'=>$data['ratio'],
                        'date_time'=> date('Y-m-d H:i:s', time()),
                        'token'=>$Token,
                    ]);
                    $gen=true;
                }
                curl_close($ch);
            } while (!$gen);
            return view('Image/addImage',['image'=>$image]);
        }
        return view('Image/addImage',['ErrorCode'=>2]);
    }

    public function oneImageGet($id){
        $image = Image::select('image.id','user.login','user.email','image.prompt','image.ratio','image.date_time','image.visibility','image.token',DB::raw('COUNT(like_image.id) as likes_count'))
        ->join('user','user.id','=','image.user_id')->leftJoin('like_image','like_image.image_id','=','image.id')
        ->groupBy('image.id', 'user.login', 'image.prompt', 'image.ratio', 'image.date_time', 'image.visibility', 'image.token')->where('image.id',"$id")->first();
        if(!$image){return redirect('/image');}
        $User=User::where('email',session('User_Email'))->first();
        $user_lick=0;
        if($User){
            $user_lick=Like_image::where('image_id',$image['id'])->where('user_id',$User['id'])->first();
            if($user_lick){$user_lick=1;}
        }
        return view('Image/oneImage',['image'=>$image,'user_lick'=>$user_lick]);
    }
    public function oneImagePost(Request $request){
        $data = $request->all();
        $image = Image::where('image.id',"{$data['ID']}")->first();
        if(!$image){return redirect('/image');}
        $User=User::where('email',session('User_Email'))->first();
        switch ($data['oneImg_button']) {
            case 'Download':{
                $path = public_path("Imag/{$image['token']}.png");
                if (file_exists($path)) {return response()->download($path);} 
                else {abort(404);}
            }break;
            case 'Like':{
                if($User){
                    $lick=Like_image::where('image_id',$image['id'])->where('user_id',$User['id'])->first();
                    if($lick){$lick->delete();}
                    else{Like_image::create(['user_id'=>$User['id'],'image_id'=>$image['id']]);}
                }
            }break;
            case 'Publish':{
                if($User){
                    $image = Image::where('user_id',"{$User['id']}")->where('image.id',"{$data['ID']}")->first();
                    if($image){
                        $image->visibility = $image->visibility == 0?1:0;
                        $image->save();
                    }
                }
            }break;
            case 'Trash':{
                if($User){
                    $image = Image::where('user_id',"{$User['id']}")->where('image.id',"{$data['ID']}")->first();
                    if($image){$image->delete();}
                }
            }break;
        }
        $image = Image::select('image.id','user.login','user.email','image.prompt','image.ratio','image.date_time','image.visibility','image.token',DB::raw('COUNT(like_image.id) as likes_count'))
        ->join('user','user.id','=','image.user_id')->leftJoin('like_image','like_image.image_id','=','image.id')
        ->groupBy('image.id', 'user.login', 'image.prompt', 'image.ratio', 'image.date_time', 'image.visibility', 'image.token')->where('image.id',"{$data['ID']}")->first();
        if(!$image){return redirect('/image');}
        $user_lick=0;
        if($User){
            $user_lick=Like_image::where('image_id',$image['id'])->where('user_id',$User['id'])->first();
            if($user_lick){$user_lick=1;}
        }
        return view('Image/oneImage',['image'=>$image,'user_lick'=>$user_lick]);
    }

    public function myImageGet(){
        if(!session('User_Email')){return redirect('user/login');};
        $images = Image::select('image.id','image.token','user.login')->join('user','user.id','=','image.user_id')->where('user.email',session('User_Email'))->get();
        return view('Image/index',['images'=>$images]);
    }
    public function myImagePost(Request $request){
        if(!session('User_Email')){return redirect('user/login');};
        $data = $request->all();
        $images = Image::select('image.id', 'image.prompt','image.token','user.login')->join('user','user.id','=','image.user_id')->where('user.email',session('User_Email'))->get();
        if((isset($data['Search_button']) && $data['Search_button']==='Search')&&(isset($data['Text_Search'])&&$data['Text_Search']!='')){
            $substring = $data['Text_Search']; 
            $images=$images->filter(function ($image) use ($substring) {return str_contains($image->prompt, $substring);});
        }
        return view('Image/index',['images'=>$images]);
    }

    public function likeImageGet(){
        if(!session('User_Email')){return redirect('user/login');};
        $User=User::where('email',session('User_Email'))->first();
        if(!$User){return redirect('user/login');};
        $images = Image::select('image.id', 'image.token', 'user.login')->join('user', 'user.id', '=', 'image.user_id')
        ->leftJoin('like_image', 'like_image.image_id', '=', 'image.id')
        ->where(function ($query) use ($User) {$query->where('image.visibility', '1')->orWhere('image.user_id', $User['id']);})
        ->where('like_image.user_id', $User['id'])->get();
        return view('Image/index',['images'=>$images]);
    }
    public function likeImagePost(Request $request){
        if(!session('User_Email')){return redirect('user/login');};
        $data = $request->all();
        $User=User::where('email',session('User_Email'))->first();
        if(!$User){return redirect('user/login');};
        $images = Image::select('image.id', 'image.prompt', 'image.token', 'user.login')->join('user', 'user.id', '=', 'image.user_id')
        ->leftJoin('like_image', 'like_image.image_id', '=', 'image.id')
        ->where(function ($query) use ($User) {$query->where('image.visibility', '1')->orWhere('image.user_id', $User['id']);})
        ->where('like_image.user_id', $User['id'])->get();
        if((isset($data['Search_button']) && $data['Search_button']==='Search')&&(isset($data['Text_Search'])&&$data['Text_Search']!='')){
            $substring = $data['Text_Search']; 
            $images=$images->filter(function ($image) use ($substring) {return str_contains($image->prompt, $substring);});
        }
        return view('Image/index',['images'=>$images]);
    }
}