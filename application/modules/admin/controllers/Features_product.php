<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Carbon\Carbon;
use Application\Contracts\ProductContract;

class Features_product extends AdminController implements ProductContract {

    
    private $featuresProductId;
    private $featuresProduct;
    private $productId;
    private $product;



    public function onLoadDatatableEventHandler() {
        $this->load->model('FeaturesProduct_model');
        $this->load->model('Product_model');

		$this->featuresProduct = $this->FeaturesProduct_model->findAll();
		if($this->featuresProduct) {
			foreach($this->featuresProduct as $featureProduct) {
                $this->product = $this->Product_model->findOne($featureProduct->product_id);
			    $this->productImages = $this->product->productImages();
                if (is_file(DIR_IMAGE . $this->productImages->image)) {
                    $image = $this->resize($this->productImages->image, 40, 40);
                } else {
                    $image = $this->resize('no_image.png', 40, 40);
                }
				$this->rows[] = array(
					'id'			=> $featureProduct->id,
                    'img'		    => $image,
					'name'		    => $this->product->name,
                    'activity_book' => ($featureProduct->activity_book && $featureProduct->activity_book == 'YES') ? 1 : 0,
                    'created_at'    => Carbon::createFromTimeStamp(strtotime($this->product->created_at))->diffForHumans(),
                    'updated_at'    => ($this->product->updated_at) ? Carbon::createFromTimeStamp(strtotime($this->product->updated_at))->diffForHumans() : ''
				);
			}
			$i = 0;
			foreach($this->rows as $row) {
                    $this->selected = ($row['activity_book'] == 'YES') ? 'selected' : '';
                    $this->data[$i][] = '<td class="text-center">
											<label class="css-control css-control-primary css-checkbox">
												<input data-id="'.$row['id'].'" type="checkbox" class="css-control-input selectCheckbox" id="row_'.$row['id'].'" name="row_'.$row['id'].'">
												<span class="css-control-indicator"></span>
											</label>
										</td>';
                    $this->data[$i][] = '<td><img src="'.$row['img'].'"></td>';
					$this->data[$i][] = '<td>'.$row['name'].'</td>';
                    $this->data[$i][] = '<td>
                                            <select data-id="'.$row['id'].'" name="activity_book" class="select floating checkboxStatus">
                                                <option value="YES" '.$this->selected.'>YES</option>
                                                <option value="NO" '.$this->selected.'>NO</option>
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
//        <li><a class="delete" href="javascript:void(0);" data-id="'.$row['id'].'" data-toggle="modal" data-target="#delete_client"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
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

    public function onClickStatusEventHandler(){}
    public function onChangeSetToActivityBook() {
        if($this->isAjaxRequest()) {
            $this->request  = $this->input->post();
            $id             = (isset($this->request['id'])) ? $this->request['id'] : '';
            $activity_book  = (isset($this->request['activity_book'])) ? $this->request['activity_book'] : '';

            FeaturesProduct_model::factory()->update(['activity_book' => $activity_book], $id);

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
        $this->template->javascript->add('assets/js/admin/product/FeaturesProduct.js');

        $this->template->content->view('features_product/index');
        $this->template->publish();
    }

    public function getData() {
        try {

            if (isset($this->error['warning'])) {
                $this->data['error_warning'] = $this->error['warning'];
            } else {
                $this->data['error_warning'] = '';
            }
            if (isset($this->error['product'])) {
                $this->data['error_product'] = $this->error['product'];
            } else {
                $this->data['error_product'] = '';
            }
            // Features Product ID
            if (!empty($this->input->post('featuresProductId'))) {
                $this->data['featuresProductId'] = $this->input->post('featuresProductId');
            } elseif (!empty($this->featuresProduct)) {
                $this->data['featuresProductId'] = $this->featuresProduct->id;
            } else {
                $this->data['featuresProductId'] = '';
            }
            if (!empty($this->input->post('featuresProduct'))) {
                $this->data['featuresProduct'] = $this->input->post('featuresProduct');
            } elseif (!empty($this->featuresProduct)) {
                $this->data['featuresProduct'] = $this->featuresProduct->product_id;
            } else {
                $this->data['featuresProduct'] = array();
            }
            $this->load->model('Product_model');
            $this->data['products'] = $this->Product_model->findAll();
            $this->data['back']         = admin_url('features_product');

            //dd($this->data);
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function create() {
        $this->template->javascript->add('assets/js/jquery.validate.js');
        $this->template->javascript->add('assets/js/additional-methods.js');
        $this->template->javascript->add('assets/js/admin/product/FeaturesProduct.js');

        $this->template->set_template('layout/admin');
        $this->getData();
        //dd($this->data);
        $this->template->content->view('features_product/create', $this->data);
        $this->template->publish();
    }

    public function store() {
        try {
            if ($this->isPost() && $this->validateForm()) {
                $this->load->model('FeaturesProduct_model');
                $this->getData();
                //dd($this->data);
                $this->FeaturesProduct_model->addFeaturesProduct($this->data);
                $this->setMessage('message', "Success: You have modified features product! ");
                $this->redirect(admin_url('features_product/create/'));
            }
            $this->create();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

    }

    public function edit($featuresProductId) {
        try {
            if(!$this->isPost()) {
                $this->load->model('FeaturesProduct_model');
                $this->featuresProduct = FeaturesProduct_model::factory()->findOne($featuresProductId);
            }
            
            if(!$this->featuresProduct) {
                $this->redirect(admin_url('features_product'));
            }
            //$this->dd($this->featuresProduct->id);
            $this->getData();
            //$this->dd($this->data);
            $this->template->javascript->add('assets/js/jquery.validate.js');
            $this->template->javascript->add('assets/js/additional-methods.js');
            $this->template->javascript->add('assets/js/admin/product/FeaturesProduct.js');

            $this->template->set_template('layout/admin');
            $this->template->content->view('features_product/edit', $this->data);
            $this->template->publish();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function update() {
        try {
            $this->lang->load('admin/product');
            if ($this->isPost() && $this->validateForm()) {
               // $this->load->model('Product_model');
                $this->featuresProductId = ($this->input->post('featuresProductId')) ? $this->input->post('featuresProductId') : '';

                $this->getData();

                FeaturesProduct_model::factory()->editFeaturesProduct($this->featuresProductId, $this->data);
                $this->setMessage('message', $this->lang->line('text_success'));

                $this->redirect(admin_url('features_product/edit/'.$this->featuresProductId));
            }
            $this->getData();
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
                $this->load->model('FeaturesProduct_model');
                foreach ($this->selected as $productId) {
                    $this->FeaturesProduct_model->deleteFeaturesProduct($productId);
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
    public function validateForm() {
        if ($this->input->post('featuresProduct') == '') {
            $this->error['featuresProduct'] = "required";
        }
        return !$this->error;
    }

}