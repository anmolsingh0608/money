{{-- @if (!empty($organizations->id))
<form method="POST" action="{{ route('admin.organizations.update', $org->id) }}" class="" enctype="multipart/form-data">
    @method('PUT')
    @else --}}
<form class="p-3" method="POST" action="{{ route('admin.organizations.store') }}" class=""
    enctype="multipart/form-data">
    {{-- @endif --}}
    @csrf
    <h3>Add Organization</h3><br>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <strong>{{ $message }}</strong>
        </div>
    @endif

    {{-- @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}


    <div class="row">
        <div class="col">
            <label><b>Organization Info <span>*</span></b></label><br>
            <div class="input-wrap" {{ $errors->has('organization_name') ? ' has-error' : '' }}>
                <input type="text" value="{{ old('organization_name') }}" required name="organization_name"
                    class="form-control" placeholder="Organization name" aria-label="First name">
                <small class="text-danger">{{ $errors->first('organization_name') }}</small><br>
            </div>
            <div class="input-wrap" {{ $errors->has('address') ? ' has-error' : '' }}>
                <input type="text" value="{{ old('address') }}" required name="address" class="form-control"
                    placeholder=" Address" aria-label="Last name">
                <small class="text-danger">{{ $errors->first('address') }}</small><br>
            </div>
            <div class="input-wrap" {{ $errors->has('city') ? ' has-error' : '' }}>
                <input type="text" value="{{ old('city') }}" required name="city" class="form-control" placeholder="City"
                    aria-label="Last name">
                <small class="text-danger">{{ $errors->first('city') }}</small><br>
            </div>
            <div class="input-wrap" {{ $errors->has('state') ? ' has-error' : '' }}>
                <input type="text" value="{{ old('state') }}" required name="state" class="form-control" placeholder="State"
                    aria-label="Last name">
                <small class="text-danger">{{ $errors->first('state') }}</small><br>
            </div>
            <div class="input-wrap" {{ $errors->has('zip_code') ? ' has-error' : '' }}>
                <input type="text" value="{{ old('zip_code') }}" required name="zip_code" class="form-control"
                    placeholder="Zip code" aria-label="Last name">
                <small class="text-danger">{{ $errors->first('zip_code') }}</small><br>
            </div>
        </div>
        <div class="col">
            <div class="input-wrap" {{ $errors->has('code') ? ' has-error' : '' }}>
                <label><b>Code <span>*</span></b></label><br>
                <input type="text" value="{{ old('code') }}" required name="code" id="code" class="form-control"
                    placeholder="Code" aria-label="Last name">
                <small id="show" class="text-danger">{{ $errors->first('code') }}</small><br>
            </div>
        </div>
        <div class="col">
            <label><b>Contact <span>*</span> </b></label><br>
            <div class="input-wrap" {{ $errors->has('name') ? ' has-error' : '' }}>

                <input type="text" value="{{ old('name') }}" required name="name" class="form-control" placeholder="Name"
                    aria-label="Last name">
                <small class="text-danger">{{ $errors->first('name') }}</small><br>
            </div>
            <div class="input-wrap" {{ $errors->has('contact') ? ' has-error' : '' }}>
                <input type="text" value="{{ old('contact') }}" required name="contact" class="form-control"
                    placeholder="Contact" aria-label="Last name">
                <small class="text-danger">{{ $errors->first('contact') }}</small><br>
            </div>
            <div class="input-wrap" {{ $errors->has('gmail') ? ' has-error' : '' }}>
                <input type="email" value="{{ old('gmail') }}" required name="gmail" class="form-control"
                    placeholder="Email " aria-label="Last name">
                <small class="text-danger">{{ $errors->first('gmail') }}</small><br>
            </div>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-secondary mt-3">Create</button>
            <button type="submit" class="btn btn-light mt-3">Cancel</button>

        </div>
    </div>

</form>
<script>
    $(document).keyup(function(event) {
        onkeyup: true,
        $('.user-copy form').on('submit', function() {
            var user = $('#code').val();
            if (user.length != 5) {
                $('#show').html("The Code should be 5 digits ")
                $('#show').css("color", "red")
                return false;
            }

        });
    });
</script>
