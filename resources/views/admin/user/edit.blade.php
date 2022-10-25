@extends('layouts.app')
@section('content')
    <main class="main">
        <div class="container-xl">
            <div class="row">
                <div class="col-md-12 pe-md-5">
                    <div class="user-copy">
                        <div class="col-12 mt-4">
                            <div>
                                <h4>Edit User</h4>
                            </div>
                            <!-- @if (count($errors) > 0)
    <div class="alert alert-danger">
                                                                    <ul>
                                                                        @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
                                                                    </ul>
                                                                </div>
    @endif -->
                            <form action="{{ route('admin.users.update', $user->id) }}" method="POST"
                                class="" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="col">
                                        <label for="First Name">First Name <span>*</span></label>
                                        <input type="text" class="form form-control mb-2" name="first_name"
                                            value="{{ old('first_name', $user->first_name) }}" placeholder="First Name" />
                                        <small class="text-danger">{{ $errors->first('first_name') }}</small>
                                        <label for="Last Name">Last Name <span>*</span></label>
                                        <input type="text" class="form form-control mb-2" name="last_name"
                                            value="{{ old('last_name', $user->last_name) }}" placeholder="Last Name" />
                                        <small class="text-danger">{{ $errors->first('last_name') }}</small>
                                        <label for="E-mail">E-mail <span>*</span></label>
                                        <input type="email" class="form form-control" name="email"
                                            value="{{ old('email', $user->email) }}" placeholder="E-mail" id="e-mail" />
                                        <small class="text-danger">{{ $errors->first('email') }}</small><br>
                                        <a href="javascript:void(0)" class="" style="color: #000000;"
                                            id="reset-link">Send Password Reset Link</a>
                                    </div>
                                    <div class="col">
                                        <label for="Organization">Organization <span>*</span></label>
                                        <input type="text" class="form form-control"
                                            @if (isset($user->organizations->organization_name)) value=" {{ old('organization_name', $user->organizations->organization_name) }}"
                                            @else
                                            value="None" @endif
                                            placeholder="Organization" disabled />
                                        <label for="Organization">Role <span>*</span></label>
                                        <select name="role_type" id="" class="form form-select exam-answer-type">
                                            <option value="student" @if($user->role_type == "student") selected="selected" @endif> Student</option>
                                            <option value="admin" @if($user->role_type == "admin") selected="selected" @endif>Admin</option>
                                           
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="Level Completed">Level Completed</label>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-secondary">Update</button>
                                    </div>
                                </div>
                            </form>
                            <form method="POST" action="{{ route('admin.user.password_reset_link') }}"
                                id="reset-password" style="display: none;">
                                @csrf
                                <input type="hidden" value="{{ old('email', $user->email) }}" name="email" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
