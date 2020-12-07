<?php
if(!defined('BASEPATH')) EXIT("No direct script access allowed");
    if ( ! function_exists('dd')) {
        function dd($attr) {
            echo "<pre>";
            print_r($attr);
            die();
        }
    }
    if ( ! function_exists('encrypt')) {
        function encrypt($str, $salt) {
            return sha1($salt . sha1($salt . sha1($str)));
        }
    }
    if ( ! function_exists('decrypt')) {
        function decrypt($str) {
            return base64_decode($str);
        }
    }
    function compress($input, $ascii_offset = 38){
        $input = strtoupper($input);
        $output = '';
        //We can try for a 4:3 (8:6) compression (roughly), 24 bits for 4 chars
        foreach(str_split($input, 4) as $chunk) {
            $chunk = str_pad($chunk, 4, '=');

            $int_24 = 0;
            for($i=0; $i<4; $i++){
                //Shift the output to the left 6 bits
                $int_24 <<= 6;

                //Add the next 6 bits
                //Discard the leading ascii chars, i.e make
                $int_24 |= (ord($chunk[$i]) - $ascii_offset) & 0b111111;
            }

            //Here we take the 4 sets of 6 apart in 3 sets of 8
            for($i=0; $i<3; $i++) {
                $output = pack('C', $int_24) . $output;
                $int_24 >>= 8;
            }
        }

        return $output;
    }
    function decompress($input, $ascii_offset = 38) {
        $output = '';
        foreach(str_split($input, 3) as $chunk) {

            //Reassemble the 24 bit ints from 3 bytes
            $int_24 = 0;
            foreach(unpack('C*', $chunk) as $char) {
                $int_24 <<= 8;
                $int_24 |= $char & 0b11111111;
            }

            //Expand the 24 bits to 4 sets of 6, and take their character values
            for($i = 0; $i < 4; $i++) {
                $output = chr($ascii_offset + ($int_24 & 0b111111)) . $output;
                $int_24 >>= 6;
            }
        }

        //Make lowercase again and trim off the padding.
        return strtolower(rtrim($output, '='));
    }
    if ( ! function_exists('strCompress')) {
        function strCompress($str, $length = 9) {
            return gzencode($str, $length);
        }
    }
    if ( ! function_exists('strUnCompress')) {
        function strUnCompress($str,$length = 9) {
            return gzdecode($str, $length);
        }
    }
    if ( ! function_exists('__token')) {
        function __token() {
           $CI = get_instance();
           $CI->load->library('security');
           return $CI->security->get_csrf_token_name();
        }
    }
    if ( ! function_exists('csrf_token')) {
        function csrf_token() {
           $CI = get_instance();
           $CI->load->library('security');
           return $CI->security->get_csrf_hash();
        }
    }
    if ( ! function_exists('token')) { 
        function token($length = 32) {
            // Create random token
            $string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            $max = strlen($string) - 1;
            $token = '';
            for ($i = 0; $i < $length; $i++) {
                $token .= $string[mt_rand(0, $max)];
            }	
            return $token;
        }
    }
    if ( ! function_exists('admin_url')) {
        function admin_url($uri = '', $protocol = NULL) {
            return get_instance()->config->base_url('admin/'.$uri, $protocol);
        }
    }
    if(!function_exists('isLogged')) {
        function isLogged() {
            $ci = get_instance();
            return ($ci->session->userdata('user_id')) && (int) $ci->session->userdata('user_id') > 0 ? (int) $ci->session->userdata('user_id') : false;
        }
    }
    if(!function_exists('userId')) {
        function userId() {
            $ci = get_instance();
            return (int)$ci->session->userdata('user_id');
        }
    }
    if(!function_exists('userName')) {
        function userName() {
            $ci = get_instance();
            return $ci->session->userdata('user')['firstname']." ".$ci->session->userdata('user')['lastname'];
        }
    }
    if(!function_exists('userEmail')) {
        function userEmail() {
            $ci = get_instance();
            return $ci->session->userdata('user')['email'];
        }
    }
    if ( ! function_exists('url')) {
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
	function url($uri = '', $protocol = NULL) {
		//getLocale(getLocaleId()).'/'.
		return get_instance()->config->site_url($uri, $protocol);
	}
    if(!function_exists('hasSession')) {
        function hasSession($key) {
            $ci = get_instance();
            return ($ci->session->has_userdata($key)) ? true : false;
        }
    }
    if(!function_exists('getSession')) {
        function getSession($key) {
            $ci = get_instance();
            return ($ci->session->userdata($key) && !empty($ci->session->userdata($key))) ? $ci->session->userdata($key) : '';
        }
    }
    if(!function_exists('setSession')) {
        function setSession($key, $value) {
            $ci = get_instance();
            $ci->session->set_userdata($key, $value);
        }
    }
    if(!function_exists('unsetSession')) {
        function unsetSession($key) {
            $ci = get_instance();
            $ci->session->unset_userdata($key);
        }
    }
    if(!function_exists('setMessage')) {
        function setMessage($key, $value) {
            $ci = get_instance();
            $ci->session->set_flashdata($key, $value);
        }
    }
    if(!function_exists('getMessage')) {
        function getMessage($key) {
            $ci = get_instance();
            return ($ci->session->flashdata($key) && !empty($ci->session->flashdata($key))) ? $ci->session->flashdata($key) : '';
        }
    }
        if(!function_exists('setWarning')) {
            function setWarning($key, $value, $options = array()) {
                $ci = get_instance();
                $ci->session->set_flashdata($key, $value);
            }
        }
        if(!function_exists('getWarning')) {
            function getWarning($key) {
                $ci = get_instance();
                return ($ci->session->flashdata($key) && !empty($ci->session->flashdata($key))) ? $ci->session->flashdata($key) : '';
            }
        }
    if(!function_exists('hasMessage')) {
        function hasMessage($key) {
            $ci = get_instance();
            return ($ci->session->flashdata($key)) ? true : false;
        }
    }
    if(!function_exists('pdfThumbnail')) {
        function pdfThumbnail($source, $target) {
            $ci = get_instance();
            $target = dirname($source).DIRECTORY_SEPARATOR.$target;
            $im     = new Imagick($source."[0]"); // 0-first page, 1-second page
            $im->setImageColorspace(255); // prevent image colors from inverting
            $im->setimageformat("jpeg");
            $im->thumbnailimage(160, 120); // width and height
            $im->writeimage($target);
            $im->clear();
            $im->destroy();
        }
    }
    if(!function_exists('getYoutubeIdFromUrl')) {
        function getYoutubeIdFromUrl($url) {
            $parts = parse_url($url);
            if(isset($parts['query'])){
                parse_str($parts['query'], $qs);
                if(isset($qs['v'])){
                    return $qs['v'];
                }else if(isset($qs['vi'])){
                    return $qs['vi'];
                }
            }
            if(isset($parts['path'])){
                $path = explode('/', trim($parts['path'], '/'));
                return $path[count($path)-1];
            }
            return false;
        }
    }
    if(!function_exists('embedUrl')) {
        function embedUrl($url) {
            $parts = parse_url($url);
            if(isset($parts['query'])){
                parse_str($parts['query'], $qs);
                if(isset($qs['v'])){
                    return "https://www.youtube.com/embed/".$qs['v'];
                }else if(isset($qs['vi'])){
                    return "https://www.youtube.com/embed/".$qs['vi'];
                }
            }
            if(isset($parts['path'])){
                $path = explode('/', trim($parts['path'], '/'));
                return "https://www.youtube.com/embed/".$path[count($path)-1];
            }
            return false;
        }
    }


}
if(!function_exists('encodeUrl')) {
    function encodeUrl($string) {
        return urlencode(utf8_encode($string));
    }
}
if(!function_exists('decodeUrl')) {
    function decodeUrl($string) {
        return utf8_decode(urldecode($string));
    }
}
if(!function_exists('resize')) {
    function resize($filename, $width, $height) {
        $ci = get_instance();
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

                $ci->image->setFile(DIR_IMAGE . $image_old);
                $ci->image->resize($width, $height);
                $ci->image->save(DIR_IMAGE . $image_new);
            } else {
                copy(DIR_IMAGE . $image_old, DIR_IMAGE . $image_new);
            }
        }

        if ($ci->input->server('HTTPS')) {
            return url() . 'image/' . $image_new;
        } else {
            return url() . 'image/' . $image_new;
        }
    }
}

if(!function_exists('resizeAssetImage')) {
    function resizeAssetImage($filename, $width, $height) {
        $ci = get_instance();

        if (!is_file(DIR_ASSETS_IMAGE . $filename) || substr(str_replace('\\', '/', realpath(DIR_ASSETS_IMAGE . $filename)), 0, strlen(DIR_ASSETS_IMAGE)) != str_replace('\\', '/', DIR_ASSETS_IMAGE)) {
            return;
        }
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $image_old = $filename;
        $image_new = 'cache/' . substr($filename, 0, strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;

        if (!is_file(DIR_ASSETS_IMAGE . $image_new) || (filemtime(DIR_ASSETS_IMAGE . $image_old) > filemtime(DIR_ASSETS_IMAGE . $image_new))) {
            list($width_orig, $height_orig, $image_type) = getimagesize(DIR_ASSETS_IMAGE . $image_old);

            if (!in_array($image_type, array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF))) {
                return DIR_ASSETS_IMAGE . $image_old;
            }

            $path = '';

            $directories = explode('/', dirname($image_new));

            foreach ($directories as $directory) {
                $path = $path . '/' . $directory;

                if (!is_dir(DIR_ASSETS_IMAGE . $path)) {
                    @mkdir(DIR_ASSETS_IMAGE . $path, 0777);
                }
            }

            if ($width_orig != $width || $height_orig != $height) {

                $ci->image->setFile(DIR_ASSETS_IMAGE . $image_old);
                $ci->image->resize($width, $height);
                $ci->image->save(DIR_ASSETS_IMAGE . $image_new);
            } else {
                copy(DIR_ASSETS_IMAGE . $image_old, DIR_ASSETS_IMAGE . $image_new);
            }
        }

        if ($ci->input->server('HTTPS')) {
            return url() . 'assets/images/' . $image_new;
        } else {
            return url() . 'assets/images/' . $image_new;
        }
    }
}
function makeThumbnail($youTubeLink='',$thumbNailQuality='HIGH',$fileNameWithExt='',$fileDownLoadPath='') {
    $videoIdExploded = explode('?v=', $youTubeLink);

    if ( sizeof($videoIdExploded) == 1)
    {
        $videoIdExploded = explode('&v=', $youTubeLink);

        $videoIdEnd = end($videoIdExploded);

        $removeOtherInVideoIdExploded = explode('&',$videoIdEnd);

        $youTubeVideoId = current($removeOtherInVideoIdExploded);
    }else{
        $videoIdExploded = explode('?v=', $youTubeLink);

        $videoIdEnd = end($videoIdExploded);

        $removeOtherInVideoIdExploded = explode('&',$videoIdEnd);

        $youTubeVideoId = current($removeOtherInVideoIdExploded);
    }

    switch ($thumbNailQuality)
    {
        case 'LOW':
            $imageUrl = 'https://img.youtube.com/vi/'.$youTubeVideoId.'/sddefault.jpg';
            break;

        case 'MEDIUM':
            $imageUrl = 'https://img.youtube.com/vi/'.$youTubeVideoId.'/mqdefault.jpg';
            break;

        case 'HIGH':
            $imageUrl = 'https://img.youtube.com/vi/'.$youTubeVideoId.'/hqdefault.jpg';
            break;

        case 'MAXIMUM':
            $imageUrl = 'https://img.youtube.com/vi/'.$youTubeVideoId.'/maxresdefault.jpg';
            break;
        default:
            return  'Choose The Quality Between [ LOW (or) MEDIUM  (or) HIGH  (or)  MAXIMUM]';
            break;
    }
    return $imageUrl;
//    if( empty($fileNameWithExt) || is_null($fileNameWithExt)  || $fileNameWithExt === '')
//    {
//        $toArray = explode('/',$imageUrl);
//        $fileNameWithExt = md5( time().mt_rand( 1,10 ) ).'.'.substr(strrchr(end($toArray),'.'),1);
//    }
//
//    if (! is_dir($fileDownLoadPath))
//    {
//        mkdir($fileDownLoadPath,0777,true);
//    }
//
//    file_put_contents($fileDownLoadPath.$fileNameWithExt, file_get_contents($imageUrl));
//    return $fileNameWithExt;
}
function getDataPair($data, $key=NULL, $value=NULL)  {
    $arr = array();
    foreach ($data as $item)  {
        if ($key !== NULL)  {
            $arr[$item[$key]] = !is_null($value) ? $item[$value] : $item;
        } else {  $arr[] = !is_null($value) ? $item[$value] : $item;
        }
    }
    return $arr;
}
if(!function_exists('isSubscribe')) {
    function isSubscribe() {
        return getSession('subscribe');
    }
}
if(!function_exists('currencyFormat')) {
    function currencyFormat($number, $currency, $value = '', $format = true) {

        $ci = get_instance();
        $query = $ci->db->query("SELECT * FROM currency");
        foreach ($query->result_array() as $result) {
            $currencies[$result['code']] = array(
                'id'   => $result['id'],
                'name'         => $result['name'],
                'code'         => $result['code'],
                'symbol_left'   => $result['symbol_left'],
                'symbol_right'  => $result['symbol_right'],
                'decimal_place' => $result['decimal_place'],
                'value'         => $result['value']
            );
        }
        $symbol_left = $currencies[$currency]['symbol_left'];
        $symbol_right = $currencies[$currency]['symbol_right'];
        $decimal_place = $currencies[$currency]['decimal_place'];

        if (!$value) {
            $value = $currencies[$currency]['value'];
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

        $string .= number_format($amount, (int)$decimal_place, $ci->config->item('decimal_point'), $ci->config->item('thousand_point'));

        if ($symbol_right) {
            $string .= $symbol_right;
        }

        return $string;
    }
    if(!function_exists('render')) {
        function render($view, $data = null) {
            $ci = get_instance();
            $ci->load->library('template');
            $ci->template->content->view($view, $data);
            $ci->template->publish();
        }
    }
    if(!function_exists('attach')) {
        function attach($str, $type = 'js') {
            $ci = get_instance();
            $ci->load->library('template');
            if($type === 'js') {
                $ci->template->javascript->add($str);
            } else {
                $ci->template->stylesheet->add($str);
            }
        }
    }
    if(!function_exists('getTotalWishListed')) {
        function getTotalWishListed() {
            $ci = get_instance();
            $ci = get_instance();
            return ($ci->session->userdata('totalWishListed')) && (int) $ci->session->userdata('totalWishListed') > 0 ? (int) $ci->session->userdata('totalWishListed') : 0;
        }
    }
}
?>