<a href="{{ route('admin.categories.edit', $item->id) }}" class="btn btn-primary">
    <i class="fa fa-edit"></i>
    {{ __('Edit') }}
</a>

<form action="{{ route('admin.categories.destroy', $item->id) }}" method="POST" class="mt-1">
    @method('DELETE')
    @csrf
    <button class="btn btn-danger nowrap">
        <i class="fa fa-trash"></i>
        {{ __('Delete') }}
    </button>
</form>
