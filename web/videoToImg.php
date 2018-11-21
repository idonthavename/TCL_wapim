<?php
require_once 'lib/imagemaker.class.php';
$imagemaker = new imagemaker();
$sourceVideo = trim($_POST['sourceVideo']);
$videoName = trim($_POST['videoName']);
$savePath = trim($_POST['savePath']);
$timestamp = $_GET['timestamp'];
$signature = strip_tags(trim($_GET['signature']));

if ($signature <> sha1(md5($sourceVideo.$videoName.$savePath).$timestamp)) $imagemaker->echo_json_response(-100,'签名验证失败');
if (!$sourceVideo || !$videoName || !$savePath) $imagemaker->echo_json_response(-100,'关键参数不能为空');
$movie = new ffmpeg_movie($sourceVideo);
$width=$movie->getFrameWidth();
$height=$movie->getFrameHeight();
$count= $movie->getFrameCount();
$host = 'http://113.106.207.11/web/webchat_upload_imgs/';

$filename = $videoName;
$img = $savePath.$filename.'-video.jpg';

$ff_frame = $movie->getFrame(2);
$gd_image = $ff_frame->toGDImage();
imagejpeg($gd_image, $img);
imagedestroy($gd_image);

$imagemaker->imagecropper($img,$width-2,$height);

if (file_exists($img)){
    $imagemaker->echo_json_response(100,'省略图已生成',['src'=>$host.$filename]);
}else{
    $imagemaker->echo_json_response(-100,'省略图生成失败');
}