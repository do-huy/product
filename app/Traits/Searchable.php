<?php

namespace App\Traits;

trait Searchable {

    public function scopeSearchable($query, ...$columns)
    {
        if ($keyword = request('keyword', '')) {
            foreach ($columns as $column) {
                if (in_array($column, $this->getFillable())) {
                    $query->orWhere($column, 'like', "%$keyword%");
                }
            }
        }
    }

}
