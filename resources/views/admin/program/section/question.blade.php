<div class="row">
    <div class="mt-3">
        <h5><span class="question-order">Question #{{ $question['order'] }}</span></h5>
    </div>
    <div class="col-12 col-sm-7">
        <div class="form-group">
            <label for="Question">Question&nbsp;</label>
            <input type="text" name="question[{{ $index }}][question]" class="form form-control" required
                value="{{ old('question', $question['question']) }}" />
        </div>
    </div>
    <div class="col-12 col-sm-2 mt-4">
        <div class="form-group">
            <select class="form form-select answer-type" name="question[{{ $index }}][answer-type]">
                <option value="single" @if ($question['answer-type'] == 'single') selected @endif>Single Select</option>
                <option value="multi" @if ($question['answer-type'] == 'multi') selected @endif>Multi Select</option>
                <option value="text" @if ($question['answer-type'] == 'text') selected @endif>Text</option>
                <option value="rating" @if ($question['answer-type'] == 'rating') selected @endif>Rating</option>
                <option value="grid" @if ($question['answer-type'] == 'grid') selected @endif>Grid</option>
                <option value="feedback" @if ($question['answer-type'] == 'feedback') selected @endif>Feedback</option>
            </select>
        </div>
    </div>
    <div class="col-12 col-sm-3 mt-4">
        <div class="form-group">
            <button type="button" @if ($question['answer-type'] == 'text' || $question['answer-type'] == 'rating' || $question['answer-type'] == 'grid') style="display: none;" @endif class="btn btn-secondary add-option" id="add-option">Add Options</button>
            <button type="button" @if ($question['answer-type'] != 'grid') style="display: none;" @endif class="btn btn-secondary add-sub-que" id="add-sub-que">Add Sub Question</button>
            <button type="button" class="btn btn-secondary remove-question">Remove</button>
        </div>
    </div>
    <input type="hidden" value="{{ $index }}" class="question-number">
    <input type="hidden" value="{{ count($question['option']) }}" class="options-count">
    <input type="hidden" value=@if($question['answer-type'] == "grid") "{{ max(array_keys($question['sque'])) + 1 }}" @else "0" @endif class="sub-question-count">
    <div class="form-group question-opts list-sub-ques list-options-Q{{ $index }}">
        <div class="col-12 col-sm-2 mt-2">
            <label for="option"><span class="option-order">Option(s)&nbsp;</span></label>
        </div>
        @if ($question && !empty($question))
            @foreach ($question['option'] as $key => $option)
                @if ($question['answer-type'] != 'text' && $question['answer-type'] != 'grid')
                    @include('admin.program.section.options', ['index' => $index, 'o_index' => $key,'option'=>$option])
                @endif
            @endforeach
            @if(isset($question['caption']))
                @if ($question['answer-type'] == 'rating')
                    @include('admin.program.section.captions', ['index' => $index,'captions'=>$question['caption']])
                @endif
            @endif
            @if($question['answer-type'] == 'grid')
                @foreach($question['sque'] as $key => $sque)
                    @include('admin.PSurvey.subques', ['q_index' => $index, 'sque' => $sque, 'index' => $key, 'options' => $question['option']])
                @endforeach
            @endif
        @endif
    </div>
    <!-- <input type="hidden" value="video" name="section[{{ $index }}][type]" /> -->
    <!-- <div class="form-group">
        <label>Description <span>*</span></label>.
        <textarea class="ckeditor form-control" name="section[{{ $index }}][description]"></textarea>
    </div> -->
    <!-- <div class="col-5 col-sm-2">
        <div class="form-group">
            <label>&nbsp;</label>
            <div>
                <button type="button" class="btn btn-primary delete-video"><i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
        </div>
    </div> -->
</div>
<script>
    function subOptions(marker, markers, url, val) {
        let addMarker = $('#add-' + marker)
        // console.log('here');
        // if (addMarker.length > 0) {
            // addMarker.on("click", function () {
                let indexElem = $(val).parents('.question-opts').parent().find('.sub-options-count');
                let elem_index = indexElem.val();
                let q_index = $(val).parents('.question-opts').parent().find('.question-number').val();
                let type = $('.sub-question-type').val();
                container = $(val).parents('.question-opts').parent();
                console.log(q_index);
                $.ajax({
                    url: url,
                    type: 'get',
                    data: {
                        'index': elem_index,
                        'q_index': q_index,
                        'type': type,
                    },
                    beforeSend: function () {
                        $("." + marker + "-processing").show();
                    },
                    success: function (response) {
                        // console.log(container.find('.sub-options-count'));
                        container.find('.list-'+markers).append(response);
                        elem_index++;
                        container.find('.sub-options-count').val(elem_index);
                    },
                    complete: function () {
                        $("." + marker + "-processing").hide();
                        // console.log(container.find('.list-sub-options'));
                        var containe = container.find('.sub-opt').slice(1);
                        // console.log(container);
                        containe.children('.list-sub-options').find('input[type="text"]').attr('disabled', 'disabled');
                        // container.children('.list-sub-options').find('input[type="radio"]').attr('name', 'sque['+elem_index+'][answer]');
                        containe.each(function(index,element){
                            let count = $(element).parent().children('.hidden-index').val();
                            // console.log($(element).children('.list-sub-options').find('input[type="radio"]'));
                            $(element).children('.list-sub-options').find('input[type="radio"]').attr('name', 'sque['+count+'][answer]');
                            $(element).children('.list-sub-options').find('input[type="checkbox"]').attr('name', 'sque['+count+'][answer][]');
                            container.find('.list-sub-options').first().find('input[type="text"]').keyup(function(){
                                let name = $(event.target).attr('name');
                                $('input[name="'+name+'"]').val($(event.target).val());
                            });
                        });

                        container.find('.sub-opt').first().children('.list-sub-options').find('input[type="radio"]').attr('name', 'sque['+$('.sub-opt').first().parent().children('.hidden-index').val()+'][answer]');
                        container.find('.sub-opt').first().children('.list-sub-options').find('input[type="checkbox"]').attr('name', 'sque['+$('.sub-opt').first().parent().children('.hidden-index').val()+'][answer][]');
                    }
                })
            // })

            $('.list-' + markers).on("click", ".remove", function () {
                if (confirm('Are you sure ?')) {
                    console.log($(this));
                    // $(this).parents(".row").first().remove();
                }
                return false;
            })
        // }
    }
</script>
