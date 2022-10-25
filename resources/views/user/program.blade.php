@extends('layouts.user')
@section('content')
    <section class="hero-title">
        @if ($program->getFirstMediaUrl('program'))
            <div class="bg-img">
                <img src="{{ $program->getFirstMediaUrl('program') }}" alt="" class="d-none d-md-block">
                <img src="{{ url('images/section-hero-mob.jpg') }}" alt="" class="d-md-none">
            </div>
        @else
            <div class="bg-img">
                <img src="{{ url('images/default.jpg') }}" alt="" class="d-none d-md-block">
                <img src="{{ url('images/section-hero-mob.jpg') }}" alt="" class="d-md-none">
            </div>
        @endif
        <div class="container-xxl position-relative">
            {{-- @foreach ($program as $progrm)
              @if ($progrm->id == $programs->id) --}}
            <h1>{{ $program->title }}</h1>

            <p>{!! $program->description !!}</p>


        </div>
    </section>
    <main class="main">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                <h3 style="text-align: center;"> {{ session('success') }} </h3>
            </div>
        @endif
        <div class="container-xxl">
            <div class="row card-grey">
                <div class="col-md-6">
                    <div class="align-items-md-center box d-md-flex justify-content-md-between leason">
                        <div class="copy">
                            <h2>Lessons Progress</h2>
                            <p>{{ $done }}/{{ $total }} lessons completed</p>
                        </div>
                        <div class="leason-percentage d-none d-md-block">{{ $percentage }}<small>%</small></div>
                    </div>
                </div>
                <div class="col-md-6 mt-3 mt-md-0">
                    <div class="align-items-md-center box certificate-box d-md-flex justify-content-md-between">
                        <h2 class="mb-md-0">Get your Certificate</h2>
                        <p class="text">When you archive a certificate you should be able to donwload here.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="row card-meta">
                        @foreach ($section as $item)


                            <div class="col-md-3">
                                <a href="/section/{{ $id }}/{{ $item->id }}" class="box">
                                    <div class="img-meta">
                                        @if ($item->getFirstMediaUrl('section'))
                                            <div class="img">
                                                <img src="{{ $item->getFirstMediaUrl('section') }}" alt=""
                                                    class="object">

                                            </div>
                                        @else
                                            <div class="img">
                                                <img src="{{ url('images/survey.jpg') }}" alt="" class="object">

                                            </div>
                                        @endif
                                        {{-- <div class="filled-bar">
                                            <div class="bar"><span class="much" style="width: 50%;"></span></div>

                                        </div> --}}
                                    </div>
                                    <div class="copy">
                                        <h2>{{ $item->name }}</h2>
                                        @if (isset($item->description))
                                            <?php
                                            $txt = strip_tags($item->description);
                                            $desc = html_entity_decode($txt, ENT_QUOTES);
                                            ?>
                                            <p>{{substr($desc,0,80)}}......</p>

                                        @endif

                                    </div>
                                </a>
                            </div>
                        @endforeach
                        @if ($exam != '')
                            @if (!$exam->isEmpty())
                                <div class="col-md-3">
                                    <a href="{{ route('examShow', ['ass_id' => $assessment_id, 'id' => $exam[0]->id]) }}"
                                        class="box">
                                        <div class="img-meta">
                                            <div class="img"><img src="{{ url('images/exam.jpg') }}" alt=""
                                                    class="object">
                                                    {{-- <div class="meta green ">Exam</div> --}}
                                            </div>

                                        </div>
                                        <div class="copy">

                                            <h2>{{ $exam[0]->title }} [Exam]</h2>
                                            <p><?php echo strip_tags($exam[0]->description); ?></p>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endif
                    </div>



                </div>
            </div>
        </div>
    </main>
    @include('user/help')
@endsection
