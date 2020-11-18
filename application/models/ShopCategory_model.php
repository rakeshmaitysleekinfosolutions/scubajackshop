<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class ShopCategory_model extends BaseModel {
    
    protected $table = "category";

    protected $primaryKey = 'id';

    // Record status for checking is deleted or not
    const SOFT_DELETED = 'is_deleted';

    public static function factory($attr = array()) {
        return new Category_model($attr);
    }
    public function addCategory($data = array()) {
        $this->db->query("INSERT INTO category SET name = '" . $this->db->escape_str($data['name']) . "', slug = '" . $this->db->escape_str($data['slug']) . "',sort_order = '" . $this->db->escape_str($data['sortOrder']) . "', status = '" . $this->db->escape_str($data['status'])."'");
        $categoryId = $this->db->insert_id();
        if(isset($categoryId)) {
            $this->db->query("INSERT INTO category_description SET category_id = '" . (int)$categoryId . "', description = '" . $this->db->escape_str($data['description']) . "',image = '" . $this->db->escape_str($data['image']) . "', meta_title = '" . $this->db->escape_str($data['meta_title']) . "', meta_keyword = '" . $this->db->escape_str($data['meta_keyword']) . "', meta_description = '" . $this->db->escape_str($data['meta_description']) . "'");
        }

        //return $categoryId;
    }
    public function categoryDescription() {
        return $this->hasMany('CategoryDescription_model', 'category_id', 'id')->get()->row_object();
    }
    public function getCategoryBySlug($slug) {
        $query = $this->db->query("SELECT * FROM category WHERE slug = '" . $this->db->escape_str(strtolower($slug)) . "'");
        return $query->row_array();
    }

    public function editCategory($categoryId, $data) {
        //dd($data);
        $this->db->query("UPDATE category SET name = '" . $this->db->escape_str($data['name']) . "', slug = '" . $this->db->escape_str($data['slug']) . "', sort_order = '" . $this->db->escape_str($data['sortOrder']) . "',status = '" . $this->db->escape_str($data['status'])."' WHERE id = '" . (int)$categoryId . "'");
        $this->db->query("DELETE FROM category_description WHERE category_id = '" . (int)$categoryId . "'");
        $this->db->query("INSERT INTO category_description SET category_id = '" . (int)$categoryId . "', description = '" . $this->db->escape_str($data['description']) . "', image = '" . $this->db->escape_str($data['image']) . "', meta_title = '" . $this->db->escape_str($data['meta_title']) . "', meta_keyword = '" . $this->db->escape_str($data['meta_keyword']) . "', meta_description = '" . $this->db->escape_str($data['meta_description']) . "'");
    }
    public function deleteCategory($categoryId, $forceDelete = false) {
        if($forceDelete) {
            $this->db->query("DELETE FROM category WHERE id = '" . (int)$categoryId . "'");
            $this->db->query("DELETE FROM category_description WHERE category_id = '" . (int)$categoryId . "'");
        }
        $this->db->query("UPDATE category SET is_deleted = 1 WHERE id = '" . (int)$categoryId . "'");
        $this->db->query("UPDATE category_description SET is_deleted = 1 WHERE category_id = '" . (int)$categoryId . "'");
    }
    public function updateStatus($categoryId, $status) {
        $this->db->query("UPDATE category SET status = '" . $this->db->escape_str($status) . "' WHERE id = '" . (int)$categoryId . "'");
    }

    public function description() {
        return $this->hasOne(CategoryDescription_model::class, 'category_id', 'id');
    }
    public function products() {
        return $this->hasMany(CategoryToProduct_model::class, 'category_id', 'id');
    }

}