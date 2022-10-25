@extends('layouts.app')
@section('content')
<main class="main">
    <div class="container-xxl">
        <div class="row">
            <div class="col-md-9 pe-md-5">
                <div class="user-copy">
                    <div class="col-12 mt-4">
                        <a href="{{ route('admin.programs.index') }}" class="text-decoration-none">
                            <button type="button" class="cta">Programs<span class="icon d-flex align-items-center justify-content-center"><img src="{{ url('images/arrow-right-cta.svg') }}" alt="" height="18" width="22"></span></button>
                        </a>
                        
                    </div>
                    <div class="col-12 mt-4">
                        <a href="{{ route('admin.organizations.index') }}" class="text-decoration-none">
                            <button type="button" class="cta">Organization<span class="icon d-flex align-items-center justify-content-center"><img src="{{ url('images/arrow-right-cta.svg') }}" alt="" height="18" width="22"></span></button>
                        </a>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection