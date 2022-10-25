<div class="actions d-flex">
    <a href="{{ route('admin.psurvey.edit', $id) }}" class="btn btn-secondary">Edit</a>
&nbsp;
    <form action="{{ route('admin.psurvey.destroy', $id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button class="btn btn-secondary" onclick="return confirm('Do you want to delete this Question?')">
            Delete
        </button>
    </form>

</div>
