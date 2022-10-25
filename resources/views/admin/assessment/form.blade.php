<form method="POST" action="{{ route('admin.assessments.store') }}" class="" enctype="multipart/form-data">
    @csrf
    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach 
    <div class="form-group">
        <label for="">Name <span>*</span></label>
        <input type="text" name="name" id="" class="form form-control"   />
        
    </div>
    @if($obj_type == 'program_type')
    <div class="form-group">
        <label for="program_type">Program Type *</label>
        <select name="obj_id" id="" class="form form-select" required>
            @foreach($program_types as $k=>$p)
            <option value="{{ $k }}">{{ $p }}</option>
            @endforeach
        </select>
    </div>
    @else
    <div class="form-group">
        <label for="program">Program *</label>
        <select name="obj_id" id="" class="form form-select" required>
            <option value="">None</option>
            @foreach($programs as $k => $v)
            <option value="{{$k}}">{{$v}}</option>
            @endforeach
        </select>
    </div>
    @if($obj_type == 'section')
        <div class="form-group">
            <label for="section">Section *</label>
            <select name="section" id="" class="form form-select" required>
                <option value="" disabled>Please select a program</option>
                
            </select>
        </div>
    @endif
    @endif
    <div class="form-group">
        <label for="exam">Exam *</label>
        <select name="exam" id="" class="form form-select" required>
            <option value="">None</option>  
            @foreach($exams as $k => $v)
            <option value="{{$k}}">{{$v}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="max_attempts">Maximum attempts</label>
        <input type="number" name="max_attempts" min="1" id="" class="form form-control" value="{{ old('max_attrmpts') }}" />
    </div>
    <!-- <div class="form-group">
        <label for="released">Release date</label>
        <input type="date" name="released" class="form form-control" value="{{ old('released') }}" />
    </div> -->
    <div class="form-group">
        <label for="status">Status *</label>
        <select name="status" id="" class="form form-select" required>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
    </div>
    <input type="hidden" name="obj_type" value="{{ $obj_type }}">
    <div class="form-group">
        <button type="submit" class="btn btn-secondary mt-3">Create</button>
    </div>
</form>