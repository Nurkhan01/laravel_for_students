<?php
namespace App\Services\Category;

use App\Models\Category;

class CategoryService {
    public function store($data)
    {
        if (Category::create($data)) {
                return 'good';
            } else {
                return 'bad';
        }
    }

    public function update($category, $data)
    {
        if ($category->update($data)) {
            return 'good';
        } else {
            return 'bad';
        }
    }
}
