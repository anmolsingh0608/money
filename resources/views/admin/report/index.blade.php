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
                            <div class="row">
                                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                                    <div class="card">
                                        <div class="card-header p-3 pt-2">
                                            <div
                                                class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                                                <i class="fas fa-graduation-cap">Organization</i>
                                            </div>
                                            <div class="text-end pt-1">
                                                <p class="text-sm mb-0 text-capitalize">Students</p>
                                                <h4 class="mb-0">{{$org_user}}</h4>
                                            </div>
                                        </div>
                                        <hr class="dark horizontal my-0">
                                        <div class="card-footer p-3">
                                            <p class="mb-0"><span
                                                    class="text-success text-sm font-weight-bolder">High school</span>&nbsp;
                                                &nbsp;&nbsp; {{$high_org}}
                                            </p>
                                            <p class="mb-0"><span
                                                    class="text-success text-sm font-weight-bolder">Junior
                                                    school</span>&nbsp; {{$junior_org}}
                                            </p>
                                            <p class="mb-0"><span
                                                class="text-success text-sm font-weight-bolder">High
                                                school spanish</span>&nbsp; {{$high_spanish_org}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                                    <div class="card">
                                        <div class="card-header p-3 pt-2">
                                            <div
                                                class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                                <i class="material-icons opacity-10">No Organization</i>
                                            </div>
                                            <div class="text-end pt-1">
                                                <p class="text-sm mb-0 text-capitalize">Students</p>
                                                <h4 class="mb-0">{{$no_org_user}}</h4>
                                            </div>
                                        </div>
                                        <hr class="dark horizontal my-0">
                                        <div class="card-footer p-3">
                                            <p class="mb-0"><span
                                                    class="text-success text-sm font-weight-bolder">High school</span>&nbsp;
                                                &nbsp;&nbsp; {{$high_no_org}}
                                            </p>
                                            <p class="mb-0"><span
                                                    class="text-success text-sm font-weight-bolder">Junior
                                                    school</span>&nbsp; {{$junior_no_org}}
                                            </p>
                                            <p class="mb-0"><span
                                                class="text-success text-sm font-weight-bolder">High
                                                school spanish</span>&nbsp; {{$high_spanish_no_org}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                                    <div class="card">
                                        <div class="card-header p-3 pt-2">
                                            <div
                                                class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                                                <i class="material-icons opacity-10">Certified Students</i>
                                            </div>
                                            <div class="text-end pt-1">
                                                <p class="text-sm mb-0 text-capitalize">Students</p>
                                                <h4 class="mb-0">{{$certified_user}}</h4>
                                            </div>
                                        </div>
                                        <hr class="dark horizontal my-0">
                                        <div class="card-footer p-3">
                                            <p class="mb-0"><span
                                                    class="text-success text-sm font-weight-bolder">High school</span>&nbsp;
                                                &nbsp;&nbsp;&nbsp;{{$certified_user_high}}
                                            </p>
                                            <p class="mb-0"><span
                                                    class="text-success text-sm font-weight-bolder">Junior
                                                    school</span>&nbsp;{{$certified_user_junior}}
                                            </p>
                                            <p class="mb-0"><span
                                                class="text-success text-sm font-weight-bolder">High
                                                school spanish</span>&nbsp; {{$certified_user_high_spanish}}
                                            </p>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-xl-3 col-sm-6">
                                    <div class="card">
                                        <div class="card-header p-3 pt-2">
                                            <div
                                                class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                                                <i class="material-icons opacity-10">All Students</i>
                                            </div>
                                            <div class="text-end pt-1">
                                                <p class="text-sm mb-0 text-capitalize">Students</p>
                                                <h4 class="mb-0">{{$all_user}}</h4>
                                            </div>
                                        </div>
                                        <hr class="dark horizontal my-0">
                                        <div class="card-footer p-3">
                                            <p class="mb-0"><span
                                                    class="text-success text-sm font-weight-bolder">High school</span>&nbsp;
                                                &nbsp;&nbsp; {{$high_user}}
                                            </p>
                                            <p class="mb-0"><span
                                                    class="text-success text-sm font-weight-bolder">Junior
                                                    school</span>&nbsp; {{$junior_user}}
                                            </p>
                                            <p class="mb-0"><span
                                                class="text-success text-sm font-weight-bolder">High
                                                school spanish</span>&nbsp; {{$high_spanish_user}}
                                        </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- {!! $dataTable->table([], true) !!} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/buttons.server-side.js') }}"></script>
    @push('scripts')
        {{-- {!! $dataTable->scripts() !!} --}}
    @endpush
@endsection
