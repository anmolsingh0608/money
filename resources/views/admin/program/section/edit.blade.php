@extends('layouts.app')
@section('content')
    <main class="main">
        <div class="container-xxl">
            <div class="row">
                <div class="col-md-12 pe-md-5">
                    <div class="user-copy">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="col-12 mt-4">
                            <div>
                                <h4>Edit Section</h4>
                                <h6>* Required Fields</h6>
                            </div>
                            <form method="POST" action="{{ route('admin.sections.update', $section->id) }}"
                                class="" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <input type="hidden"
                                    value=@if (empty($survey)) "0" @else "{{ count($survey['data']) }}" @endif
                                    id="questions-index" />
                                <input type="hidden" value=@if (empty($video)) "0" @else "{{ count($video) }}" @endif id="links-index" />
                                <input type="hidden" value="0" id="options-index" />
                                <input type="hidden" value="{{ url()->previous() }}" name="pre_path" />
                                <label>Name <span>*</span></label>
                                <input type="text" class="form-control mb-3" name="name"
                                    value="{{ old('name', $section->name) }}" required>

                                <label>Description </label>
                                <textarea class="ckeditor form-control"
                                    name="description">{{ old('url', $section->description) }} </textarea>

                                <div class="form-group">
                                    <label for="">Section Type</label>
                                    <select name="type" id="change-type" class="form-select">
                                        <option value="video" @if ($section->type == 'video') selected @endif>Video
                                        </option>
                                        <option value="survey" @if ($section->type == 'survey') selected @endif>Survey
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Is Bonus Section?</label>
                                    <select name="is_bonus" id="" class="form-select">
                                        <option value="no" @if($section->is_bonus == 'no') selected @endif>No</option>
                                        <option value="yes" @if($section->is_bonus == 'yes') selected @endif>Yes</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Image</label>
                                    <input type="file" class="form form-control" name="section_image" />
                                </div>
                                @if ($section->getFirstMediaUrl('section'))
                                    <div class="form-group mt-2">
                                        <img src="{{ $section->getFirstMediaUrl('section') }}"
                                            alt="{{ url('/images/no-image-icon.png') }}" width="250" height="200">
                                    </div>
                                @endif
                                <div class="form-group vid" @if ($section->type != 'video') style="display:none;" @endif>
                                    <div class="form-group">
                                        <label for="onCsurvey">On Completion Survey</label>
                                        <select name="onCsurvey" id="" class="form form-select">
                                            <option value="">None</option>
                                            @foreach($psurvey as $k => $v)
                                            <option value="{{ $v->id }}" @if($section->psurvey->isNotEmpty()) @if($section->psurvey->first()->pivot->on_completion == 'yes') @if($section->psurvey[0]->id == $v->id) selected @endif @endif @endif>{{ $v->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="button" class="btn btn-secondary mt-3" id="add-video">Add
                                        Video Link</button><br>
                                    <!-- <label>Video URL(s) <span></span></label> -->
                                    <!-- <input type="url" class="form form-control mb-3" name="url"
                                        value="{{ old('url', $section->url) }}"
                                        @if ($section->type == 'video') required @endif> -->
                                    <div class="form-group list-links">
                                        @if (!empty($video))
                                            @foreach ($video as $key => $vid)
                                                @include('admin.program.section.video', ['index' => $key,
                                                'video'=>$vid, 'psurvey' => $psurvey])
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group survey-div" @if ($section->type != 'survey') style="display:none;" @endif>
                                    <label for="psurvey">Survey *</label>
                                    <select name="psurvey" id="" class="form form-select" @if($section->type == 'survey') required @endif>
                                        <option value="">None</option>
                                        @foreach($psurvey as $k => $v)
                                        <option value="{{ $v->id }}" @if($section->psurvey->isNotEmpty()) @if($section->psurvey->first()->pivot->on_completion == 'no') @if($section->psurvey[0]->id == $v->id) selected @endif @endif @endif>{{ $v->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-secondary mt-3">Update</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
