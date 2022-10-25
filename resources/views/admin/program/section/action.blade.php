<div class="actions d-flex">
    <!-- <a href="{{ url('admin/programs/sections/'.$id) }}">View</a>&nbsp;  -->
    <a href="{{ route('admin.sections.edit', $id) }}">Edit</a>
    {{-- <form action="{{ route('admin.sections.destroy', $id) }}" method="POST"  >
        @csrf
        @method('DELETE')
        <button  onclick="return confirm('Do you want to delete this Section?')">
            Delete
        </button>
    </form> --}}
</div>