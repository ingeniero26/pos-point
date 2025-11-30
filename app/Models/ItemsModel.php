<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemsModel extends Model
{
    //
    protected $table = 'items';

    protected $fillable = ['product_type', 'product_name', 'sku',
        'reference', 'category_id','sub_category_id', 'description', 'brand_id', 'measure_id', 'cost_price',
    'selling_price','tax_id', 'price_total','created_by'];

    protected $hidden = ['created_at', 'updated_at'];
     protected $casts = [
        'series_enabled' => 'boolean',
        'batch_management' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id');
    }
    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }
    public function brand()
    {
        return $this->belongsTo(BrandModel::class, 'brand_id');
    }
    public function measure()
    {
        return $this->belongsTo(MeasureModel::class,'measure_id');
    }
    public function invoice_groups()
    {
        return $this->belongsTo(InvoiceGroup::class, 'invoice_group_id');
    }

    public function tax()
    {
        return $this->belongsTo(TaxesModel::class, 'tax_id');
    }
    public function items_type() {
        return $this->belongsTo(TypeItemsModel::class, 'item_type_id');
    }
    
    public function currencies() {
        return $this->belongsTo(CurrenciesModel::class, 'currency_id');
    }

     public function itemWarehouses()
    {
        return $this->hasMany(InventoryModel::class, 'item_id');
    }
    // purchases
    public function purchases() {
        return $this->hasMany(PurchaseModel::class, 'item_id');
    }
    // sales
  
    public function sales() {
        return $this->hasMany(Invoices::class, 'item_id');
    }

    static public  function checkSlug($slug)
    {   
        return self::where('slug','=',$slug)->count();
    }



    

}
