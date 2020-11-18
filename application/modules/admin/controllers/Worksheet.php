<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Carbon\Carbon;
class Worksheet extends AdminController {


    private $worksheets;
    /**
     * @var object
     */
    private $worksheet;
    private $worksheetDescription;
    /**
     * @var string[]
     */
    private $filesExt;
    /**
     * @var string[]
     */
    private $filesExt2;
    /**
     * @var string
     */
    private $ext;

    public function __construct() {
        parent::__construct();
        $this->template->set_template('layout/admin');
       // $this->setData();
    }

    public function index() {
        $this->template->stylesheet->add('assets/theme/light/js/datatables/dataTables.bootstrap4.css');
        $this->template->javascript->add('assets/theme/light/js/datatables/jquery.dataTables.min.js');
        $this->template->javascript->add('assets/theme/light/js/datatables/dataTables.bootstrap4.min.js');
        $this->template->javascript->add('assets/js/admin/worksheet/Worksheet.js');

        $this->template->content->view('worksheet/index');
        $this->template->publish();
    }
    public function setData() {
        //Primary Key Id
        if (isset($this->worksheet)) {
            $this->data['id'] = $this->worksheet->id;
        } else {
            $this->data['id'] = '';
        }
        // Title
        if (!empty($this->input->post('title'))) {
            $this->data['title'] = $this->input->post('title');
        } elseif(!empty($this->worksheet)) {
            $this->data['title'] = $this->worksheet->title;
        } else {
            $this->data['title'] = '';
        }
        // Worksheet SortOrder
        if (!empty($this->input->post('sort_order'))) {
            $this->data['sort_order'] = $this->input->post('sort_order');
        } elseif(!empty($this->worksheet)) {
            $this->data['sort_order'] = $this->worksheet->sort_order;
        } else {
            $this->data['sort_order'] = '';
        }
        // Worksheet Description data
        if (!empty($this->input->post('worksheets'))) {
            $this->worksheets = $this->input->post('worksheets');
        } elseif (!empty($this->worksheet)) {
            $this->worksheets = $this->worksheet->worksheets($this->worksheet->id);
        } else {
            $this->worksheets = array();
        }

        $this->data['worksheets'] = array();

        foreach ($this->worksheets as $worksheet) {
            if (is_file(DIR_IMAGE . $worksheet['data'])) {
                $data       = $worksheet['data'];
                $thumb      = $worksheet['data'];

                $name       = str_split(basename($data), 14);
                $fileName   = implode('', $name);

                $this->filesExt = array(
                    'pdf'
                );
                $this->filesExt2 = array(
                    'jpg',
                    'jpeg',
                    'gif',
                    'png',
                );
                $this->ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                if (in_array($this->ext, $this->filesExt)) {
                    $data = $worksheet['data'];
                    $thumb = resize('pdf-placeholder-original.png', 100, 100);
                } else {
                    if (in_array($this->ext, $this->filesExt2)) {
                        $data = $worksheet['data'];
                        $thumb = resize($thumb, 100, 100);
                    }
                }

            } else {
                $data = '';
                $thumb =  resize('pdf-placeholder.png', 100, 100);
            }

            $this->data['worksheets'][] = array(
                'data'          => $data,
                'thumb'         => $thumb,
                'title'         => $worksheet['title'],
                'sort_order'    => $worksheet['sort_order'],
            );
        }
        //dd($this->data['worksheets']);
        $this->data['placeholder'] = $this->resize('pdf-placeholder.png', 100, 100);
        $this->data['back']         = admin_url('worksheet');
    }
    public function create() {
        $this->setData();
        $this->template->javascript->add('assets/js/jquery.validate.js');
        $this->template->javascript->add('assets/js/additional-methods.js');
        $this->template->javascript->add('assets/js/admin/worksheet/Worksheet.js');
        $this->template->content->view('worksheet/create', $this->data);
        $this->template->publish();
    }
    public function store() {
        $this->setData();
        try {
            if ($this->isPost()) {
                Worksheet_model::factory()->insert([
                    'title'      => $this->data['title'],
                    'sort_order' =>  $this->data['sort_order'],
                ]);
                $this->id = Worksheet_model::factory()->getLastInsertID();
                if(isset($this->data['worksheets'])) {
                    foreach ($this->data['worksheets'] as $worksheet) {
                        WorksheetDescription_model::factory()->insert([
                            'worksheet_id'  => $this->id,
                            'title'          => $worksheet['title'],
                            'data'          => $worksheet['data'],
                            'sort_order'    => $worksheet['sort_order'],
                        ]);
                    }
                }
                $this->setMessage('message', 'Worksheet has been successfully modified!');
                $this->redirect(admin_url('worksheet/create'));
            }
            $this->create();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function edit($id) {
        try {
            $this->worksheet = Worksheet_model::factory()->findOne($id);
            $this->setData();
            //dd($this->data);
            if(!$this->worksheet) {
                $this->setMessage('warning', 'Worksheet does not exists!');
                $this->redirect(admin_url('worksheets'));
            }
            $this->template->javascript->add('assets/js/jquery.validate.js');
            $this->template->javascript->add('assets/js/additional-methods.js');
            $this->template->javascript->add('assets/js/admin/worksheet/Worksheet.js');

            $this->template->content->view('worksheet/edit', $this->data);
            $this->template->publish();

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function update($id) {
        $this->setData();
        try {
            if ($this->isPost()) {
                // Insert Worksheet
                Worksheet_model::factory()->update([
                    'title'      => $this->data['title'],
                    'sort_order' =>  $this->data['sort_order'],
                ], $id);
                // Insert Worksheet Description
                WorksheetDescription_model::factory()->delete(['worksheet_id' => $id], true);
                if(isset($this->data['worksheets'])) {
                    foreach ($this->data['worksheets'] as $worksheet) {
                        WorksheetDescription_model::factory()->insert([
                            'worksheet_id'  => $id,
                            'title'          => $worksheet['title'],
                            'data'          => $worksheet['data'],
                            'sort_order'    => $worksheet['sort_order'],
                        ]);
                    }
                }
                $this->setMessage('message', 'Worksheet has been successfully modified!');
                $this->redirect(admin_url('worksheet/edit/'.$id));
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
                        Worksheet_model::factory()->delete($id);
                        WorksheetDescription_model::factory()->delete(['worksheet_id' => $id]);
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
        $this->results = Worksheet_model::factory()->findAll();
        if($this->results) {
            foreach($this->results as $result) {
                $this->rows[] = array(
                    'id'			    => $result->id,
                    'title'		        => $result->title,
                    'sort_order'        => $result->sort_order,
                    'totalWorksheets'   => count($result->totalWorksheets),
                    'created_at'        => Carbon::createFromTimeStamp(strtotime($result->created_at))->diffForHumans(),
                    'updated_at'        => ($result->updated_at) ? Carbon::createFromTimeStamp(strtotime($result->updated_at))->diffForHumans() : ''
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
                $this->data[$i][] = '<td>'.$row['title'].'</td>';
                $this->data[$i][] = '<td>'.$row['sort_order'].'</td>';
                $this->data[$i][] = '<td>'.$row['totalWorksheets'].'</td>';
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
}