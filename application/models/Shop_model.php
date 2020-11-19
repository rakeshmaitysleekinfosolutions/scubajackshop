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
    public function categories($itemId) {
        $items = ShopToCategory_model::factory()->findAll(['shop_category_id' => $itemId]);
        $ids = array();
        if(count($items) > 0) {
            foreach ($items as $item) {
                $ids[] = $item->shop_category_id;
            }
        }
        if($ids) {
            return $ids;
        }
    }
    public function images($projectId) {
        return ShopImage_model::factory()->find()->where('shop_id', $projectId)->order_by('sort_order','ASC')->get()->result_array();
    }

}