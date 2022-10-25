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
                                <h4>Edit Program</h4>
                            </div>
                            <form method="POST" action="{{ route('admin.programs.update', $program->id) }}"
                                class="" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="form-group">
                                    <label>Title <span>*</span></label>
                                    <input type="text" class="form-control" name="title"
                                        value="{{ old('title', $program->title) }}" required>
                                </div>

                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="ckeditor form-control" value=""
                                        name="description">{{ old('description', $program->description) }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="">Status</label>
                                    <select name="status" id="" class="form-select">
                                        <option value="active" @if ($program->status == 'active') selected @endif>Active
                                        </option>
                                        <option value="inactive" @if ($program->status == 'inactive') selected @endif>Inactive
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Program Type</label>
                                    <select name="program_type" id="" class="form-select">
                                        {{-- <option value="">None</option> --}}
                                        @foreach ($programTypes as $k => $p)
                                            <option value="{{ $k }} " disabled
                                                @if ($program->program_type == $k) selected="selected" @endif>
                                                {{ $p }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="">Image</label>
                                    <input type="file" class="form form-control" name="prog_image" />
                                </div>
                                @if ($program->getFirstMediaUrl('program'))
                                    <div class="form-group mt-2">
                                        <img src="{{ $program->getFirstMediaUrl('program') }}"
                                            alt="{{ url('/images/no-image-icon.png') }}" width="250" height="200">
                                    </div>
                                @endif
                                <div class="sections-container-list">
                                <div class="mt-3">
                                    <h5>Section(s)</h5>
                                </div>
                                @php($i = 1)
                                @foreach ($sections as $key => $section)
                                    <div class="row">
                                        <div class="col-12 col-sm-5">
                                            <div class="form-group">
                                                <label for="Name" style="margin-left: 8.3%;">Name&nbsp;</label>
                                                <div class="drag-group d-flex">
                                                    <img src="{{ asset('/images/drag-14-32.png') }}" alt="" style="cursor: pointer; margin-right:10px; ">
                                                    <input type="text" name="" class="form form-control" required
                                                        value="{{ $section->name }}" disabled />
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" value="{{ $section->id }}" class="section-id" />
                                        <input type="hidden" class="delete-id" />
                                        <div class="col-12 col-sm-5">
                                            <div class="form-group">
                                                <label for="Type">Type&nbsp;</label>
                                                <input type="text" class="form form-control" disabled
                                                    value="{{ $section->type }}" name="" />
                                            </div>
                                        </div>
                                        <div class="col-5 col-sm-2">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <div>
                                                    <a href="{{ route('admin.sections.edit', $section->id) }}"
                                                        class="text-decoration-none"><button type="button"
                                                            class="btn btn-secondary delete-video">Edit</button></a>&nbsp;
                                                    &nbsp;
                                                    <button type="button"
                                                        class="btn btn-secondary delete-section">Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" value="{{ $section->id }}" name="sections[{{ $key }}][id]">
                                        <input type="hidden" value="{{ $key+1 }}" name="sections[{{ $key }}][sequence]" class="section-sequence">
                                    </div>
                                    @php($i++)
                                @endforeach
                                </div>
                                @include('admin/program/popup')
                                <button type="button" id="add-section" class="btn btn-secondary mt-3">Add Section</button>
                                <div class="list-sections">
                                    <input type="hidden" value="{{ count($program->sections) }}" id="section-index">
                                </div>
                                <button type="submit" class="btn btn-secondary mt-4">Update</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
