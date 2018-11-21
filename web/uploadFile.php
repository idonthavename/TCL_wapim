<?php
error_reporting(E_ERROR);

require_once "../vendor/autoload.php";
use Medoo\Medoo;
$medoo = new Medoo([
    'database_type' => 'mysql',
    'database_name' => 'wap',
    'server' => '10.68.4.139',
    'username' => 'root',
    'password' => 'rooT@41!39',
    'charset' => 'utf8',
]);
if (isset($_POST['phone']) && !empty($_POST['phone'])) $medoo->insert('upload',['phone'=>$_POST['phone'],'content'=>'上传图片/视频','file'=>json_encode($_FILES['file']),'dateline'=>date('Y-m-d H:i:s')]);

header('Access-Control-Allow-Origin:*');
function echo_json_response($status,$msg = '',$data = []){
    die(json_encode(['status'=>$status, 'msg'=>$msg, 'data'=>$data]));
}
if ($_POST){
    $timestamp = strip_tags(trim($_GET['timestamp']));
    $signature = strip_tags(trim($_GET['signature']));
    if (md5('wapIm2017'.$timestamp) <> $signature) echo_json_response(-100,'sign validate fail');

    $_FILES["file"]["name"] = iconv("UTF-8", "gb2312", $_FILES["file"]["name"]);
    $upfile = $_FILES["file"];

    if (!$_FILES["file"]) echo_json_response(-100,'请上传文件');

    $allowedPhotoExt = ["gif", "jpeg", "jpg", "png"];
    $allowedVideoExt = ["flv","wmv","rmvb","avi","mp4","mkv","mov"];
    $temp = explode(".", $upfile["name"]);
    $extension = strtolower(end($temp));        // 获取文件后缀名
    //file_put_contents('a.txt',var_export($_FILES["file"],true));
    if (!in_array($extension, array_merge($allowedPhotoExt,$allowedVideoExt))) echo_json_response(-100,'文件后缀不符合要求');

    if (in_array($extension,$allowedVideoExt)){
        if ($upfile['size'] > 8192000 || $upfile['size'] < 1) echo_json_response(-100,'请上传符合大小的图片或视屏');    //视屏不超过8M
    }else{
        if ($upfile['size'] > 10240000 || $upfile['size'] < 1) echo_json_response(-100,'请上传符合大小的图片或视屏');    //图片不超过10M
    }
    $path = DIRECTORY_SEPARATOR.'webchat_upload_imgs'.DIRECTORY_SEPARATOR.'wap'.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').DIRECTORY_SEPARATOR.date('d').DIRECTORY_SEPARATOR;

    $localpath = dirname(__FILE__).$path;

    $filename = md5(time()).mt_rand(11111,999999);

    $filetype = '.'.$extension;

    if (!file_exists(dirname(__FILE__).$path)){
        mkdir($localpath, 0777, true);
    }

    $isLocalUpLoad = move_uploaded_file($upfile['tmp_name'], $localpath.$filename.$filetype);
    if (!$isLocalUpLoad) echo_json_response(-100,'本地文件上传失败');

    //等比压缩图片  start
    if (in_array($extension,$allowedPhotoExt)){
        require_once dirname(__FILE__).'/lib/resizeImage.class.php';
        $image = new resizeImage($localpath.$filename.$filetype);
        $image->percent = '0.8';     //1为原图   设置0.1~1
        $image->openImage();
        $image->thumpImage();
        $image->saveImage($localpath.$filename,$filetype);
    }
    //等比压缩图片  end

    require_once dirname(__FILE__).'/lib/ftpUpload.class.php';

    //测试
    //$ftpUploadClass = new ftpUpload('10.4.62.41',21,'administrator','Ky6241');
    //正式
    $ftpUploadClass = new ftpUpload('10.4.28.64',21,'ftp','Koyoo2864');

    $upload = $ftpUploadClass->up_file($localpath.$filename.$filetype ,$path.$filename.$filetype,true);

    if ($upload) {
        $thumbnail = '';
        //unlink($localpath.$filename.$filetype);
        //判断是否视频生成缩略图
        if (in_array($extension,$allowedVideoExt)){


            $movie = new ffmpeg_movie($localpath.$filename.$filetype);
            $width=$movie->getFrameWidth();
            $height=$movie->getFrameHeight();
            $count= $movie->getFrameCount();
            $host = 'http://113.106.207.11/web'.$path;

            $img = $localpath.$filename.'-video.jpg';

            $ff_frame = $movie->getFrame(2);
            $gd_image = $ff_frame->toGDImage();
            imagejpeg($gd_image, $img);
            imagedestroy($gd_image);

            require_once 'lib/imagemaker.class.php';
            $imagemaker = new imagemaker();
            $imagemaker->imagecropper($img,$width-2,$height);
            if (!file_exists($img)) echo_json_response(-100,'省略图生成失败');

            $thumbnail = $host.$filename.'-video.jpg';
        }
        echo_json_response(100,'上传成功',['url'=>str_replace('\\','/',$path.$filename.$filetype),'fileExt'=>in_array($extension,$allowedPhotoExt) ? 'postPhoto' : 'postVideo', 'thumbnail'=>$thumbnail]);
    }else{
        echo_json_response(-100,'远程文件上传失败');
    }

    $ftpUploadClass->close();
}else{
    echo_json_response(-100,'请上传文件');
}