<div class="row mt-2 sub-questions-list">
    <div class="col-12 col-sm-8">
        <div class="form-group">
            <label for="">Question Title</label>
            <input type="text" name="sque[{{$index}}][title]" class="form form-control" required autofocus value="{{ old('title', $quest['title']) }}" />
        </div>
    </div>
    <div class="col-12 col-sm-2">
        <div class="form-group">
            <button type="button" style="width:100%;" class="btn btn-secondary mt-4 add-sub-option" id="add-sub-option" onClick='subOptions("sub-option", "sub-options", "/admin/questions/add-sub-option")'>Add Option</button>
        </div>
    </div>
    <div class="col-12 col-sm-2">
        <div class="form-group">
            <button type="button" class="btn btn-secondary mt-4 remove offset-1">Remove</button>
        </div>
    </div>
</div>
<div>
    <input type="hidden" value="{{ $index }}" class="hidden-index"/>
    <div class="row sub-opt">
        @php 
        $quest['option'] = json_decode($quest['options'], true);
        @endphp
        @if($quest['option'] && !empty($quest['option']))
        <input type="hidden" value="{{ $quest['id']}}" name="sque[{{$index}}][id]">
        @endif
        <input type="hidden" value=@if($quest['option'] && !empty($quest['option'])) "{{ max(array_keys($quest['option'])) + 1 }}" @else "0" @endif class="sub-options-count">
        <div class="form-group list-sub-options">
            <label for="option"><span class="option-exam">Option(s) <span>*</span>&nbsp;</span></label>
            <div class="col-12 col-sm-2 mt-2">
                
            </div>
            @if($quest['option'] && !empty($quest['option']))
            @foreach($quest['option'] as $key=>$option)
            @php $answer = json_decode($quest['answer'], true) @endphp
            @include('admin.question.subopt', ['index' => $key, 'q_index' => $index, 'option' => $option, 'type' => $quest['type'], 'answers' => $answer])
            @endforeach
            @endif
        </div>
    </div>
</div>