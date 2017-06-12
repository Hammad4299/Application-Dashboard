<html>
    <body>
        <div>
            <span>Hi: {{ $user->name }}</span>
            To confirm your email click on
            <span><a href="{{ route('users.confirm-email', ['confirmation_hash' => $user->confirmation_hash]) }}">Email Confirmation Link</a></span>
        </div>

    </body>
</html>