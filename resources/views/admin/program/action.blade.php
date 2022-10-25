<div class="actions d-flex">
    <a href="{{ route('admin.program.section.index', $id) }}" class="text-decoration-none">View</a>&nbsp; 
    <a href="{{ route('admin.programs.edit', $id) }}" class="text-decoration-none">Edit</a>
    {{-- <form action="{{ route('admin.programs.destroy', $id) }}" method="POST"  >
        @csrf
        @method('DELETE')
        <button  onclick="return confirm('Do you want to delete this Program?')">
            Delete
        </button>
    </form> --}}
</div>