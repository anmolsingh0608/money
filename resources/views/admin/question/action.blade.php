<div class="actions d-flex">
    <!-- <a href="{{ route('admin.questions.show', $id) }}" class="text-decoration-none">View</a>&nbsp;  -->
    <a href="{{ route('admin.questions.edit', $id) }}" class="btn btn-secondary">Edit</a>
&nbsp;
    <form action="{{ route('admin.questions.destroy', $id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button class="btn btn-secondary" onclick="return confirm('Do you want to delete this Question?')">
            Delete
        </button>
    </form>

</div>
