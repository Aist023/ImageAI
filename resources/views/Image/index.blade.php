@extends('layouts/default')
@section('title') Image @endsection
@section('content')
<div class="main-gallery">
    <div class="search-block">
        <form action="" method="post" class="search-block-form">
            @csrf
            <div class="search-block-text">
                <img src="{{asset('/Icon/Icon-Img.png')}}" alt="" class="icon">
                <input type="text" name="Text_Search" id="" maxlength="150" class="search-block-input search-block-input-mar" placeholder="Search for baskets..." value="<?php echo (isset($_POST['Text_Search']))?$_POST['Text_Search']:''?>">
            </div>
            <div>
                <button type="submit" class="search-block-button search-block-button-d" name="Search_button" value="Search">Search</button>
            </div>
        </form>
    </div>
    <div class="main-padding">
        <div class="image-gallery">
            @if (isset($images))
                @foreach ($images as $item)
                    <a href="/PHP/ImageAI/public/image/oneImage/{{$item['id']}}"><div class="image-gallery-block">
                        <img src="{{asset('/Imag/'.$item['token'].'.png')}}" alt="" class="image-gallery-block-img-front">
                        <div class="image-gallery-block-img-infa-front"><p>{{$item['login']}}</p></div>
                    </div></a>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection