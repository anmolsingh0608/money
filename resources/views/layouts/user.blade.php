<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/css.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ url('js/main.js') }}"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    <title>FitMoney: Financially Fit Certificate</title>
</head>

<body>
    <header class="header d-flex align-items-center justify-content-between shadow">
        <div class="brand"><a href="/"><img src="{{ url('images/beta_logo.svg') }}" alt="" class="w-100"></a></div>
        <form method="POST" action="{{ route('logout') }}" class="d-flex">
            @csrf
            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                    this.closest('form').submit();" class="logout">
                <span class="d-none d-md-block">Logout</span><span class="d-md-none"><img
                        src="{{ url('images/logout-icon.svg') }}" alt=""></span>
            </a>
        </form>
    </header>


    @yield('content')

    @stack('modals')
    @stack('scripts')
</body>

</html>
