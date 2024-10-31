@extends('layouts/default')
@section('title') Add Ai_Key @endsection
@section('content')
<div class="block-center">
    <form action="" method="post" class="forma-LR">
        @csrf
        <h2 class="forma-LR-h2">Add AI-key</h2>
        <p class="forma-LR-blokc_input-p-Error">Keys are created here: <a href="https://platform.stability.ai/sandbox">https://platform.stability.ai/sandbox</a></p>
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
                <input type="text" name="password" id="" maxlength="50" class="forma-LR-blokc_input-pole-input" placeholder="Password" value="<?php echo (isset($_POST['password']))?$_POST['password']:'' ?>">
            </div>
        </div>
        <div class="forma-LR-blokc_input">
            <p>AI-Key:</p>
            <div class="forma-LR-blokc_input-pole">
                <img src="{{asset('/Icon/Icon-Key.png')}}" alt="" class="icon">
                <input type="text" name="key" id="" maxlength="100" class="forma-LR-blokc_input-pole-input" placeholder="AI-Key" value="<?php echo (isset($_POST['key']))?$_POST['key']:'' ?>">
            </div>
        </div>
        <div class="forma-LR-blokc_button">
            <button type="submit" name="Ai_Key_button" class="forma-LR-blokc_button-button" value="Save">Save</button>
        </div>
    </form>
</div>
@endsection