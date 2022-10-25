<div class="actions d-flex">
    <a href="{{ route('admin.assessments.edit', $id) }}" class="text-decoration-none">Edit</a>
    {{-- <form action="{{ route('admin.assessments.destroy', $id) }}" method="POST"  >
        @csrf
        @method('DELETE')
        <button  onclick="return confirm('Do you want to delete this Assessment?')">
            Delete
        </button>
    </form> --}}
</div>