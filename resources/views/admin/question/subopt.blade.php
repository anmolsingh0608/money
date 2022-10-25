<div class="row mt-2 exam-options-list">
    <div class="col-12 col-sm-10">
        <div class="form-group">
            <input type="text" name="option[{{$index}}]" class="form form-control" required autofocus value="{{ old('option', $option) }}"/>
        </div>
    </div>
    <div class="col-12 col-sm-2">
        <div class="form-group">
            @if($type == 'single')
                <input type="radio" name="sque[{{$q_index}}][answer]" class="form-check-input" value="{{ $index }}" @if($answers == $index) checked="checked" @endif required>
            @elseif($type == 'multi')
                <input type="checkbox" name="sque[{{$q_index}}][answer][]" class="form-check-input checkbox" @foreach($answers as $key => $answer) @if($answer == $index) checked="checked" @endif @endforeach value="{{ $index }}">
            @endif
            <button type="button" class="btn btn-secondary remove-exam-option">Remove</button>
        </div>
    </div>
</div>