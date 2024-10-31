<?php
// http://localhost:88/PHP/ImageAI/public/

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function indexGet(){
        return view('Home/index');
    }
}