<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('Icon/Icon-AI.png') }}">
    <title>Image-AI | @yield('title')</title>
    <link rel="stylesheet" href="{{asset('/css/app.css')}}">
    <link rel="stylesheet" href="{{asset('/css/menu.css')}}">
    <link rel="stylesheet" href="{{asset('/css/image_gallery.css')}}">
    <link rel="stylesheet" href="{{asset('/css/form_style.css')}}">
    <link rel="stylesheet" href="{{asset('/css/one_image.css')}}">
    <link rel="stylesheet" href="{{asset('/css/create.css')}}">
    <style>
    </style>
</head>
<body>
    <?php
        $Mitem_bef='menu-item menu-item-hover';
        $Mitem_sel='menu-item-r';
        ?>
    <div class="flex">
        <menu class="menu">
            <div class="menu-head-blokc">
                <a href="/PHP/ImageAI/public/image"><div class="menu-head"><h3>Image-AI</h3></div></a>
                <a href="{{route('image.index')}}"><div class="{{request()->routeIs('image.index')?$Mitem_sel:$Mitem_bef}}"><img src="{{asset('Icon/Icon-Explore'.(request()->routeIs('image.index')?'-r':'').'.png')}}" alt="" class="icon"><p>Explore</p></div></a>
                <a href="{{route('image.addImage')}}"><div class="{{request()->routeIs('image.addImage')?$Mitem_sel:$Mitem_bef}}"><img src="{{asset('/Icon/Icon-Create'.(request()->routeIs('image.addImage')?'-r':'').'.png')}}" alt="" class="icon"><p>Create</p></div></a>
                <a href="{{route('image.myImage')}}"><div class="{{request()->routeIs('image.myImage')?$Mitem_sel:$Mitem_bef}}"><img src="{{asset('/Icon/Icon-My_Gallery'.(request()->routeIs('image.myImage')?'-r':'').'.png')}}" alt="" class="icon"><p>My Gallery</p></div></a>
                <a href="{{route('image.likeImage')}}"><div class="{{request()->routeIs('image.likeImage')?$Mitem_sel:$Mitem_bef}}"><img src="{{asset('/Icon/Icon-M_Like'.(request()->routeIs('image.likeImage')?'-r':'').'.png')}}" alt="" class="icon"><p>Liked</p></div></a>
                @if (true)
                    <a href="{{route('aikey.addAiKey')}}"><div class="{{request()->routeIs('aikey.addAiKey')?$Mitem_sel:$Mitem_bef}}"><img src="{{asset('/Icon/Icon-AI'.(request()->routeIs('aikey.addAiKey')?'-r':'').'.png')}}" alt="" class="icon"><p>Add AI-key</p></div></a>
                @endif    
            </div>
            <div class="menu-futer-blokc">
                <a href="{{route('image.home')}}"><div class="{{request()->routeIs('image.home')?$Mitem_sel:$Mitem_bef}}"><img src="{{asset('/Icon/Icon-Info'.(request()->routeIs('image.home')?'-r':'').'.png')}}" alt="" class="icon"><p>Info</p></div></a>
                @if (session('User_Email'))
                    <a href="{{route('user.exit')}}"><div class="menu-item-r"><img src="{{asset('/Icon/Icon-Exit.png')}}" alt="" class="icon"><p>Exit: {{session('User_Login')}}</p></div></a>
                @else
                <a href="{{route('user.login')}}"><div class="menu-item menu-item-def"><img src="{{asset('/Icon/Icon-Log_In.png')}}" alt="" class="icon"><p>Login</p></div></a>
                <a href="{{route('user.registr')}}"><div class="menu-item-r"><img src="{{asset('/Icon/Icon-Sing_Up.png')}}" alt="" class="icon"><p>Registr</p></div></a>
                @endif
            </div>
        </menu>
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>