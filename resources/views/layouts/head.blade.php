<header>
    <div>
        <h3><a href="/PHP/ImageAI/public/">Home</a> | <a href="/PHP/ImageAI/public/image">Image</a> | <a href="/PHP/ImageAI/public/image/addImage">addImage</a> | <a href="/PHP/ImageAI/public/aikey">addAiKey</a></h3>
    </div>
    <div>
        @if (session('User_Email'))
            <p>{{session('User_Email')}} | <a href="/PHP/ImageAI/public/user/exit">Exit</a></p>
        @else
            <p><a href="/PHP/ImageAI/public/user/login">Login</a> / <a href="/PHP/ImageAI/public/user/registr">Registr</a> </p>
        @endif
    </div>
</header>