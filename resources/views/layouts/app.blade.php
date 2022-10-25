<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/css.css') }}">
    <title>FitMoney: Financially Fit Certificate</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>

    <script src="{{ asset('js/program.js') }}" defer></script>
    <script src="{{ asset('js/section.js') }}" defer></script>
    <script src="{{ asset('js/question.js') }}" defer></script>
    <script src="{{ asset('js/user.js') }}" defer></script>
    <script src="{{ asset('js/exam.js') }}" defer></script>
    <script src="{{ asset('js/assessment.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

    <style>
        .paginate_button.page-item.active>a {
            background-color: #6c757d;
            border: #6c757d;
        }

        .navbar {
            overflow: hidden;
            background-color: #333;
        }

        .navbar a {
            float: left;
            font-size: 16px;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        .dropdown {
            float: left;
            overflow: hidden;
        }

        /* .dropdown .dropbtn {
        font-size: 16px;
        border: none;
        outline: none;
        color: #686868;
        padding: 14px 16px;
        background-color: inherit;
        font-family: inherit;
        margin: 0;
        } */

        /* .navbar a:hover, .dropdown:hover .dropbtn {
        background-color: red;
        } */

        .dropdown-content {
            display: none;
            position: fixed;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            float: none;
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
</head>

<body>
    @include('admin/header')
    <!-- Page Content -->
    @yield('content')

    @stack('modals')
    @stack('scripts')

    @livewireScripts
</body>
<script type="text/javascript">
    $(document).ready(function() {
        $('.ckeditor').ckeditor();
    });
    // $('.questions-list-container').sortable();
</script>
<script type="text/javascript">
    $('.questions-list-container').sortable({
        cursor: 'move',
        opacity: 0.6,
        update: function() {
            sendOrderToServer();
        }
    });

    function sendOrderToServer() {
        var order = [];
        $('.questions-list-container select').each(function(index, element) {
            $(this).parent().parent().parent().next().val(index + 1);
        });
    }
</script>

</html>
