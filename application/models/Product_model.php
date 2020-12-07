<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Product_model extends BaseModel {
    protected $table = "products";

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
        return new Product_model($attr);
    }

    public function addProduct($data = array()) {
        $this->db->query("INSERT INTO products SET name = '" . $this->db->escape_str($data['name']) . "',search_keywords = '" . $this->db->escape_str($data['search_keywords']) . "', slug = '" . $this->db->escape_str($data['slug']) . "', quiz_id = '" . $this->db->escape_str($data['quizId']) . "', status = '" . $this->db->escape_str($data['status'])."'");
        $productId = $this->db->insert_id();
        if(isset($productId)) {
            $this->updateProductRelatedModels($productId, $data);
        }
        //return $productId;
    }

    public function getProductBySlug($slug) {
        $query = $this->db->query("SELECT * FROM products WHERE slug = '" . $this->db->escape_str(strtolower($slug)) . "'");
        return $query->row_array();
    }

    private function deleteProductRelatedModels($productId, $forceDelete = false) {
        if($forceDelete) {
            $this->db->query("DELETE FROM category_to_products WHERE product_id = '" . (int)$productId . "'");
            $this->db->query("DELETE FROM products_description WHERE product_id = '" . (int)$productId . "'");
            $this->db->query("DELETE FROM products_images WHERE product_id = '" . (int)$productId . "'");
            $this->db->query("DELETE FROM products_videos WHERE product_id = '" . (int)$productId . "'");
            $this->db->query("DELETE FROM products_pdf WHERE product_id = '" . (int)$productId . "'");
        }
        $this->db->query("UPDATE category_to_products SET is_deleted = 1 WHERE product_id = '" . (int)$productId . "'");
        $this->db->query("UPDATE products_description SET is_deleted = 1 WHERE product_id = '" . (int)$productId . "'");
        $this->db->query("UPDATE products_images SET is_deleted = 1 WHERE product_id = '" . (int)$productId . "'");
        $this->db->query("UPDATE products_videos SET is_deleted = 1 WHERE product_id = '" . (int)$productId . "'");
        $this->db->query("UPDATE products_pdf SET is_deleted = 1 WHERE product_id = '" . (int)$productId . "'");
    }
    private function updateProductRelatedModels($productId, $data = array()) {
        if($data['categoryProducts']) {
            $this->db->query("DELETE FROM category_to_products WHERE product_id = '" . (int)$productId . "'");
            foreach ($data['categoryProducts'] as $categoryId) {
                $this->db->query("INSERT INTO category_to_products SET category_id = '".(int)$categoryId."', product_id = '" . (int)$productId . "', sort_order = '" . $this->db->escape_str($data['sort_order'])."'");
            }
        }
        if(isset($data['description'])) {
            $this->db->query("DELETE FROM products_description WHERE product_id = '" . (int)$productId . "'");
            $this->db->query("INSERT INTO products_description SET product_id = '" . (int)$productId . "',description = '" . $this->db->escape_str($data['description']) . "', meta_title = '" . $this->db->escape_str($data['meta_title']) . "', meta_keyword = '" . $this->db->escape_str($data['meta_keyword']) . "', meta_description = '" . $this->db->escape_str($data['meta_description']) . "'");
        }
        if(isset($data['image'])) {
            $this->db->query("UPDATE products_images SET is_deleted = 1 WHERE product_id = '" . (int)$productId . "'");
            $this->db->query("INSERT INTO products_images SET image = '".$data['image']."', product_id = '" . (int)$productId . "'");
        }
        if(isset($data['youtubeUrl'])) {
            $this->db->query("UPDATE products_videos SET is_deleted = 1 WHERE product_id = '" . (int)$productId . "'");
            $this->db->query("INSERT INTO products_videos SET url = '".$data['youtubeUrl']."', thumb = '" . $this->db->escape_str($data['youtubeThumb']) . "', product_id = '" . (int)$productId . "'");
        }
        if(isset($data['pdf'])) {
            $this->db->query("UPDATE products_pdf SET is_deleted = 1 WHERE product_id = '" . (int)$productId . "'");
            $this->db->query("INSERT INTO products_pdf SET product_id = '" . (int)$productId . "', pdf = '" . $this->db->escape_str($data['pdf']) . "'");
        }

    }
    public function editProduct($productId, $data) {
        //dd($data);
        try {
            $this->db->query("UPDATE products SET name = '" . $this->db->escape_str($data['name']) . "',search_keywords = '" . $this->db->escape_str($data['search_keywords']) . "', slug = '" . $this->db->escape_str($data['slug']) . "', quiz_id = '" .(int)$data['quizId'] . "', status = '" . $this->db->escape_str($data['status'])."' WHERE id = '" . (int)$productId . "'");
            $this->updateProductRelatedModels($productId, $data);
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

    }
    public function deleteProduct($productId, $forceDelete = false) {
        if($forceDelete) {
            $this->db->query("DELETE FROM products WHERE id = '" . (int)$productId . "'");
            $this->deleteProductRelatedModels($productId, true);
        }
        $this->db->query("UPDATE products SET is_deleted = 1 WHERE id = '" . (int)$productId . "'");
        $this->deleteProductRelatedModels($productId, false);
    }
    public function updateStatus($id, $status) {
        $this->db->query("UPDATE products SET status = '" . $this->db->escape_str($status) . "' WHERE id = '" . (int)$id . "'");
    }

    public function categoryProducts() {
        return $this->hasOne('CategoryToProduct_model', 'product_id', 'id')->order_by('sort_order', 'ASC')->get()->row_object();
    }
    public function productDescription() {
        return $this->hasOne('ProductDescription_model', 'product_id', 'id')->get()->row_object();
    }
    public function productImages() {
        return $this->hasOne('ProductImages_model', 'product_id', 'id')->get()->row_object();
    }
    public function productVideos() {
        return $this->hasOne('ProductVideos_model', 'product_id', 'id')->get()->row_object();
    }
    public function productPdf() {
        return $this->hasOne('ProductPdf_model', 'product_id', 'id')->get()->row_object();
    }
    public function featuresProduct() {
        return $this->hasMay('FeaturesProduct_model', 'product_id', 'id')->get()->result_object();
    }
    public function images() {
        return $this->hasOne(ProductImages_model::class, 'product_id', 'id');
    }
    public function description() {
        return $this->hasOne(ProductDescription_model::class, 'product_id', 'id');;
    }
    public function videos() {
        return $this->hasOne(ProductVideos_model::class, 'product_id', 'id');
    }
    public function pdf() {
        return $this->hasOne(ProductPdf_model::class, 'product_id', 'id');
    }
    public function quiz() {
        return $this->hasOne(Quiz_model::class, 'id', 'quiz_id');
    }
    public function categoryToProduct() {
        return $this->hasOne(CategoryToProduct_model::class, 'product_id', 'id');
    }
    public function image() {
        return $this->hasOne(ProductImages_model::class, 'product_id', 'id');
    }
    public function search($data) {
        $sql    = "SELECT p.* FROM `products` p WHERE  p.is_deleted = '0' AND status = 1 AND CONCAT(',', search_keywords, ',') LIKE '".$this->db->escape_like_str($data['q'])."%' ";
        $query  = $this->db->query($sql);
        $arr    = array();
        $image  = null;
        $productDescription = array();
        if ($query->num_rows()) {
            foreach ($query->result_array() as $key => $product) {
                $productDescription = $this->descriptionByProductId($product['id']);
                if (is_file(DIR_IMAGE . $productDescription['image'])) {
                    $image = resize($productDescription['image'], 64, 64);
                } else {
                    $image = resize('no_image.png', 64, 64);
                }
                $arr[] = array(
                    'id'            => $product['id'],
                    'name'          => $product['name'],
                    'slug'          => $product['slug'],
                    'image'         => $image,
                    'description'   => strip_tags($productDescription['description']),
                    'category'      => $this->categoryByProductId($product['id'])
                );
            }
        }
        if($arr) {
            return $arr;
        }

        dd($arr);
    }

    public function categoryByProductId($productId) {
        $categoryToProduct = CategoryToProduct_model::factory()->findOne(['product_id' => $productId]);
        if($categoryToProduct) {
            return array(
                'slug'        => $categoryToProduct->product->categoryToProduct->category->slug,
                'name'        => $categoryToProduct->product->categoryToProduct->category->name,
                'description' => $categoryToProduct->product->categoryToProduct->category->description->description
            );
        }
    }
    public function descriptionByProductId($productId) {
        $categoryToProduct = CategoryToProduct_model::factory()->findOne(['product_id' => $productId]);
        if($categoryToProduct) {
            return array(
                'description'   => $categoryToProduct->product->description->description,
                'image'         => $categoryToProduct->product->image->image
            );
        }
    }
}
