@foreach($listField as $item)
    <tr>
        <td>{{ $item->id }}</td>
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
        <td>
            {{ $item->title }}
        </td>
        <td>
            {{ $item->type }}
        </td>
        <td>
            @include('admin.field.include.action_td')
        </td>
    </tr>
@endforeach
