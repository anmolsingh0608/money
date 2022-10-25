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
                        <a href="{{ route('admin.organizations.create') }}">
                            <button type="button" class="btn btn-secondary mt-3" style="float: right;">Add new</button>
                        </a>
                        {!! $dataTable->table([], true) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/buttons.server-side.js') }}"></script>
@push('scripts')
{!! $dataTable->scripts() !!}
@endpush
@endsection