<div class="row mt-2 exam-feedback-list">
    <div class="col-12 col-sm-10">
        <div class="form-group">
            <input type="text" name="option[{{$index}}]" class="form form-control" required autofocus value="{{ old('option', $option) }}"/>
        </div>
    </div>
    <div class="col-12 col-sm-2">
        <div class="form-group">
            <button type="button" class="btn btn-secondary remove-exam-feedback">Remove</button>
        </div>
    </div>
</div>
