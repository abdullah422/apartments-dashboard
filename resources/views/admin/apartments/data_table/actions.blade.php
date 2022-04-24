@if (auth()->user()->hasPermission('read_apartments'))
    <a href="{{ route('admin.apartments.show', $id) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> @lang('site.show')</a>
@endif

@if (auth()->user()->hasPermission('update_apartments'))
    <a href="{{ route('admin.apartments.edit', $id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
@endif

@if (auth()->user()->hasPermission('delete_apartments'))
    <form action="{{ route('admin.apartments.destroy', $id) }}" class="my-1 my-xl-0" method="post" style="display: inline-block;">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i> @lang('site.delete')</button>
    </form>
@endif



