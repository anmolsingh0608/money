<div class="row">
    <div class="mt-3">
        <h5><span class="question-order">Question</span></h5>
    </div>
    <div class="col-12 col-sm-8">
        <div class="form-group">
            <label for="Question">Question&nbsp;</label>
            <input type="text" name="question[{{$index}}][question]" class="form form-control" required value=""/>
        </div>
    </div>
    <div class="col-12 col-sm-2 mt-4">
        <div class="form-group">
            <select class="form form-select answer-type" name="question[{{$index}}][answer-type]">
                <option value="single" >Single Select</option>
                <option value="multi" >Multi Select</option>
                <option value="text" >Text</option>
            </select>
        </div>
    </div>
    <div class="col-12 col-sm-2 mt-4">
        <div class="form-group">
            <button type="button" class="btn btn-secondary add-exam-option" id="add-option">Add Options</button>
        <button type="button" class="btn btn-secondary remove-question">Remove</button>
        </div>
    </div>
    <input type="hidden" value="{{$index}}" class="question-exam-number">
    <input type="hidden" value="0" class="options-exam-count">
    <div class="form-group list-exam-options-Q{{$index}}">
        <div class="col-12 col-sm-2 mt-2">
            <label for="option"><span class="option-order">Option(s)&nbsp;</span></label>
        </div>

    </div>
    <!-- <input type="hidden" value="video" name="section[{{$index}}][type]" /> -->
    <!-- <div class="form-group">
        <label>Description <span>*</span></label>
        <textarea class="ckeditor form-control" name="section[{{$index}}][description]"></textarea>
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