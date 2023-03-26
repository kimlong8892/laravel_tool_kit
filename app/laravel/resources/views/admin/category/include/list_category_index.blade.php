@foreach($listCategory as $item)
    <tr>
        <td class="text-center">{{ $item->id }}</td>
        <td>
            {{ $item->name }}
            @if(!empty($item->ChildCategories) && count($item->ChildCategories) > 0)
                <table class="table table-bordered table-responsive mt-3">
                    <tr>
                        @include('admin.category.include.tr_header')
                    </tr>
                    @include('admin.category.include.list_category_index', ['listCategory' => $item->ChildCategories])
                </table>
            @endif
        </td>
        <td>
            <img src="{{ $item->getImage() }}" width="100%">
        </td>
        <td>
            @include('admin.category.include.action_td')
        </td>
    </tr>
@endforeach
