@extends('layouts.app')
@section('content')
<main class="main">
    <div class="container-xxl">
        <div class="row">
            <div class="col-md-12 pe-md-5">
                <div class="user-copy">
                    <div class="user-copy">
                        <div class="col-12 mt-4">
                            <div>
                                <h4>Edit Assessment</h4>
                                <h6>* Required Fields</h6>
                            </div>
                            <form method="POST" action="{{ route('admin.assessments.update', $assessment->id) }}" class="" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                                <div class="form-group">
                                    <label for="">Name <span>*</span></label>
                                    <input type="text" value="{{ old('name',$assessment->name) }}" name="name" id="" class="form form-control" required  />

                                </div>
                                @if($assessment->obj_type == 'program_type')
                                <div class="form-group">
                                    <label for="program_type">Program Type *</label>
                                    <select name="obj_id" id="" class="form form-select" required>
                                        @foreach($program_types as $k=>$p)
                                        <option value="{{ $k }}" @if($assessment->obj_id == $k) selected="selected" @endif>{{ $p }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                @if($assessment->obj_type == 'program')
                                <div class="form-group">
                                    <label for="program">Program *</label>
                                    <select name="obj_id" id="" class="form form-select" required>
                                        <option value="">None</option>
                                        @foreach($programs as $k => $v)
                                        <option value="{{$k}}" @if($assessment->obj_id == $k) selected="selected" @endif>{{$v}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                @if($assessment->obj_type == 'section')
                                <div class="form-group">
                                    <label for="program">Program *</label>
                                    <select name="obj_id" id="" class="form form-select" required>
                                        <option value="">None</option>
                                        @foreach($programs as $k => $v)
                                        <option value="{{$k}}" @if($programId == $k) selected="selected" @endif>{{$v}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="section">Section *</label>
                                    <select name="section" id="" class="form form-select" required>
                                        <option value="">None</option>
                                        @if(!empty($sections))
                                        @foreach($sections as $k => $v)
                                        <option value="{{ $k }}" @if($sectionId == $k) selected="selected" @endif>{{ $v }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                @endif

                                <div class="form-group">
                                    <label for="exam">Exam *</label>
                                    <select name="exam" id="" class="form form-select" required>
                                        <option value="">None</option>
                                        @foreach($exams as $k => $v)
                                        <option value="{{$k}}"  @if($assessment->exam_id == $k) selected="selected" @endif>{{$v}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="max_attempts">Maximum attempts</label>
                                    <input type="number" name="max_attempts" min="1" id="" class="form form-control" value="{{ old('max_attempts', $assessment->max_attempts) }}" />
                                </div>
                                <!-- <div class="form-group">
                                    <label for="released">Release date</label>
                                    <input type="date" name="released" class="form form-control" value="{{ old('released', $assessment->released) }}" />
                                </div> -->
                                <div class="form-group">
                                    <label for="status">Status *</label>
                                    <select name="status" id="" class="form form-select" required>
                                        <option value="active" @if($assessment->status == 'active') selected="selected" @endif>Active</option>
                                        <option value="inactive" @if($assessment->status == 'inactive') selected="selected" @endif>Inactive</option>
                                    </select>
                                </div>
                                <input type="hidden" name="obj_type" value="{{ $assessment->obj_type }}">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-secondary mt-3">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</main>

@endsection
