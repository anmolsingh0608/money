<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/css.css') }}">
    <title>Fit Money</title>
</head>

<body>
    <div class="container-fluid">
        <div class="card" style="align-items: center;">
            <div class="align-items-center col-md-6 d-flex justify-content-center">
                <div class="form-wrap">
                    <div class="brand"><img src="{{ url('/images/logo.svg') }}" alt="" class="img-fluid"></div>
                    <x-jet-validation-errors class="mb-4" />
                    <h6 class="mb-3">Update your password</h6>
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="row mb-3">
                            <label for="email" value="{{ __('Email') }}" />
                            <x-jet-input id="email" class="form form-control" type="email" name="email" :value="old('email', $request->email)" required autofocus />
                        </div>

                        <div class="row mb-3">
                            <label for="password" value="{{ __('Password') }}" />
                            <input id="password" class="form form-control" type="password" name="password" required autocomplete="new-password" placeholder="Password"/>
                        </div>

                        <div class="row mb-3">
                            <label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                            <input id="password_confirmation" class="form form-control"" type=" password" name="password_confirmation" required autocomplete="new-password" placeholder="Password"/>
                        </div>

                        <button type="submit" class="btn btn-secondary">
                            {{ __('Reset Password') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>