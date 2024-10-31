@extends('layouts/default')
@section('title') Login @endsection
@section('style') form_style @endsection
@section('content')
<div class="block-center">
    <form action="" method="post" class="forma-LR">
        @csrf
        <h2 class="forma-LR-h2">Login</h2>
        <div class="forma-LR-blokc_input">
            <p>Email:</p>
            <div class="forma-LR-blokc_input-pole">
                <img src="{{asset('/Icon/Icon-Email.png')}}" alt="" class="icon">
                <input type="text" name="email" id="" maxlength="50" class="forma-LR-blokc_input-pole-input" placeholder="Email" value="<?php echo (isset($_POST['email']))?$_POST['email']:'' ?>">
            </div>
        </div>
        <div class="forma-LR-blokc_input">
            <p>Password:</p>
            <div class="forma-LR-blokc_input-pole">
                <img src="{{asset('/Icon/Icon-Password.png')}}" alt="" class="icon">
                <input type="password" name="password" id="" maxlength="50" class="forma-LR-blokc_input-pole-input" placeholder="Password" value="<?php echo (isset($_POST['password']))?$_POST['password']:'' ?>">
            </div>
        </div>
        @if (isset($ErrorCode)&&$ErrorCode==1) <p class="forma-LR-blokc_input-p-Global_Error">Fill in all fields</p> @endif
        @if (isset($ErrorCode)&&$ErrorCode==2) <p class="forma-LR-blokc_input-p-Global_Error">Wrong email or password</p> @endif
        @if (isset($ErrorCode)&&$ErrorCode==3) <p class="forma-LR-blokc_input-p-Global_Error">Error</p> @endif
        <div class="forma-LR-blokc_button">
            <button type="submit" name="Login_button" class="forma-LR-blokc_button-button" value="Login">Login</button>
        </div>
    </form>
</div>
</div>
@endsection