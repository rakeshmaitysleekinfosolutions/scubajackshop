<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class OrderHistory_model extends BaseModel {
    
    protected $table = "orders_history";

    protected $primaryKey = 'id';

    // Record status for checking is deleted or not
    const SOFT_DELETED = 'is_deleted';

    public static function factory($attr = array()) {
        return new OrderHistory_model($attr);
    }


}