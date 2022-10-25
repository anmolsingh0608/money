@extends('layouts.app')
@section('content')
    <main class="main">
        <div class="container-xl">
            <div>
                <h4>{{ $user->first_name }} {{ $user->last_name }}</h4>
            </div>
            <div class="row">
                <div class="col-md-12 pe-md-5">
                    <div class="user-copy">
                        <div class="col-12 mt-4">
                            <div class="row">
                                <div class="col">
                                    <label for="Contact Info">
                                        <h6>Contact Info</h6>
                                    </label>
                                    <div class="mt-3">{{ $user->first_name }} {{ $user->last_name }}</div>
                                    <div>{{ $user->email }}</div>
                                </div>
                                <div class="col">
                                    <label for="Organization">
                                        <h6>Organization</h6>
                                    </label>
                                    <div class="mt-3">
                                        @if (isset($user->organizations->organization_name))
                                            {{ $user->organizations->organization_name }}
                                        @else
                                            None
                                        @endif


                                    </div>
                                </div>
                                <div class="col">
                                    <label for="Level Completed">
                                        <h6>Level Completed</h6>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
