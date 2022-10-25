<div class="row question-select mb-3">
    <div class="col-12 col-sm-10">
        <div class="form-group">
            <label>Question <span></span></label>

            <div class="drag-group d-flex">
            <img  src="{{ asset('images/drag-14-32.png') }}" alt="" style="cursor: pointer; margin-right:10px; ">
            <select name="question[{{ $index }}][id]" id="questions{{ $index }} "
                class="form-select form-control worth required">
                <option value="" disabled>None</option>
                @if ($questions->isNotEmpty())
                    @foreach ($questions as $key => $question)
                        <option value="{{ $question->id }}" data-marks="{{ $question->worth }}"
                            @if (isset($q) && !empty($q->id) && $q->id == $question->id) selected="selected" @endif>{{ $question->title }} -
                            {{ $question->worth }} Point</option>
                    @endforeach
                @endif
            </select>
            </div>
        </div>
    </div>
    <input type="hidden" value="{{ $index+1 }}" name="question[{{ $index }}][sequence]">
    <div class="col-5 col-sm-2">
        <div class="form-group">
            <label>&nbsp;</label>
            <div>
                <button type="button" class="btn btn-secondary remove-question-row">
                    Remove
                </button>
            </div>
        </div>
    </div>
</div>
{{-- <script>
    function getSelectValue(questions{{ $index }}) {
        if (questions{{ $index }}) != '') {
        alert(questions{{ $index }});
    }
    }
</script> --}}
