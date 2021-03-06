<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BaseController extends MX_Controller {
    public  $data;
    public  $results;
    public  $json       = array();
    public  $request    = array();
    public  $currencies    = array();
    private $csrfArray;
    public  $options    = array();

    public function __construct() {
         parent::__construct();
         $this->load->library('security');
         $this->csrfArray =  array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
         );
        $this->onLoad();

	}
    public function onLoad() {
        $this->options['currency'] =  $this->currency->getCurrency('USD');
        if($this->ecart->hasProducts()) {
            setSession('total',sprintf('%s item(s) - %s', $this->ecart->countProducts() , $this->currency->format($this->ecart->totals()['total'], $this->options['currency']['code'])));
        } else {
            setSession('total', '0 item(s) - $0.00');
        }

    }
    public  function __token() {
        return (isset($this->csrfArray['name'])) ? $this->csrfArray['name'] : '';
    }
    public	function csrf_token() {
        return (isset($this->csrfArray['hash'])) ? $this->csrfArray['hash'] : '';
    }
    public function isSubscribed() {
        if($this->hasSession('subscribe')) {
            return true;
        }
        return false;
    }
//    public function clear() {
//        $this->ecart->clear();
//    }
    protected function dd($attr) {
        echo "<pre>";
        print_r($attr);
        die();
    }
    protected function isAjaxRequest() {
        if ($this->input->is_ajax_request()) {
            return true;
        }
         return false;
    }
    protected function isPost() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            return true;
        }
        return false;
    }
    protected function xss_clean($data) {
        return $this->security->xss_clean($data);
    }
    protected function get($key){
        if ($this->has($key))
        {
            return $this->input->get($key);
        }
        return false;
    }
    protected function post($key) {
        if ($this->has($key))
        {
            return $this->xss_clean($this->input->post($key));
        }
        return false;
    }
    protected function setCookie($array = array(), $XSSFilter  = TRUE) {
        $this->input->cookie($array, $XSSFilter); // with XSS filter
        return $this;
    }
    protected function has($key)
    {
        return (!empty($key) && $key !== NULL);
    }
    protected function getSession($key)
    {
        return ($this->session->userdata($key)) ? $this->session->userdata($key) : '';
    }
    protected function hasSession($key)
    {
        if($this->getSession($key)) {
            return true;
        }
        return false;
    }
    protected function setSession($key, $value)
    {
        $this->session->set_userdata($key, $value);
        return $this;
    }
    protected function setMessage($key, $value)
    {
        $this->session->set_flashdata($key, $value);
        return $this;
    }
    protected function getMessage($key)
    {
        return ($this->session->flashdata($key)) ? $this->session->flashdata($key) : '';
    }
    protected function unsetSession($key) {
        if($this->hasSession($key)) {
            $this->session->unset_userdata($key);
        }
    }
    public function redirect($uri = '', $method = 'auto', $code = NULL)
	{
		if ( ! preg_match('#^(\w+:)?//#i', $uri))
		{
			$uri = site_url($uri);
		}

		// IIS environment likely? Use 'refresh' for better compatibility
		if ($method === 'auto' && isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS') !== FALSE)
		{
			$method = 'refresh';
		}
		elseif ($method !== 'refresh' && (empty($code) OR ! is_numeric($code)))
		{
			if (isset($_SERVER['SERVER_PROTOCOL'], $_SERVER['REQUEST_METHOD']) && $_SERVER['SERVER_PROTOCOL'] === 'HTTP/1.1')
			{
				$code = ($_SERVER['REQUEST_METHOD'] !== 'GET')
					? 303	// reference: http://en.wikipedia.org/wiki/Post/Redirect/Get
					: 307;
			}
			else
			{
				$code = 302;
			}
		}

		switch ($method)
		{
			case 'refresh':
				header('Refresh:0;url='.$uri);
				break;
			default:
				header('Location: '.$uri, TRUE, $code);
				break;
		}
		exit;
    }

    /**
     * Site URL
     *
     * Create a local URL based on your basepath. Segments can be passed via the
     * first parameter either as a string or an array.
     *
     * @param	string	$uri
     * @param	string	$protocol
     * @return	string
     */
    // public function url($uri = '', $protocol = NULL) {
    //     //getLocale(getLocaleId()).'/'.
    //     return get_instance()->config->site_url($uri, $protocol);
    // }

    public function resize($filename, $width, $height) {
		if (!is_file(DIR_IMAGE . $filename) || substr(str_replace('\\', '/', realpath(DIR_IMAGE . $filename)), 0, strlen(DIR_IMAGE)) != str_replace('\\', '/', DIR_IMAGE)) {
			return;
		}

		$extension = pathinfo($filename, PATHINFO_EXTENSION);

		$image_old = $filename;
		$image_new = 'cache/' . substr($filename, 0, strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;

		if (!is_file(DIR_IMAGE . $image_new) || (filemtime(DIR_IMAGE . $image_old) > filemtime(DIR_IMAGE . $image_new))) {
			list($width_orig, $height_orig, $image_type) = getimagesize(DIR_IMAGE . $image_old);

			if (!in_array($image_type, array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF))) {
				return DIR_IMAGE . $image_old;
			}

			$path = '';

			$directories = explode('/', dirname($image_new));

			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;

				if (!is_dir(DIR_IMAGE . $path)) {
					@mkdir(DIR_IMAGE . $path, 0777);
				}
			}

			if ($width_orig != $width || $height_orig != $height) {

                $this->image->setFile(DIR_IMAGE . $image_old);
				$this->image->resize($width, $height);
				$this->image->save(DIR_IMAGE . $image_new);
			} else {
				copy(DIR_IMAGE . $image_old, DIR_IMAGE . $image_new);
			}
		}

		if ($this->input->server('HTTPS')) {
			return url() . 'image/' . $image_new;
		} else {
			return url() . 'image/' . $image_new;
		}
    }

    /**
	 * Constructor
	 *
	 * @param	string	$header
	 *
 	*/
	public function addHeader($header) {
		$this->headers[] = $header;
	}

	/**
	 *
	 *
	 * @param	string	$url
	 * @param	int		$status
	 *
 	*/
	// public function redirect($url, $status = 302) {
	// 	header('Location: ' . str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $url), true, $status);
	// 	exit();
	// }

	/**
	 *
	 *
	 * @param	int		$level
 	*/
	public function setCompression($level) {
		$this->level = $level;
	}


	/**
	 *
	 *
	 * @param	string	$data
	 * @param	int		$level
	 *
	 * @return	string
 	*/
	private function compress($data, $level = 0) {
		if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false)) {
			$encoding = 'gzip';
		}

		if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'x-gzip') !== false)) {
			$encoding = 'x-gzip';
		}

		if (!isset($encoding) || ($level < -1 || $level > 9)) {
			return $data;
		}

		if (!extension_loaded('zlib') || ini_get('zlib.output_compression')) {
			return $data;
		}

		if (headers_sent()) {
			return $data;
		}

		if (connection_status()) {
			return $data;
		}

		$this->addHeader('Content-Encoding: ' . $encoding);

		return gzencode($data, (int)$level);
	}

	/**
	 *
 	*/

    public function format($number, $currency, $value = '', $format = true) {
        $symbol_left = $this->currencies[$currency]['symbol_left'];
        $symbol_right = $this->currencies[$currency]['symbol_right'];
        $decimal_place = $this->currencies[$currency]['decimal_place'];
        if (!$value) {
            $value = $this->currencies[$currency]['value'];
        }
        $amount = $value ? (float)$number * $value : (float)$number;
        $amount = round($amount, (int)$decimal_place);
        if (!$format) {
            return $amount;
        }
        $string = '';
        if ($symbol_left) {
            $string .= $symbol_left;
        }
        $string .= number_format($amount, (int)$decimal_place, $this->config->item('decimal_point'), $this->config->item('thousand_point'));
        if ($symbol_right) {
            $string .= $symbol_right;
        }
        return $string;
    }

    public function convert($value, $from, $to) {
        if (isset($this->currencies[$from])) {
            $from = $this->currencies[$from]['value'];
        } else {
            $from = 1;
        }

        if (isset($this->currencies[$to])) {
            $to = $this->currencies[$to]['value'];
        } else {
            $to = 1;
        }

        return $value * ($to / $from);
    }

    public function getCurrencyId($currency) {
        if (isset($this->currencies[$currency])) {
            return $this->currencies[$currency]['currency_id'];
        } else {
            return 0;
        }
    }

    public function getSymbolLeft($currency) {
        if (isset($this->currencies[$currency])) {
            return $this->currencies[$currency]['symbol_left'];
        } else {
            return '';
        }
    }

    public function getSymbolRight($currency) {
        if (isset($this->currencies[$currency])) {
            return $this->currencies[$currency]['symbol_right'];
        } else {
            return '';
        }
    }

    public function getDecimalPlace($currency) {
        if (isset($this->currencies[$currency])) {
            return $this->currencies[$currency]['decimal_place'];
        } else {
            return 0;
        }
    }

    public function getValue($currency) {
        if (isset($this->currencies[$currency])) {
            return $this->currencies[$currency]['value'];
        } else {
            return 0;
        }
    }

    public function hasCurrency($currency) {
        return isset($this->currencies[$currency]);
    }

}