<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Order_model extends BaseModel {
    
    protected $table = "orders";

    protected $primaryKey = 'id';

    // Record status for checking is deleted or not
    const SOFT_DELETED = 'is_deleted';

    public static function factory($attr = array()) {
        return new Order_model($attr);
    }


}