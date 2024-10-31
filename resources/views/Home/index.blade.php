@extends('layouts/default')
@section('title') Home @endsection
@section('content')
    <div class='Block'>
        <div>
            <form action="" method="post">
                @csrf
                <div>
                    <div><button type='submit' name='Ex_1_button' value='Open_News'>Open News</button></div>
                    <div><button type='submit' name='Ex_1_button' value='Open_Questions'>Open Questions</button></div>
                </div>
            </form>
        </div>
    </div>
@endsection