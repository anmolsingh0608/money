@extends('layouts.app')
@section('content')
<main class="main">
    <div class="container-xxl">
        <div class="row">
            <div class="col-md-12 pe-md-5">
                <div class="user-copy">
                    <div class="col-12 mt-4">
                        <div>
                            <h3>{{$org->organization_name}}</h3> <br>
                        </div>
                        

                    </div>
                    <div class="row">
                        <div class="col">
                          <label><b>Organization Info </b></label><br><br>
                          <td> {{$org->organization_name}}</td><br>
                          <td> {{$org->address}}</td><br>
                          <td> {{$org->city}},{{$org->state}},{{$org->zip_code}}</td>


                          
                        </div>
                        <div class="col">
                          <label><b>Code </b></label><br><br>
                          <td> {{$org->code}}</td>

                        </div>
                        <div class="col">
                            <label><b>Contact </b></label><br><br>
                            {{$org->name}}<br>
                            {{$org->contact}}<br>
                            {{$org->gmail}}<br>

                        </div>
                    </div>   
                    {{-- <form method="POST" action="{{ route('admin.organizations.destroy',$org->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-dark mt-3">Delete</button>
                    </form> --}}
                </div>
            </div>
        </div>
    </div>
</main>
@endsection