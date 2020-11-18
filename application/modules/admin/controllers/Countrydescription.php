<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Carbon\Carbon;
use Application\Contracts\CrudContract;

class Countrydescription extends AdminController implements CrudContract {


    private $countryDescription;
    /**
     * @var object
     */
    private $countryDescriptionBlog;
    private $countryDescriptionId;

    public function __construct() {
        parent::__construct();
        $this->lang->load('admin/countrydescription');
        $this->template->set_template('layout/admin');
    }

    public function index() {
        $this->template->stylesheet->add('assets/theme/light/js/datatables/dataTables.bootstrap4.css');
        $this->template->javascript->add('assets/theme/light/js/datatables/jquery.dataTables.min.js');
        $this->template->javascript->add('assets/theme/light/js/datatables/dataTables.bootstrap4.min.js');
        $this->template->javascript->add('assets/js/admin/countrydescription/CountryDescription.js');

        $this->template->content->view('countrydescription/index');
        $this->template->publish();
    }
    public function setData() {

    }
    public function setCountryDescription() {
        // Country Description
        if (isset($this->countryDescription)) {
            $this->data['primaryKey'] = $this->countryDescription->id;
        } else {
            $this->data['primaryKey'] = '';
        }

        if (!empty($this->input->post('country'))) {
            $this->data['countryId'] = $this->input->post('country');
        } elseif (!empty($this->countryDescription)) {
            $this->data['countryId'] = $this->countryDescription->country_id;
        }else {
            $this->data['countryId'] = '';
        }
        if (!empty($this->input->post('title'))) {
            $this->data['title'] = $this->input->post('title');
        } elseif (!empty($this->countryDescription)) {
            $this->data['title'] = $this->countryDescription->title;
        } else {
            $this->data['title'] = '';
        }

        if (!empty($this->input->post('description'))) {
            $this->data['description'] = $this->input->post('description');
        } elseif (!empty($this->countryDescription)) {
            $this->data['description'] = $this->countryDescription->description;
        } else {
            $this->data['description'] = '';
        }
        if (!empty($this->input->post('image'))) {
            $this->data['image'] = $this->input->post('image');
        } elseif (!empty($this->countryDescription)) {
            $this->data['image'] = $this->countryDescription->image;
        } else {
            $this->data['image'] = '';
        }
        if (!empty($this->input->post('image')) && is_file(DIR_IMAGE . $this->input->post('image'))) {
            $this->data['thumb'] = $this->resize($this->input->post('image'), 100, 100);
        } elseif (!empty($this->countryDescription) && is_file(DIR_IMAGE . $this->countryDescription->image)) {
            $this->data['thumb'] = $this->resize($this->countryDescription->image, 100, 100);
        } else {
            $this->data['thumb'] = $this->resize('no_image.png', 100, 100);
        }

        $this->data['placeholder']  = $this->resize('no_image.png', 100, 100);
        $this->data['back']         = admin_url('countrydescription');
        $this->data['countries']    = Country_model::factory()->findAll();

    }


    public function create() {
        $this->template->javascript->add('assets/js/jquery.validate.js');
        $this->template->javascript->add('assets/js/additional-methods.js');
        $this->template->javascript->add('assets/js/admin/countrydescription/CountryDescription.js');
        $this->setCountryDescription();
        $this->template->content->view('countrydescription/create', $this->data);
        $this->template->publish();
    }

    public function store() {
        try {
            if ($this->isPost()) {
                $this->setCountryDescription();
                //dd($this->data);
                CountryDescription_model::factory()->insert([
                    'country_id'        => $this->data['countryId'],
                    'title'             => $this->data['title'],
                    'description'       => $this->data['description'],
                    'image'             => $this->data['image'],
                ]);
                $this->setMessage('message', $this->lang->line('text_success'));
                $this->redirect(admin_url('countrydescription/create/'));
            }
            $this->create();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

    }

    public function edit($id) {
        try {
            $this->countryDescription = CountryDescription_model::factory()->findOne($id);
            if(!$this->countryDescription) {
                $this->setMessage('warning', $this->lang->line('text_notfound'));
                $this->redirect(admin_url('countrydescription'));
            }
            $this->template->javascript->add('assets/js/jquery.validate.js');
            $this->template->javascript->add('assets/js/additional-methods.js');
            $this->template->javascript->add('assets/js/admin/countrydescription/CountryDescription.js');
            $this->setCountryDescription();
            $this->template->content->view('countrydescription/edit', $this->data);
            $this->template->publish();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function update($id) {
        try {
            $this->setCountryDescription();
            if ($this->isPost()) {
                CountryDescription_model::factory()->update([
                    'country_id'        => $this->data['countryId'],
                    'title'             => $this->data['title'],
                    'description'       => $this->data['description'],
                    'image'             => $this->data['image'],
                ], $id);
                $this->setMessage('message', $this->lang->line('text_success'));
                $this->redirect(admin_url('countrydescription/edit/'.$id));
            }
            $this->edit($id);
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

    }

    public function delete() {
        try {
            if($this->isAjaxRequest()) {
                $this->request = $this->input->post();

                if(!empty($this->request['selected']) && isset($this->request['selected'])) {
                    if(array_key_exists('selected', $this->request) && is_array($this->request['selected'])) {
                        $this->selected = $this->request['selected'];
                    }
                }
                if($this->selected) {
                    foreach ($this->selected as $id) {
                        CountryDescription_model::factory()->delete($id);
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
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
    public function onLoadDatatableEventHandler() {

        $this->results = CountryDescription_model::factory()->findAll();
        if($this->results) {
            foreach($this->results as $result) {
                if (is_file(DIR_IMAGE . $result->image)) {
                    $image = $this->resize($result->image, 40, 40);
                } else {
                    $image = $this->resize('no_image.png', 40, 40);
                }
                $this->rows[] = array(
                    'id'			=> $result->id,
                    'country'		=> $result->country->name,
                    'title'		    => $result->title,
                    'countBlogs'    => count($result->blogs),
                    'img'		    => $image,
                    'created_at'    => Carbon::createFromTimeStamp(strtotime($result->created_at))->diffForHumans(),
                    'updated_at'    => ($result->updated_at) ? Carbon::createFromTimeStamp(strtotime($result->updated_at))->diffForHumans() : ''
                );
            }
            $i = 0;
            foreach($this->rows as $row) {

                $this->data[$i][] = '<td class="text-center">
											<label class="css-control css-control-primary css-checkbox">
												<input data-id="'.$row['id'].'" type="checkbox" class="css-control-input selectCheckbox" id="row_'.$row['id'].'" name="row_'.$row['id'].'">
												<span class="css-control-indicator"></span>
											</label>
										</td>';
                $this->data[$i][] = '<td><img src="'.$row['img'].'"></td>';
                $this->data[$i][] = '<td>'.$row['title'].'</td>';
                $this->data[$i][] = '<td>'.$row['country'].'</td>';
                $this->data[$i][] = '<td>'.$row['created_at'].'</td>';
                $this->data[$i][] = '<td>'.$row['updated_at'].'</td>';
                $this->data[$i][] = '<td class="text-right">
	                            <div class="dropdown">
	                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
	                                <ul class="dropdown-menu pull-right">
	                                    <li><a class="edit" href="javascript:void(0);" data-id="'.$row['id'].'" data-toggle="modal" data-target="#edit_client"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
	                                    <li><a class="blog" href="javascript:void(0);" data-id="'.$row['id'].'" data-toggle="modal" data-target="#edit_client"><i class="fab fa-blogger"></i> Blog('.$row['countBlogs'].')</a></li>
	                                    
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

    public function onChangeStatusEventHandler() {
        try {
            if($this->isAjaxRequest()) {
                $this->id       = ($this->input->post('id')) ? $this->input->post('id') : '';
                $this->status   = ($this->input->post('status')) ? $this->input->post('status') : '';
                Quiz_model::factory()->update([
                    'status' => $this->status,
                ], $this->id);
                $this->json['status'] = 'Status has been successfully updated';
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode($this->json));
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

    }
    public function validateForm()
    {
        // TODO: Implement validateForm() method.
        if ((strlen($this->input->post('question')) < 1) || (strlen(trim($this->input->post('question'))) > 255)) {
            $this->error['question'] = $this->lang->line('error_question');
        }

        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->lang->line('error_warning');
        }
        //$this->dd($this->error);
        return !$this->error;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function fetchBlog($id) {
        $this->results = CountryDescriptionBlog_model::factory()->findAll(['country_descriptions_id' => $id]);
        if($this->results) {
            foreach($this->results as $result) {
                if (is_file(DIR_IMAGE . $result->image)) {
                    $image = $this->resize($result->image, 40, 40);
                } else {
                    $image = $this->resize('no_image.png', 40, 40);
                }
                $this->rows[] = array(
                    'id'			=> $result->id,
                    'country_descriptions_id'			=> $result->country_descriptions_id,
                    'title'		    => $result->title,
                    'img'		    => $image,
                    'created_at'    => Carbon::createFromTimeStamp(strtotime($result->created_at))->diffForHumans(),
                    'updated_at'    => ($result->updated_at) ? Carbon::createFromTimeStamp(strtotime($result->updated_at))->diffForHumans() : ''
                );
            }
            $i = 0;
            foreach($this->rows as $row) {

                $this->data[$i][] = '<td class="text-center">
											<label class="css-control css-control-primary css-checkbox">
												<input data-id="'.$row['id'].'" type="checkbox" class="css-control-input selectCheckbox" id="row_'.$row['id'].'" name="row_'.$row['id'].'">
												<span class="css-control-indicator"></span>
											</label>
										</td>';
                $this->data[$i][] = '<td><img src="'.$row['img'].'"></td>';
                $this->data[$i][] = '<td>'.$row['title'].'</td>';
                $this->data[$i][] = '<td>'.$row['created_at'].'</td>';
                $this->data[$i][] = '<td>'.$row['updated_at'].'</td>';
                $this->data[$i][] = '<td class="text-right">

	                            <div class="dropdown">
	                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
	                                <ul class="dropdown-menu pull-right">
	                                    <li><a class="edit" href="javascript:void(0);" data-id="'.$row['id'].'" data-country_descriptions_id="'.$row['country_descriptions_id'].'" data-toggle="modal" data-target="#edit_client"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
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

    /**
     * @param $id
     */
    public function getCountryDescription($id) {
        $this->countryDescriptionId = $id;
        $this->countryDescription   = CountryDescription_model::factory()->findOne($this->countryDescriptionId);
    }

    /**
     *
     */
    public function setCountryDescriptionBlog() {
        // Country Description Blog
        if (isset($this->countryDescriptionBlog)) {
            $this->data['primaryKey'] = $this->countryDescriptionBlog->id;
        } else {
            $this->data['primaryKey'] = '';
        }
        if (!empty($this->input->post('title'))) {
            $this->data['title'] = $this->input->post('title');
        } elseif(!empty($this->countryDescriptionBlog)) {
            $this->data['title'] = $this->countryDescriptionBlog->title;
        } else {
            $this->data['title'] = '';
        }
        if (!empty($this->input->post('title'))) {
            $this->data['slug'] = url_title($this->input->post('title'),'dash', true);
        } elseif (!empty($this->countryDescriptionBlog)) {
            $this->data['slug'] = $this->countryDescriptionBlog->slug;
        } else {
            $this->data['slug'] = url_title($this->input->post('title'),'dash', true);
        }
        if (!empty($this->input->post('smallDescription'))) {
            $this->data['smallDescription'] = $this->input->post('smallDescription');
        } elseif (!empty($this->countryDescriptionBlog)) {
            $this->data['smallDescription'] = $this->countryDescriptionBlog->small_description;
        } else {
            $this->data['smallDescription'] = '';
        }
        if (!empty($this->input->post('description'))) {
            $this->data['description'] = $this->input->post('description');
        } elseif (!empty($this->countryDescriptionBlog)) {
            $this->data['description'] = $this->countryDescriptionBlog->description;
        } else {
            $this->data['description'] = '';
        }
        if (!empty($this->input->post('image'))) {
            $this->data['image'] = $this->input->post('image');
        } elseif (!empty($this->countryDescriptionBlog)) {
            $this->data['image'] = $this->countryDescriptionBlog->image;
        } else {
            $this->data['image'] = '';
        }

        if (!empty($this->input->post('image')) && is_file(DIR_IMAGE . $this->input->post('image'))) {
            $this->data['thumb'] = $this->resize($this->input->post('image'), 100, 100);
        } elseif (!empty($this->countryDescriptionBlog) && is_file(DIR_IMAGE . $this->countryDescriptionBlog->image)) {
            $this->data['thumb'] = $this->resize($this->countryDescriptionBlog->image, 100, 100);
        } else {
            $this->data['thumb'] = $this->resize('no_image.png', 100, 100);
        }

        // Images
        if (!empty($this->input->post('images'))) {
            $blogImages = $this->input->post('images');

        } elseif (!empty($this->countryDescriptionBlog)) {

            $blogImages = $this->countryDescriptionBlog->images($this->countryDescriptionBlog->id);
            //dd($blogImages);
            //dd($blogImages);

        } else {
            $blogImages = array();
        }

        $this->data['images'] = array();

        foreach ($blogImages as $blogImage) {
            if (is_file(DIR_IMAGE . $blogImage['image'])) {
                $image = $blogImage['image'];
                $thumb = $blogImage['image'];
            } else {
                $image = '';
                $thumb = 'no_image.png';
            }

            $this->data['images'][] = array(
                'image'      => $image,
                'thumb'      => resize($thumb, 100, 100),
                'video'      => $blogImage['video'],
                'sort_order' => $blogImage['sort_order'],
            );
        }
        //dd($this->data['images']);
        $this->data['placeholder'] = resize('no_image.png', 100, 100);


        $this->data['countryDescUrl']    = '';
        $this->data['createUrl']    = '';
        $this->data['saveUrl']      = '';


    }

    /**
     * @param $countryDescriptionId
     */
    public function blog($countryDescriptionId) {
        $this->getCountryDescription($countryDescriptionId);
        if($this->countryDescription) {
            $this->data['countryDescUrl']       = admin_url('countrydescription');
            $this->data['fetchBlogUrl']         = admin_url('countrydescription/fetchBlog/'.$this->countryDescriptionId);
            $this->data['editBlogUrl']          = admin_url('countrydescription/editblog/');
            $this->data['createBlogUrl']        = admin_url('countrydescription/createblog/'.$this->countryDescriptionId);
            $this->data['saveBlogUrl']          = admin_url('countrydescription/storeblog/'.$this->countryDescriptionId);
            $this->data['backBlogUrl']          = admin_url('countrydescription/blog/'.$this->countryDescriptionId);
        }
        if(!$this->countryDescription) {
            $this->redirect($this->data['countryDescUrl']);
        }
        $this->template->stylesheet->add('assets/theme/light/js/datatables/dataTables.bootstrap4.css');
        $this->template->javascript->add('assets/theme/light/js/datatables/jquery.dataTables.min.js');
        $this->template->javascript->add('assets/theme/light/js/datatables/dataTables.bootstrap4.min.js');
        $this->template->javascript->add('assets/js/admin/countrydescription/Blog.js');

        $this->template->content->view('countrydescription/blog/index', $this->data);
        $this->template->publish();
    }

    /**
     * @param $countryDescriptionId
     */
    public function createBlog($countryDescriptionId) {
        $this->getCountryDescription($countryDescriptionId);
        if($this->countryDescription) {
            $this->data['saveBlogUrl']          = admin_url('countrydescription/storeblog/'.$this->countryDescriptionId);
            $this->data['backBlogUrl']          = admin_url('countrydescription/blog/'.$this->countryDescriptionId);
        }
        $this->setCountryDescriptionBlog();

        if(!$this->countryDescription) {
            $this->redirect($this->data['countryDescUrl']);
        }
        $this->template->javascript->add('assets/js/jquery.validate.js');
        $this->template->javascript->add('assets/js/additional-methods.js');
        $this->template->javascript->add('assets/js/admin/countrydescription/Blog.js');
       // dd($this->data);
        $this->template->content->view('countrydescription/blog/create', $this->data);
        $this->template->publish();
    }

    /**
     * @param $countryDescriptionId
     */
    public function storeBlog($countryDescriptionId) {
        try {
            if ($this->isPost()) {
                $this->getCountryDescription($countryDescriptionId);
                $this->setCountryDescriptionBlog();
                CountryDescriptionBlog_model::factory()->insert([
                    'country_descriptions_id '  => $this->countryDescriptionId,
                    'title'                     => $this->data['title'],
                    'slug'                      => $this->data['slug'],
                    'description'               => $this->data['description'],
                    'small_description'         => $this->data['smallDescription'],
                ]);
                $this->setId(CountryDescriptionBlog_model::factory()->getLastInsertID());
                if(isset($this->data['image'])) {
                    CountryDescriptionBlog_model::factory()->update([
                        'image'         => $this->data['image'],
                    ], $this->id);
                }
                if(isset($this->data['images'])) {
                    foreach ($this->data['images'] as $image) {
                        CountryDescriptionBlogImage_model::factory()->update([
                            'country_descriptions_blogs_id' => $this->id,
                            'image'         => $image['image'],
                            'video'         => $image['video'],
                            'sort_order'    => $image['sort_order'],
                        ], $this->id);
                    }
                }
                $this->setMessage('message', $this->lang->line('text_success'));
                $this->data['createBlogUrl']        = admin_url('countrydescription/createblog/'.$this->countryDescriptionId);
                $this->redirect($this->data['createBlogUrl']);
            }
            $this->createBlog($this->countryDescription->id);
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

    }

    public function editBlog($id, $countryDescriptionId) {
        try {
            $this->getCountryDescription($countryDescriptionId);
            $this->countryDescriptionBlog = CountryDescriptionBlog_model::factory()->findOne($id);
            $this->setCountryDescriptionBlog();
            $this->template->javascript->add('assets/js/jquery.validate.js');
            $this->template->javascript->add('assets/js/additional-methods.js');
            $this->template->javascript->add('assets/js/admin/countrydescription/Blog.js');

            $this->data['backBlogUrl']          = admin_url('countrydescription/blog/'.$this->countryDescriptionId);
            $this->data['updateBlogUrl']          = admin_url('countrydescription/updateblog/'.$id.'/'.$this->countryDescriptionId);

            $this->template->content->view('countrydescription/blog/edit', $this->data);
            $this->template->publish();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function updateBlog($id, $countryDescriptionId) {
        try {
            $this->getCountryDescription($countryDescriptionId);
            $this->data['backBlogUrl'] = admin_url('countrydescription/blog/'.$this->countryDescriptionId);
            $this->data['editBlogUrl'] = admin_url('countrydescription/editblog/'.$id.'/'.$this->countryDescriptionId);
            $this->setCountryDescriptionBlog();
            if ($this->isPost()) {
                CountryDescriptionBlog_model::factory()->update([
                    'country_descriptions_id '  => $this->countryDescriptionId,
                    'title'                     => $this->data['title'],
                    'slug'                      => $this->data['slug'],
                    'description'               => $this->data['description'],
                    'small_description'         => $this->data['smallDescription'],
                ], $id);

                if(isset($this->data['image'])) {
                    CountryDescriptionBlog_model::factory()->update([
                        'image'         => $this->data['image'],
                    ], $id);
                }
                CountryDescriptionBlogImage_model::factory()->delete(['country_descriptions_blogs_id' => $id], true);
                if(isset($this->data['images'])) {
                    //dd($this->data['images']);
                    foreach ($this->data['images'] as $image) {
                        CountryDescriptionBlogImage_model::factory()->insert([
                            'country_descriptions_blogs_id' => $id,
                            'image'         => $image['image'],
                            'video'         => $image['video'],
                            'sort_order'    => $image['sort_order'],
                        ]);
                    }
                }
                $this->setMessage('message', $this->lang->line('text_success'));
                $this->redirect($this->data['editBlogUrl']);
            }
            $this->editBlog($id, $countryDescriptionId);
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

    }

    public function deleteBlog() {
        try {
            if($this->isAjaxRequest()) {
                $this->request = $this->input->post();

                if(!empty($this->request['selected']) && isset($this->request['selected'])) {
                    if(array_key_exists('selected', $this->request) && is_array($this->request['selected'])) {
                        $this->selected = $this->request['selected'];
                    }
                }
                if($this->selected) {
                    foreach ($this->selected as $id) {
                        CountryDescriptionBlog_model::factory()->delete($id);
                        CountryDescriptionBlogImage_model::factory()->delete(['country_descriptions_blogs_id' => $id]);
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
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
}