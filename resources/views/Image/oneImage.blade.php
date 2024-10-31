@extends('layouts/default')
@section('title') One image @endsection
@section('content')
<div class="image_one">
    <div class="image_one-img_block">
        <img src="{{asset('/Imag/'.$image['token'].'.png')}}" alt="" class="image_one-img_block-img_bek">
        <div class="image_one-img_block-block_front">
            <div class="image_one-img_block-block_front-padding">
                <img src="{{asset('/Imag/'.$image['token'].'.png')}}" alt="" class="image_one-img_block-block_front-img">
            </div>
        </div>
    </div>
    <div class="image_one-info">
        <div class="image_one-info-block">
            <form action="{{route('image.oneImage')}}" method="post" class="image_one-info-block-form">
                @csrf
                <input type="text" name="ID" value="{{$image['id']}}" hidden>
                <div class="image_one-info-block-form-top">
                    <h3 class="image_one-info-block-form-top-h3">{{$image['login']}}</h3>
                    <p class="image_one-info-block-form-top-smol_p">{{$image['date_time']}}</p>
                    <p class="image_one-info-block-form-top-p">
                        {{$image['prompt']}}
                    </p>
                    <p class="image_one-info-block-form-top-smol_p">{{$image['ratio']}}</p>
                    <div class="image_one-info-block-form-top-button_blokc">
                        <button type="submit" name="oneImg_button" value="Download" class="image_one-info-block-form-min_button">
                            <img src="{{asset('/Icon/Icon-Download.png')}}" alt="" class="icon">
                            <p class="image_one-info-block-form-min_button-p">Download</p>
                        </button>
                        <button type="submit" name="oneImg_button" value="Like" class="image_one-info-block-form-min_button">
                            <?php $Icon_Likee = '/Icon/Icon-Likee'.(($user_lick==1)?'-sel':'').'.png' ?>
                            <img src="{{asset($Icon_Likee)}}" alt="" class="icon">
                            <p class="image_one-info-block-form-min_button-p">{{$image['likes_count']}}</p>
                        </button>
                    </div>
                </div>
                @if (session('User_Email')===$image['email'])
                    <div class="image_one-info-block-form-bottom">
                        <div class="image_one-info-block-form-bottom-button_blokc">
                            <button type="submit" name="oneImg_button" value="Publish" class="image_one-info-block-form-max_button image_one-info-block-form-max_button-h">
                                <p>Publish: <?php echo ($image['visibility']==0)?'On':'Off' ?></p>
                            </button>
                            <button type="submit" name="oneImg_button" value="Trash" class="image_one-info-block-form-max_button image_one-info-block-form-max_button-r">
                                <img src="{{asset('/Icon/Icon-Trash.png')}}" alt="" class="icon">
                                <p>Trash</p>
                            </button>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection