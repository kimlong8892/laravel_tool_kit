<?php

namespace App\Repositories\Field;

use App\Models\Field;
use App\Repositories\BaseRepository;

class FieldRepository extends BaseRepository implements FieldRepositoryInterface {
    public function getListInAdmin(): \Illuminate\Contracts\Pagination\LengthAwarePaginator {
        $perPage = config('custom.field')['per_page'] ?? 10;

        return Field::with(['ChildFields'])
            ->paginate($perPage);
    }

    public function store($data) {
        $field = new Field();
        $data = $this->mapDataRequest($field, $data);
        $field->fill($data);
        $field->save();

        return $field->getAttribute('id');
    }

    public function update($id, $data) {
        $field = Field::find($id);
        $data = $this->mapDataRequest($field, $data);
        $field->fill($data);
        $field->save();

        return $field->getAttribute('id');
    }

    protected function mapDataRequest($item, $data) {
        $data = parent::mapDataRequest($item, $data);

        if (!empty($data['values']) && is_array($data['values'])) {
            $data['values'] = implode(',', $data['values']);
        }

        return $data;
    }

    public function getDetail($id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null {
        return Field::with(['ChildFields'])->find($id);
    }
}
