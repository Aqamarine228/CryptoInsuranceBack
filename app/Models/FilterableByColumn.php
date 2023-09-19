<?php

namespace App\Models;

use RuntimeException;

trait FilterableByColumn
{
    public function scopeFilterByColumns($q, array $filterableColumns) {
        foreach ($filterableColumns as $column) {
            $q = $q->orderBy($column['name'], $column['order']);
        }

        return $q;
    }

}
