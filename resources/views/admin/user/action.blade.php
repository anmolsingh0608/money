<div class="actions d-flex">
    <a href="{{ route('admin.users.show', $id) }}" class="btn btn-secondary">View</a>&nbsp; 
    <a href="{{ route('admin.users.edit', $id) }}" class="btn btn-secondary">Edit</a>&nbsp;
    {{-- <form action="{{ route('admin.users.destroy', $id) }}" method="POST"  >
        @csrf
        @method('DELETE')
        <button  class="btn btn-secondary" onclick="return confirm('Do you want to delete this Organization?')">
            Delete
        </button>
    </form> --}}
</div>