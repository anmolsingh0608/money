@extends('layouts.user')
@section('content')
<main class="main py-0 bg-white">
    <div class="container-xxl">
        <div class="row justify-content-center">
            <div class="col-xl-10 py50">
                <div class="user-copy pe-md-5">
                    <div class="go-back"><a href="/" class="align-items-center d-inline-flex"><span class="icon"><img src="images/go-back-green.svg" alt=""></span> Go back to Dashboard</a></div>
                    <p>Thank you for completing the Exam. <br/>
                        Your total score is {{ round(Session::get('total_marks')) }}
                    </p>
                    <!-- <p>
                        @if(round(Session::get('total_marks')) >= 18)
                        Congratulations, you’ve passed! Enjoy your certificate and best of luck in your financially fit future!
                        @else
                        Please try the assessment again to collect your certificate. You’ll need a score of at least 18 to be certified financially fit.
                        @endif
                    </p> -->
                    <p>
                        @if(Session::get('assessment') !== null)
                        @if(Session::get('assessment')->obj_type != 'program_type')
                        Finish all videos and quizzes to get your certificate
                        @else
                        Congratulations, you’ve passed! Enjoy your certificate and best of luck in your financially fit future!
                        @endif
                        @endif
                    </p>
                    {{-- @if(isset(Session::get('wrong'))) --}}
                    @php
                        $i = 1;
                    @endphp
                    @if(Session::get('wrong'))
                        <p>Right Answers:</p>
                        @php
                        $wrong = json_decode(Session::get('wrong'), true)
                        @endphp
                        @foreach($wrong as $w)

                            @if($w['type'] == 'single')
                                <p>{{$i++ }}: {{$w['title']}}

                                <?php
                                    $answer = (int) str_replace("\"", "", $w['answer']);
                                    $options = json_decode($w['options'], true);
                                    echo "<br/>Right Answer: ".$options[$answer]."</p>";
                                ?>

                            @elseif($w['type'] == 'multi')
                                <p>{{$i++ }}:  {{$w['title']}}
                                <?php
                                $answers = json_decode($w['answer'], true);

                                $options = json_decode($w['options'], true);
                                $listAnswers = [];
                                if(!empty($answers))  {
                                    foreach($answers as $answer) {
                                        $listAnswers[] = $options[$answer];
                                    }
                                }
                                echo "<br /> Right Answer: ".implode(', ', $listAnswers)."</p>";
                            ?>


                            @elseif($w['type'] == 'text')
                            <p>{{$i++ }}:  {{$w['title']}}
                            Right Answer:
                            <?php
                            $answer =  json_decode($w['answer'], true);
                            ?>

                            {{$answer[0] }} </p>

                            @elseif($w['type'] == 'grid')


                                <p>{{$i++ }}:  {{$w['title']}}</p>
                                @if (is_array($w['answer']) || is_object($w['answer']))
                                    @foreach ($w['answer'] as $item)
                                        @if($item['type'] == 'single')
                                            <p>{{$item['title']}}

                                            <?php
                                                $answer = (int) str_replace("\"", "", $item['answer']);

                                                $options = json_decode($item['options'], true);
                                                echo "</br>Right Answer: ".$options[$answer]."</p>";
                                            ?>
                                        @endif
                                        @if($item['type'] == 'multi')
                                            <p>{{$item['title']}}
                                            <?php
                                                $answers = json_decode($item['answer'], true);

                                                $options = json_decode($item['options'], true);
                                                $listAnswers = [];
                                                if(!empty($answers))  {
                                                    foreach($answers as $answer) {
                                                        $listAnswers[] = $options[$answer];
                                                    }
                                                }
                                                echo "</br>Right Answer: ".implode(', ', $listAnswers)."</p>";
                                            ?>

                                        @endif
                                    @endforeach
                                @endif






                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
@include('user/help')
@endsection
