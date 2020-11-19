<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class ShopCategory_model extends BaseModel {
    
    protected $table = "shop_category";

    protected $primaryKey = 'id';

    // Record status for checking is deleted or not
    const SOFT_DELETED = 'is_deleted';

    public static function factory($attr = array()) {
        return new ShopCategory_model($attr);
    }

    public function description() {
        return $this->hasOne(ShopCategoryDescription_model::class, 'category_id', 'id');
    }
}