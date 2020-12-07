<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Carbon\Carbon;
use Application\Contracts\ProductContract;

class Product extends AdminController implements ProductContract {


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
    /**
     * @var object
     */
    private $product;
    private $categoryProducts;
    private $productImages;
    private $productToVideos;
    private $productPdf;
    private $productVideos;
    private $productDescription;
    /**
     * @var string
     */
    private $productId;
    /**
     * @var mixed|string
     */


    public function onLoadDatatableEventHandler() {
		$this->results = Product_model::factory()->findAll();
		if($this->results) {
			foreach($this->results as $result) {

			    //$this->product = Product_model::factory()->findOne($result->id);
			    //$this->productImages = $this->product->productImages();
               // dd($this->productImages->image);
                if (is_file(DIR_IMAGE . $result->images->image)) {
                    $image = $this->resize($result->images->image, 40, 40);
                } else {
                    $image = $this->resize('no_image.png', 40, 40);
                }


				$this->rows[] = array(
					'id'			=> $result->id,
                    'img'		    => $image,
					'name'		    => $result->name,
					'slug' 		    => $result->slug,
					'category' 		    => $result->categoryByProductId($result->id)['name'],
                    'status' 		=> ($result->status && $result->status == 1) ? 1 : 0,
                    'hasVideo'      => ($result->videos) ? "YES" : "NO",
                    'hasPdf'        => ($result->pdf) ? "YES" : "NO",
                    'hasQuiz'       => ($result->quiz) ? "YES" : "NO",
                    'created_at'    => Carbon::createFromTimeStamp(strtotime($result->created_at))->diffForHumans(),
                    'updated_at'    => ($result->updated_at) ? Carbon::createFromTimeStamp(strtotime($result->updated_at))->diffForHumans() : ''
				);
			}
			$i = 0;
			foreach($this->rows as $row) {
                    $selected = ($row['status'] == 1) ? 'selected' : '';
					$this->data[$i][] = '<td class="text-center">
											<label class="css-control css-control-primary css-checkbox">
												<input data-id="'.$row['id'].'" type="checkbox" class="css-control-input selectCheckbox" id="row_'.$row['id'].'" name="row_'.$row['id'].'">
												<span class="css-control-indicator"></span>
											</label>
										</td>';
                    $this->data[$i][] = '<td><img src="'.$row['img'].'"></td>';
					$this->data[$i][] = '<td>'.$row['name'].'</td>';
					$this->data[$i][] = '<td>'.$row['slug'].'</td>';
					$this->data[$i][] = '<td>'.$row['category'].'</td>';
//					$this->data[$i][] = '<td>
//											<div class="material-switch pull-right">
//											<input data-id="'.$row['id'].'" class="checkboxStatus" name="switch_checkbox" id="chat_module" type="checkbox" value="'.$row['status'].'" '.$checked.'/>
//											<label for="chat_module" class="label-success"></label>
//										</div>
//                                        </td>';
                    $this->data[$i][] = '<td>
                                            <select data-id="'.$row['id'].'" name="status" class="select floating checkboxStatus" id="input-payment-status" >
                                                <option value="0" '.$selected.'>Inactive</option>
                                                <option value="1" '.$selected.'>Active</option>
                                            </select>
                                        </td>';
                    $this->data[$i][] = '<td>'.$row['hasVideo'].'</td>';
                    $this->data[$i][] = '<td>'.$row['hasPdf'].'</td>';
                    $this->data[$i][] = '<td>'.$row['hasQuiz'].'</td>';
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

//            <li><a class="delete" href="#" data-toggle="modal" data-target="#delete_client"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
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
            $this->id       = (isset($this->request['id'])) ? $this->request['id'] : '';
            $this->status   = (isset($this->request['status'])) ? $this->request['status'] : '';

            Product_model::factory()->updateStatus($this->id, $this->status);

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
        $this->template->javascript->add('assets/js/admin/product/Product.js');

		$this->template->content->view('product/index');
		$this->template->publish();
    }

    public function getData() {
        try {

            if (isset($this->error['warning'])) {
                $this->data['error_warning'] = $this->error['warning'];
            } else {
                $this->data['error_warning'] = '';
            }
            // Product Type
            if (isset($this->error['type'])) {
                $this->data['error_type'] = $this->error['type'];
            } else {
                $this->data['error_type'] = '';
            }
            if (isset($this->error['name'])) {
                $this->data['error_name'] = $this->error['name'];
            } else {
                $this->data['error_name'] = '';
            }

            if (isset($this->error['slug'])) {
                $this->data['error_slug'] = $this->error['slug'];
            } else {
                $this->data['error_slug'] = '';
            }
            if (isset($this->error['sort_order'])) {
                $this->data['error_sort_order'] = $this->error['sort_order'];
            } else {
                $this->data['error_sort_order'] = '';
            }

            // Status
            if (isset($this->error['status'])) {
                $this->data['error_status'] = $this->error['status'];
            } else {
                $this->data['error_status'] = '';
            }
            // Category
            if (isset($this->error['category'])) {
                $this->data['error_category'] = $this->error['category'];
            } else {
                $this->data['error_category'] = '';
            }
            // Image
            if (isset($this->error['image'])) {
                $this->data['error_image'] = $this->error['image'];
            } else {
                $this->data['error_image'] = '';
            }
            // Meta data
            if (isset($this->error['meta_title'])) {
                $this->data['error_meta_title'] = $this->error['meta_title'];
            } else {
                $this->data['error_meta_title'] = '';
            }
            // Product ID
            if (isset($this->product)) {
                $this->data['primaryKey'] = $this->product->id;
            } else {
                $this->data['primaryKey'] = '';
            }
            // Category
            if (!empty($this->input->post('category'))) {
                $this->data['categoryProducts'] = $this->input->post('category');
            } elseif (!empty($this->categoryProducts)) {
                //foreach($this->categoryProducts as $categoryProduct) {
                    //dd($categoryProduct);
                    //$this->data['categoryProducts'][] = $categoryProduct->category_id;
                    $this->data['categoryProducts'] = $this->categoryProducts->category_id;
               // }
            } else {
                $this->data['categoryProducts'] = '';
            }
            //dd($this->data['categoryProducts']);
            // Product type
            if (!empty($this->input->post('type'))) {
                $this->data['type'] = $this->input->post('type');
            } elseif (!empty($this->product)) {
                $this->data['type'] = $this->product->type;
            } else {
                $this->data['type'] = '';
            }

            // Name
            if (!empty($this->input->post('name'))) {
                $this->data['name'] = $this->input->post('name');
            } elseif (!empty($this->product)) {
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
            // Sort Order
            if (!empty($this->input->post('sort_order'))) {
                $this->data['sort_order'] = $this->input->post('sort_order');
            } elseif (!empty($this->categoryProducts)) {
                //dd($this->categoryProducts);
                $this->data['sort_order'] = (!empty($this->categoryProducts->sort_order)) ? $this->categoryProducts->sort_order : 0;
            } else {
                $this->data['sort_order'] = 0;
            }
            //dd($this->data);
            // Description
            if (!empty($this->input->post('description'))) {
                $this->data['description'] = $this->input->post('description');
            } elseif (!empty($this->productDescription)) {
                $this->data['description'] = $this->productDescription->description;
            } else {
                $this->data['description'] = '';
            }
            // Quiz
            if (!empty($this->input->post('quiz'))) {
                $this->data['quizId'] = $this->input->post('quiz');
                //$this->dd($this->data);
            } elseif (!empty($this->product)) {
                $this->data['quizId'] = $this->product->quiz_id;
            } else {
                $this->data['quizId'] = '';
            }
            // keywords
            if (!empty($this->input->post('search_keywords'))) {
                $this->data['search_keywords'] = $this->input->post('search_keywords');
            } elseif (!empty($this->product)) {
                $this->data['search_keywords'] = $this->product->search_keywords;
            } else {
                $this->data['search_keywords'] = '';
            }
            // Meta Title
            if (!empty($this->input->post('meta_title'))) {
                $this->data['meta_title'] = $this->input->post('meta_title');
            } elseif (!empty($this->productDescription)) {
                $this->data['meta_title'] = $this->productDescription->meta_title;
            } else {
                $this->data['meta_title'] = '';
            }
            // Meta Description
            if (!empty($this->input->post('meta_description'))) {
                $this->data['meta_description'] = $this->input->post('meta_description');
            } elseif (!empty($this->productDescription)) {
                $this->data['meta_description'] = $this->productDescription->meta_description;
            } else {
                $this->data['meta_description'] = '';
            }
            // Meta keyword
            if (!empty($this->input->post('meta_keyword'))) {
                $this->data['meta_keyword'] = $this->input->post('meta_keyword');
            } elseif (!empty($this->productDescription)) {
                $this->data['meta_keyword'] = $this->productDescription->meta_keyword;
            } else {
                $this->data['meta_keyword'] = '';
            }

            // Status
            if (!empty($this->input->post('status'))) {
                $this->data['status'] = $this->input->post('status');
            } elseif (!empty($this->product)) {
                $this->data['status'] = $this->product->status;
            } else {
                $this->data['status'] = 1;
            }
            // Image
            if (!empty($this->input->post('image'))) {
                $this->data['image'] = $this->input->post('image');
            } elseif (!empty($this->productImages)) {
                $this->data['image'] = $this->productImages->image;
            } else {
                $this->data['image'] = '';
            }

            if (!empty($this->input->post('image')) && is_file(DIR_IMAGE . $this->input->post('image'))) {
                $this->data['thumb'] = $this->resize($this->input->post('image'), 100, 100);
            } elseif (!empty($this->productImages) && is_file(DIR_IMAGE . $this->productImages->image)) {
                $this->data['thumb'] = $this->resize($this->productImages->image, 100, 100);
            } else {
                $this->data['thumb'] = $this->resize('no_image.png', 100, 100);
            }
            // Youtube URL
            if (!empty($this->input->post('youtubeUrl'))) {
                $this->data['youtubeUrl'] = $this->input->post('youtubeUrl');
                $this->data['youtubeThumb'] = makeThumbnail($this->input->post('youtubeUrl'));
            } elseif (!empty($this->productVideos)) {
                $rx = '~
                      ^(?:https?://)?                           
                       (?:www[.])?                              
                       (?:youtube[.]com/watch[?]v=) 
                       ([^&]{11})                               
                        ~x';

                $has_match = preg_match($rx, $this->productVideos->url, $matches);
                if($has_match) {
                    $this->data['youtubeUrl'] = $this->productVideos->url;
                } else {
                    $extractUrl = explode('https://youtu.be/',$this->productVideos->url);
                    $youtubeId = (isset($extractUrl[1])) ? $extractUrl[1] : '';
                    $this->data['youtubeUrl'] = 'https://www.youtube.com/watch?v='.$youtubeId;
                }
                $this->data['youtubeThumb'] = makeThumbnail($this->data['youtubeUrl']);
            } else {
                $this->data['youtubeUrl'] = '';
                $this->data['youtubeThumb'] = '';
            }


            // Youtube URL Thumb
//            if (!empty($this->input->post('youtubeThumb'))) {
//                $this->data['youtubeThumb'] = $this->input->post('youtubeThumb');
//            } elseif (!empty($this->productVideos)) {
//                $this->data['youtubeThumb'] = $this->productVideos->thumb;
//            } else {
//                $this->data['youtubeThumb'] = '';
//            }
            // PDF
            if (!empty($this->input->post('pdf'))) {
                $this->data['pdf'] = $this->input->post('pdf');
            } elseif (!empty($this->productPdf)) {
                $name = str_split(basename($this->productPdf->pdf), 5);
                $this->data['pdfText'] = ($name) ? implode('', $name) : '';
                $this->data['pdf'] = $this->productPdf->pdf;
            } else {
                $this->data['pdf'] = '';
            }
            if (!empty($this->input->post('pdf')) && is_file(DIR_IMAGE . $this->input->post('pdf'))) {
                $this->data['pdf_thumb'] = $this->resize('pdf-placeholder.png', 100, 100);
            } elseif (!empty($this->productPdf) && is_file(DIR_IMAGE . $this->productPdf->pdf)) {
                $ext = strtolower(pathinfo($this->productPdf->pdf, PATHINFO_EXTENSION));
                $extensions = array(
                    'pdf',
                    'ppt',
                    'pptx',
                    'doc',
                    'docx',
                    'xls',
                    'xlsx',
                );

                $this->data['pdf_thumb'] = $this->resize($ext.'-placeholder-original.png', 100, 100);
            } else {
                $this->data['pdf_thumb'] = $this->resize('pdf-placeholder.png', 100, 100);
            }

            $this->data['placeholder']  = $this->resize('no_image.png', 100, 100);
            $this->data['back']         = admin_url('product');

            $this->load->model('Category_model');
            //$this->dd($this->data);
            $this->data['categories'] = $this->Category_model->findAll();
            $this->data['quizzes']      = Quiz_model::factory()->findAll(['status' => 1]);
            $this->data['pdfPlaceHolder'] = $this->resize('pdf-placeholder.png', 100, 100);
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function validateForm() {
        $this->lang->load('admin/product');
		if ((strlen($this->input->post('name')) < 1) || (strlen(trim($this->input->post('name'))) > 255)) {
			$this->error['name'] = $this->lang->line('error_name');
		}
        if ($this->input->post('status') == '') {
            $this->error['status'] = $this->lang->line('error_status');
        }
        if ((strlen($this->input->post('sort_order')) < 1) || is_int($this->input->post('sort_order'))) {
            $this->error['sort_order'] = 'required sort order|support number only';
        }

        // Category
//        echo count($this->input->post('category'));
//        exit;
//        if (empty($this->input->post('category')) && is_array($this->input->post('category')) && count($this->input->post('category')) != 0) {
//            $this->error['category'] = $this->lang->line('error_category');
//        }
        // product type
//        if ($this->input->post('type') == '') {
//            $this->error['type'] = $this->lang->line('error_type');
//        }
        if ((strlen($this->input->post('meta_title')) < 1) || (strlen(trim($this->input->post('meta_title'))) > 255)) {
            $this->error['meta_title'] = $this->lang->line('error_meta_title');
        }
//        if ((strlen($this->input->post('image')) < 1)) {
//            $this->error['image'] = $this->lang->line('error_image');
//        }

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->lang->line('error_warning');
		}
		//dd($this->error);

		return !$this->error;
    }

    public function create() {
        $this->template->javascript->add('assets/js/jquery.validate.js');
        $this->template->javascript->add('assets/js/additional-methods.js');
        $this->template->stylesheet->add('assets/theme/light/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css');
        $this->template->javascript->add('assets/theme/light/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js');
        $this->template->javascript->add('assets/js/admin/product/Product.js');
        $this->template->set_template('layout/admin');
        $this->getData();
        //dd($this->data);
        $this->template->content->view('product/create', $this->data);
        $this->template->publish();
    }

    public function store() {
        try {
            $this->getData();
            if ($this->isPost() && $this->validateForm()) {
                Product_model::factory()->addProduct($this->data);
                $this->setMessage('message', $this->lang->line('text_success'));
                $this->redirect(admin_url('product/create/'));
            }

            $this->create();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function edit($productId) {
        try {
            $this->product = Product_model::factory()->findOne($productId);
            if($this->product) {
                $this->productDescription  = $this->product->productDescription();
                $this->categoryProducts   = $this->product->categoryProducts();
                $this->productImages      = $this->product->productImages();
                $this->productVideos      = $this->product->productVideos();
                $this->productPdf         = $this->product->productPdf();
            }
            if(!$this->product) {
                $this->redirect(admin_url('product'));
            }
            $this->getData();
            //$this->dd($this->data);
            $this->template->javascript->add('assets/js/jquery.validate.js');
            $this->template->javascript->add('assets/js/additional-methods.js');
            $this->template->stylesheet->add('assets/theme/light/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css');
            $this->template->javascript->add('assets/theme/light/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js');
            $this->template->javascript->add('assets/js/admin/product/Product.js');

            $this->template->set_template('layout/admin');
            $this->template->content->view('product/edit', $this->data);
            $this->template->publish();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function update($id) {
        try {
            $this->getData();
            $this->lang->load('admin/product');
            if ($this->isPost() && $this->validateForm()) {
                Product_model::factory()->editProduct($id, $this->data);
                $this->setMessage('message', $this->lang->line('text_success'));
                $this->redirect(admin_url('product/edit/'.$id));
            }

            $this->getData();
            $this->edit($id);
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
                $this->load->model('Product_model');
                foreach ($this->selected as $productId) {
                    $this->Product_model->deleteProduct($productId);
                    FeaturesProduct_model::factory()->delete(['product_id' => $productId], true);
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
    public function addFeaturesProduct() {

    }
    public function features() {
        $this->template->set_template('layout/admin');

        $this->template->stylesheet->add('assets/theme/light/js/datatables/dataTables.bootstrap4.css');
        $this->template->javascript->add('assets/theme/light/js/datatables/jquery.dataTables.min.js');
        $this->template->javascript->add('assets/theme/light/js/datatables/dataTables.bootstrap4.min.js');
        $this->template->javascript->add('assets/js/admin/product/Product.js');

        $this->template->content->view('product/features/index');
        $this->template->publish();
    }
}