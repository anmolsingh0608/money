@extends('layouts.app')
@section('content')
<main class="main">
    <div class="container-xxl">
        <div class="row">
            <div class="col-md-12 pe-md-5">
                <div class="user-copy">
                    <div class="user-copy">
                        <div class="col-12 mt-4">
                            <div>
                                <h4>Edit Question</h4>
                            </div>
                            <form method="POST" action="{{ route('admin.questions.update', $question->id) }}" class="" enctype="multipart/form-data" onsubmit="checkans(event)">
                                @csrf
                                @method('PUT')
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
                                <input type="hidden" value="0" id="exam-questions-index" />
                                <div class="form-group">
                                    <label for="">Title <span>*</span></label>
                                    <input type="text" name="title" id="" class="form form-control" value="{{ old('title', $question->title) }}" required />
                                </div>
                                <div class="form-group">
                                    <label for="">Description <span></span></label>
                                    <textarea class="ckeditor form-control" value=""
                                            name="description">{{ old('description', $question->description) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Image</label>
                                    <input type="file" class="form form-control" name="que_image" />
                                </div>
                                @if ($question->getFirstMediaUrl('question'))
                                    <div class="form-group mt-2">
                                        <img src="{{ $question->getFirstMediaUrl('question') }}"
                                            alt="{{ url('/images/no-image-icon.png') }}" width="250" height="200">
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label for="">Video URL</label>
                                    <input type="url" class="form form-control" name="url" value="{{ old('url', $question->url) }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Worth <span>*</span></label>
                                    <input type="number" name="worth" class="form form-control" value="{{ old('worth', $question->worth) }}" required />
                                </div>
                                <div class="form-group select-type">
                                    <label for="">Type <span>*</span></label>
                                    <select name="type" id="exam-answer-type" class="form form-select exam-answer-type">
                                        <option value="single" @if($question->type == "single") selected="selected" @endif>Single select</option>
                                        <option value="multi" @if($question->type == "multi") selected="selected" @endif>Multi select</option>
                                        <option value="text" @if($question->type == "text") selected="selected" @endif>Text</option>
                                        <option value="rate" @if($question->type == "rate") selected="selected" @endif>Rating</option>
                                        <option value="grid" @if($question->type == "grid") selected="selected" @endif>Grid</option>
                                        <option value="feedback" @if($question->type == "feedback") selected="selected" @endif>Feedback</option>
                                    </select>
                                </div>

                                <div  @if($question->type == "text" || $question->type == 'grid' || $question->type == 'rate' || $question->type == 'feedback') style="display:none;" @endif class="exam-options-container">
                                <div class="form-group exam-options mt-3">
                                    <button type="button" class="btn btn-secondary add-exam-option" id="add-exam-option">Add Options</button>
                                </div>
                                <input type="hidden" value=@if($question->option && !empty($question->option)) "{{ max(array_keys($question->option)) + 1 }}" @else "0" @endif class="options-exam-count">
                                <div class="form-group list-exam-options">
                                    <div class="col-12 col-sm-2 mt-2">
                                        <label for="option"><span class="option-exam">Option(s)&nbsp;</span></label>
                                    </div>
                                    @if($question->type == 'single')
                                    @if($question->option && !empty($question->option))
                                    @foreach($question->option as $key=>$option)
                                    @include('admin.question.options', ['index' => $key, 'option' => $option, 'type' => $question->type, 'answers' => $question->answer])
                                    @endforeach
                                    @endif
                                    @endif
                                </div>
                                </div>

                                <div @if($question->type != "text") style="display:none;" @endif class="exam-answer-container">
                                    <div class="form-group exam-answers mt-3">
                                        <button type="button" class="btn btn-secondary add-exam-answers" id="add-exam-answer">Add Answers</button>
                                    </div>
                                    <input type="hidden" value=@if($question->type == "text") "{{ max(array_keys($question->answers)) + 1 }}" @else "0" @endif class="answers-exam-count">
                                    <div class="form-group list-exam-answers">
                                        <div class="col-12 col-sm-2 mt-2">
                                            <label for="option"><span class="answer-exam">Answer(s)&nbsp;</span></label>
                                        </div>
                                        @if($question->answers && !empty($question->answers))
                                        @foreach($question->answers as $key=>$answer)
                                        @include('admin.question.answer', ['index' => $key, 'answer' => $answer, 'type' => $question->type])
                                        @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group exam-feedback mt-3" @if($question->type != "feedback") style="display: none;" @endif>
                                    <button type="button"  class="btn btn-secondary add-exam-feedback" id="add-exam-feedback">Add Options</button>
                                </div>

                                <input type="hidden" value=@if($question->option && !empty($question->option)) "{{ max(array_keys($question->option)) + 1 }}" @else "0" @endif class="options-feedback-count">
                                <div class="form-group list-feedback-options">
                                    @if($question->type == 'feedback')
                                    <div class="col-12 col-sm-2 mt-2">
                                        <label for="option"><span class="option-feedback">Option(s) <span>*</span>&nbsp;</span></label>
                                    </div>

                                    @if($question->option && !empty($question->option))
                                    @foreach($question->option as $key=>$option)
                                    @include('admin.question.feedback-options', ['index' => $key, 'option' => $option ])
                                    @endforeach
                                    @endif
                                    @endif
                                </div>

                                <div @if($question->type == "grid") @else style="display:none;" @endif class="exam-sub-question">
                                <div class="form-group">
                                        @php
                                        if($question->sub_question()->exists())
                                            $type = $question->sub_question[0]->type;
                                        else
                                            $type = '';
                                        @endphp
                                        <label for="">Sub Questions Type <span>*</span></label>
                                        <select name="sque_type" id="sub-question-type" class="form form-select sub-question-type">
                                            <option value="single" @if($type == 'single') selected @endif>Single select</option>
                                            <option value="multi" @if($type == 'multi') selected @endif>Multi select</option>
                                        </select>
                                    </div>
                                    <button type="button"  class="btn btn-secondary add-sub-question mt-3" id="add-sub-question">Add Sub Question</button>

                                    <input type="hidden" value=@if($question->type == "grid") "{{ max(array_keys($question->sub_question->toArray())) + 1 }}" @else "0" @endif class="sub-question-count">
                                    <div class="form-group list-sub-questions">
                                        <div class="col-12 col-sm-2 mt-2">
                                            <label for="option"><span class="answer-exam">Question(s)&nbsp;</span></label>
                                        </div>
                                        @if($question->sub_question && !empty($question->sub_question))
                                        @foreach($question->sub_question as $key=>$quest)
                                        @include('admin.question.subques', ['index' => $key, '$quest' => $quest, 'type' => $quest->type])
                                        @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group exam-rate" @if($question->type == 'rate') @else style="display: none;" @endif>
                                    @if($question->type == 'rate')
                                    @php
                                        $rate = json_decode($question->rate, true);
                                    @endphp
                                    @else
                                    @php
                                        $rate = ['first' => '', 'second' => ''];
                                    @endphp
                                    @endif
                                    <div class="col-12 col-sm-12">
                                        <label for="option"><span class="answer-exam">Starting Caption <span>*</span>&nbsp;</span></label>
                                        <input type="text" name="rate[first]" class="form form-control" value="{{ old('first', $rate['first']) }}" />
                                        <label for="option"><span class="answer-exam">Ending Caption <span>*</span>&nbsp;</span></label>
                                        <input type="text" name="rate[second]"class="form form-control" value="{{ old('first', $rate['second']) }}" />
                                    </div>
                                </div>
                                <!-- <div class="form-group list-exam-questions">

    </div> -->
                                <div class="form-group">
                                    <button type="submit" onclick="checkFun(event)" class="btn btn-secondary mt-3">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
</main>

<script>
    function subOptions(marker, markers, url) {
        let addMarker = $('#add-' + marker)
        // console.log('here');
        // if (addMarker.length > 0) {
            // addMarker.on("click", function () {
                let indexElem = $('.sub-options-count');
                let elem_index = indexElem.val();
                let type = $('.sub-question-type').val();
                console.log(type);
                $.ajax({
                    url: url,
                    type: 'get',
                    data: {
                        'index': elem_index,
                        'type': type,
                    },
                    beforeSend: function () {
                        $("." + marker + "-processing").show();
                    },
                    success: function (response) {
                        // console.log($('.list-'+markers));
                        $('.list-'+markers).append(response);
                        elem_index++;
                        $('.sub-options-count').val(elem_index);
                    },
                    complete: function () {
                        $("." + marker + "-processing").hide();
                        var container = $('.sub-opt').slice(1);
                        // console.log(container);
                        container.children('.list-sub-options').find('input[type="text"]').attr('disabled', 'disabled');
                        // container.children('.list-sub-options').find('input[type="radio"]').attr('name', 'sque['+elem_index+'][answer]');
                        container.each(function(index,element){
                            let count = $(element).parent().children('.hidden-index').val();
                            // console.log($(element).children('.list-sub-options').find('input[type="radio"]'));
                            $(element).children('.list-sub-options').find('input[type="radio"]').attr('name', 'sque['+count+'][answer]');
                            $(element).children('.list-sub-options').find('input[type="checkbox"]').attr('name', 'sque['+count+'][answer][]');
                            $('.list-sub-options').first().find('input[type="text"]').keyup(function(){
                                let name = $(event.target).attr('name');
                                $('input[name="'+name+'"]').val($(event.target).val());
                            });
                        });

                        $('.sub-opt').first().children('.list-sub-options').find('input[type="radio"]').attr('name', 'sque['+$('.sub-opt').first().parent().children('.hidden-index').val()+'][answer]');
                        $('.sub-opt').first().children('.list-sub-options').find('input[type="checkbox"]').attr('name', 'sque['+$('.sub-opt').first().parent().children('.hidden-index').val()+'][answer][]');
                    }
                })
            // })

            $('.list-' + markers).on("click", ".remove", function () {
                if (confirm('Are you sure ?')) {
                    $(this).parents(".row").first().remove();
                }
                return false;
            })
        // }
    }
</script>

@endsection
