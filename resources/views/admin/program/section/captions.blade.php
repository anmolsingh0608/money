<div class="form-group captions">
    <div class="row">
        @foreach($captions as $key=>$caption)
        <div class="col-12 col-sm-5">
            <input type="text" name="question[{{$index}}][caption][{{$key}}]" value="{{$caption}}" class="form-control" required>
        </div>
        @endforeach
    </div>
</div>
