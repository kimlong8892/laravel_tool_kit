@foreach($listField as $item)
    <tr>
        <td class="text-center">{{ $item->id }}</td>
        <td>
            {{ $item->name }}
            @if(!empty($item->ChildFields) && count($item->ChildFields) > 0)
                <table class="table table-bordered table-responsive mt-3">
                    <tr>
                        @include('admin.field.include.tr_header')
                    </tr>
                    @include('admin.field.include.list_field_index', ['listField' => $item->ChildFields])
                </table>
            @endif
        </td>
        <td nowrap>
            {{ $item->title }}
        </td>
        <td nowrap>
            {{ $item->type }}
        </td>
        <td>
            @include('admin.field.include.action_td')
        </td>
    </tr>
@endforeach
