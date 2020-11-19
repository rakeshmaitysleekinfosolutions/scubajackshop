<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class ShopDescription_model extends BaseModel {
    
    protected $table = "shop_description";

    protected $primaryKey = 'id';

    // Record status for checking is deleted or not
    const SOFT_DELETED = 'is_deleted';

    public static function factory($attr = array()) {
        return new ShopDescription_model($attr);
    }
}