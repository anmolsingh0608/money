@extends('layouts.app')
@section('content')
@if(isset($org->id))
    <main class="main">
        <div class="container-xxl">
            <div class="row">
                <div class="col-md-12 pe-md-5">
                    <div class="user-copy">
                        <div class="col-12 mt-4">
                            <div>
                                <h4>Edit Organization</h4>
                            </div>
                            <form method="POST" action="{{ route('admin.organizations.update', $org->id) }}"
                                class="" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                @if ($message = Session::get('success'))
                                    <div class="alert alert-success">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @endif



                                <div class="row">
                                    <div class="col">
                                        <label><b>Organization Info <span>*</span></b></label><br>
                                        <div class="input-wrap"
                                            {{ $errors->has('organization_name') ? ' has-error' : '' }}>
                                            <input type="text"
                                                value="{{ old('organization_name', $org->organization_name) }}"
                                                name="organization_name" class="form-control"
                                                placeholder="Organization name" aria-label="First name">
                                            <small
                                                class="text-danger">{{ $errors->first('organization_name') }}</small><br>
                                        </div>
                                        <div class="input-wrap" {{ $errors->has('address') ? ' has-error' : '' }}>
                                            <input type="text" value="{{ old('address', $org->address) }}" name="address"
                                                class="form-control" placeholder=" Address" aria-label="Last name">
                                            <small class="text-danger">{{ $errors->first('address') }}</small><br>
                                        </div>
                                        <div class="input-wrap" {{ $errors->has('city') ? ' has-error' : '' }}>
                                            <input type="text" value="{{ old('city', $org->city) }}" name="city"
                                                class="form-control" placeholder="City" aria-label="Last name">
                                            <small class="text-danger">{{ $errors->first('city') }}</small><br>
                                        </div>
                                        <div class="input-wrap" {{ $errors->has('state') ? ' has-error' : '' }}>
                                            <input type="text" value="{{ old('state', $org->state) }}" name="state"
                                                class="form-control" placeholder="State" aria-label="Last name">
                                            <small class="text-danger">{{ $errors->first('state') }}</small><br>
                                        </div>
                                        <div class="input-wrap" {{ $errors->has('zip_code') ? ' has-error' : '' }}>
                                            <input type="text" value="{{ old('zip_code', $org->zip_code) }}"
                                                name="zip_code" class="form-control" placeholder="Zip code"
                                                aria-label="Last name">
                                            <small class="text-danger">{{ $errors->first('zip_code') }}</small><br>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="input-wrap" {{ $errors->has('code') ? ' has-error' : '' }}>
                                            <label><b>Code <span>*</span></b></label><br>
                                            <input type="text" value="{{ old('code', $org->code) }}" id="code"
                                                class="form-control" placeholder="Code" aria-label="Last name" disabled>
                                            <small id="show"
                                                class="text-danger">{{ $errors->first('code') }}</small><br>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label><b>Contact <span>*</span></b></label><br>
                                        <div class="input-wrap" {{ $errors->has('name') ? ' has-error' : '' }}>

                                            <input type="text" value="{{ old('name', $org->name) }}" name="name"
                                                class="form-control" placeholder="Name" aria-label="Last name">
                                            <small class="text-danger">{{ $errors->first('name') }}</small><br>
                                        </div>
                                        <div class="input-wrap" {{ $errors->has('contact') ? ' has-error' : '' }}>
                                            <input type="text" value="{{ old('contact', $org->contact) }}" name="contact"
                                                class="form-control" placeholder="Contact" aria-label="Last name">
                                            <small class="text-danger">{{ $errors->first('contact') }}</small><br>
                                        </div>
                                        <div class="input-wrap" {{ $errors->has('gmail') ? ' has-error' : '' }}>
                                            <input type="email" value="{{ old('gmail', $org->gmail) }}" name="gmail"
                                                class="form-control" placeholder="Email " aria-label="Last name">
                                            <small class="text-danger">{{ $errors->first('gmail') }}</small><br>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-secondary mt-3">Save Changes</button>
                                        <a href="{{ route('admin.organizations.index') }}"
                                            class="btn btn-light mt-3">Cancel</a>

                                    </div>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

@endif    
@endsection
