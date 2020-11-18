<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Carbon\Carbon;
use Application\Contracts\CategoryContract;

class Category extends AdminController implements CategoryContract {

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

		$this->results = Category_model::factory()->findAll();
		if($this->results) {
			foreach($this->results as $result) {
				$this->rows[] = array(
					'id'			=> $result->id,
					'name'		    => $result->name,
					'slug' 		    => $result->slug,
                    'sortOrder'     => $result->sort_order,
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
												<input data-id="'.$row['id'].'" type="checkbox" class="css-control-input selectCheckbox" id="row_'.$row['id'].'" name="row_'.$row['id'].'">
												<span class="css-control-indicator"></span>
											</label>
										</td>';
					$this->data[$i][] = '<td>'.$row['name'].'</td>';
					$this->data[$i][] = '<td>'.$row['slug'].'</td>';
                    $this->data[$i][] = '<td>'.$row['sortOrder'].'</td>';
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
	                                    <li><a class="edit" href="javascript:void(0);" data-id="'.$row['id'].'" data-toggle="modal" data-target="#edit_client"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
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

            $this->load->model('Category_model');
            $this->Category_model->updateStatus($this->categoryId, $this->status);
            $this->json['message'] = 'Data has been successfully updated';
            $this->json['status'] = true;

            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($this->json));

        }
    }
    public function index() {
        $this->template->set_template('layout/admin');
       
		$this->template->stylesheet->add('assets/theme/light/js/datatables/dataTables.bootstrap4.css');
        $this->template->javascript->add('assets/theme/light/js/datatables/jquery.dataTables.min.js');
		$this->template->javascript->add('assets/theme/light/js/datatables/dataTables.bootstrap4.min.js');
        $this->template->javascript->add('assets/js/admin/category/Category.js');

		$this->template->content->view('category/index');
		$this->template->publish();
    }
    public function getData() {

        // Errors
        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }
      
        if (isset($this->error['name'])) {
            $this->data['error_name'] = $this->error['name'];
        } else {
            $this->data['error_name'] = '';
        }

        if (isset($this->error['sortOrder'])) {
            $this->data['error_sortOrder'] = $this->error['sortOrder'];
        } else {
            $this->data['error_sortOrder'] = '';
        }
        //dd($this->data);
        if (isset($this->error['status'])) {
            $this->data['error_status'] = $this->error['status'];
        } else {
            $this->data['error_status'] = '';
        }

        if (isset($this->error['image'])) {
            $this->data['error_image'] = $this->error['image'];
        } else {
            $this->data['error_image'] = '';
        }

        if (isset($this->error['meta_title'])) {
            $this->data['error_meta_title'] = $this->error['meta_title'];
        } else {
            $this->data['error_meta_title'] = '';
        }
        // Data

        // Category ID
        if (!empty($this->input->post('categoryId'))) {
            $this->data['categoryId'] = $this->input->post('categoryId');
        } elseif (!empty($this->category)) {
            $this->data['categoryId'] = $this->category->id;
        } else {
            $this->data['categoryId'] = '';
        }
        // Name
        if (!empty($this->input->post('name'))) {
            $this->data['name'] = $this->input->post('name');
        } elseif (!empty($this->category)) {
            $this->data['name'] = $this->category->name;
        } else {
            $this->data['name'] = '';
        }
        // Sort Order
        if (!empty($this->input->post('sortOrder'))) {
            $this->data['sortOrder'] = $this->input->post('sortOrder');
        } elseif (!empty($this->category)) {
            $this->data['sortOrder'] = $this->category->sort_order;
        } else {
            $this->data['sortOrder'] = '';
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
        } elseif (!empty($this->categoryDescription)) {
            $this->data['description'] = $this->categoryDescription->description;
        } else {
            $this->data['description'] = '';
        }
        // Meta Title
        if (!empty($this->input->post('meta_title'))) {
            $this->data['meta_title'] = $this->input->post('meta_title');
        } elseif (!empty($this->categoryDescription)) {
            $this->data['meta_title'] = $this->categoryDescription->meta_title;
        } else {
            $this->data['meta_title'] = '';
        }
        // Meta Description
        if (!empty($this->input->post('meta_description'))) {
            $this->data['meta_description'] = $this->input->post('meta_description');
        } elseif (!empty($this->categoryDescription)) {
            $this->data['meta_description'] = $this->categoryDescription->meta_description;
        } else {
            $this->data['meta_description'] = '';
        }
        // Meta keyword
        if (!empty($this->input->post('meta_keyword'))) {
            $this->data['meta_keyword'] = $this->input->post('meta_keyword');
        } elseif (!empty($this->categoryDescription)) {
            $this->data['meta_keyword'] = $this->categoryDescription->meta_keyword;
        } else {
            $this->data['meta_keyword'] = '';
        }
        //dd($this->data);
        // Status
        if (!empty($this->input->post('status'))) {
            $this->data['status'] = $this->input->post('status');
        } elseif (!empty($this->category)) {
            $this->data['status'] = $this->category->status;
        } else {
            $this->data['status'] = 0;
        }
        // Image

		if (!empty($this->input->post('image'))) {
			$this->data['image'] = $this->input->post('image');
		} elseif (!empty($this->categoryDescription)) {
			$this->data['image'] = $this->categoryDescription->image;
		} else {
			$this->data['image'] = '';
		}

		if (!empty($this->input->post('image')) && is_file(DIR_IMAGE . $this->input->post('image'))) {
			$this->data['thumb'] = $this->resize($this->input->post('image'), 100, 100);
		} elseif (!empty($this->categoryDescription) && is_file(DIR_IMAGE . $this->categoryDescription->image)) {
			$this->data['thumb'] = $this->resize($this->categoryDescription->image, 100, 100);
		} else {
			$this->data['thumb'] = $this->resize('no_image.png', 100, 100);
		}

		$this->data['placeholder'] = $this->resize('no_image.png', 100, 100);

		$this->data['back'] = admin_url('category');
		//$this->dd($this->data);
    }
    public function validateForm() {
        $this->lang->load('admin/category');
		if ((strlen($this->input->post('name')) < 1) || (strlen(trim($this->input->post('name'))) > 255)) {
			$this->error['name'] = $this->lang->line('error_name');
		}

		if ((strlen($this->input->post('sortOrder')) < 1)) {
			$this->error['sortOrder'] = $this->lang->line('error_sortOrder');
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

        $this->load->model('Category_model');

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->lang->line('error_warning');
		}
		//dd($this->error);
      
		return !$this->error;
    }
    public function create() {
        $this->template->javascript->add('assets/js/jquery.validate.js');
        $this->template->javascript->add('assets/js/additional-methods.js');
        $this->template->javascript->add('assets/js/admin/category/Category.js');



        $this->template->set_template('layout/admin');
        $this->getData();
        //dd($this->data);
        $this->template->content->view('category/create', $this->data);
        $this->template->publish();
    }
    public function store() {
        if ($this->isPost() && $this->validateForm()) {
            $this->load->model('Category_model');
            $this->getData();
            Category_model::factory()->addCategory($this->data);
            $this->setMessage('message', $this->lang->line('text_success'));
            $this->redirect(admin_url('category/create/'));
        }
        $this->create();
    }
    public function edit($categoryId) {
        if(!$this->isPost()) {
            $this->load->model('Category_model');
            $this->category = Category_model::factory()->findOne($categoryId);
        }
        if($this->category) {
            $this->categoryDescription = $this->category->categoryDescription();
        }
        if(!$this->category) {
            $this->redirect(admin_url('category'));
        }
        $this->getData();
        //$this->dd($this->data);
        $this->template->javascript->add('assets/js/jquery.validate.js');
        $this->template->javascript->add('assets/js/additional-methods.js');
        $this->template->javascript->add('assets/js/admin/category/Category.js');

        $this->template->set_template('layout/admin');
        $this->template->content->view('category/edit', $this->data);
        $this->template->publish();
    }
    public function update() {
        try {
            $this->lang->load('admin/category');
            if ($this->isPost() && $this->validateForm()) {
                $this->load->model('Category_model');
                $this->categoryId = ($this->input->post('categoryId')) ? $this->input->post('categoryId') : '';

                $this->getData();
                $this->Category_model->editCategory($this->categoryId, $this->data);
                $this->setMessage('message', $this->lang->line('text_success'));
                //$this->redirect(admin_url('category'));
                $this->redirect(admin_url('category/edit/'.$this->categoryId));
            }
            $this->getData();
            $this->create();
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
                $this->load->model('Category_model');
                foreach ($this->selected as $categoryId) {
                    $this->Category_model->deleteCategory($categoryId);
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