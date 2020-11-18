<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class ProductPdf_model extends BaseModel {
    
    protected $table = "products_pdf";

    protected $primaryKey = 'id';
  
    // Record status for checking is deleted or not
    const SOFT_DELETED = 'is_deleted';
    
    public static function factory($attr = array()) {
        return new ProductPdf_model($attr);
    }
    
}