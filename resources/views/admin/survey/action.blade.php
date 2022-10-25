<div class="actions d-flex">

    <a href="{{ route('admin.survey.show', $id) }}" class="text-decoration-none">View</a>
    {{-- <form action="{{ route('admin.survey.destroy', $id) }}" method="POST"  >
        @csrf
        @method('DELETE')
        <button  onclick="return confirm('Do you want to delete this Survey?')">
            Delete
        </button>
    </form> --}}
</div>
