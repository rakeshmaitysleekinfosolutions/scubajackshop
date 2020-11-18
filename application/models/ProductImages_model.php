<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class ProductImages_model extends BaseModel {
    
    protected $table = "products_images";

    protected $primaryKey = 'id';
  
    // Record status for checking is deleted or not
    const SOFT_DELETED = 'is_deleted';
    
    public static function factory($attr = array()) {
        return new ProductImages_model($attr);
    }
    
}