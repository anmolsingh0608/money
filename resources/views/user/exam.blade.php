@extends('layouts.user')
@section('content')
    <main class="main py-0 bg-white">
        <div class="container-xxl">
            <div class="row justify-content-center">
                <div class="col-xl-10 py50">
                    <div class="user-copy pe-md-5">
                        <div class="go-back"><a href="/" class="align-items-center d-inline-flex"><span class="icon"><img src="/images/go-back-green.svg" alt=""></span> Go back to Dashboard</a></div>
                        <h1>Well done!</h1>
                        <p>You’ve completed the modules, now let’s see what you learned. Good luck!</p>
                    </div>
                    <form action="{{ route('examSave') }}" method="POST" class="form-user exam pe-md-5">
                    @csrf
                    <input type="hidden" value="{{ $ass_id }}" name="ass_id"/>
                    <input type="hidden" name="attempts" value="{{ $attempts }}">
                    @foreach($examQuestions as $k=>$question)
                        @if($question->type == 'single')
                        <div class="mb-5 ques">
                            <label for="abs1" class="form-label">{{ $question->title }}</label>
                            {!! $question->description !!}
                            @if ($question->getFirstMediaUrl('question'))
                                <div class="form-group mt-2">
                                    <img src="{{ $question->getFirstMediaUrl('question') }}"
                                        alt="{{ url('/images/no-image-icon.png') }}">
                                </div>
                            @endif
                            @if(!empty($question->url))
                            <iframe src="{{ $question->url }}" alt="" class="w-100"
                                    height="480px"></iframe>
                            @endif
                            <input type="hidden" name="question[{{ $k }}][question]" value="{{ $question->title }}" />
                            <input type="hidden" name="question[{{ $k }}][id]" value="{{ $question->id }}" />
                            <input type="hidden" name="question[{{ $k }}][type]" value="{{$question->type}}" />
                            @php
                                $options = [json_decode($question->options, true)];
                                $i = 1;
                            @endphp
                            @foreach($options[0] as $key=>$option)
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" id="ans_sin{{$k}}{{$i}}" value="{{ $option }}" name="question[{{$k}}][answer]">
                                <label class="form-check-label" for="ans_sin{{$k}}{{$i++}}">{{ $option }}</label>
                            </div>

                            @endforeach
                        </div>
                        @endif
                        @if($question->type == 'multi')
                        <div class="mb-5 ques">
                            <input type="hidden" name="question[{{ $k }}][question]" value="{{ $question->title }}" />
                            <input type="hidden" name="question[{{ $k }}][id]" value="{{ $question->id }}" />
                            <input type="hidden" name="question[{{ $k }}][type]" value="{{$question->type}}" />
                            <label for="abs1" class="form-label">{{ $question->title }}</label>
                            {!! $question->description !!}
                            @if ($question->getFirstMediaUrl('question'))
                                <div class="form-group mt-2">
                                    <img src="{{ $question->getFirstMediaUrl('question') }}"
                                        alt="{{ url('/images/no-image-icon.png') }}">
                                </div>
                            @endif
                            @if(!empty($question->url))
                            <iframe src="{{ $question->url }}" alt="" class="w-100"
                                    height="480px"></iframe>
                            @endif
                            @php
                                $options = [json_decode($question->options, true)];
                                $i = 1;
                            @endphp
                            @foreach($options[0] as $key=>$option)
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="ans_mul{{$k}}{{$i}}" value="{{ $key }}" name="question[{{$k}}][answer][]">
                                <label class="form-check-label" for="ans_mul{{$k}}{{$i++}}">{{ $option }}</label>
                            </div>
                            @endforeach
                        </div>
                        @endif
                        @if($question->type == 'text')
                        <div class="mb-5 ques">
                            <input type="hidden" name="question[{{ $k }}][question]" value="{{ $question->title }}" />
                            <input type="hidden" name="question[{{ $k }}][id]" value="{{ $question->id }}" />
                            <input type="hidden" name="question[{{ $k }}][type]" value="{{$question->type}}" />
                            <label for="abs1" class="form-label">{{$question->title}}</label>
                            {!! $question->description !!}
                            @if ($question->getFirstMediaUrl('question'))
                                <div class="form-group mt-2">
                                    <img src="{{ $question->getFirstMediaUrl('question') }}"
                                        alt="{{ url('/images/no-image-icon.png') }}">
                                </div>
                            @endif
                            @if(!empty($question->url))
                            <iframe src="{{ $question->url }}" alt="" class="w-100"
                                    height="480px"></iframe>
                            @endif
                            <textarea class="form-control" placeholder="write your answer here..." id="" style="height: 130px" name="question[{{$k}}][answer]"></textarea>
                        </div>
                        @endif
                        @if($question->type == 'rate')
                        <div class="mb-5 ques">
                            <input type="hidden" name="question[{{ $k }}][question]" value="{{ $question->title }}" />
                            <input type="hidden" name="question[{{ $k }}][id]" value="{{ $question->id }}" />
                            <input type="hidden" name="question[{{ $k }}][type]" value="{{$question->type}}" />
                            @if ($question->getFirstMediaUrl('question'))
                                <div class="form-group mt-2">
                                    <img src="{{ $question->getFirstMediaUrl('question') }}"
                                        alt="{{ url('/images/no-image-icon.png') }}">
                                </div>
                            @endif
                            @if(!empty($question->url))
                            <iframe src="{{ $question->url }}" alt="" class="w-100"
                                    height="480px"></iframe>
                            @endif
                            @php
                                $msgs = json_decode($question->rate, true);
                                $i = 1;
                            @endphp
                            <h2 class="form-label d-flex mb-3 justify-content-between align-items-center"><span class="ques-text">{{$question->title}}<sup class="text-red"></sup></span></h2>
                            <h3><i>Mark only one oval.</i></h3>
                            <table class="table mb-5" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tbody>
                                    <tr>
                                        <th class="text-center" align="center"></th>
                                        <th class="text-center" align="center">1</th>
                                        <th class="text-center" align="center">2</th>
                                        <th class="text-center" align="center">3</th>
                                        <th class="text-center" align="center">4</th>
                                        <th class="text-center" align="center">5</th>
                                        <th class="text-center" align="center"></th>
                                    </tr>
                                    <tr>
                                        <td valign="center" align="left">{{ $msgs['first'] }}</td>
                                        <td valign="center" align="center"><input type="radio" class="form-check-input" name="question[{{$k}}][answer]" value="1" id="s2q1ra1"></td>
                                        <td valign="center" align="center"><input type="radio" class="form-check-input" name="question[{{$k}}][answer]" value="2" id="s2q1ra2"></td>
                                        <td valign="center" align="center"><input type="radio" class="form-check-input" name="question[{{$k}}][answer]" value="3" id="s2q1ra3"></td>
                                        <td valign="center" align="center"><input type="radio" class="form-check-input" name="question[{{$k}}][answer]" value="4" id="s2q1ra4"></td>
                                        <td valign="center" align="center"><input type="radio" class="form-check-input" name="question[{{$k}}][answer]" value="5" id="s2q1ra5"></td>
                                        <td valign="center" align="right">{{ $msgs['second'] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @endif
                        @if($question->type == 'grid')
                            <input type="hidden" name="question[{{ $k }}][question]" value="{{ $question->title }}" />
                            <input type="hidden" name="question[{{ $k }}][id]" value="{{ $question->id }}" />
                            <input type="hidden" name="question[{{ $k }}][type]" value="{{$question->type}}" />
                            <!-- <label for="abs1" class="form-label">{{$question->title}}</label> -->
                            @if ($question->getFirstMediaUrl('question'))
                                <div class="form-group mt-2">
                                    <img src="{{ $question->getFirstMediaUrl('question') }}"
                                        alt="{{ url('/images/no-image-icon.png') }}">
                                </div>
                            @endif
                            @if(!empty($question->url))
                            <iframe src="{{ $question->url }}" alt="" class="w-100"
                                    height="480px"></iframe>
                            @endif
                            @php
                                $options = json_decode($question->options, true);
                                $i = 1;
                            @endphp
                            <div class="mb-5 ques">
                            <h2 class="form-label d-flex mb-3 justify-content-between align-items-center"><span class="ques-text">{{ $question->title }}<sup class="text-red"></sup></span> <!--<span class="point">1 point</span>--></h2>
                            {!! $question->description !!}
                            <h3><i>Check all that apply.</i></h3>
                            <table class="mb-0 table" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tbody>
                                    <tr align="center">
                                        <th>&nbsp;</th>
                                        @foreach($options as $key=>$option)
                                        <th>{{ $option }}</th>
                                        @endforeach
                                    </tr>
                                    @foreach($question->sub_question as $subKey=>$subQue)
                                    <tr>
                                        <input type="hidden" name="question[{{ $k }}][sque][{{$subKey}}][question]" value="{{ $subQue->title }}" />
                                        <input type="hidden" name="question[{{ $k }}][sque][{{$subKey}}][id]" value="{{ $subQue->id }}" />
                                        <input type="hidden" name="question[{{ $k }}][sque][{{$subKey}}][type]" value="{{$subQue->type}}" />
                                        <th>{{ $subQue->title }}</th>
                                        @if($subQue->type == 'multi')
                                        @foreach($options as $key=>$option)
                                        <td valign="center" align="center">
                                            <input type="checkbox" class="form-check-input" name="question[{{$k}}][sque][{{$subKey}}][answer][]" value="{{ $key }}" id="q1ra1">
                                        </td>
                                        @endforeach
                                        @else
                                        @foreach($options as $key=>$option)
                                        <td valign="center" align="center">
                                            <input type="radio" class="form-check-input" name="question[{{$k}}][sque][{{$subKey}}][answer]" value="{{ $option }}" id="q1ra1">
                                        </td>
                                        @endforeach
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                        @endif
                        @if($question->type == 'feedback')
                        <div class="mb-5 ques">
                            <label for="abs1" class="form-label">{{ $question->title }}</label>
                            {!! $question->description !!}
                            @if ($question->getFirstMediaUrl('question'))
                                <div class="form-group mt-2">
                                    <img src="{{ $question->getFirstMediaUrl('question') }}"
                                        alt="{{ url('/images/no-image-icon.png') }}">
                                </div>
                            @endif
                            @if(!empty($question->url))
                            <iframe src="{{ $question->url }}" alt="" class="w-100"
                                    height="480px"></iframe>
                            @endif
                            <input type="hidden" name="question[{{ $k }}][question]" value="{{ $question->title }}" />
                            <input type="hidden" name="question[{{ $k }}][id]" value="{{ $question->id }}" />
                            <input type="hidden" name="question[{{ $k }}][type]" value="{{$question->type}}" />
                            @php
                                $options = json_decode($question->options, true);
                                $i = 1;
                            @endphp
                            @foreach($options as $key=>$option)
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" id="ans_fee{{$k}}{{$i}}" value="{{ $option }}" name="question[{{$k}}][answer]">
                                <label class="form-check-label" for="ans_fee{{$k}}{{$i++}}">{{ $option }}</label>
                            </div>

                            @endforeach
                        </div>
                        @endif
                        @endforeach

                        <button type="submit" class="cta">Send my answers <span class="icon"><img src="/images/arrow-right-cta.svg" alt="" height="18" width="22"></span></button>

                    </form>
                </div>
            </div>
        </div>
    </main>
    @include('user/help')
@endsection
