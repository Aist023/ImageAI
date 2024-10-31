@extends('layouts/default')
@section('title') Add image @endsection
@section('content')
<div class="create_block">
    <form action="" method="post" class="create_block-form">
        @csrf
        <input type="text" name="ID" value="<?php echo isset($image['id'])?$image['id']:'' ?>" hidden>
        <div class="create_block-form-block">
            <p>Image Prompt:</p>
            <textarea name="prompt" id="" maxlength="1500" rows="5" class="create_block-form-block-textarea" placeholder="Image Prompt"><?php echo (isset($_POST['prompt']))?$_POST['prompt']:'' ?></textarea>
        </div>
        <div class="create_block-form-block">
            <p>Ratio:</p>
            <select name="ratio" id="ratio" class="create_block-form-block-select">
                <option value="-">-</option>
                <option value="21:9" <?php echo (isset($_POST['ratio'])&&$_POST['ratio']=='21:9')? 'selected':'' ?>>21:9</option>
                <option value="16:9" <?php echo (isset($_POST['ratio'])&&$_POST['ratio']=='16:9')? 'selected':'' ?>>16:9</option>
                <option value="5:4" <?php echo (isset($_POST['ratio'])&&$_POST['ratio']=='5:4')? 'selected':'' ?>>5:4</option>
                <option value="3:2" <?php echo (isset($_POST['ratio'])&&$_POST['ratio']=='3:2')? 'selected':'' ?>>3:2</option>
                <option value="1:1" <?php echo (isset($_POST['ratio'])&&$_POST['ratio']=='1:1')? 'selected':'' ?>>1:1</option>
                <option value="2:3" <?php echo (isset($_POST['ratio'])&&$_POST['ratio']=='2:3')? 'selected':'' ?>>2:3</option>
                <option value="4:5" <?php echo (isset($_POST['ratio'])&&$_POST['ratio']=='4:5')? 'selected':'' ?>>4:5</option>
                <option value="9:16" <?php echo (isset($_POST['ratio'])&&$_POST['ratio']=='9:16')? 'selected':'' ?>>9:16</option>
                <option value="9:21" <?php echo (isset($_POST['ratio'])&&$_POST['ratio']=='9:21')? 'selected':'' ?>>9:21</option>
            </select>
        </div>
        @if (isset($ErrorCode)&&$ErrorCode==1) <p class="create_block-form-Global_Error">Fill in all fields</p> @endif
        @if (isset($ErrorCode)&&$ErrorCode==2) <p class="create_block-form-Global_Error">Error</p> @endif
        @if (isset($ErrorCode)&&$ErrorCode==3) <p class="create_block-form-Global_Error">Ran out of koins</p> @endif
        @if (isset($ErrorCode)&&$ErrorCode==4) <p class="create_block-form-Global_Error">Can't complete the command no image</p> @endif
        @if (isset($ErrorCode)&&$ErrorCode==4) <p class="create_block-form-Global_Error">Error DeepL</p> @endif
        <div class="create_block-form-button_block">
            <div class="create_block-form-button_block--flex">
                <button type="submit" name="Generation_button" value="Trash" class="create_block-form-button_block-button create_block-form-button_block-button-r">
                    <img src="{{asset('/Icon/Icon-Trash.png')}}" alt="" class="icon">
                    <p>Trash</p>
                </button>
                <button type="submit" name="Generation_button" value="Download" class="create_block-form-button_block-button create_block-form-button_block-button-h">
                    <img src="{{asset('/Icon/Icon-Download.png')}}" alt="" class="icon">
                    <p>Download</p>
                </button>
            </div>
            <div>
                <button type="submit" name="Generation_button" value="Generation" class="create_block-form-button_block-button create_block-form-button_block-button-h">
                    <p>Generation</p>
                </button>
            </div>
        </div>
        <div class="create_block-form-image_block">
            @if (isset($image['token']))
                <img src="{{asset('/Imag/'.$image['token'].'.png')}}" alt="" class="create_block-form-image_block-image create_block-form-image_block-image-style">
            @else
                <img src="{{asset('/Icon/Icon-Img_Error.png')}}" alt="" class="create_block-form-image_block-image ">
            @endif
        </div>
    </form>
</div>
@endsection