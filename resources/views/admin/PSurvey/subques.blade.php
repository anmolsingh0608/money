<div class="row mt-2 sub-questions-list">
    <div class="col-12 col-sm-8">
        <div class="form-group">
            <label for="">Question Title</label>
            <input type="text" name="question[{{$q_index}}][sque][{{$index}}][title]" class="form form-control" required autofocus value="{{ old('title', $sque['title']) }}" />
        </div>
    </div>
    <div class="col-12 col-sm-2">
        <div class="form-group">
            <button type="button" style="width:100%;" class="btn btn-secondary mt-4 add-sub-option" id="add-sub-option" onClick='subOptions("sub-option", "sub-options", "/admin/sections/add-sub-option", this)'>Add Option</button>
        </div>
    </div>
    <div class="col-12 col-sm-2">
        <div class="form-group">
            <button type="button" class="btn btn-secondary mt-4 remove-sque offset-1">Remove</button>
        </div>
    </div>
</div>
<div>
    <input type="hidden" value="{{ $index }}" class="hidden-index"/>
    <div class="row sub-opt">
        @if($options && !empty($options))

        @endif
        <input type="hidden" value=@if($options && !empty($options)) "{{ max(array_keys($options)) + 1 }}" @else "0" @endif class="sub-options-count">
        <div class="form-group list-sub-options">
            <label for="option"><span class="option-exam">Option(s) <span>*</span>&nbsp;</span></label>
            <div class="col-12 col-sm-2 mt-2">

            </div>
            @if($options && !empty($options))
            @foreach($options as $key=>$option)
            @include('admin.PSurvey.subopt', ['index' => $key, 'q_index' => $q_index, 'option' => $option])
            @endforeach
            @endif
        </div>
    </div>
</div>
