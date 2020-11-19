<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Carbon\Carbon;


class Category extends AdminController {

    public function __construct() {
        parent::__construct();
    }

    /**
     * @var object
     */
    private $category;
    private $categoryDescription;
    /**
     * @var string
     */
    private $categoryId;
    /**
     * @var mixed|string
     */
    private $status;

    public function onLoadDatatableEventHandler() {

        $this->results = ShopCategory_model::factory()->findAll();
        if($this->results) {
            foreach($this->results as $result) {
                $this->rows[] = array(
                    'id'			=> $result->id,
                    'name'		    => $result->name,
                    'slug' 		    => $result->slug,
                    'sort_order'    => $result->sort_order,
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
	                                    <li><a class="edit" href="'.url('shop/category/edit/'.$row['id']).'" ><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
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
            $this->categoryId   = (isset($this->request['id'])) ? $this->request['id'] : '';
            $this->status       = (isset($this->request['status'])) ? $this->request['status'] : '';

            $this->load->model('ShopCategory_model');
            $this->ShopCategory_model->updateStatus($this->categoryId, $this->status);
            $this->json['message'] = 'Data has been successfully updated';
            $this->json['status'] = true;

            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($this->json));

        }
    }
    public function index() {

        $this->init();
        $this->data['title']     = 'Shop Category';
        $this->data['columns'][] = 'Name';
        $this->data['columns'][] = 'Sort Order';
        $this->data['columns'][] = 'Status';
        $this->data['columns'][] = 'Created At';
        $this->data['columns'][] = 'Updated At';
        $this->data['add'] = url('shop/category/create');
        attach('assets/theme/light/js/datatables/dataTables.bootstrap4.css', 'css');
        attach('assets/theme/light/js/datatables/jquery.dataTables.min.js', 'js');
        attach('assets/theme/light/js/datatables/dataTables.bootstrap4.min.js', 'js');
        attach('assets/js/shop/Category.js', 'js');

        render('category/index', $this->data);
    }
    public function init() {
        
        $this->data['heading']       = 'Shop Category';
        $this->data['entryName']     = 'Name';
        $this->data['entrySlug']     = 'Slug';
        $this->data['entryStatus']   = 'Status';
        $this->data['back']          = url('shop/category');
        $this->data['btnSave']       = 'Save & Update';
        $this->data['btnBack']       = 'Back';
        $this->data['addBtn']        = 'Add';
        $this->data['deleteBtn']     = 'Delete';

        $this->data['form']             = array(
            'id'    => 'CategoryForm',
            'name'  => 'CategoryForm',
        );
        // Category ID
        if (!empty($this->input->post('id'))) {
            $this->data['id'] = $this->input->post('id');
        } elseif (!empty($this->category)) {
            $this->data['id'] = $this->category->id;
        } else {
            $this->data['id'] = '';
        }
        // Name
        if (!empty($this->input->post('name'))) { //add
            $this->data['name'] = $this->input->post('name');
        } elseif (!empty($this->category)) {//edit
            $this->data['name'] = $this->category->name;
        } else {
            $this->data['name'] = '';
        }
        // Sort Order
        if (!empty($this->input->post('sort_order'))) {
            $this->data['sort_order'] = $this->input->post('sort_order');
        } elseif (!empty($this->category)) {
            $this->data['sort_order'] = $this->category->sort_order;
        } else {
            $this->data['sort_order'] = '';
        }
        // Slug
        if (!empty($this->input->post('slug'))) {
            $this->data['slug'] = url_title($this->input->post('slug'),'dash', true);
        } elseif (!empty($this->category)) {
            $this->data['slug'] = ($this->category->slug) ? $this->category->slug : url_title($this->input->post('name'),'dash', true);
        } else {
            $this->data['slug'] = url_title($this->input->post('name'),'dash', true);
        }
        // Description
        if (!empty($this->input->post('description'))) {
            $this->data['description'] = $this->input->post('description');
        } elseif (!empty($this->category)) {
            $this->data['description'] = $this->category->description->description;
        } else {
            $this->data['description'] = '';
        }
        // Meta Title
        if (!empty($this->input->post('meta_title'))) {
            $this->data['meta_title'] = $this->input->post('meta_title');
        } elseif (!empty($this->category)) {
            $this->data['meta_title'] = $this->category->description->meta_title;
        } else {
            $this->data['meta_title'] = '';
        }
        // Meta Description
        if (!empty($this->input->post('meta_description'))) {
            $this->data['meta_description'] = $this->input->post('meta_description');
        } elseif (!empty($this->category)) {
            $this->data['meta_description'] = $this->category->description->meta_description;
        } else {
            $this->data['meta_description'] = '';
        }
        // Meta keyword
        if (!empty($this->input->post('meta_keywords'))) {
            $this->data['meta_keywords'] = $this->input->post('meta_keywords');
        } elseif (!empty($this->category)) {
            $this->data['meta_keywords'] = $this->category->description->meta_keywords;
        } else {
            $this->data['meta_keywords'] = '';
        }
        //dd($this->data);
        // Status
        if (!empty($this->input->post('status'))) {
            $this->data['status'] = $this->input->post('status');
        } elseif (!empty($this->category)) {
            $this->data['status'] = $this->category->status;
        } else {
            $this->data['status'] = 1;
        }
        //parent
        if (!empty($this->input->post('parent_id'))) {
            $this->data['parent_id'] = $this->input->post('parent_id');
        } elseif (!empty($this->category)) {
            $this->data['parent_id'] = $this->category->parent_id;
        } else {
            $this->data['parent_id'] = '';
        }
        
        // Image

        if (!empty($this->input->post('image'))) {
            $this->data['image'] = $this->input->post('image');
        } elseif (!empty($this->category)) {
            $this->data['image'] = $this->category->image;
        } else {
            $this->data['image'] = '';
        }

        if (!empty($this->input->post('image')) && is_file(DIR_IMAGE . $this->input->post('image'))) {
            $this->data['thumb'] = $this->resize($this->input->post('image'), 100, 100);
        } elseif (!empty($this->category) && is_file(DIR_IMAGE . $this->category->image)) {
            $this->data['thumb'] = $this->resize($this->category->image, 100, 100);
        } else {
            $this->data['thumb'] = $this->resize('no_image.png', 100, 100);
        }

        $this->data['placeholder'] = $this->resize('no_image.png', 100, 100);

        $this->data['back'] = url('shop/category');
        $this->data['category'] = ShopCategory_model::factory()->findAll([],null,'name', 'ASC');
        //$this->dd($this->data);
    }
    public function validateForm() {
        $this->lang->load('admin/category');
        if ((strlen($this->input->post('name')) < 1) || (strlen(trim($this->input->post('name'))) > 255)) {
            $this->error['name'] = $this->lang->line('error_name');
        }

        if ((strlen($this->input->post('sort_order')) < 1)) {
            $this->error['sort_order'] = $this->lang->line('error_sort_order');
        }
        //dd($this->input->post('status'));
        if ($this->input->post('status') == '') {
            $this->error['status'] = $this->lang->line('error_status');
        }
        if ((strlen($this->input->post('meta_title')) < 1) || (strlen(trim($this->input->post('meta_title'))) > 255)) {
            $this->error['meta_title'] = $this->lang->line('error_meta_title');
        }

        if ((strlen($this->input->post('image')) < 1)) {
            $this->error['image'] = $this->lang->line('error_image');
        }

        $this->load->model('ShopCategory_model');

        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->lang->line('error_warning');
        }
        //dd($this->error);

        return !$this->error;
    }
    public function create() {
        $this->init();
        $this->data['title'] = 'Add Shop Category Form';
        $this->data['route'] = url('shop/category/store');
        attach('assets/js/jquery.validate.js', 'js');
        attach('assets/js/additional-methods.js', 'js');
        attach('assets/theme/light/js/datatables/dataTables.bootstrap4.css', 'css');
        attach('assets/js/shop/Category.js', 'js');
        render('category/create', $this->data); 
    }
    
    public function store() {
        try {
            $this->init();
            ShopCategory_model::factory()->insert([
                'name'          => $this->data['name'],
                'slug'          => $this->data['slug'],
                'image'         => $this->data['image'],
                'parent_id'     => $this->data['parent_id'],
                'sort_order'    => $this->data['sort_order'],
                'status'        => $this->data['status'],
            ]);
            ShopCategoryDescription_model::factory()->insert([
                'category_id'       => ShopCategory_model::factory()->getLastInsertID(),
                'description'       => $this->data['description'],
                'meta_title'        => $this->data['meta_title'],
                'meta_description'  => $this->data['meta_description'],
                'meta_keywords'     => $this->data['meta_keywords'],
            ]);
            setMessage('message', 'Success: You have modified features product!');
            redirect(url('shop/category/create/'));
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
    public function edit($id) {
       
        $this->category = ShopCategory_model::factory()->findOne($id);
        
        if(!$this->category) {
            setMessage('message', 'Record not found');
            redirect(url('shop/category/'));
        }
       
        $this->init();
        $this->data['title'] = 'Edit Shop Category Form';
        $this->data['route'] = url('shop/category/update/'.$id);
        //$this->dd($this->data);
        attach('assets/js/jquery.validate.js', 'js');
        attach('assets/js/additional-methods.js', 'js');
        attach('assets/js/shop/Category.js', 'js');
        render('category/edit', $this->data);
    }
    public function update($id) {
        try {
            $this->category = ShopCategory_model::factory()->findOne($id);
            if(!$this->category) {
                setMessage('message', 'Info: Category does not exists!');
                redirect(url('shop/category'));
            }
            $this->init();
            // Category Model
            ShopCategory_model::factory()->update([
                'name'          => $this->data['name'],
                'slug'          => $this->data['slug'],
                'image'         => $this->data['image'],
                'parent_id'     => $this->data['parent_id'],
                'sort_order'    => $this->data['sort_order'],
                'status'        => $this->data['status'],
            ],[
                'id' => $id
            ]);
            ShopCategoryDescription_model::factory()->update([
                'description'       => $this->data['description'],
                'meta_title'        => $this->data['meta_title'],
                'meta_description'  => $this->data['meta_description'],
                'meta_keywords'     => $this->data['meta_keywords'],
            ],[
                'category_id' => $id
            ]);
            // Category Image Model
            if(isset($this->data['image'])) {
                ShopCategory_model::factory()->delete([
                    'id' => $categoryId
                ], true);
                foreach ($this->data['image'] as $image) {
                    ShopCategory_model::factory()->insert([
                        'id'            => $categoryId,
                        'image'         => $image['image'],
                    ]);
                }
            }
            //dd($this->data);
            setMessage('message', "Success: You have modified category! ");
            redirect(url('shop/category/edit/'. $id));
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
                $this->load->model('ShopCategory_model');
                foreach ($this->selected as $categoryId) {
                    $this->ShopCategory_model->deleteCategory($categoryId);
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
    public function show($id)
    {
        // TODO: Implement show() method.
    }
}