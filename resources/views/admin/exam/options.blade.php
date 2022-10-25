<div class="row mt-2 exam-options-list">
    <div class="col-12 col-sm-10">
        <div class="form-group">
            <input type="text" name="option[{{$o_index}}]" class="form form-control" required autofocus value="{{ old('option', $option) }}"/>
        </div>
    </div>
    <div class="col-12 col-sm-2">
        <div class="form-group">
            @if($type == 'single')
                <input type="radio" name="answer" class="form-check-input" value="{{ $o_index }}" required>
            @elseif($type == 'multi')
                <input type="checkbox" name="answer[]" class="form-check-input checkbox" value="{{ $o_index }}">
            @endif
            <button type="button" class="btn btn-secondary remove-exam-option">Remove</button>
        </div>
    </div>
</div>