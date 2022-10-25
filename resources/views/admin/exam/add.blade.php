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
                                    <h4>Add Exam</h4>
                                </div>
                                @include('admin/exam/form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>

    @include('components/toast')
@endsection
