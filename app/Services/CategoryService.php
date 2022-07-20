<?php


namespace App\Services;


use App\Database\Category;

class CategoryService
{
    static function show($id)
    {
        $category = new Category();
        return $category->getCategoryById($id);

    }

}