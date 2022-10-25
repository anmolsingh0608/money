<x-guest-layout>



    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 px-0 d-none d-md-block">
                <div class="img-full"><img src="{{ url('images/login.jpg') }}" alt=""></div>
            </div>
            <div class="align-items-center col-md-6 d-flex justify-content-center">
                <div class="form-wrap">
                    <div class="brand"><img src="{{ url('images/beta_logo.svg') }}" alt="" class="img-fluid">
                    </div>
                    <h2 class="text-center">Let’s get you logged in</h2>
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <x-jet-validation-errors class="mb-4" />

                    <form method="POST" class="row g-2" action="{{ route('login') }}">
                        @csrf
                        <div class="col-12">
                            <div class="input-wrap">
                                <label for="email" class="form-label">Email*</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="johndoe@example.com" required autofocus>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-wrap">
                                <label for="password" class="form-label">Password*</label>
                                <div class="pass-input">
                                    <span class="reveal d-flex" id="revealpass"><img
                                            src="{{ url('images/view-password-icon.svg') }}" alt="" width="25"
                                            height="18"></span>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Type your password" required autocomplete="current-password">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-4">
                            @if (Route::has('password.request'))
                                <label class="form-check-label"><a href="{{ route('password.request') }}"
                                        class="text-decoration-none">Forgot your password?</a></label>
                            @endif
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="cta">Login<span
                                    class="icon d-flex align-items-center justify-content-center"><img
                                        src="{{ url('images/arrow-right-cta.svg') }}" alt="" height="18"
                                        width="22"></span></button>
                        </div>
                        <div class="col-12">
                            <hr>
                        </div>
                        <div class="col-12 mt-0">
                            <p class="mb-0 text-center">Don't have an account? <a href="/signup">Join us</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-guest-layout>
