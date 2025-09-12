<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    //
    protected $table = 'categories';
    public function items()
    {
        return $this->hasMany(ItemsModel::class, 'category_id'); // Asegúrate de que 'category_id' sea el campo correcto
    }
    public function subcategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id'); // Asegúrate de que 'category_id' sea el campo correcto
    }
}
