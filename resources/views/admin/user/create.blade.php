@extends('layouts.app')
@section('content')
    <main class="main">
        <div class="container-xxl">
            <div class="row">
                <div class="col-md-12 pe-md-5">
                    <div class="user-copy">
                        <div class="col-12 mt-4">
                            <form method="POST" action="{{ route('admin.users.store') }}" class=""
                                enctype="multipart/form-data">
                                @csrf
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
                                <div class="form-group">
                                    <label for="">First Name <span>*</span></label>
                                    <input type="text" name="first_name" id="" class="form form-control" />
                                    <small class="text-danger">{{ $errors->first('first_name') }}</small>
                                </div>
                                <div class="form-group">
                                    <label for="">Last Name <span>*</span></label>
                                    <input type="text" name="lname" id="" class="form form-control" />
                                    <small class="text-danger">{{ $errors->first('lname') }}</small>


                                </div>
                                <div class="form-group">
                                    <label for="">Email <span>*</span></label>
                                    <input type="email" name="email" id="" class="form form-control" />
                                    <small class="text-danger">{{ $errors->first('email') }}</small>

                                </div>
                                <div class="form-group">
                                    <label for="">Password <span>*</span></label>
                                    <input type="password" name="password" id="" class="form form-control" />
                                    <small class="text-danger">{{ $errors->first('password') }}</small>

                                </div>
                                <div class="form-group">
                                    <label for="">Zip Code <span>*</span></label>
                                    <input type="number" name="zcode" id="" class="form form-control" />
                                    <small class="text-danger">{{ $errors->first('zcode') }}</small>

                                </div>
                                <div class="form-group">
                                    <label for="">Organization Code </label>
                                    <input type="text" name="ocode" id="" class="form form-control" />
                                    <small class="text-danger">{{ $errors->first('ocode') }}</small>

                                </div>
                                <div class="form-group">
                                    <label for="">Age <span>*</span></label>
                                    <select id="age" name="age" class="form-select">
                                        <option value="">---</option>
                                        @for ($i = 5; $i < 22; $i++)
                                            <option value=" {{ $i }}"
                                                {{ old("$i") == "$i" ? 'selected' : '' }}> {{ $i }}</option>
                                        @endfor
                                    </select>
                                    <small class="text-danger">{{ $errors->first('age') }}</small>

                                </div>
                                <div class="form-group">
                                    <label for="">Program <span>*</span></label>
                                    <select id="age" name="program" class="form-select">
                                        <option value="">---</option>
                                        <option value="1" {{ old('program') == 'Junior program' ? 'selected' : '' }}>
                                            Junior Program </option>
                                        <option value="2" {{ old('program') == 'Highschool program' ? 'selected' : '' }}>
                                            High School Program </option>
                                        <option value="3"
                                            {{ old('program') == 'High School (Spanish)' ? 'selected' : '' }}>
                                            High School (Spanish) </option>

                                    </select>
                                    <small class="text-danger">{{ $errors->first('program') }}</small>

                                </div>
                                <div class="form-group">
                                    <label for="">Grade <span>*</span></label>
                                    <select id="grade" name="grade" class="form-select">
                                        <option value="">---</option>
                                        @for ($i = 1; $i < 13; $i++)
                                            <option value=" {{ $i }}"
                                                {{ old(' $i') == " $i" ? 'selected' : '' }}> {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                    <small class="text-danger">{{ $errors->first('grade') }}</small>

                                </div>
                                <div class="form-group">
                                    <label for="">Role<span>*</span></label>
                                    <select name="role_type" id="" class="form form-select exam-answer-type">
                                        <option value="student"> Student</option>
                                        <option value="admin">Admin</option>

                                    </select>
                                    <small class="text-danger">{{ $errors->first('role_type') }}</small>

                                </div>

                                <div class="form-group">
                                    <button id="submitBtn" type="submit" class="btn btn-secondary mt-3">Create</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
