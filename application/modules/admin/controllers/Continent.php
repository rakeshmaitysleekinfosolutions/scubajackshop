<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Carbon\Carbon;
use Application\Contracts\CrudContract;

class Continent extends AdminController implements CrudContract {
    /**
     * @var object
     */
    private $continent;

    public function __construct() {
        parent::__construct();
        $this->template->set_template('layout/admin');
    }
    public function onLoadDatatableEventHandler() {
		$this->results = Continent_model::factory()->findAll();
		if($this->results) {
			foreach($this->results as $result) {
			    //dd($result);
			    $flag = strtolower('flags/'.$result->country->iso_code_2).'.png';
                if (is_file(DIR_IMAGE . $flag)) {
                    $image = $this->resize($flag, 40, 40);
                } else {
                    $image = $this->resize('no_image.png', 40, 40);
                }
				$this->rows[] = array(
					'id'			=> $result->id,
                    'img'		    => $image,
					'name'		    => $result->country->name,
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
					$this->data[$i][] = '<td>'.$row['name'].'</td>';
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

    public function onChangeStatusEventHandler(){}


    public function index() {
        $this->template->set_template('layout/admin');

        $this->template->stylesheet->add('assets/theme/light/js/datatables/dataTables.bootstrap4.css');
        $this->template->javascript->add('assets/theme/light/js/datatables/jquery.dataTables.min.js');
        $this->template->javascript->add('assets/theme/light/js/datatables/dataTables.bootstrap4.min.js');
        $this->template->javascript->add('assets/js/admin/continent/Continent.js');

        $this->template->content->view('continent/index');
        $this->template->publish();
    }

    public function setData() {

        if (isset($this->error['continent'])) {
            $this->data['error_continent'] = $this->error['continent'];
        } else {
            $this->data['error_continent'] = '';
        }
        // primaryKey
        if (isset($this->continent)) {
            $this->data['primaryKey'] = $this->continent->id;
        } else {
            $this->data['primaryKey'] = '';
        }
        if (!empty($this->input->post('continents'))) {
            $this->data['continents'] = $this->input->post('continents');
        } elseif (!empty($this->continent)) {
            $this->data['continents'] = $this->continent->country_id;
        } else {
            $this->data['continents'] = array();
        }

        $this->data['countries']    = Country_model::factory()->findAll();
        $this->data['back']         = admin_url('continent');
    }

    public function create() {
        $this->template->javascript->add('assets/js/jquery.validate.js');
        $this->template->javascript->add('assets/js/additional-methods.js');
        $this->template->javascript->add('assets/js/admin/continent/Continent.js');
        $this->setData();
        $this->template->content->view('continent/create', $this->data);
        $this->template->publish();
    }

    public function store() {
        try {
            if ($this->isPost()) {
                $this->setData();
                if (isset($this->data['continents'])) {
                    foreach ($this->data['continents'] as $continent) {
                        Continent_model::factory()->delete(['country_id' => $continent], true);
                        Continent_model::factory()->insert([
                            'country_id' => $continent
                        ]);
                    }
                }
                $this->setMessage('message', "Success: You have modified continent!");
                $this->redirect(admin_url('continent/create/'));
            }
            $this->create();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

    }

    public function edit($id) {
        try {
            $this->id = $id;
            $this->continent = Continent_model::factory()->findOne($this->id);
            if(!$this->continent) {
                //($this->continent);
                $this->redirect(admin_url('continent'));
            }
            $this->template->javascript->add('assets/js/jquery.validate.js');
            $this->template->javascript->add('assets/js/additional-methods.js');
            $this->template->javascript->add('assets/js/admin/continent/Continent.js');
            $this->setData();
            $this->template->content->view('continent/edit', $this->data);
            $this->template->publish();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function update($id) {
        try {
            $this->setData();
            $this->id = $id;
            $this->continent = Continent_model::factory()->findOne($this->id);

            if(!$this->continent) {
                $this->setMessage('warning', $this->lang->line('text_notfound'));

                $this->redirect(admin_url('continent'));
            }
            if ($this->isPost()) {
                if (isset($this->data['continents'])) {
                    foreach ($this->data['continents'] as $continent) {
                        Continent_model::factory()->delete(['country_id' => $continent],true);
                        Continent_model::factory()->insert([
                            'country_id' => $continent
                        ]);
                    }
                }
            }

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
                foreach ($this->selected as $id) {
                    Continent_model::factory()->delete($id);
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
        if ($this->input->post('continents') == '') {
            $this->error['continent'] = "required";
        }
        return !$this->error;
    }

}