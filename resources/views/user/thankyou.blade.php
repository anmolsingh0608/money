@extends('layouts.user')
@section('content')
    <main class="main py-0">
        <div class="container-xxl">
            <div class="row partition-white">
                <div class="col-md-8 bg-white py50 whitebefore pe-md-5 mb-5 mb-md-0">
                    <div class="user-copy pe-md-5 mb-0">
                        <div class="go-back"><a href="/" class="align-items-center d-inline-flex"><span
                                    class="icon"><img src="{{ url('images/go-back-green.svg') }}" alt=""></span>
                                Go back to
                                Dashboard</a></div>
                        <h1>Thank you!</h1>
                        <p>Thank you for participating in the Financially Fit Certification Survey. Your input will help us
                            continue to improve FitMoney.</p>
                        @if (isset($next))
                            <a href="/section/{{ $p_id }}/{{ $next->id }}"
                                class="cta mt-5 d-flex justify-content-center">Begin the
                                next lesson <span class="icon d-flex align-items-center justify-content-center"><img
                                        src="{{ url('images/arrow-right-cta.svg') }}" alt="" height="18"
                                        width="22"></span></a>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 ps-md-5 side-col">
                    @if (isset($next))
                        <div class="cta-box mb-5">
                            <a href="/section/{{ $p_id }}/{{ $next->id }}"
                                class="cta transparent w-100">Continue to the next
                                Section
                                <span class="icon"><img src="{{ url('images/arrow-right-green-cta.svg') }}"
                                        alt="" height="18" width="22"></span></a>
                        </div>
                    @endif
                    @foreach ($sections as $program)
                        <div class="acc-box">

                            <div class="acc-head">
                                <span class="d-flex point"><img src="{{ url('images/flag-point.svg') }}" alt=""
                                        class="closed"><img src="{{ url('images/flag-point-green.svg') }}" alt=""
                                        class="opened"></span>
                                <h2>{{ $program->name }}</h2>
                                <span class="arrow"><img src="{{ url('images/arrow-acc.svg') }}" alt=""></span>
                            </div>
                            <div class="acc-content">
                                <ul class="mb-0">
                                    @if($program->description)
                                        <li>{!! $program->description !!}</li>
                                    @endif
                                </ul>
                                <a href="/section/{{ $p_id }}/{{ $program->id }}" class="cta d-inline-flex justify-content-center mt-4 w-auto" style="max-width: none; padding:10px 15px;">Start</a>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
        </div>
    </main>
    @include('user/help')
@endsection
