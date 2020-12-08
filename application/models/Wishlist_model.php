<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Wishlist_model extends BaseModel {
    
    protected $table = "users_wishlist";

    protected $primaryKey = 'id';

    // Record status for checking is deleted or not
    const SOFT_DELETED = 'is_deleted';

    public static function factory($attr = array()) {
        return new Wishlist_model($attr);
    }
    public function getTotalWishlist() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `users_wishlist` WHERE `user_id` = '" . (int)$this->user->getId() . "'");
        return $query->row_array()['total'];
    }

}