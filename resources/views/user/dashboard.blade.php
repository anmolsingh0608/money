@extends('layouts.user')
@section('content')
<main class="main">
    <div class="container-xxl">
        <div class="row">
            <div class="col-md-9 pe-md-5">
                <div class="user-copy">
                    {{-- @foreach ($user as $item) --}}
                    <h1>Welcome {{ Auth::user()->first_name }}! </h1>
                    {{-- @endforeach --}}

                    <p>Every lesson is built to get you from zero to hero! We recomend you to follow the program in
                        order, starting with section one.</p>
                    <p><strong>FitMoney is here to help! If you have any questions, don’t hesitate to <a href="mailto: info@fitmoney.org">ask!</a></strong></p>
                </div>
                <div class="progress-meta bg-white my-5 shadow-sm d-md-none">
                    <h2 class="text-center">Progress Indicator</h2>
                    <div class="filled-bar mb-4">
                        <div class="bar"><span class="much" style="width: {{ round($combined_ptg) }}%;"></span></div>
                        <div class="meta text-center">{{ round($combined_ptg) }}% completed</div>
                    </div>
                    <a href="{{ route('generate-pdf') }}" class="cta @if ($attempts == 0 || $final_per != 100) disabled @endif">Get your certificates <span class="icon"><img src="images/download-arrow.svg" alt=""></span></a>
                </div>
                <div class="row card-meta">
                    @foreach ($program as $programs)
                    @if (Auth::user()->program == $programs->program_type)
                    <div class="col-md-4">
                        <a href="program/{{ $programs->id }}" class="box">
                            {{-- <input type="hidden" value="{{$programs->id}}"> --}}
                            <div class="img-meta">
                                @if ($programs->getFirstMediaUrl('program'))
                                <div class="img"><img src="{{ $programs->getFirstMediaUrl('program') }}" alt="" class="object"><span class="badge">
                                        <img src="{{ url('images/uc1.svg') }}" alt=""></span>
                                </div>
                                @else
                                <div class="img"><img src="{{ url('images/default.jpg') }}" alt="" class="object"><span class="badge">
                                        <img src="{{ url('images/uc1.svg') }}" alt=""></span>
                                </div>
                                @endif

                                <div class="filled-bar">
                                    <div class="bar"><span class="much" style="width: @if (isset($programs->progress)) {{ $programs->progress }}%;@else 0%; @endif"></span>
                                    </div>
                                    <div class="meta green">
                                        @if (isset($programs->progress))
                                        {{ $programs->progress }}% completed
                                        @else
                                        0% completed
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="copy">
                                <h2> {{ $programs->title }}</h2>
                                @if (isset($programs->description))
                                <?php
                                $txt = strip_tags($programs->description);
                                $desc = html_entity_decode($txt, ENT_QUOTES);
                                ?>
                                <p>{{ substr($desc, 0, 80) }}......</p>
                                @endif

                            </div>
                        </a>

                    </div>
                    @endif
                    @endforeach
                    @if ($exam != '')
                    @if (!$exam->isEmpty())
                    <div class="col-md-4">
                        <a href="{{ route('examShow', ['ass_id' => $assessment_id, 'id' => $exam[0]->id]) }}" class="box">
                            <div class="img-meta">
                                <div class="img"><img src="{{ url('images/exam.jpg') }}" alt="" class="object"><span class="badge">
                                        <img src="{{ url('images/uc1.svg') }}" alt=""></span>
                                </div>
                                <div class="filled-bar">
                                    <div class="bar"><span class="much" style="width: 0%;"></span></div>
                                    <div class="meta green">Exam</div>
                                </div>
                            </div>
                            <div class="copy">
                                <h2> {{ $exam[0]->title }}</h2>
                                <p><?php echo strip_tags($exam[0]->description); ?></p>
                            </div>
                        </a>
                    </div>
                    @endif
                    @endif
                </div>
                <hr style="background-color: #66BB2E; opacity:1; height:2px;" class="my-5">
                <h2 style="color:#177483; font-size:30px; " class="mb-4">Other Available Programs</h2>
                <div class="row card-meta">
                    @foreach ($secondary_programs as $programs)
                    @if (Auth::user()->program !== $programs->program_type)
                    <div class="col-md-4">
                        <a href="program/{{ $programs->id }}" class="box">
                            {{-- <input type="hidden" value="{{$programs->id}}"> --}}
                            <div class="img-meta">
                                @if ($programs->getFirstMediaUrl('program'))
                                <div class="img"><img src="{{ $programs->getFirstMediaUrl('program') }}" alt="" class="object"><span class="badge">
                                        <img src="{{ url('images/uc1.svg') }}" alt=""></span>
                                </div>
                                @else
                                <div class="img"><img src="{{ url('images/default.jpg') }}" alt="" class="object"><span class="badge">
                                        <img src="{{ url('images/uc1.svg') }}" alt=""></span>
                                </div>
                                @endif

                                <div class="filled-bar">
                                    <div class="bar"><span class="much" style="width: @if (isset($programs->progress)) {{ $programs->progress }}%;@else 0%; @endif"></span>
                                    </div>
                                    <div class="meta green">
                                        @if (isset($programs->progress))
                                        {{ $programs->progress }}% completed
                                        @else
                                        0% completed
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="copy">
                                <h2> {{ $programs->title }}</h2>
                                @if (isset($programs->description))
                                <?php
                                $txt = strip_tags($programs->description);
                                $desc = html_entity_decode($txt, ENT_QUOTES);
                                ?>
                                <p>{{ substr($desc, 0, 30) }}......</p>
                                @endif

                            </div>
                        </a>

                    </div>
                    @endif

                    @endforeach

                </div>
            </div>
            <div class="col-md-3 mt-5 mt-md-0">
                <div class="progress-meta bg-white mb-5 shadow-sm d-none d-md-block">
                    <h2 class="text-center">Progress Indicator </h2>
                    <div class="donut-chart chart">
                        <canvas id="chartProgress" width="400px"></canvas>

                    </div>

                    <a href="{{ route('generate-pdf') }}" target="_blank" class="cta @if ($attempts == 0 || $final_per != 100) disabled @endif">Get your certificates <span class="icon"><img src="images/download-arrow.svg" alt=""></span></a>
                </div>
                <div class="cta-box mb-5">
                    <a href="mailto: info@fitmoney.org" class="box"><img src="{{ url('images/dyk.jpg') }}" alt="" class="w-100"><span class="text">Did you know?</span></a>
                </div>
                <div class="cta-box">
                    <a href="mailto: info@fitmoney.org" class="box"><img src="{{ url('images/nh.jpg') }}" alt="" class="w-100"><span class="text">Need help?</span></a>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    var chartProgress = document.getElementById("chartProgress");
    if (chartProgress) {
        var myChartCircle = new Chart('chartProgress', {
            type: 'doughnut',
            data: {
                datasets: [{
                    label: 'Progress',
                    percent: '{{ round($combined_ptg) }}',
                    backgroundColor: ['#66BB2E'],
                    borderColor: ['#66BB2E', '#cccccc'],
                    borderWidth: 0
                }]
            },
            plugins: [{
                    beforeInit: (chart) => {
                        const dataset = chart.data.datasets[0];
                        chart.data.labels = [dataset.label];
                        dataset.data = [dataset.percent, 100 - dataset.percent];
                    }
                },
                {
                    beforeDraw: (chart) => {
                        var width = chart.chart.width,
                            height = chart.chart.height,
                            ctx = chart.chart.ctx;
                        ctx.restore();
                        var fontSize = (height / 150).toFixed(2);
                        ctx.font = '700 55px "Lato",sans-serif';
                        // ctx.fillStyle = "#686868";
                        ctx.textBaseline = "middle";
                        var text = chart.data.datasets[0].percent + "%",
                            textX = Math.round((width - ctx.measureText(text).width) / 2),
                            textY = height / 2;
                        ctx.fillText(text, textX, textY);
                        ctx.save();
                        ctx.globalCompositeOperation = 'destination-over';
                        ctx.fillStyle = 'white';
                        ctx.fillRect(0, 0, chart.width, chart.height);
                        ctx.restore();
                    }
                }
            ],
            options: {
                maintainAspectRatio: false,
                cutoutPercentage: 85,
                rotation: Math.PI / 2,
                legend: {
                    display: false,
                },
                tooltips: {
                    enabled: false
                }

            }
        });

    }
</script>
@endsection
