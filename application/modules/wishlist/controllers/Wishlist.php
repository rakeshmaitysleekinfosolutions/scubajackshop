<?php
class Wishlist extends AppController {
    public function add() {
        if($this->isAjaxRequest()) {
            $this->json = array();
            if($this->input->post('product_id')) {
                $this->data['product_id'] = (int)$this->input->post('product_id');
            } else {
                $this->data['product_id'] = 0;
            }
            $this->product = Shop_model::factory()->findOne($this->data['product_id']);
            if($this->product) {
                if($this->user->isLogged()) {
                    Wishlist_model::factory()->delete([
                        'user_id'       => $this->user->getId(),
                        'product_id'    => $this->product->id,
                    ], true);
                    Wishlist_model::factory()->insert([
                        'user_id'       => $this->user->getId(),
                        'product_id'    => $this->product->id,
                        'created_at'    => NOW()
                    ]);
                    $this->json['success'] = true;
                    $this->json['totalWishListed'] = sprintf('Wish List (%s)', Wishlist_model::factory()->getTotalWishlist());
                    setSession('totalWishListed', Wishlist_model::factory()->getTotalWishlist());
                } else {
                    $this->wishlist = (getSession('wishlist')) ? getSession('wishlist') : array();
                    if(!$this->wishlist) {
                        setSession('wishlist', $this->wishlist);
                    }
                    $this->wishlist[] = $this->input->post('product_id');
                    $this->wishlist = array_unique($this->wishlist);
                    if($this->wishlist) {
                        setSession('wishlist', $this->wishlist);
                        setSession('totalWishListed', ($this->wishlist) ? count($this->wishlist) : 0);
                    }
                    $this->json['success'] = true;
                    $this->json['totalWishListed'] = sprintf('Wish List (%s)', ($this->wishlist) ? count($this->wishlist) : 0);
                }
            }
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($this->json));
        }
    }
}