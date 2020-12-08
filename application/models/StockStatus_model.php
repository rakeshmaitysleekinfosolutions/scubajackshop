<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class StockStatus_model extends BaseModel
{

    protected $table = "stock_status";

    protected $primaryKey = 'id';

    // Record status for checking is deleted or not
    const SOFT_DELETED = 'is_deleted';

    public static function factory($attr = array())
    {
        return new StockStatus_model($attr);
    }
}