<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    //
    protected $table = 'sub_categories';
    protected $fillable = [
        'name',
        'category_id',
        'description',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'company_id',
        'created_by'
    ];
    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id');
    }
    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
