@extends('layouts.user')
@section('content')
<style>
    .play-btn {
        height: 50px;
        width: 50px;
        position: absolute;
        top: 50%;
        left: 50%;
        margin: -25px 0 0 -25px;
        cursor: pointer;
        transition: 0.5s;
        opacity: 1;
    }
    .vidplay{
        position: relative;
    }
    .vidplay:hover .play-btn{
        opacity: 1;
    }
</style>
<main class="main py-0">
    <div class="container-xxl">
        <div class="row partition-white">
            <div class="col-md-8 bg-white py50 whitebefore pe-md-5 mb-5 mb-md-0">

                @if ($section->type == 'video')
                <div class="user-copy pe-md-5">
                    <div class="go-back"><a href="/" class="align-items-center d-inline-flex"><span class="icon"><img src="{{ url('images/go-back-green.svg/') }}" alt=""></span> Go back to
                            Dashboard</a></div>
                    <h1>{{ $section->name }}</h1>


                    <p><strong>{!! $section->description !!}</strong></p>
                </div>
                <div class="row card-meta">
                    <!-- <iframe src="{{ $section->url }}" alt="" class="w-100"
                                    height="480px"></iframe> -->

                    @php $a = json_decode($section->url);

                    @endphp
                    @if($a !== null)
                    @foreach($a as $k=>$link)
                    <div class="col-md-4 vid">
                        <a href="javascript:void(0)" data-id="{{ $k }}" class="linkSource vidplay box bg-white d-flex flex-column shadow-sm text-decoration-none @if((count($a)-1) == $k) lastvid @endif">
                            <div class="img-meta">
                                <div class="img">
                                    <img
                                        @if(isset($link->image))
                                        src={{ '/images/uploads/'.$link->image }}
                                        @else
                                        src={{ '/images/uploads/default.jpg' }}
                                        @endif
                                        alt="" class="object">
                                    @if(in_array($k, $videosArr))
                                    <span class="badge">
                                        <img src="{{ url('images/checkmark.png') }}" alt="">
                                    </span>
                                    @endif
                                </div>
                                </div>
                                <div class="copy">
                                    <h2>{{$link->name}}</h2>
                                    @if (isset($link->description))
                                    <?php
                                    $txt = strip_tags($link->description);
                                    $desc = html_entity_decode($txt, ENT_QUOTES);
                                    ?>
                                    <p>{{substr($desc,0,60)}}......</p>
                                    @endif
                                </div>
                            </a>
                            <div id="myModal" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">{{$link->name}}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>{!! $link->description !!}</p>
                                        <iframe height="575px" class="embed-responsive-item w-100" src="{{$link->url}}"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @if($section->psurvey->isNotEmpty())
                    @foreach($section->psurvey as $k=>$v)
                    <div class="col-md-4 vid">
                        <a href="javascript:void(0)" class="linkSource vidplay box bg-white d-flex flex-column shadow-sm text-decoration-none">
                            <div class="img-meta">
                            @if ($v->getFirstMediaUrl('psurvey'))
                                <div class="img">
                                    <img
                                    src={{ $v->getFirstMediaUrl('psurvey') }}
                                    alt="" class="object">
                                </div>
                            @else
                                <div class="img">
                                    <img
                                    src={{ '/images/uploads/default.jpg' }}
                                    alt="" class="object">
                                </div>
                            @endif
                                <div class="copy">
                                    <h2>{{$v->title}}</h2>
                                </div>
                            </div>
                        </a>
                    <div id="myModal" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">{{$v->title}}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form class="form-user exam pe-md-5" action="{{ route('store', $section->id) }}" method="POST" onsubmit="checkvalidate(event)">
                                        @csrf
                                        {{-- {{$p_id}} --}}
                                        {{-- <input type="hidden" value="{{$p_id }} " name="p_id" /> --}}
                                        <input type="hidden" value="{{ $section->program_id }} " name="program_id" />
                                        <input type="hidden" value="{{ $section->id }} " name="section_id" />
                                        <input type="hidden" value=" {{ Auth::user()->id }}" name="user_id" />
                                        <input type="hidden" name="junior_survey" value="junior survey" />
                                        @php
                                        $survey = [json_decode($v->meta, true)];
                                        $i = 1;
                                        @endphp
                                        @foreach ($survey as $key)
                                        @if (isset($key['data']) && !empty($key['data']))
                                        @foreach ($key['data'] as $k => $question)
                                        @if ($question['answer-type'] == 'text')
                                        <div class="mb-5 ques">
                                            <div class=" mb-3">

                                                <label for="abs1" class="form-label">
                                                    {{ $question['question'] }} </label>
                                            </div>
                                            <input type="hidden" name="question[{{ $k }}]['question']" value="{{ $question['question'] }}" />
                                            <input type="hidden" name="question[{{ $k }}]['answer-type']" value="{{ $question['answer-type'] }}" />

                                            <textarea class="form-control" name="question[{{ $k }}]['answer']" placeholder="write your answer here..." id="ans1" style="height: 130px" required></textarea>

                                        </div>
                                        @elseif ($question['answer-type'] == 'single')
                                        <div class="mb-5 ques">

                                            @if (isset($question['option']) && !empty($question['option']))
                                            <input type="hidden" name="question[{{ $k }}]['question']" value="{{ $question['question'] }}" />
                                            <input type="hidden" name="question[{{ $k }}]['answer-type']" value="{{ $question['answer-type'] }}" />
                                            <div class=" mb-3">

                                                <label for="abs1" class="form-label">
                                                    {{ $question['question'] }} </label>
                                            </div>
                                            @php $t = 0; @endphp
                                            @foreach ($question['option'] as $item)
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" required type="radio" id="ans3a{{ $t }}" name="question[{{ $k }}]['answer']" value="{{ $item }}" required>
                                                <label class="form-check-label" for="ans3a{{ $t }}" name="ans3">{{ $item }}</label> <br>
                                            </div>
                                            @php $t++ ; @endphp
                                            @endforeach
                                            @endif

                                        </div>
                                        @elseif ($question['answer-type'] == 'multi')
                                        <div class="mb-5 ques">
                                          <div class="checkbox-group required">
                                            <span class="tool-tip">Please check atleast one</span>
                                            @if (isset($question['option']) && !empty($question['option']))
                                            <div class="mb-4">
                                                <div class=" mb-3">

                                                    <label for="ans4" class="form-label">
                                                        {{ $question['question'] }}
                                                    </label>
                                                </div>
                                                <input type="hidden" name="question[{{ $k }}]['question']" value="{{ $question['question'] }}" />
                                                <input type="hidden" name="question[{{ $k }}]['answer-type']" value="{{ $question['answer-type'] }}" />
                                                @php
                                                $i = 0;
                                                @endphp
                                                @foreach ($question['option'] as $item)
                                                <div class="form-check mb-3">

                                                    <input type="checkbox" name="question[{{ $k }}]['answer'][]" value="{{ $item }}" class="form-check-input" id="ans4{{ $i }}">
                                                    <label class="form-check-label" for="ans4{{ $i }}">
                                                        {{ $item }}
                                                    </label>
                                                </div>
                                                @php
                                                $i++;
                                                @endphp
                                                @endforeach
                                            </div>
                                            @endif
                                          </div>
                                        </div>
                                        @elseif($question['answer-type'] == 'rating')
                                        <div class="mb-5 ques">
                                            <input type="hidden" name="question[{{ $k }}]['question']" value="{{ $question['question'] }}" />
                                            <input type="hidden" name="question[{{ $k }}]['answer-type']" value="{{ $question['answer-type'] }}" />

                                            <h2 class="form-label d-flex mb-3 justify-content-between align-items-center"><span class="ques-text">{{ $question['question'] }}<sup class="text-red"></sup></span></h2>
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
                                                        <td valign="center" align="left">{{ $question['caption'][0] }}</td>
                                                        <td valign="center" align="center"><input type="radio" class="form-check-input" name="question[{{$k}}][answer]" value="1" id="s2q1ra1"></td>
                                                        <td valign="center" align="center"><input type="radio" class="form-check-input" name="question[{{$k}}][answer]" value="2" id="s2q1ra2"></td>
                                                        <td valign="center" align="center"><input type="radio" class="form-check-input" name="question[{{$k}}][answer]" value="3" id="s2q1ra3"></td>
                                                        <td valign="center" align="center"><input type="radio" class="form-check-input" name="question[{{$k}}][answer]" value="4" id="s2q1ra4"></td>
                                                        <td valign="center" align="center"><input type="radio" class="form-check-input" name="question[{{$k}}][answer]" value="5" id="s2q1ra5"></td>
                                                        <td valign="center" align="right">{{ $question['caption'][1] }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        @elseif ($question['answer-type'] == 'feedback')
                                        <div class="mb-4 ques">

                                            @if (isset($question['option']) && !empty($question['option']))
                                            <input type="hidden" name="question[{{ $k }}]['question']" value="{{ $question['question'] }}" />
                                            <input type="hidden" name="question[{{ $k }}]['answer-type']" value="{{ $question['answer-type'] }}" />
                                            <div class=" mb-3">

                                            <label for="abs1" class="form-label">{{ $question['question'] }}</label>
                                            </div>
                                            @php $t = 0; @endphp
                                            @foreach ($question['option'] as $item)
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" required type="radio" id="ans3a{{ $t }}" name="question[{{ $k }}]['answer']" value="{{ $item }}" required>
                                                <label class="form-check-label" for="ans3a{{ $t }}" name="ans3">{{ $item }}</label> <br>
                                            </div>
                                            @php $t++ ; @endphp
                                            @endforeach
                                            @endif

                                        </div>
                                        @elseif ($question['answer-type'] == 'grid')
                                        <input type="hidden" name="question[{{ $k }}]['question']" value="{{ $question['question'] }}" />
                                        <input type="hidden" name="question[{{ $k }}]['answer-type']" value="{{ $question['answer-type'] }}" />

                                        <div class="mb-5 ques">
                                        <h2 class="form-label d-flex mb-3 justify-content-between align-items-center"><span class="ques-text">{{ $question['question'] }}<sup class="text-red"></sup></span> <!--<span class="point">1 point</span>--></h2>
                                        <h3><i>Check all that apply.</i></h3>
                                        <table class="mb-0 table" width="100%" cellspacing="0" cellpadding="0" border="0">
                                            <tbody>
                                                <tr align="center">
                                                    <th>&nbsp;</th>
                                                    @foreach($question['option'] as $key=>$option)
                                                    <th>{{ $option }}</th>
                                                    @endforeach
                                                </tr>
                                                @foreach($question['sque'] as $subKey=>$subQue)
                                                <tr>
                                                    <input type="hidden" name="question[{{ $k }}][sque][{{$subKey}}][question]" value="{{ $subQue['title'] }}" />
                                                    <input type="hidden" name="question[{{ $k }}][sque][{{$subKey}}][type]" value="{{@$subQue['type']}}" />
                                                    <th>{{ $subQue['title'] }}</th>
                                                    @if(@$subQue['type'] == 'multi')
                                                    @foreach($question['option'] as $key=>$option)
                                                    <td valign="center" align="center">
                                                        <input type="checkbox" class="form-check-input" name="question[{{$k}}][sque][{{$subKey}}][answer][]" value="{{ $key }}" id="q1ra1">
                                                    </td>
                                                    @endforeach
                                                    @else
                                                    @foreach($question['option'] as $key=>$option)
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
                                        @endforeach
                                        @if (isset($next->id))
                                        {{-- @dd($next->id) --}}
                                        <input type="hidden" name="next_id" value="{{ $next->id }}" />
                                        @endif
                                        <button type="submit" class="cta">Send my answers <span class="icon"><img src="{{ url('images/arrow-right-cta.svg') }}" alt="" height="18" width="22"></span></button>
                                        @endif
                                        @endforeach
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    @endforeach
                    @endif
                    @if ($exam != '')
                    @if (!$exam->isEmpty())
                    <div class="col-md-4">
                        <a href="{{ route('examShow', ['ass_id' => $assessment_id, 'id' => $exam[0]->id]) }}" class="linkSource box bg-white d-flex flex-column shadow-sm text-decoration-none">
                            <div class="img-meta">
                                <div class="img">
                                    <img
                                    src={{ '/images/uploads/default.jpg' }}
                                    alt="" class="object">
                                </div>
                                <div class="copy">
                                    <h2>{{ $exam[0]->title }} (Exam)</h2>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endif
                    @endif
                    @endif
                </div>
                <!-- <div class="progress-indicator mt-5">
                            <ul class="bar d-flex justify-content-between list-unstyled">
                                <li><span class="icon"><img src="{{ url('images/drop.svg') }}" alt="" width="12"
                                            height="15"></span></li>
                                <li><span class="icon"><img src="{{ url('images/drop.svg') }}" alt="" width="12"
                                            height="15"></span></li>
                                <li><span class="icon"><img src="{{ url('images/drop.svg') }}" alt="" width="12"
                                            height="15"></span></li>
                                <li class="filled" style="width: 50%;"></li>
                            </ul>
                        </div> -->
                @endif

                @if (isset($survey[0]['id']) == null || isset($survey[0]['user_id']) != Auth::user()->id)
                @if ($section->type == 'survey')
                <div class="user-copy pe-md-5">
                    <div class="go-back"><a href="/" class="align-items-center d-inline-flex"><span class="icon"><img src="{{ url('images/go-back-green.svg') }}" alt=""></span> Go back to
                            Dashboard</a></div>
                    <h1>{{ $section->name }}</h1>
                    <p><strong>Thank you for participating in the Financially Fit Certification Survey!</strong>
                    </p>
                    <p>Please fill in the information below and then complete the behavioral, knowledge and
                        pre-questions to assess what you already know!</p>
                </div>
                @if($section->psurvey->isNotEmpty())
                <form class="form-user exam pe-md-5" action="{{ route('store', $section->id) }}" method="POST" onsubmit="checkvalidate(event)">
                    @csrf
                    {{-- {{$p_id}} --}}
                    {{-- <input type="hidden" value="{{$p_id }} " name="p_id" /> --}}
                    <input type="hidden" value="{{ $section->program_id }} " name="program_id" />
                    <input type="hidden" value="{{ $section->id }} " name="section_id" />
                    <input type="hidden" value=" {{ Auth::user()->id }}" name="user_id" />
                    @php
                    $survey = [json_decode($section->psurvey[0]->meta, true)];
                    $i = 1;
                    @endphp
                    @foreach ($survey as $key)
                    @if (isset($key['data']) && !empty($key['data']))
                    @foreach ($key['data'] as $k => $question)
                    @if($question['answer-type'] == 'rating')
                    <div class="mb-5 ques">
                        <input type="hidden" name="question[{{ $k }}]['question']" value="{{ $question['question'] }}" />
                        <input type="hidden" name="question[{{ $k }}]['answer-type']" value="{{ $question['answer-type'] }}" />

                        <h2 class="form-label d-flex mb-3 justify-content-between align-items-center"><span class="ques-text">{{ $question['question'] }}<sup class="text-red"></sup></span></h2>
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
                                    <td valign="center" align="left">{{ $question['caption'][0] }}</td>
                                    <td valign="center" align="center"><input type="radio" class="form-check-input" name="question[{{$k}}][answer]" value="1" id="s2q1ra1"></td>
                                    <td valign="center" align="center"><input type="radio" class="form-check-input" name="question[{{$k}}][answer]" value="2" id="s2q1ra2"></td>
                                    <td valign="center" align="center"><input type="radio" class="form-check-input" name="question[{{$k}}][answer]" value="3" id="s2q1ra3"></td>
                                    <td valign="center" align="center"><input type="radio" class="form-check-input" name="question[{{$k}}][answer]" value="4" id="s2q1ra4"></td>
                                    <td valign="center" align="center"><input type="radio" class="form-check-input" name="question[{{$k}}][answer]" value="5" id="s2q1ra5"></td>
                                    <td valign="center" align="right">{{ $question['caption'][1] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @elseif ($question['answer-type'] == 'feedback')
                    <div class="mb-4 ques">

                        @if (isset($question['option']) && !empty($question['option']))
                        <input type="hidden" name="question[{{ $k }}]['question']" value="{{ $question['question'] }}" />
                        <input type="hidden" name="question[{{ $k }}]['answer-type']" value="{{ $question['answer-type'] }}" />
                        <div class=" mb-3">

                        <label for="abs1" class="form-label">{{ $question['question'] }}</label>
                        </div>
                        @php $t = 0; @endphp
                        @foreach ($question['option'] as $item)
                        <div class="form-check mb-3">
                            <input class="form-check-input" required type="radio" id="ans3a{{ $t }}" name="question[{{ $k }}]['answer']" value="{{ $item }}" required>
                            <label class="form-check-label" for="ans3a{{ $t }}" name="ans3">{{ $item }}</label> <br>
                        </div>
                        @php $t++ ; @endphp
                        @endforeach
                        @endif

                    </div>
                    @elseif ($question['answer-type'] == 'grid')
                    <input type="hidden" name="question[{{ $k }}]['question']" value="{{ $question['question'] }}" />
                    <input type="hidden" name="question[{{ $k }}]['answer-type']" value="{{ $question['answer-type'] }}" />

                    <div class="mb-5 ques">
                    <h2 class="form-label d-flex mb-3 justify-content-between align-items-center"><span class="ques-text">{{ $question['question'] }}<sup class="text-red"></sup></span> <!--<span class="point">1 point</span>--></h2>
                    <h3><i>Check all that apply.</i></h3>
                    <table class="mb-0 table" width="100%" cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                            <tr align="center">
                                <th>&nbsp;</th>
                                @foreach($question['option'] as $key=>$option)
                                <th>{{ $option }}</th>
                                @endforeach
                            </tr>
                            @foreach($question['sque'] as $subKey=>$subQue)
                            <tr>
                                <input type="hidden" name="question[{{ $k }}][sque][{{$subKey}}][question]" value="{{ $subQue['title'] }}" />
                                <input type="hidden" name="question[{{ $k }}][sque][{{$subKey}}][type]" value="{{@$subQue['type']}}" />
                                <th>{{ $subQue['title'] }}</th>
                                @if(@$subQue['type'] == 'multi')
                                @foreach($question['option'] as $key=>$option)
                                <td valign="center" align="center">
                                    <input type="checkbox" class="form-check-input" name="question[{{$k}}][sque][{{$subKey}}][answer][]" value="{{ $key }}" id="q1ra1">
                                </td>
                                @endforeach
                                @else
                                @foreach($question['option'] as $key=>$option)
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
                    @elseif ($question['answer-type'] == 'text')
                    <div class="mb-4 ques">
                        <div class=" mb-3">

                            <label for="abs1" class="form-label">
                                {{ $question['question'] }} </label>
                        </div>
                        <input type="hidden" name="question[{{ $k }}]['question']" value="{{ $question['question'] }}" />
                        <input type="hidden" name="question[{{ $k }}]['answer-type']" value="{{ $question['answer-type'] }}" />

                        <textarea class="form-control" name="question[{{ $k }}]['answer']" placeholder="write your answer here..." id="ans1" style="height: 130px" required></textarea>

                    </div>
                    @elseif ($question['answer-type'] == 'single')
                    <div class="mb-4 ques">

                        @if (isset($question['option']) && !empty($question['option']))
                        <input type="hidden" name="question[{{ $k }}]['question']" value="{{ $question['question'] }}" />
                        <input type="hidden" name="question[{{ $k }}]['answer-type']" value="{{ $question['answer-type'] }}" />
                        <div class=" mb-3">

                        <label for="abs1" class="form-label">{{ $question['question'] }}</label>
                        </div>
                        @php $t = 0; @endphp
                        @foreach ($question['option'] as $item)
                        <div class="form-check mb-3">
                            <input class="form-check-input" required type="radio" id="ans3a{{ $t }}" name="question[{{ $k }}]['answer']" value="{{ $item }}" required>
                            <label class="form-check-label" for="ans3a{{ $t }}" name="ans3">{{ $item }}</label> <br>
                        </div>
                        @php $t++ ; @endphp
                        @endforeach
                        @endif

                    </div>
                    @elseif ($question['answer-type'] == 'multi')
                    <div class="mb-4 ques">
                      <div class="checkbox-group required">
                        <span class="tool-tip">Please check atleast one</span>
                        @if (isset($question['option']) && !empty($question['option']))
                        <div class="mb-4">
                            <div class=" mb-3">

                                <label for="ans4" class="form-label">
                                    {{ $question['question'] }}
                                </label>
                            </div>
                            <input type="hidden" name="question[{{ $k }}]['question']" value="{{ $question['question'] }}" />
                            <input type="hidden" name="question[{{ $k }}]['answer-type']" value="{{ $question['answer-type'] }}" />
                            @php
                            $i = 0;
                            @endphp
                            @foreach ($question['option'] as $item)
                            <div class="form-check mb-3">

                                <input type="checkbox" name="question[{{ $k }}]['answer'][]" value="{{ $item }}" class="form-check-input" id="ans4{{ $i }}">
                                <label class="form-check-label" for="ans4{{ $i }}">
                                    {{ $item }}
                                </label>
                            </div>
                            @php
                            $i++;
                            @endphp
                            @endforeach
                        </div>
                        @endif
                      </div>
                    </div>
                    @endif
                    @endforeach
                    @if (isset($next->id))
                    {{-- @dd($next->id) --}}
                    <input type="hidden" name="next_id" value="{{ $next->id }}" />
                    @endif
                    <button type="submit" class="cta">Send my answers <span class="icon"><img src="{{ url('images/arrow-right-cta.svg') }}" alt="" height="18" width="22"></span></button>
                    @endif
                    @endforeach
                </form>
                @endif
                @endif
                @else
                @if ($section->type == 'survey')
                <div class="user-copy pe-md-5">
                    <div class="go-back"><a href="/" class="align-items-center d-inline-flex"><span class="icon"><img src="{{ url('images/go-back-green.svg') }}" alt=""></span> Go back to
                            Dashboard</a></div>
                    <h1>{{ $section->name }}</h1>
                    <p><strong>Thank you for participating in the Financially Fit Certification Survey!</strong>
                    </p>
                    <p>Please fill in the information below and then complete the behavioral, knowledge and
                        pre-questions to assess what you already know!</p>
                </div>
                <div class="alert alert-success" role="alert">
                    Survey already completed.....
                </div>
                @endif
                @endif
            </div>
            <div class="col-md-4 ps-md-5 side-col">
                @if (isset($next->id))
                <div class="cta-box mb-5">
                    <a href="/section/{{ $p_id }}/{{ $next->id }}" class="cta transparent w-100">Continue to the next
                        Section
                        <span class="icon"><img src="{{ url('images/arrow-right-green-cta.svg') }}" alt="" height="18" width="22"></span></a>
                </div>
                @endif
                @foreach ($sections as $program)
                <div class="acc-box">
                    <div class="acc-head">
                        <span class="d-flex point"><img src="{{ url('images/flag-point.svg') }}" alt="" class="closed"><img src="{{ url('images/flag-point-green.svg') }}" alt="" class="opened"></span>
                        <h2>{{ $program->name }}</h2>
                        <span class="arrow"><img src="{{ url('images/arrow-acc.svg') }}" alt=""></span>
                    </div>
                    <div class="acc-content">

                        @if($program->description)
                        {!! $program->description !!}
                        @endif
                        {{-- <a href="/section/{{$p_id}}/{{ $program->id }}" class="link-info"> --}}
                        <a href="/section/{{ $p_id }}/{{ $program->id }}" class="cta d-inline-flex justify-content-center mt-4 w-auto" style="max-width: none; padding:10px 15px;">Start</a>
                    </div>

                </div>
                @endforeach
                @if ($final_exam != '')
                @if (!$final_exam->isEmpty())
                <div class="acc-box">
                    <div class="acc-head">
                        <span class="d-flex point"><img src="{{ url('images/flag-point.svg') }}" alt="" class="closed"><img src="{{ url('images/flag-point-green.svg') }}" alt="" class="opened"></span>
                        <h2>{{ $final_exam[0]->title }} (Exam)</h2>
                        <span class="arrow"><img src="{{ url('images/arrow-acc.svg') }}" alt=""></span>
                    </div>
                    <div class="acc-content">

                        @if($program->description)
                        {!! $program->description !!}
                        @endif
                        <a href="{{ route('examShow', ['ass_id' => $final_assessment_id, 'id' => $final_exam[0]->id]) }}" class="cta d-inline-flex justify-content-center mt-4 w-auto" style="max-width: none; padding:10px 15px;">Start</a>
                    </div>

                </div>
                @endif
                @endif
            </div>
        </div>
    </div>
</main>
@include('user/help')

<script>
    $(document).ready(function() {

        // $(".box").click(function() {
        //     $("#myCarousel").carousel();
        //     // $("#myModal").modal("show");
        //     $(this).find('#myModal').modal("show");
        // });
        $(".linkSource").click(function() {
            $("#myCarousel").carousel();
            // $("#myModal").modal("show");
            $(this).parents('.vid').find('.modal').modal("show");
        });

        // $('body').on('click', '.btn-close', function()
        // {
        //     $('#myModal').modal("hide");
        // });
        $('.lastvid').click(function(){
            let token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('progressSave') }}",
                data: {
                    p_id: {{ $p_id }},
                    s_id: {{ $id }},
                    _token: token
                },
                success: function(response) {
                    if (response.status == "success") {
                        console.log(response);
                    } else {
                        console.log(response);
                    }
                }
            });
        });

        $('.vidplay').click(function(){
            let _token = $('meta[name="csrf-token"]').attr('content');
            let v_id = $(this).attr('data-id');
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('videoStatus') }}",
                data: {
                    p_id: {{ $p_id }},
                    s_id: {{ $id }},
                    v_id: v_id,
                    _token: _token
                },
                success: function(response) {
                    if (response.status == "success") {
                        console.log(response);
                    } else {
                        console.log(response);
                    }
                }
            });
        })
    });
</script>
@endsection
