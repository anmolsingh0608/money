@if(!empty($psurvey->id))
<form action="{{ route('admin.psurvey.update', $psurvey->id) }}" method="POST" enctype="multipart/form-data">
@method('PUT')
@else
<form action="{{ route('admin.psurvey.store') }}" method="POST" class="" enctype="multipart/form-data">
@endif
@csrf
@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <strong>{{ $message }}</strong>
    </div>
@endif

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <input type="hidden"
        value=@if (empty($survey)) "0" @else "{{ count($survey['data']) }}" @endif
        id="questions-index" />
    <div class="form-group">
        <label>Title <span>*</span></label>
        <input type="text" class="form-control" name="title" value="{{ old('title', $psurvey->title) }}" required>
    </div>

    <div class="form-group">
        <label for="">Image</label>
        <input type="file" class="form form-control" name="image" />
    </div>
    @if ($psurvey->getFirstMediaUrl('psurvey'))
        <div class="form-group mt-2">
            <img src="{{ $psurvey->getFirstMediaUrl('psurvey') }}"
                alt="{{ url('/images/no-image-icon.png') }}" width="250" height="200">
        </div>
    @endif

    <div class="form-group survey-div">
        <button type="button" class="btn btn-secondary mt-3" id="add-question">Add Questions</button><br>
        <div class="form-group list-questions">
        @if (!empty($survey))
            @if ($survey['data'] && !empty($survey))
                @foreach ($survey['data'] as $key => $question)
                    @include('admin.program.section.question', ['index' => $key,
                    'question'=>$question])
                @endforeach
            @endif
        @endif
        </div>
    </div>

    <button class="btn btn-secondary mt-3" type="submit">@if(!empty($psurvey->id)) Update @else Create @endif</button>
</form>
