<?php
global $settings;
$header_css = array();
$footer_js = array();

$settings = $container->get('settings');
function add_css($file = '')
{
    $str = '';
    global $header_css;
    if (empty($file)) {
        return;
    }
    if (is_array($file)) {
        if (!is_array($file) && count($file) <= 0) {
            return;
        }
        foreach ($file AS $item) {
            $header_css[] = $item;
        }
    } else {
        $str = $file;
        $header_css[] = $str;
    }
}

function add_js($file = '')
{
    $str = '';
    global $footer_js;
    if (empty($file)) {
        return;
    }
    if (is_array($file)) {
        if (!is_array($file) && count($file) <= 0) {
            return;
        }
        foreach ($file AS $item) {
            $footer_js[] = $item;
        }
    } else {
        $str = $file;
        $footer_js[] = $str;
    }
}

function base_url($seg = "")
{
    global $container;
    return $container["settings"]["url"] . trim($seg, "/");
}
function base_api_url($seg = "")
{
    global $container;
    return $container["settings"]["url_api"] . trim($seg, "/");
}
function put_headers()
{
    $str = '';
    global $header_css;
    foreach ($header_css AS $item) {
        $str .= '<link rel="stylesheet" href="' . $item . '?css=' . date("d") . '" type="text/css" />' . "\n";
    }
    return $str;
}

function put_footers()
{
    $str = '';
    global $footer_js;
    foreach ($footer_js AS $item) {
        $str .= '<script src="' . $item . '?js=' . date("d") . '"></script>' . "\n";
    }
    return $str;
}

function ar_remote_post($url,$data,$header =[]){

    global $settings;

    $ch = curl_init();
    $fp = fopen(dirname(__FILE__).'/errorlog.txt', 'w');
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_STDERR, $fp);
    curl_setopt($ch, CURLOPT_POSTFIELDS,
          http_build_query($data));

// Receive server response ...
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec($ch);

    curl_close ($ch);


    return json_decode($server_output);
}

function ar_remote_get($url,$data,$header =[]){

    global $settings;

    $ch = curl_init();
    $fp = fopen(dirname(__FILE__).'/errorlog.txt', 'w');
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_STDERR, $fp);
    curl_setopt($ch, CURLOPT_POSTFIELDS,
        http_build_query($data));

// Receive server response ...
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec($ch);

    curl_close ($ch);


    return json_decode($server_output);
}

function isLoggedIn()
{
    global $new_request;
    if (isset($new_request)) {
        $header_uid = $new_request->getAttribute("uid");
    }
    if (isset($header_uid)) {
        return $header_uid;
    } elseif (isset($_SESSION['user_id'])) {
        return $_SESSION['user_id'];
    } else {
        return false;
    }
}
function fa_number_format($int_value)
{
    if (is_numeric($int_value)) {
        return tr_num(number_format($int_value), "fa");
    }
    return $int_value;
}

function checkArCodeIsValid($code)
{
    $code = trim(strtoupper($code), "-");
    if (!empty($code) && preg_match("/-/", $code) && strlen($code) > 4) {
        $splitted = preg_split('/-/', $code);
        if (is_numeric(end($splitted))) {
            $vCode = (int)end($splitted);
            if ($vCode >= 0 AND $vCode <= 99) {
                $sumSegments = 0;
                $j = 1;
                for ($i = 0; $i < count($splitted) - 1; $i++) {
                    $splittedChars = str_split($splitted[$i]);
                    foreach ($splittedChars as $char) {
                        $sumSegments += ord($char) * $j;
                    }
                    $j++;
                }
                if ($vCode == $sumSegments % 100) {
                    return true;
                }
            }
        }
    }
    return false;
}

function addArValidSeg($code)
{
    $code = trim(strtoupper($code), "-");
    if (!empty($code) && preg_match("/-/", $code) && strlen($code) > 2) {
        $splitted = preg_split('/-/', $code);
        $sumSegments = 0;
        $j = 1;
        for ($i = 0; $i < count($splitted); $i++) {
            $splittedChars = str_split($splitted[$i]);
            foreach ($splittedChars as $char) {
                $sumSegments += ord($char) * $j;
            }
            $j++;
        }
        $vCode = $sumSegments % 100;
        if ($vCode < 10) {
            $vCode = '0' . $vCode;
        }
        return $code . '-' . $vCode;
    }
}

function removeArValidSeg($code)
{
    $outStr = '';
    $code = trim(strtoupper($code), "-");
    if (!empty($code) && preg_match("/-/", $code) && strlen($code) > 4) {
        $splitted = preg_split('/-/', $code);

        for ($i = 0; $i < count($splitted) - 1; $i++) {
            $outStr .= $splitted[$i] . '-';
        }
    }
    return trim($outStr, '-');
}

function getParcelOutStatus($status)
{
    $str = '';
    switch ($status) {
        case 'before_pay':
            $str = 'در انتظار پرداخت';
            break;
        case 'paid':
            $str = 'پرداخت شده';
            break;
        case 'set-place':
            $str = 'انتصاب جستارش';
            break;
        case 'aggregation':
            $str = 'تجمیع شده';
            break;
        case 'sending-api':
            $str = 'ارسال به سامانه حمل و نقل';
            break;
        case 'posted-api':
            $str = 'در انتظار پاسخ سامانه حمل و نقل';
            break;
        case 'address-print':
            $str = 'چاپ آدرس';
            break;
        case 'exit-repo':
            $str = 'خروج از انبار';
            break;
        case 'delivered':
            $str = 'تحویل شده';
            break;
    }
    return $str;
}

function getCountryLocations($country_id)
{
    $country_meta = countryMetaById($country_id);
    if ($country_meta) {
        $data_phat = $country_meta->data_phat;
        $province_list = file_get_contents(PATH . "/" . $data_phat);
        if ($province_list) {
            $province_list = json_decode($province_list, true);
            return $province_list;
        }

    }
    return array();
}

function countryMetaById($country_id)
{
    $return_country = [];
    $folder = 'assets/locations/';
    $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folder));
    $files = array();
    foreach ($rii as $file) {
        if ($file->isDir()) {
            continue;
        }
        $path_name = $file->getPathname();
        if (strpos($path_name, "meta")) {
            $files[] = $path_name;
        }
    }
    if (!empty($files)) {
        foreach ($files as $file) {
            $meta_data = file_get_contents($file);
            if (!empty($meta_data)) {
                $meta_data = json_decode($meta_data);
                if ($meta_data->id == $country_id) {
                    return $meta_data;
                }
            }
        }
    }
    return false;
}

function getLocationName($id, $location_data = array(), $key = "name")
{
    $search = recursiveFind($location_data, $id, "id");
    if (is_array($search)) {
        return $search["name"] . '-' . $search["name_en"];
    }
    return "";
}