<div class="row mt-2 exam-answers-list">
    <div class="col-12 col-sm-10">
        <div class="form-group">
            <input type="text" name="answer[{{$index}}]" class="form form-control" required autofocus value="{{ old('answer', $answer) }}"/>
        </div>
    </div>
    <div class="col-12 col-sm-2">
        <div class="form-group">
            <button type="button" class="btn btn-secondary remove-exam-answer">Remove</button>
        </div>
    </div>
</div>