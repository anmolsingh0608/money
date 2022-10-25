<div class="actions d-flex">
    <a href="{{ url('admin/organizations/show',$id) }}" class="text-decoration-none">View</a>&nbsp; 
    <a href="{{ route('admin.organizations.edit', $id) }}" class="text-decoration-none">Edit</a>
    {{-- <form action="{{ route('admin.organizations.destroy', $id) }}" method="POST"  >
        @csrf
        @method('DELETE')
        <button  onclick="return confirm('Do you want to delete this Organization?')">
            Delete
        </button>
    </form> --}}
</div>