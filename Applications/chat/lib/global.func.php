<?php
/**
 *  global.func.php 公共函数库
 *
 * @copyright			(C) 2005-2010 PHPCMS
 * @license				http://www.phpcms.cn/license/
 * @lastmodify			2010-6-1
 */

function httpPost($url, $data, $content_type = 'appliaction/json', $data_type='json', $timeout = 60) {
    $cl = curl_init();
    if (is_array($data)) $data = http_build_query($data);
    if(stripos($url, 'https://') !== FALSE) {
        curl_setopt($cl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($cl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($cl, CURLOPT_SSLVERSION, 1);
    }
    curl_setopt($cl, CURLOPT_URL, $url);
    if (isset($content_type)) $headers[] = 'Content-Type: '.$content_type;
    if ($headers && isset($content_type)) curl_setopt($cl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($cl, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt($cl, CURLOPT_TIMEOUT,$timeout);
    curl_setopt($cl, CURLOPT_POST, true);
    curl_setopt($cl, CURLOPT_POSTFIELDS, $data);
    $content = curl_exec($cl);
    $status = curl_getinfo($cl);
    curl_close($cl);
    if (isset($status['http_code']) && $status['http_code'] == 200) {
        if ($data_type == 'json') {
            $content = json_decode($content,true);
        }
        return $content;
    } else {
        return FALSE;
    }
}