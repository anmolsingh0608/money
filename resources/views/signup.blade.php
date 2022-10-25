<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/css.css">
    <title>Fit Money - Join</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 px-0 d-none d-md-block">
                <div class="img-full"><img src="images/signup.jpg" alt=""></div>
            </div>
            <div class="align-items-center col-md-6 d-flex justify-content-center">
                <div class="form-wrap">
                    <div class="brand"><img src="images/beta_logo.svg" alt="" class="img-fluid"></div>
                    <h2 class="text-center">Welcome to FitMoney!</h2>
                    <form method="post" action="/save" class="row g-2">
                        @csrf
                        {{-- @if (count($errors) > 0)
                            <div class="alert alert-danger">

                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif --}}
                        {{-- @if ($message = Session::get('success'))
                                        <div class="alert alert-success">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @endif --}}
                        <div class="col-md-6">
                            <div class="input-wrap" {{ $errors->has('fname') ? ' has-error' : '' }}>
                                <label for="fname" class="form-label">First Name*</label>
                                <input type="text" value="{{ old('fname') }}" required name="fname"
                                    class="form-control" id="fname" placeholder="John">
                                <small class="text-danger">{{ $errors->first('fname') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-wrap" {{ $errors->has('lname') ? ' has-error' : '' }}>
                                <label for="lname" class="form-label">Last Name*</label>
                                <input type="text" value="{{ old('lname') }}" required name="lname"
                                    class="form-control" id="lname" placeholder="Doe">
                                <small class="text-danger">{{ $errors->first('lname') }}</small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-wrap" {{ $errors->has('email') ? ' has-error' : '' }}>
                                <label for="email" class="form-label">Email*</label>
                                <input type="email" value="{{ old('email') }}" required name="email"
                                    class="form-control" id="email" placeholder="johndoe@example.com">
                                <small class="text-danger">{{ $errors->first('email') }}</small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-wrap" {{ $errors->has('password') ? ' has-error' : '' }}>
                                <label for="password" class="form-label">Password*</label>
                                <div class="pass-input">
                                    <span class="reveal d-flex" id="revealpass"><img
                                            src="images/view-password-icon.svg" alt="" width="25" height="18"></span>
                                    <input type="password" value="{{ old('password') }}" required name="password"
                                        class="form-control" id="password" placeholder="At least 8 characters">
                                    <small class="text-danger">{{ $errors->first('password') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-wrap" {{ $errors->has('zcode') ? ' has-error' : '' }}>
                                <label for="zcode" class="form-label">Zip Code*</label>
                                <input type="number" value="{{ old('zcode') }}" required name="zcode"
                                    class="form-control" id="zcode" placeholder="00000">
                                <small class="text-danger">{{ $errors->first('zcode') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-wrap" {{ $errors->has('ocode') ? ' has-error' : '' }}>
                                <label for="ocode" class="form-label">Organization Code</label>
                                <input name="ocode" value="{{ old('ocode') }}" class="form-control" id="tag"
                                    placeholder="55755">
                                <small class="text-danger">{{ $errors->first('ocode') }}</small>
                                <small class="text-danger">{{ $errors->first('msg') }}</small>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-wrap" {{ $errors->has('age') ? ' has-error' : '' }}>
                                <label for="age" class="form-label">Age*</label>
                                <select id="age" name="age" required class="form-select">
                                    <option value="">---</option>
                                    @for ($i = 5; $i < 22; $i++)
                                        <option value=" {{ $i }}"
                                            {{ old("$i") == "$i" ? 'selected' : '' }}> {{ $i }}</option>
                                    @endfor
                                </select>
                                <small class="text-danger">{{ $errors->first('age') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-wrap" {{ $errors->has('grade') ? ' has-error' : '' }}>
                                <label for="grade" class="form-label">Grade*</label>
                                <select id="grade" required name="grade" class="form-select">
                                    <option value="">---</option>
                                    @for ($i = 1; $i < 13; $i++)
                                        <option value=" {{ $i }}"
                                            {{ old(' $i') == " $i" ? 'selected' : '' }}> {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                                <small class="text-danger">{{ $errors->first('grade') }}</small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-wrap" {{ $errors->has('program') ? ' has-error' : '' }}>
                                <label for="program" class="form-label">Program*</label>
                                <select id="program" required name="program" class="form-select">
                                    <option value="">Choose one...</option>
                                    <option value="1"
                                        {{ old('program') == 'Junior program' ? 'selected' : '' }}>
                                        Junior Program </option>
                                    <option value="2"
                                        {{ old('program') == 'Highschool program' ? 'selected' : '' }}>
                                        High School Program </option>
                                    <option value="3"
                                        {{ old('program') == 'High School (Spanish)' ? 'selected' : '' }}>
                                        High School (Spanish) </option>

                                </select>
                                <small class="text-danger">{{ $errors->first('program') }}</small>
                            </div>
                        </div>
                        {{-- @foreach ($user as $item)
                            <input type="hidden"  name="code[]" value="{{$item->code}}"   />
                        @endforeach --}}
                        <div class="col-12 mt-4">
                            <div class="form-check" {{ $errors->has('check') ? ' has-error' : '' }}>
                                <input class="form-check-input" type="checkbox" name="check" id="checkin">
                                <label class="form-check-label" for="checkin">I agree with <a href="#">Terms</a> and <a
                                        href="#">Privacy</a></label> <br>
                                <small class="text-danger">{{ $errors->first('check') }}</small>
                            </div>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="cta">Join now <span class="icon"><img
                                        src="images/arrow-right-cta.svg" alt="" height="18" width="22"></span></button>
                        </div>
                        <div class="col-12">
                            <hr>
                        </div>
                        <div class="col-12 mt-0">
                            <p class="mb-0 text-center"><a href="/" class="text-decoration-none">Already registered</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

</body>

</html>
