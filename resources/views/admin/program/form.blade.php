@if (!empty($program->id))
    <form method="POST" action="{{ route('admin.programs.update', $program->id) }}" class=""
        enctype="multipart/form-data">
        @method('PUT')
    @else
        <form class="p-3" method="POST" action="{{ route('admin.programs.store') }}" class=""
            enctype="multipart/form-data">
@endif
@csrf
<h3>Add Program</h3>
@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <strong>{{ $message }}</strong>
    </div>
@endif

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="row">
    <div class="col-12 col-sm-12">
        <div class="form-group">
            <label>Title *<span></span></label>
            <input type="text" class="form-control" name="title" value="{{ old('title', $program->title) }}"
                required>
        </div>
        <div class="form-group">
            <label>Description <span></span></label>
            <textarea class="ckeditor form-control" value="{{ old('description', $program->description) }}"
                name="description"></textarea>
        </div>
        @include("admin/program/popup")
        <div class="form-group">
            <label for="">Status </label>
            <select name="status" id="" class="form-select">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
        <div class="form-group">
            <label for="">Program Type </label>
            <select name="program_type" id="" class="form-select">
                {{-- <option value="">None</option> --}}
                @foreach($programTypes as $k=>$p)
                <option value="{{$k}}">{{$p}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="">Image</label>
            <input type="file" class="form form-control" name="prog_image" />
        </div>
    </div>
</div>
<button type="button" id="add-section" class="btn btn-secondary mt-3">Add Section</button>
<div class="list-sections">
    <input type="hidden" value="0" id="section-index">
</div>

<div class="col-12">
    <button type="submit" class="btn btn-secondary mt-3">{{ !empty($program->id) ? 'Update' : 'Create' }}</button>
</div>
</div>

</form>
