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
                    <div class="col-12 mt-4">

                        <label for="">Type of Assessment:</label>
                        <div class="form-group">
                            <a href="{{ route('admin.assessments.create.type', 'program') }}" class="text-decoration-none">
                                <button type="button" class="btn btn-secondary">Program</button>
                            </a>
                        
                            <a href="{{ route('admin.assessments.create.type', 'section') }}" class="text-decoration-none">
                                <button type="button" class="btn btn-secondary">Section</button>
                            </a>
                        
                            <a href="{{ route('admin.assessments.create.type', 'program_type') }}" class="text-decoration-none">
                                <button type="button" class="btn btn-secondary">Programs(Entire)</button>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection