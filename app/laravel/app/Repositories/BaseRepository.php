<?php

namespace App\Repositories;

abstract class BaseRepository {
    protected function mapDataRequest($item, $data) {
        foreach ($data as $key => $value) {
            if (!in_array($key, $item->getFillable())) {
                unset($data[$key]);
            }
        }

        return $data;
    }
}
