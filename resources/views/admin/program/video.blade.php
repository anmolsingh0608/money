<div class="row">
    <div class="mt-3">
        <span style="display: inline">
            <h5 style="display: inline;" class="section-order">Section {{$index + 1}}</h5>
        </span>
        <span style="display: inline">(Video)</span>
    </div>
    <div class="col-12 col-sm-11">
        <div class="form-group">
            <label for="Name">Name&nbsp;</label>
            <input type="text" name="section[{{$index}}][name]" class="form form-control" required />
        </div>
    </div>
    <div class="col-12 col-sm-1 mt-4">
        <div class="form-group">
            <button type="button" class="btn btn-secondary delete-row">Remove</button>
        </div>
    </div>
    <input type="hidden" value="video" name="section[{{$index}}][type]" />
    <div class="form-group">
        <label>Description</label>
        <textarea class="ckeditor form-control" name="section[{{$index}}][description]"></textarea>
    </div>
    <!-- <div class="col-5 col-sm-2">
        <div class="form-group">
            <label>&nbsp;</label>
            <div>
                <button type="button" class="btn btn-primary delete-video"><i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
        </div>
    </div> -->
    <input type="hidden" value="{{ $index+1 }}" name="section[{{ $index }}][sequence]">
</div>
