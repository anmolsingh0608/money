<div class="actions d-flex">
    <!-- <a href="{{ url('admin/organizations/show',$id) }}" class="text-decoration-none">View</a>&nbsp;  -->
    <a href="{{ route('admin.exams.edit', $id) }}" class="btn btn-secondary">Edit</a>
    &nbsp;
    <form action="{{ route('admin.exams.destroy', $id) }}" method="POST"  >
        @csrf
        @method('DELETE')
        <button class="btn btn-secondary"  onclick="return confirm('Do you want to delete this Exam?')">
            Delete
        </button>
    </form>
</div>