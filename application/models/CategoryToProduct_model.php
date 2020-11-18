<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class CategoryToProduct_model extends BaseModel {
    
    protected $table = "category_to_products";

    protected $primaryKey = 'id';
  
    // Record status for checking is deleted or not
    const SOFT_DELETED = 'is_deleted';
    
    public static function factory($attr = array()) {
        return new CategoryToProduct_model($attr);
    }

    public function product() {
        return $this->hasOne(Product_model::class, 'id', 'product_id');
    }
    public function category() {
        return $this->hasOne(Category_model::class, 'id', 'category_id');
    }
}