<div class="row mt-2 options">
    <div class="col-12 col-sm-10">
        <div class="form-group">
            <input type="text" name="question[{{$index}}][option][{{$o_index}}]" class="form form-control" required autofocus value="{{ old('option', $option) }}"/>
        </div>
    </div>
    <div class="col-12 col-sm-2">
        <div class="form-group">
            <button type="button" class="btn btn-secondary remove-option">Remove</button>
        </div>
    </div>
</div>