<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/css.css') }}">
    <title>Fit Money - Certificate</title>
</head>

<body>
    <section class="certificate">
        <div class="inner">
            <div class="logo"><img src="{{ url('images/logo.svg') }}" alt="" class="w-100"></div>
            <h1>Financially Fit Certificate</h1>
            <h2>Awarded to</h2>
            <h3><span class="fname">{{$user->first_name}}</span> <span class="lname">{{$user->last_name}}</span></h3>
            <h4>for completion and excellence in the financial literacy course.</h4>
            <div class="sign"><img src="{{ url('images/sign-dummy.jpg') }}" alt=""></div>
            <div class="meta">
                <p>Jessica Pelletier<br>Executive Director</p>
                <a href="#">FitMoney.org</a>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>