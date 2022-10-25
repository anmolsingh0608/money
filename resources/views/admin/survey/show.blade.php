@extends('layouts.app')
@section('content')
    <main class="main">
        <div class="container-xxl">
            <div class="row">
                <div class="col-md-12 pe-md-5">
                    <div class="user-copy">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="container">


                            @php
                                $surveys = json_decode($survey->survey, true);
                                $i = 1;
                            @endphp

                            @foreach ($surveys as $survey)
                                @if ($survey["'answer-type'"] == 'text')
                                    <div class="card row">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                {{ $i++ }}. {{ $survey["'question'"] }}
                                            </h6>
                                            <div class="card-text">
                                                Answer: {{ $survey["'answer'"] }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($survey["'answer-type'"] == 'single')
                                    <div class="card row">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                {{ $i++ }}. {{ $survey["'question'"] }}
                                            </h6>
                                            <div class="card-text">
                                                 Answer: {{ $survey["'answer'"] }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($survey["'answer-type'"] == 'multi')
                                    <div class="card row">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                {{ $i++ }}. {{ $survey["'question'"] }}
                                            </h6>
                                            @foreach ($survey["'answer'"] as $key)
                                                <div class="card-text">
                                                    Answer: {{ $key }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                @if ($survey["'answer-type'"] == 'rating')
                                    <div class="card row">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                {{ $i++ }}. {{ $survey["'question'"] }}
                                            </h6>
                                            <div class="card-text">
                                                Answer: {{ $survey["answer"] }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($survey["'answer-type'"] == 'feedback')
                                    <div class="card row">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                {{ $i++ }}. {{ $survey["'question'"] }}
                                            </h6>
                                            <div class="card-text">
                                                 Answer: {{ $survey["'answer'"] }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($survey["'answer-type'"] == 'grid')
                                    <div class="card row">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                {{ $i++ }}. {{ $survey["'question'"] }}
                                            </h6>
                                            <div class="card-text"><ul>
                                                @foreach($survey['sque'] as $k=>$s)
                                                <li><div class="card row sque" style="border: 0px">
                                                    <div class="card-body">
                                                        <h6 class="card-title">
                                                            {{ $s["question"] }}
                                                        </h6>
                                                        <div class="card-text">
                                                        {{ $s["answer"] }}
                                                        </div>
                                                    </div>
                                                </div></li>
                                                @endforeach
                                            </ul></div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/buttons.server-side.js') }}"></script>
@endsection
