<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class FeaturesProduct_model extends BaseModel {

    protected $table = "features_products";

    protected $primaryKey = 'id';

    protected $timestamps = true;

    // Mainstream creating field name
    const CREATED_AT = 'created_at';

    // Mainstream updating field name
    const UPDATED_AT = 'updated_at';

    // Use unixtime for saving datetime
    protected $dateFormat = 'datetime';

    // Record status for checking is deleted or not
    const SOFT_DELETED = 'is_deleted';

    // 0: actived, 1: deleted
    protected $recordDeletedFalseValue = '1';

    protected $recordDeletedTrueValue = '0';

    public static function factory($attr = array()) {
        return new FeaturesProduct_model($attr);
    }
    public function addFeaturesProduct($data = array()) {
        // dd($data['featuresProduct']);
        if(isset($data['featuresProduct']) && !empty($data['featuresProduct'])) {
            foreach ($data['featuresProduct'] as $productId) {
                $this->deleteFeaturesProductByProductId($productId, true);
                $this->db->query("INSERT INTO features_products SET product_id = '".(int)$productId."'");
            }
        }
    }

    public function getFeaturesProductById($id) {
        $query = $this->db->query("SELECT * FROM features_products WHERE id = '" . $this->db->escape_str(strtolower($id)) . "'");
        return $query->row_array();
    }
    public function editFeaturesProduct($featuresProductId, $data = array()) {
        try {
            if(isset($data['featuresProduct']) && !empty($data['featuresProduct'])) {
                foreach ($data['featuresProduct'] as $productId) {
                    $this->deleteFeaturesProductByProductId($productId, true);
                    $this->db->query("INSERT INTO features_products SET product_id = '".(int)$productId."'");
                }
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

    }
    public function deleteFeaturesProductByProductId($productId, $forceDelete = false) {
        if($forceDelete) {
            $this->db->query("DELETE FROM features_products WHERE product_id = '" . (int)$productId . "'");
        }
        $this->db->query("UPDATE features_products SET is_deleted = 1 WHERE product_id = '" . (int)$productId . "'");
    }
    public function deleteFeaturesProduct($featuresProductId, $forceDelete = false) {
        if($forceDelete) {
            $this->db->query("DELETE FROM features_products WHERE id = '" . (int)$featuresProductId . "'");
        }
        $this->db->query("UPDATE features_products SET is_deleted = 1 WHERE id = '" . (int)$featuresProductId . "'");
    }

    public function product() {
        return $this->hasOne(Product_model::class, 'id', 'product_id');
    }

}
