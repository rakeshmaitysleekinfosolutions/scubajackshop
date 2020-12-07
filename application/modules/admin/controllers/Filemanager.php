<?php
class Filemanager extends AdminController {
    /**
     * @var string
     */
    private $folder;
    /**
     * @var string
     */
    private $filename;
    /**
     * @var string[]
     */
    private $filesExt;
    /**
     * @var string
     */
    private $ext;
    /**
     * @var string[]
     */
    private $filesExt2;

    public function index() {
		$this->lang->load('admin/filemanager');

		// Find which protocol to use to pass the full image link back
		if ($this->input->server('HTTPS')) {
			$server = url();
		} else {
			$server = url();
		}

		if ($this->input->get('filter_name')) {
			$filter_name = rtrim(str_replace(array('*', '/', '\\'), '', $this->input->get('filter_name')), '/');
		} else {
			$filter_name = '';
		}

		// Make sure we have the correct directory
		if ($this->input->get('directory')) {
			$directory = rtrim(DIR_IMAGE . 'catalog/' . str_replace('*', '', $this->input->get('directory')), '/');
		} else {
			$directory = DIR_IMAGE . 'catalog';
		}

		if (isset($this->input->get['page'])) {
			$page = $this->input->get['page'];
		} else {
			$page = 1;
		}

		$directories = array();
		$files = array();

		$this->data['images'] = array();

		//$this->load->model('tool/image');

		if (substr(str_replace('\\', '/', realpath($directory) . '/' . $filter_name), 0, strlen(DIR_IMAGE . 'catalog')) == str_replace('\\', '/', DIR_IMAGE . 'catalog')) {
			// Get directories
			$directories = glob($directory . '/' . $filter_name . '*', GLOB_ONLYDIR);

			if (!$directories) {
				$directories = array();
			}


			// Get files
			$files = glob($directory . '/' . $filter_name . '*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF,pdf,ppt,pptx,doc,docx,xls,xlsx}', GLOB_BRACE);

			if (!$files) {
				$files = array();
			}
		}
        //$this->dd($files);
		// Merge directories and files
		$images = array_merge($directories, $files);

		// Get total number of files and directories
		$image_total = count($images);

		// Split the array based on current page number and max number of items per page of 10
		//$images = array_splice($images, ($page - 1) * 16, 16);

		foreach ($images as $image) {

			$name = str_split(basename($image), 14);
            //dd($name);
			if (is_dir($image)) {
				$url = '';

				if ($this->input->get('target')) {
					$url .= '&target=' . $this->input->get('target');
				}

				if ($this->input->get('thumb')) {
					$url .= '&thumb=' . $this->input->get('thumb');
				}
                if ($this->input->get('type')) {
                    $url .= '&type=' . $this->input->get('type');
                }

				$this->data['images'][] = array(
					'thumb' => '',
					'name'  => implode(' ', $name),
					'type'  => 'directory',
					'path'  => substr($image, strlen(DIR_IMAGE)),
					'href'  => admin_url('filemanager?directory=' . urlencode(substr($image, strlen(DIR_IMAGE . 'catalog/'))) . $url)
				);
			} elseif (is_file($image)) {
			    $fileName = implode('', $name);

                $this->filesExt = array(
                    'pdf',
                    'ppt',
                    'pptx',
                    'doc',
                    'docx',
                    'xls',
                    'xlsx',
                );
                $this->filesExt2 = array(
                    'jpg',
                    'jpeg',
                    'gif',
                    'png',
                );
                $this->ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                //$this->dd($this->filesExt);

                if (in_array($this->ext, $this->filesExt)) {

                    if(in_array($this->ext, array('ppt','pptx'))) {
                        $this->data['images'][] = array(
                            'thumb' => $this->resize('ppt-placeholder-original.png', 100, 100),
                            'name'  => implode('', $name),
                            'type'  => 'craft',
                            'originalFileType' => 'ppt',
                            'path'  => substr($image, strlen(DIR_IMAGE)),
                            'href'  => $server . 'image/' . substr($image, strlen(DIR_IMAGE))
                        );
                    }
                    if(in_array($this->ext, array('doc','docx'))) {
                        $this->data['images'][] = array(
                            'thumb' => $this->resize('doc-placeholder-original.png', 100, 100),
                            'name'  => implode('', $name),
                            'type'  => 'craft',
                            'originalFileType' => 'doc',
                            'path'  => substr($image, strlen(DIR_IMAGE)),
                            'href'  => $server . 'image/' . substr($image, strlen(DIR_IMAGE))
                        );
                    }
                    if(in_array($this->ext, array('xls','xlsx'))) {
                        $this->data['images'][] = array(
                            'thumb' => $this->resize('xls-placeholder-original.png', 100, 100),
                            'name'  => implode('', $name),
                            'type'  => 'craft',
                            'originalFileType' => 'xls',
                            'path'  => substr($image, strlen(DIR_IMAGE)),
                            'href'  => $server . 'image/' . substr($image, strlen(DIR_IMAGE))
                        );
                    }
                    $this->data['images'][] = array(
                        'thumb' => $this->resize('pdf-placeholder-original.png', 100, 100),
                        'name'  => implode('', $name),
                        'type'  => 'craft',
                        'originalFileType' => 'pdf',
                        'path'  => substr($image, strlen(DIR_IMAGE)),
                        'href'  => $server . 'image/' . substr($image, strlen(DIR_IMAGE))
                    );
                } else if (in_array($this->ext, $this->filesExt2)) {
                    $this->data['images'][] = array(
                        'thumb' => $this->resize(substr($image, strlen(DIR_IMAGE)), 100, 100),
                        'name'  => implode('', $name),
                        'type'  => 'image',
                        'originalFileType' => 'image',
                        'path'  => substr($image, strlen(DIR_IMAGE)),
                        'href'  => $server . 'image/' . substr($image, strlen(DIR_IMAGE))
                    );
                } else {
                    $this->data['images'][] = array(
                        'thumb' => $this->resize(substr($image, strlen(DIR_IMAGE)), 100, 100),
                        'name'  => implode('', $name),
                        'type'  => 'image',
                        'originalFileType' => 'image',
                        'path'  => substr($image, strlen(DIR_IMAGE)),
                        'href'  => $server . 'image/' . substr($image, strlen(DIR_IMAGE))
                    );
                }


			}
		}

        //$this->dd($this->data['images']);
//        if (in_array($this->ext, $this->filesExt)) {
//            $this->data['isImage'] = false;
//        } else {
//            $this->data['isImage'] = true;
//        }
		if ($this->input->get('directory')) {
			$this->data['directory'] = urlencode($this->input->get('directory'));
		} else {
			$this->data['directory'] = '';
		}

		if ($this->input->get('filter_name')) {
			$this->data['filter_name'] = $this->input->get('filter_name');
		} else {
			$this->data['filter_name'] = '';
		}

		// Return the target ID for the file manager to set the value
		if ($this->input->get('target')) {
			$this->data['target'] = $this->input->get('target');
		} else {
			$this->data['target'] = '';
		}

        if ($this->input->get('type')) {
            $this->data['type'] = $this->input->get('type');
        } else {
            $this->data['type'] = '';
        }

		// Return the thumbnail for the file manager to show a thumbnail
		if ($this->input->get('thumb')) {
			$this->data['thumb'] = $this->input->get('thumb');
		} else {
			$this->data['thumb'] = '';
		}

		// Parent
		$url = '';

		if ($this->input->get('directory')) {
			$pos = strrpos($this->input->get('directory'), '/');

			if ($pos) {
				$url .= '&directory=' . urlencode(substr($this->input->get('directory'), 0, $pos));
			}
		}

		if ($this->input->get('target')) {
			$url .= '&target=' . $this->input->get('target');
		}

		if ($this->input->get('thumb')) {
			$url .= '&thumb=' . $this->input->get('thumb');
		}
        if ($this->input->get('type')) {
            $url .= '&type=' . $this->input->get('type');
        }

		$this->data['parent'] = admin_url('filemanager?'.$url);

		// Refresh
		$url = '';

		if ($this->input->get('directory')) {
			$url .= '&directory=' . urlencode($this->input->get('directory'));
		}

		if ($this->input->get('target')) {
			$url .= '&target=' . $this->input->get('target');
		}

		if ($this->input->get('thumb')) {
			$url .= '&thumb=' . $this->input->get('thumb');
		}
        if ($this->input->get('type')) {
            $url .= '&type=' . $this->input->get('type');
        }

		$this->data['refresh'] = admin_url('filemanager?' . $url);

		$url = '';

		if ($this->input->get('directory')) {
			$url .= '&directory=' . urlencode(html_entity_decode($this->input->get('directory'), ENT_QUOTES, 'UTF-8'));
		}

		if ($this->input->get('filter_name')) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->input->get('filter_name'), ENT_QUOTES, 'UTF-8'));
		}

		if ($this->input->get('target')) {
			$url .= '&target=' . $this->input->get('target');
		}

		if (isset($this->input->get['thumb'])) {
			$url .= '&thumb=' . $this->input->get('thumb');
		}
        
		// $pagination = new Pagination();
		// $pagination->total = $image_total;
		// $pagination->page = $page;
		// $pagination->limit = 16;
		// $pagination->url = $this->url->link('common/filemanager', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		// $this->data['pagination'] = $pagination->render();
        //dd($this->data);
		$this->setOutput($this->load->view('filemanager/index', $this->data));
	}

	public function upload() {
		$this->lang->load('admin/filemanager');

		$this->json = array();

		// Make sure we have the correct directory
		if ($this->input->get('directory')) {
			$directory = rtrim(DIR_IMAGE . 'catalog/' . $this->input->get('directory'), '/');
		} else {
			$directory = DIR_IMAGE . 'catalog';
		}
        if ($this->input->get('type')) {
            $this->data['type'] = $this->input->get('type');
        } else {
            $this->data['type'] = '';
        }
		// Check its a directory
//		if (!is_dir($directory) || substr(str_replace('\\', '/', realpath($directory)), 0, strlen(DIR_IMAGE . 'catalog')) != str_replace('\\', '/', DIR_IMAGE . 'catalog')) {
//			$this->json['error'] = $this->lang->line('error_directory');
//		}

		if (!$this->json) {
			// Check if multiple files are uploaded or just one
			$files = array();

			if (!empty($_FILES['file']['name']) && is_array($_FILES['file']['name'])) {

				foreach (array_keys($_FILES['file']['name']) as $key) {

					$files[] = array(
						'name'     => $_FILES['file']['name'][$key],
						'type'     => $_FILES['file']['type'][$key],
						'tmp_name' => $_FILES['file']['tmp_name'][$key],
						'error'    => $_FILES['file']['error'][$key],
						'size'     => $_FILES['file']['size'][$key]
					);
				}
			} else {
                dd($_FILES['file']);
            }

			foreach ($files as $file) {
				if (is_file($file['tmp_name'])) {
					// Sanitize the filename
					$this->filename = strtolower(trim(basename(html_entity_decode($file['name'], ENT_QUOTES, 'UTF-8'))));

					// Validate the filename length
					if ((strlen($this->filename) < 3) || (strlen($this->filename) > 255)) {
						$this->json['error'] = $this->lang->line('error_filename');
					}

					// Allowed file extension types
					$allowed = array(
						'jpg',
						'jpeg',
						'gif',
						'png',
                        'pdf',
                        'xls',
                        'xlsx',
                        'ppt',
                        'pptx',
                        'doc',
                        'docx'
					);

					if (!in_array(strtolower(substr(strrchr($this->filename, '.'), 1)), $allowed)) {
						$this->json['error'] = $this->lang->line('error_filetype');
					}

					// Allowed file mime types
					$allowed = array(
						'image/jpeg',
						'image/pjpeg',
						'image/png',
						'image/x-png',
						'image/gif',
                        'application/pdf',
                        'doc' => 'application/msword',
                        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'xls' => 'application/vnd.ms-excel',
                        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'ppt' => 'application/vnd.ms-powerpoint',
                        'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
					);

					if (!in_array($file['type'], $allowed)) {
						$this->json['error'] = $this->lang->line('error_filetype');
					}

					// Return any upload error
					if ($file['error'] != UPLOAD_ERR_OK) {
						$this->json['error'] = $this->lang->line('error_upload_' . $file['error']);
					}
				} else {
					$this->json['error'] = $this->lang->line('error_upload');
				}

				if (!$this->json) {
					move_uploaded_file($file['tmp_name'], $directory . '/' . $this->filename);
				}
			}
		}

		if (!$this->json) {
			$this->json['success'] = $this->lang->line('text_uploaded');
		}

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($this->json));
	}

	public function folder() {
		$this->lang->load('admin/filemanager');

		$this->json = array();



		// Make sure we have the correct directory
		if (isset($this->input->get['directory'])) {
			$directory = rtrim(DIR_IMAGE . 'catalog/' . $this->input->get['directory'], '/');
		} else {
			$directory = DIR_IMAGE . 'catalog';
		}

		// Check its a directory
		if (!is_dir($directory) || substr(str_replace('\\', '/', realpath($directory)), 0, strlen(DIR_IMAGE . 'catalog')) != str_replace('\\', '/', DIR_IMAGE . 'catalog')) {
			$this->json['error'] = $this->lang->line('error_directory');
		}

		if ($this->isPost()) {
			// Sanitize the folder name
			$this->folder = basename(html_entity_decode($this->input->post('folder'), ENT_QUOTES, 'UTF-8'));

			// Validate the filename length
			if ((strlen($this->folder) < 3) || (strlen($this->folder) > 128)) {
				$this->json['error'] = $this->lang->line('error_folder');
			}

			// Check if directory already exists or not
			if (is_dir($directory . '/' . $this->folder)) {
				$this->json['error'] = $this->lang->line('error_exists');
			}
		}

		if (!isset($this->json['error'])) {
			mkdir($directory . '/' . $this->folder, 0777);
			chmod($directory . '/' . $this->folder, 0777);

			@touch($directory . '/' . $this->folder . '/' . 'index.html');

			$this->json['success'] = $this->lang->line('text_directory');
		}
        //dd($this->json);
//		$this->addHeader('Content-Type: application/json');
//		$this->setOutput(json_encode($this->json));
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($this->json));
	}

	public function delete() {
		$this->lang->load('admin/filemanager');

		$this->json = array();


		if (!empty($this->input->post('path'))) {
			$paths = $this->input->post('path');
		} else {
			$paths = array();
		}

		// Loop through each path to run validations
		foreach ($paths as $path) {
			// Check path exsists
            //echo substr(str_replace('\\', '/', realpath(DIR_IMAGE . $path)), 0, strlen(DIR_IMAGE . 'catalog'));
            //exit;
			if ($path == DIR_IMAGE . 'catalog' || substr(str_replace('\\', '/', realpath(DIR_IMAGE . $path)), 0, strlen(DIR_IMAGE . 'catalog')) != str_replace('\\', '/', DIR_IMAGE . 'catalog')) {
				$this->json['error'] = $this->lang->line('error_delete');

				break;
			}
		}
        //dd($this->json);
		if (!$this->json) {
			// Loop through each path
			foreach ($paths as $path) {
				$path = rtrim(DIR_IMAGE . $path, '/');

				// If path is just a file delete it
				if (is_file($path)) {
					unlink($path);

				// If path is a directory beging deleting each file and sub folder
				} elseif (is_dir($path)) {
					$files = array();

					// Make path into an array
					$path = array($path);

					// While the path array is still populated keep looping through
					while (count($path) != 0) {
						$next = array_shift($path);

						foreach (glob($next) as $file) {
							// If directory add to path array
							if (is_dir($file)) {
								$path[] = $file . '/*';
							}

							// Add the file to the files to be deleted array
							$files[] = $file;
						}
					}

					// Reverse sort the file array
					rsort($files);

					foreach ($files as $file) {
						// If file just delete
						if (is_file($file)) {
							unlink($file);

						// If directory use the remove directory function
						} elseif (is_dir($file)) {
							rmdir($file);
						}
					}
				}
			}

			$this->json['success'] = $this->lang->line('text_delete');
		}

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($this->json));
	}
}