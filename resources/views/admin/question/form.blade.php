<form method="POST" action="{{ route('admin.questions.store') }}" class="" enctype="multipart/form-data" onsubmit="checkans(event)">
    @csrf
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
        <textarea class="ckeditor form-control" value="{{ old('description', $question->description) }}"
                name="description"></textarea>
    </div>
    <div class="form-group">
        <label for="">Image</label>
        <input type="file" class="form form-control" name="que_image" />
    </div>
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
            <option value="single">Single select</option>
            <option value="multi">Multi select</option>
            <option value="text">Text</option>
            <option value="rate">Rating</option>
            <option value="grid">Grid</option>
            <option value="feedback">Feedback</option>
        </select>
    </div>
    <div class="form-group exam-options mt-3">
        <button type="button"  class="btn btn-secondary add-exam-option" id="add-exam-option">Add Options</button>
    </div>

    <input type="hidden" value="0" class="options-exam-count">
    <div class="form-group list-exam-options">
        <div class="col-12 col-sm-2 mt-2">
            <label for="option"><span class="option-exam">Option(s) <span>*</span>&nbsp;</span></label>
        </div>

    </div>

    <div class="form-group exam-sub-question" style="display: none;">
        <div class="form-group">
            <label for="">Sub Question Type <span>*</span></label>
            <select name="sque_type" id="sub-question-type" class="form form-select sub-question-type">
                <option value="single">Single select</option>
                <option value="multi">Multi select</option>
            </select>
        </div>
        <button type="button"  class="btn btn-secondary add-sub-question mt-3" id="add-sub-question">Add Sub Question</button>


        <input type="hidden" value="0" class="sub-question-count">
        <div class="form-group list-sub-questions">
            <div class="col-12 col-sm-2 mt-2">
                <label for="option"><span class="sub-question">Questions(s) <span>*</span>&nbsp;</span></label>
            </div>

        </div>
    </div>

    <div class="form-group exam-answers" style="display: none;">
        <button type="button" class="btn btn-secondary add-exam-answers" onClick="onClick()" id="add-exam-answer">Add Answers</button>
    </div>
    <input type="hidden" value="0" class="answers-exam-count">
    <div class="form-group list-exam-answers" style="display: none;">
        <div class="col-12 col-sm-2 mt-2">
            <label for="option"><span class="answer-exam">Answer(s) <span>*</span>&nbsp;</span></label>
        </div>

    </div>

    <div class="form-group exam-rate" style="display: none;">
        <div class="col-12 col-sm-12">
            <label for="option"><span class="answer-exam">Starting Caption <span>*</span>&nbsp;</span></label>
            <input type="text" name="rate[first]" class="form form-control mb-3" value="" />
            <label for="option"><span class="answer-exam">Ending Caption <span>*</span>&nbsp;</span></label>
            <input type="text" name="rate[second]"class="form form-control" value="" />
        </div>
    </div>

    <div class="form-group exam-feedback mt-3" style="display: none;">
        <button type="button"  class="btn btn-secondary add-exam-feedback" id="add-exam-feedback">Add Options</button>
    </div>

    <input type="hidden" value="0" class="options-feedback-count">
    <div class="form-group list-feedback-options" style="display: none;">
        <div class="col-12 col-sm-2 mt-2">
            <label for="option"><span class="option-feedback">Option(s) <span>*</span>&nbsp;</span></label>
        </div>

    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-secondary mt-3" onclick="checkFun(event)">create</button>
    </div>


</form>

<script>
function subOptions(marker, markers, url) {
        let addMarker = $('#add-' + marker)
        // console.log('here');
        // if (addMarker.length > 0) {
            // addMarker.on("click", function () {
                let indexElem = $('.sub-options-count');
                let elem_index = indexElem.val();
                let type = $('.sub-question-type').val();
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
