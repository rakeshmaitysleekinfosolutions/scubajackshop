<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Carbon\Carbon;


class Product extends AdminController {
    /**
     * @var object
     */
    private $product;
    public function __construct() {
        parent::__construct();
    }
    public function init() {
        $this->data['heading']                  = 'Product Management';

        $this->data['entryName']                = 'Name';
        $this->data['entryModel']               = 'Model';
        $this->data['entryDescription']         = 'Description';
        $this->data['entrySlug']                = 'Slug';
        $this->data['entrySortOrder']           = 'Sort Order';
        $this->data['entryCategory']            = 'Category';

        $this->data['entryMetaTitle']           = 'Meta Title';
        $this->data['entryMetaDescription']     = 'Meta Description';
        $this->data['entryMetaKeywords']        = 'Meta Keywords';

        $this->data['form']             = array(
            'id'    => 'frmShopProduct',
            'name'  => 'frmShopProduct',
        );
        
        if (!empty($this->input->post('name'))) { //add
            $this->data['name'] = $this->input->post('name');
        } elseif (!empty($this->product)) {//edit
            $this->data['name'] = $this->product->name;
        } else {
            $this->data['name'] = '';
        }
        // Slug
        if (!empty($this->input->post('slug'))) {
            $this->data['slug'] = url_title($this->input->post('slug'),'dash', true);
        } elseif (!empty($this->product)) {
            $this->data['slug'] = $this->product->slug;
        } else {
            $this->data['slug'] = url_title($this->input->post('name'),'dash', true);
        }
        // quantity
        if (!empty($this->input->post('quantity'))) {
            $this->data['quantity'] = $this->input->post('quantity');
        } elseif (!empty($this->product)) {
            $this->data['quantity'] = $this->product->quantity;
        } else {
            $this->data['quantity'] = 1;
        }
        if (!empty($this->input->post('price'))) {
            $this->data['price'] = $this->input->post('price');
        } elseif (!empty($this->product)) {
            $this->data['price'] = $this->product->price;
        } else {
            $this->data['price'] = 0.00;
        }
        //sort_order
        if (!empty($this->input->post('sort_order'))) {
            $this->data['sort_order'] = $this->input->post('sort_order');
        } elseif (!empty($this->product)) {
            $this->data['sort_order'] = $this->product->sort_order;
        } else {
            $this->data['sort_order'] = 1;
        }
        //status
        if (!empty($this->input->post('status'))) {
            $this->data['status'] = $this->input->post('status');
        } elseif (!empty($this->product)) {
            $this->data['status'] = $this->product->status;
        } else {
            $this->data['status'] = 1;
        }
        // Category
        if (!empty($this->input->post('categories_id'))) {
            $this->data['categories_id'] = $this->input->post('categories_id');
        } elseif (!empty($this->product)) {
            $this->data['categories_id'] = $this->product->categories($this->product->id);;
        } else {
            $this->data['categories_id'] = array();
        }
        // Description
        if (!empty($this->input->post('description'))) {
            $this->data['description'] = $this->input->post('description');
        } elseif (!empty($this->product)) {
            $this->data['description'] = $this->product->description->description;
        } else {
            $this->data['description'] = '';
        }
        // Meta Title
        if (!empty($this->input->post('meta_title'))) {
            $this->data['meta_title'] = $this->input->post('meta_title');
        } elseif (!empty($this->product)) {
            $this->data['meta_title'] = $this->product->description->meta_title;
        } else {
            $this->data['meta_title'] = '';
        }
        // Meta Description
        if (!empty($this->input->post('meta_description'))) {
            $this->data['meta_description'] = $this->input->post('meta_description');
        } elseif (!empty($this->product)) {
            $this->data['meta_description'] = $this->product->description->meta_description;
        } else {
            $this->data['meta_description'] = '';
        }
        // Meta keyword
        if (!empty($this->input->post('meta_keyword'))) {
            $this->data['meta_keyword'] = $this->input->post('meta_keyword');
        } elseif (!empty($this->product)) {
            $this->data['meta_keyword'] = $this->product->description->meta_keyword;
        } else {
            $this->data['meta_keyword'] = '';
        }

        // Image

        if (!empty($this->input->post('image'))) {
            $this->data['image'] = $this->input->post('image');
        } elseif (!empty($this->product)) {
            $this->data['image'] = $this->product->image;
        } else {
            $this->data['image'] = '';
        }

        if (!empty($this->input->post('image')) && is_file(DIR_IMAGE . $this->input->post('image'))) {
            $this->data['thumb'] = $this->resize($this->input->post('image'), 100, 100);
        } elseif (!empty($this->product) && is_file(DIR_IMAGE . $this->product->image)) {
            $this->data['thumb'] = $this->resize($this->product->image, 100, 100);
        } else {
            $this->data['thumb'] = $this->resize('no_image.png', 100, 100);
        }

        // Images
        if (!empty($this->input->post('images'))) {
            $projectImages = $this->input->post('images');
        } elseif (!empty($this->product)) {
            if($this->isPost()) {
                $projectImages = $this->input->post('images');
            } else {
                $projectImages = $this->product->images($this->product->id);
            }

        } else {
            $projectImages = array();
        }
        //dd($projectImages);
        $this->data['images'] = array();

        // dd($projectImages);
        foreach ($projectImages as $projectImage) {
            if (is_file(DIR_IMAGE . $projectImage['image'])) {
                $image = $projectImage['image'];
                $thumb = $projectImage['image'];
            } else {
                $image = '';
                $thumb = 'no_image.png';
            }
            $this->data['images'][] = array(
                'image'      => $image,
                'thumb'      => resize($thumb, 100, 100),
                'sort_order' => $projectImage['sort_order'],
                'thumbnail'  => $projectImage['thumbnail'],
            );
        }
        $this->data['placeholder'] = $this->resize('no_image.png', 100, 100);
        $this->data['back'] = url('shop/product/');
        $this->data['categories'] = ShopCategory_model::factory()->findAll(['status' => 1],null,'sort_order', 'ASC');
    }

    public function index() {
        $this->data['title']        = 'Product List';
        $this->data['columns'][]    = 'Name';
        $this->data['columns'][]    = 'Sort Order';
        $this->data['columns'][]    = 'Status';
        $this->data['columns'][]    = 'Created At';
        $this->data['columns'][]    = 'Updated At';

        render('product/index', $this->data);
    }


    public function create() {
        $this->init();
        $this->data['title'] = 'Add Product';
        $this->data['route'] = url('shop/product/store');
        render('product/create', $this->data);
    }
    
    public function store() {
        try {
            $this->init();
            Shop_model::factory()->insert([
                'name'             => $this->data['name'],
                'slug'             => $this->data['slug'],
                'image'            => $this->data['image'],
                'sort_order'       => $this->data['sort_order'],
                'quantity'         => $this->data['quantity'],
                'price'            => $this->data['price'],
                'status'           => $this->data['status'],
            ]);
            $shopId = Shop_model::factory()->getLastInsertID();
            ShopDescription_model::factory()->insert([
                'shop_id'           => $shopId,
                'description'       => $this->data['description'],
                'meta_title'        => $this->data['meta_title'],
                'meta_description'  => $this->data['meta_description'],
                'meta_keyword'     => $this->data['meta_keyword'],
            ]);
            if(isset($this->data['images'])) {
                foreach ($this->data['images'] as $image) {
                    ShopImage_model::factory()->insert([
                        'shop_id'       => $shopId,
                        'image'         => $image['image'],
                        'sort_order'    => $image['sort_order'],
                    ]);
                }
            }
            if(isset($this->data['categories_id'])) {
                foreach ($this->data['categories_id'] as $categoryId) {
                    ShopToCategory_model::factory()->insert([
                        'shop_id'       => $shopId,
                        'shop_category_id'   => $categoryId,
                    ]);
                }
            }
            setMessage('message', 'Success: You have modified features product!');
            redirect(url('shop/product/create/'));
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
    public function edit($id) {
        $this->product = ShopCategory_model::factory()->findOne($id);
        if(!$this->product) {
            setMessage('message', 'Record not found');
            redirect(url('shop/product/'));
        }
        $this->init();
        $this->data['title'] = 'Edit Shop';
        $this->data['route'] = url('shop/product/update/'.$id);
        render('product/edit', $this->data);
    }
    public function update($id) {
        try {
            $this->init();
            Shop_model::factory()->update([
                'name'             => $this->data['name'],
                'slug'             => $this->data['slug'],
                'image'            => $this->data['image'],
                'sort_order'       => $this->data['sort_order'],
                'quantity'         => $this->data['quantity'],
                'price'            => $this->data['price'],
                'status'           => $this->data['status'],
            ],[
                'id' => $id
            ]);
            ShopDescription_model::factory()->update([
                'description'       => $this->data['description'],
                'meta_title'        => $this->data['meta_title'],
                'meta_description'  => $this->data['meta_description'],
                'meta_keyword'     => $this->data['meta_keyword'],
            ],[
                'shop_id' => $id
            ]);
            if(isset($this->data['images'])) {
                ShopImage_model::factory()->delete([
                    'shop_id' => $id
                ], true);
                foreach ($this->data['images'] as $image) {
                    ShopImage_model::factory()->insert([
                        'shop_id'       => $id,
                        'sort_order'    => $image['sort_order'],
                        'image'         => $image['image'],
                    ]);
                }
            }
            if(isset($this->data['categories_id'])) {
                ShopCategory_model::factory()->delete([
                    'shop_id' => $id
                ], true);
                foreach ($this->data['categories_id'] as $categoryId) {
                    ShopToCategory_model::factory()->insert([
                        'shop_id'       => $id,
                        'shop_category_id'   => $categoryId,
                    ]);
                }
            }
            setMessage('message', "Success: You have modified category! ");
            redirect(url('shop/product/edit/'. $id));
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function delete() {
        if($this->isAjaxRequest()) {
            $this->request = $this->input->post();
            if(!empty($this->request['selected']) && isset($this->request['selected'])) {
                if(array_key_exists('selected', $this->request) && is_array($this->request['selected'])) {
                    $this->selected = $this->request['selected'];
                }
            }
            if($this->selected) {
                foreach ($this->selected as $id) {
                    Shop_model::factory()->delete($id);
                    ShopDescription_model::factory()->delete(['shop_id' => $id]);
                    ShopImage_model::factory()->delete(['shop_id' => $id]);
                }
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode(array('data' => $this->onLoadDatatableEventHandler(), 'status' => true,'message' => 'Record has been successfully deleted')));
            }
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(array('data' => $this->onLoadDatatableEventHandler(), 'status' => false, 'message' => 'Sorry! we could not delete this record')));
        }
    }
    public function onLoadDatatableEventHandler() {
        $this->results = ShopCategory_model::factory()->findAll();
        if($this->results) {
            foreach($this->results as $result) {
                $this->rows[] = array(
                    'id'			=> $result->id,
                    'name'		    => $result->name,
                    'slug' 		    => $result->slug,
                    'sort_order'     => $result->sort_order,
                    'status' 		=> ($result->status && $result->status == 1) ? 1 : 0,
                    'created_at'    => Carbon::createFromTimeStamp(strtotime($result->created_at))->diffForHumans(),
                    'updated_at'    => ($result->updated_at) ? Carbon::createFromTimeStamp(strtotime($result->updated_at))->diffForHumans() : ''
                );
            }
            $i = 0;
            foreach($this->rows as $row) {
                $this->selected = ($row['status'] == 1) ? 'selected' : '';
                $this->data[$i][] = '<td class="text-center">
											<label class="css-control css-control-primary css-checkbox">
                                                <input type="checkbox" class="css-control-input selectCheckbox" value="'.$row['id'].'" name="selected[]">
                                                <span class="css-control-indicator"></span>
											</label>
										</td>';
                $this->data[$i][] = '<td>'.$row['name'].'</td>';
                $this->data[$i][] = '<td>'.$row['sort_order'].'</td>';
//					$this->data[$i][] = '<td>
//											<div class="material-switch pull-right">
//											<input data-id="'.$row['id'].'" class="checkboxStatus" name="switch_checkbox" id="chat_module" type="checkbox" value="'.$row['status'].'" '.$checked.'/>
//											<label for="chat_module" class="label-success"></label>
//										</div>
//                                        </td>';
                $this->data[$i][] = '<td>
                                            <select data-id="'.$row['id'].'" name="status" class="select floating checkboxStatus" id="input-payment-status" >
                                                <option value="0" '.$this->selected.'>Inactive</option>
                                                <option value="1" '.$this->selected.'>Active</option>
                                            </select>
                                        </td>';
                $this->data[$i][] = '<td>'.$row['created_at'].'</td>';
                $this->data[$i][] = '<td>'.$row['updated_at'].'</td>';
                $this->data[$i][] = '<td class="text-right">
	                            <div class="dropdown">
	                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
	                                <ul class="dropdown-menu pull-right">
	                                    <li><a class="edit" href="'.url('shop/product/edit/'.$row['id']).'" ><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
	                                </ul>
	                            </div>
	                        </td>
                        ';
                $i++;
            }


        }

        if($this->data) {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(array('data' => $this->data)));
        } else {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(array('data' => [])));
        }
    }
    public function onClickStatusEventHandler() {
        if($this->isAjaxRequest()) {
            $this->request = $this->input->post();
            $this->productId   = (isset($this->request['id'])) ? $this->request['id'] : '';
            $this->status       = (isset($this->request['status'])) ? $this->request['status'] : '';

            $this->load->model('ShopCategory_model');
            $this->ShopCategory_model->updateStatus($this->productId, $this->status);
            $this->json['message'] = 'Data has been successfully updated';
            $this->json['status'] = true;

            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($this->json));

        }
    }
    public function show($id)
    {
        // TODO: Implement show() method.
    }
}