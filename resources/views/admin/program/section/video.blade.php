<div class="main-row">
    <div class="row">
        <div class="mt-3">
            <h5><span class="">Video</span></h5>
        </div>
        <div class="col-12 col-sm-12">
            <div class="form-group">
                <label for="">Name</label>
                <input type="text" class="form form-control" name="url[{{ $index }}][name]"
                    value="{{ old('name', $video['name']) }}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="form-group">
                <label for="">Description</label>
                <textarea name="url[{{ $index }}][description]"
                    class="form form-control">{{ old('description', $video['description']) }}</textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="form-group">
                <label for="">Image</label>
                <input type="file" class="form form-control"  name="url[{{ $index }}][image]"
                />
                @if (isset($video['image']))
                <input type="hidden" value="{{ $video['image'] }}" name="url[{{ $index }}][img]" />
                @endif


            </div>
        </div>
        {{-- @dd($video['image']) --}}
        @if (isset($video['image']))
            <div class="form-group mt-2">
                <img src="{{ '/images/uploads/' . $video['image'] }}" alt="{{ url('/images/no-image-icon.png') }}"
                    width="250" height="200">
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-12 col-sm-10">
            <div class="form-group">
                <label for="">Video Link *</label>
                <input type="url" class="form form-control link" name="url[{{ $index }}][url]"
                    value="{{ old('url', $video['url']) }}" required>
            </div>
        </div>
        <div class="col-12 col-sm-2">
            <div class="form-group">
                <button type="button" class="btn btn-secondary mt-4 remove-link">Remove</button>
            </div>
        </div>
    </div>
</div>
