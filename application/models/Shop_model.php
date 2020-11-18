<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Shop_model extends BaseModel {
    
    protected $table = "shop";

    protected $primaryKey = 'id';

    // Record status for checking is deleted or not
    const SOFT_DELETED = 'is_deleted';

    public static function factory($attr = array()) {
        return new Shop_model($attr);
    }
    
    public function description() {
        return $this->hasOne(ShopDescription_model::class, 'shop_id', 'id');
    }

}