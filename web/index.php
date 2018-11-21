<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>TCL官方服务</title>
  <!--[if IE]>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <![endif]-->
  <meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport">
  <link rel="stylesheet" href="css/styles.min.css">
  <link rel="stylesheet" href="customDetail/css/styles.min.css">
  <script type="text/javascript" src="js/init.js"></script>
  <link rel="stylesheet" href="emoji/emoji184f03.css">
  <script type="text/javascript" src="js/jQuery.js"></script>
  <script type="text/javascript" src="js/dialog.js"></script>
  <script type="text/javascript" src="js/xback.js"></script>
  <link rel="stylesheet" type="text/css" href="css/progress.css">
  <link rel="stylesheet" type="text/css" href="css/webuploader.css">
  <script type="text/javascript" src="js/webuploader.min.js"></script>
  <script>
    history.pushState('x-back', null, location.href);
    XBack.listen(function(){
      var d = dialog({
        title: '提示',
        content: '亲，离开此页面的话，对话将结束哦',
        okValue: '离开',
        ok: function () {
          history.go(-2);
        },
        cancelValue: '继续',
        cancel: function () {
          history.pushState('x-back', null, location.href);
        }
      });
      d.showModal();
    });
  </script>
</head>
<body>

<div class="customer-chat J-CustomerChat">
  <!-- head start -->
  <div class="chat-head">
    <!--<div class="goback">&#xe621;</div>-->
    <div class="title">在线客服</div>
      <div class="prompt" style="display: none;"><!--当前由客服为您服务--></div>
  </div>
  <!-- @head end -->

  <!-- main start -->
  <div class="chat-main sizing">
    <div class="message">
      <div class="chat-cont">
        <!--<div class="mess-right sizing">
          <div class="user-img"><img src="img/user.jpg"></div>
          <div class="user-mess">
            <p class="user-name">客服</p>
            <div class="mess-cont J-MessCont">
              <span class="video-mask J-Play" data-path="http://10.68.213.60/gateWayWorker/win/web/webchat_upload_imgs/wap/2017/09/27/2ab2627312d62e8d54bdffb4b14a326e595868.mp4"></span>
              <span class="video-play"></span>
              <img id="img" src="http://10.68.213.60/gateWayWorker/win/web/webchat_upload_imgs/screencap4.png" />
            </div>
          </div>
        </div>-->
      </div>
    </div>
  </div>
  <!-- @main end -->


  <!-- footer start -->
  <div class="chat-foot sizing">
    <div class="chat-box">
      <div class="fl">
        <span class="face-icon J-FaceIcon"></span>
      </div>
      <div class="message-box">
        <input type="text" class="sizing J-SendVal" id="msgTxt" value="" />
      </div>
      <div class="fr">
        <!--<span class="add-icon J-AddIcon"><form id="uploadForm" class="J-Form" ><input type="file" class="uploadimg J-UpLoadImg" id="file"/></form></span>-->
        <span class="add-icon J-AddIcon" id="webuploadFile">&nbsp;</span>
        <span class="send-mess J-SendMessage" unselectable="on" onmousedown="return false">发送</span>
      </div>
    </div>
    <div class="hide-icon">
      <div class="hide-box face-icon emotionface J-FaceBox">
      </div>
      <div class="hide-box J-UpLoadBox">
        <!--<div class="hide-item">
          <div>&#xe617;<input type="file" class="uploadimg J-PhotoLoadImg" /></div>
          <p>拍摄</p>
        </div>-->
        <div class="hide-item">
          <div>&#xe614; <form id="uploadForm" ><input type="file" class="uploadimg J-UpLoadImg" id="file"/></form>
          </div>
          <p>相册</p>
        </div>
      </div>

    </div>
  </div>
  <!-- @footer end -->
  <div class="chat-mask J-ChatMask"></div>
  <div class="video-maks J-VideoMask sizing">
    <span class="close J-VideoClose"></span>
    <video id="video" src="" controls="controls" autoplay="autoplay" ></video>
  </div>
</div>
<canvas id="canvas" style="display:none;">Your Broswer don't support html5 canvas</canvas>

<script type="text/javascript" src="js/md5.js" ></script>
<script type="text/javascript">
  $(function(){
    var faceflag = false;
    $('.J-AddIcon').click(function(){
      ShowIconBox();
    });
    $('.J-FaceIcon').click(function(){
      ShowFaceBox();
    });

    $('.J-ChatMask').click(function(){
      faceflag = false;
      $('.J-CustomerChat').removeClass('show-icon');
    });

    $('.J-SendVal').focus(function(){
      faceflag = false;
      $('.J-CustomerChat').removeClass('show-icon');
      $('.message').animate({scrollTop: $(".message")[0].scrollHeight}, 300);
    });

    //展开发送照片栏目
    function ShowIconBox(){
      if ($('.J-CustomerChat').hasClass('show-icon')) {
        faceflag = false;
        $('.J-CustomerChat').removeClass('show-icon');
        setTimeout(function(){
          $('.J-FaceBox').hide();
        },310);
      }
    }
    function ShowFaceBox(){
      if ($('.J-CustomerChat').hasClass('show-icon')) {
        faceflag = false;
        $('.J-CustomerChat').removeClass('show-icon');
        setTimeout(function(){
          $('.J-FaceBox').hide();
        },310);
      } else {
        faceflag = true;
        $('.J-CustomerChat').addClass('show-icon');
        $('.J-FaceBox').show();
      }
    }

    var uploadTimestamp = new Date().getTime();
    var uploadSignature = $.md5('wapIm2017'+uploadTimestamp);

    var uploader = WebUploader.create({

      // 选完文件后，是否自动上传。
      auto: true,

      // swf文件路径
      swf: 'swf/Uploader.swf',

      // 文件接收服务端。
      server: 'http://wap.service.tcl.com/web/uploadFile.php?timestamp='+uploadTimestamp+'&signature='+uploadSignature,

      // 选择文件的按钮。可选。
      // 内部根据当前运行是创建，可能是input元素，也可能是flash.
      pick: '#webuploadFile',

      // 只允许选择图片文件。
      accept: {
        title: 'Images&Video',
        extensions: 'gif,jpg,jpeg,png,GIF,JPG,PNG,mp4,MP4,MOV,mov',
      },

      formData: {phone: $.cookie("phone")},
      fileSizeLimit: 10*1024*1024,                //10M
      multiple: false
    });

    uploader.on( 'beforeFileQueued', function( file ) {
      if (!sendMultimediaOpen) {
        alert('接入后才能上传图片或视屏');
        return false;
      }
      if (isSendingMultimedia) {
        alert('图片或视频还在上传中，请稍后再试');
        return false;
      }
    });

    uploader.on( 'error', function( type ) {
      switch (type){
        case "Q_EXCEED_SIZE_LIMIT":
          alert('上传文件不能超过10M');
          break;
        case "Q_TYPE_DENIED":
          alert('请上传JPG、PNG、GIF、JPEG、MOV、MP4格式文件');
          break;
        default:
          alert("上传出错！请检查后重新上传！错误代码"+type);
      }
    });

    uploader.on('uploadProgress', function( file,percentage ) {
      console.log(percentage);
      uploadDialog.showModal();
      uploadDialog.content('<center>文件上传中，请稍后......</center><div class="progress"><span class="bar" style="width: '+100*percentage+'%;">'+100*percentage+'%</span></div>');
      isSendingMultimedia = true;
    });

    uploader.on( 'uploadSuccess', function( file,response ) {
      if (response.status == 100){
        json.action = response.data.fileExt;
        json.text = response.data.url;
        json.thumbnail = response.data.thumbnail;
        json.name = $.cookie("phone");
        json.sessionid = '<?=session_id();?>';
        json.channel = channel;
        json.specialContent = '';
        ws.send(JSON.stringify(json));
      }else{
        alert(response.msg);
      }
      isSendingMultimedia = false;
    });

    uploader.on( 'uploadError', function( file,reason ) {
      console.log(reason);
    });

    uploader.on( 'uploadComplete', function( file ) {
      uploadDialog.close();
    });

    $('.J-SendVal').focusin(function(){
        setTimeout(function(){
            $('body').scrollTop(1500);
        },150);
    });

    // 点击播放视频
    $(document).on('touchend',".J-Play",function(e){
      e.preventDefault();
      $('.J-VideoMask').show();
      var video = document.getElementById("video");
      video.src = $(this).data('path');
      $(video).css({'display':'flex'});
    });
    $(document).on('touchend',".J-VideoClose",function(e){
      e.preventDefault();
      var video = document.getElementById("video");
      $(video).hide();
      video.src = '';
      $('.J-VideoMask').hide();
    });

      /*
    getVideoImg('http://10.128.90.65:8080/img/tennis.mp4');
    function getVideoImg(url){
      var video = document.getElementById("video");
      var img = document.getElementById("img");
      video.src = url;

      video.addEventListener('canplaythrough',function(){
        video.play();
        var canvas = document.getElementById("canvas"); //document.createElement("canvas");
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
            img.src = canvas.toDataURL("image/png");

      });
    }
    */
  });
</script>
<script type="text/javascript" src="emoji/jquery.qqface.js"></script>
<script type="text/javascript" src="emoji/qqemoji_regex.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js" ></script>
<script>
  var emoji_pic_path = 'emoji/qqemoji/';
  $('.emotionface').qqFace({
    id: 'facebox',
    assign: 'msgTxt',
    path: emoji_pic_path  //表情存放的路径
  });

  kefu = false;
  var messageTime = 0;
  var json = {};
  var validatePhone = false;
  var ws = new WebSocket("ws://wap.service.tcl.com:8384");
  var customName = '客服';
  var sendMultimediaOpen = false;
  var isSendingMultimedia = false;
  var curl = '';
  var channel = 'wapT';//'<?=isset($_GET['channel']) && !empty($_GET['channel']) ? strip_tags(trim($_GET['channel'])) : 'wapT'?>';

  ws.onopen = function(e) {
    console.log("连接成功");
  };

  ws.onmessage = function(e) {
    //console.log(e);
    returnData = JSON.parse(e.data);

    var content = returnData.text;

        if (content){
          if(content == "at_enter_ing"){
            $(".title").text("客服正在输入......");
            return false;
          }else if(content == "at_noenter_ing") {
            $(".title").text("在线客服");
            return false;
          }else if(content.indexOf("客服代表") == 0 && content.indexOf("竭诚为您服务") > 0){   /*获取坐席昵称 */
              customName = content.replace("客服代表","").replace("竭诚为您服务","");
              sendMultimediaOpen = true;
              kefu = false;
              $(".prompt").html('当前由'+customName+'为您服务，<a class="customName-cover" data="customName" href="javascript:;">查看信息>></a>');
              cusurl = 'http://wap.service.tcl.com/web/mediaSys.php?name='+customName+'&type=1';
              $("#msgTxt").attr("placeholder","");
          }else if(content.indexOf("我们的座席目前全忙") > 0){
              var realCustomName = customName == "客服" ? "" : customName;
              $.getJSON("http://wap.service.tcl.com/web/mediaSys.php",{skillid:'skillid',type:"2"},function(re){
                  var result = re.success == true ? re.result : 'null';
                  $(".prompt").show();
                  $(".chat-cont").css("padding-top","2rem")
                  kefu = false;
                  $(".prompt").html('您前面还有 <font color="red">'+result+'</font>位用户，请耐心等候');
                  $("#msgTxt").attr("placeholder","目前处于咨询高峰期，请耐心等待");
              });
          }
          else if(content.indexOf("会话已转接，客服代表") == 0 && content.indexOf("继续为您服务。") > 0){     /*转接重新获取坐席昵称 */
              customName = content.replace("会话已转接，客服代表","").replace("继续为您服务。","");
              $("#customName").text(customName);
              cusurl = 'http://wap.service.tcl.com/web/mediaSys.php?name='+customName+'&type=1';
              kefu = false;
          }else if(content.indexOf("感谢您的评价") > 0 ){
              kefu = true;
          }else if(content.indexOf("中止本次人工服务") > 0 ){
              sendMultimediaOpen = false;
          }
      }


    if (returnData.userType == 'self'){
      sendSelf(returnData.time,returnData.name,returnData.text,returnData.msgType);
    }else if(returnData.userType == 'customer'){
      sendCustomer(returnData.time,customName,returnData.text,returnData.msgType);
    }
  };

  ws.onerror = function (evt) {
    console.log('Error occured: ' + evt.data);
  }

  ws.onclose = function (e) {
    //sendCustomer(getTime(),customName,'对话已结束');
  }

  $(document).ready(function(){
    sendCustomer(getTime(),customName,'尊敬的用户，您好！为便于座席更好地为您提供服务，请输入您的手机号码。');

    if( typeof(window.WebSocket) != "function" ) {
      $('body').html("<h1>Error</h1><h3>Your browser does not support HTML5 Web Sockets. Try Google Chrome instead.</h3><h3>抱歉，请升级或更换高版本浏览器</h3>");
    }

    $(".J-SendMessage").click(function () {
      wapImValidatePhone();
    });

    $("#msgTxt").keydown(function(keyboardEvent){
      if (keyboardEvent.keyCode == 13 && keyboardEvent.ctrlKey){//回车键
        wapImValidatePhone();
      }
    })
  });

  function wapImValidatePhone(){
    json.action = 'sendMessage';
    if (validatePhone == false){
      var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1})|(19[0-9]{1}))+\d{8})$/;
      var text = $("#msgTxt").val();
      console.log(kefu)
      if(!myreg.test(text))
      {
        sendCustomer(getTime(),customName,'您输入的手机号码格式不正确，请重新输入');
        $("#msgTxt").val("");
        return false;
      }else{
        $.cookie("phone", text,{expires:1});
        // $.getJSON("http://10.68.213.60/gateWayWorker/win/web/mediaSys.php",{skillid:'',type:"2"},function(re){
        //   var total = re.success == true ? re.total : 'null';
        //   $(".prompt").show();
        //   $(".prompt").html('您前面还有 <font color="red">'+total+'</font>位用户，请耐心等候');
        // });
        validatePhone = true;
        kefu = true;
        json.action = 'validatePhone';
      }
    }
    if(kefu == true){
      number = $("#msgTxt").val();
      pdkefu(number);
      /*if(number == 1){
        ivr();
      }else if(number == 2){
        ivr();
      }else if(number == 3){
        ivr();
      }else if(number == 4){
        ivr();
      }else if(number == 5){
        ivr();
      }else if(number == 6){
        ivr();
      }else if(number == 7){
        ivr();
      }else if(number == 8){
        ivr();
      }else if(number == 9){
        ivr();
      }else if(number == 10){
        ivr();
      }else if(number == 11){
        ivr();
      }else if(number == 12){
        ivr();
      }else if(number == 13){
        ivr();
      }*/
    }

    if ($("#msgTxt").val() == '' || $("#msgTxt").val() == null){
      // $("#msgTxt").focus();
      return false;
    }
    json.text = $("#msgTxt").val();
    json.name = $.cookie("phone");
    json.sessionid = '<?=session_id();?>';
    json.channel = channel;
    json.specialContent = '';
    $("#msgTxt").val("");
    ws.send(JSON.stringify(json));
    return false;
    function pdkefu(number){
      $.getJSON("http://wap.service.tcl.com/web/mediaSys.php?type=2",{skillid:number,type:"2"},function(re){
        var result = re.success == true ? re.result : 'null';
        $(".prompt").show();
         $(".chat-cont").css("padding-top","2rem")
        $(".prompt").html('您前面还有 <font color="red">'+result+'</font>位用户，请耐心等候');
        kefu = false;
        if(re.code == 0){
          $("#msgTxt").attr("placeholder","目前处于咨询高峰期，请耐心等待");
        }
      });
        // json.action = 'sendMessage';
        // json.text = $(this).data("content");
        // json.name = $.cookie("phone");
        // json.sessionid = '<?=session_id();?>';
        // json.channel = channel;
        // json.specialContent = $(this).html();
        // ws.send(JSON.stringify(json));
    }
    function ivr(){
      call = '<?=session_id();?>';
      $.getJSON("http://10.4.62.41:8080/weChatAdapter/data/getIVRStatu",{userid:call},function(re){
        if(re.code == 1){
          pdkefu(number);
        }
      });
    }
  }

  function sendSelf(time,name,text,msgType){
    var nowTime = getTimestamp();
    var messageHtml = '';
    if(nowTime - messageTime >= 180){
      messageHtml = '<div class="time">'+time+'</div>';
      messageTime = nowTime;
    }
    $(".chat-cont").append(messageHtml+
            '<div class="mess-right sizing">'+
            '<div class="user-img"><img src="img/user.jpg" /></div>'+
            '<div class="user-mess">'+
            '<p class="user-name">'+name+'</p>'+
            '<div class="mess-cont '+(msgType == 'photo' || msgType == 'video' ? 'J-MessCont' : '')+'">'+parse_content(text)+'</div>'+
            '</div>'+
            '</div>');
    $('.message').animate({scrollTop: $(".message")[0].scrollHeight}, 300);
  }

  function sendCustomer(time,name,text,msgType){
    var nowTime = getTimestamp();
    var messageHtml = '';
    if(nowTime - messageTime >= 180){
      messageHtml = '<div class="time">'+time+'</div>';
      messageTime = nowTime;
    }
    $(".chat-cont").append(messageHtml+
            '<div class="mess-left sizing">'+
            '<div class="user-img"><img src="img/tcl.jpg" /></div>'+
            '<div class="user-mess">'+
            '<p class="user-name">'+name+'</p>'+
            '<div class="mess-cont '+(msgType == 'photo' || msgType == 'video' ? 'J-MessCont' : '')+'">'+parse_content(text)+'</div>'+
            '</div>'+
            '</div>');
    $('.message').animate({scrollTop: $(".message")[0].scrollHeight}, 300);
  }

  function getTime(){
    var date = new Date();
    return date.getHours()+':'+date.getMinutes()+':'+date.getSeconds();
  }

  function getTimestamp(){
    var timestamp = Date.parse(new Date());
    timestamp = timestamp / 1000;
    return timestamp;
  }

  /* pc版刷新或退出系统提示，经优化后使用xback
   window.onbeforeunload = function() {
      return "确定离开页面吗？";
   }
   */
</script>


<!--客服信息弹窗 start-->
<div class="cust-main" style="position: fixed;top: 0;left: 50%;margin-left: -8rem;width: 16rem;height: 100%;z-index: 99;background: #fff;display: none;">
    <div class="cust-main-close sizing" >
      <img src="img/close.png" style="width: 2rem;" alt=""/>
    </div>
    <!-- head html satrt -->
    <div class="header">
      <div class="user-img-box">
        <div class="sex"><img class="J-Sex" src="" /></div>  
        <div class="user-img">
          <img src="" class="J-UserImg" src="" />
        </div>
      </div>
      <!-- <div class="user-img">
          <img src="" class="J-UserImg" />
      </div> -->
      <div class="user-info font26 J-UserName"></div>
      <div class="user-info font22 J-Skilles"></div>
      <div class="collect font22 sizing">
        <div class="sizing">
          <p>共服务了</p>
          <span class="J-ServiceCount"></span>
        </div>
        <div class="sizing">
          <p>好评率</p>
          <span class="red J-Evaluationpercent"></span>
        </div>
        <div class="sizing">
          <p>服务时长</p>
          <span class="J-ServiceTime"></span>
        </div>
      </div>
    </div>
    <!-- @head end -->

    <!--  -->
    <div class="assess padd font20">
      <h3>评价星级</h3>
      <ul class="font20">
        <li>
          <div class="left">5星 (无可挑剔)</div>
          <div class="center J-Assess"><span class="red J-EvalWid5"></span></div>
          <div class="right J-Eval5"></div>
        </li>
        <li>
          <div class="left">4星 (挺好哒)</div>
          <div class="center"><span class="red J-EvalWid4"></span></div>
          <div class="right J-Eval4"></div>
        </li>
        <li>
          <div class="left">3星 (还行)</div>
          <div class="center"><span class="red J-EvalWid3"></span></div>
          <div class="right J-Eval3"></div>
        </li>
        <li>
          <div class="left">2星 (不开心)</div>
          <div class="center"><span class="red J-EvalWid2"></span></div>
          <div class="right J-Eval2"></div>
        </li>
        <li>
          <div class="left">1星 (忍无可忍)</div>
          <div class="center"><span class="red J-EvalWid1"></span></div>
          <div class="right J-Eval1">2</div>
        </li>
      </ul>
    </div>
    <!--  -->
    <div class="assess font20">
        <h3>大家对她的印象</h3>
        <div class="asse-list J-AsseList">
        </div>
    </div>
</div>
<script type="text/javascript">
	var cusurl = ''
    $(document).on('click',".customName-cover",function(){
      GetCustomer();
      $(".cust-main").show();
      return false;
    })
    $(".cust-main-close").on("click",function(){ $(".cust-main").hide(); })
    $(document).on('click','.specialContent',function(){
        skillid = $(this).attr("data-content");
        $.getJSON("http://wap.service.tcl.com/web/mediaSys.php?type=2",{skillid:skillid,type:"2"},function(re){
          var result = re.success == true ? re.result : 'null';
          $(".prompt").show();
           $(".chat-cont").css("padding-top","2rem")
          $(".prompt").html('您前面还有 <font color="red">'+result+'</font>位用户，请耐心等候');
          // if(re.code == -1){
          //   $("#msgTxt").attr("placeholder","目前处于咨询高峰期，请耐心等待");
          // }
          kefu = false;
          $(".specialContent").removeClass("specialContent");
          if(re.code == 0){
            $("#msgTxt").attr("placeholder","目前处于咨询高峰期，请耐心等待");
          }
        });


        json.action = 'sendMessage';
        json.text = $(this).data("content");
        json.name = $.cookie("phone");
        json.sessionid = '<?=session_id();?>';
        json.channel = channel;
        json.specialContent = $(this).html();
        ws.send(JSON.stringify(json));
    });
    function GetCustomer(){
        $.ajax({
            url: cusurl,
            type: 'GET',
            success: function(data){
              console.log('data', data);
                var obj = JSON.parse(data);
                if (obj.success) {
                    var r = obj.result,
                    w = $('.J-Assess').width(),
                    imgpath = 'img/tcl.jpg';
                    seximg = r.sex=='男' ? 'img/boy.png' : 'img/girl.png';
                    // var seximg = 
                    //imgpath = 'http://10.4.62.41:8089/upload/photo/',    //测试
                    //imgpath = 'http://10.4.28.69:8089/upload/photo/',
                    evaluation = parseInt(r.evaluation1)+parseInt(r.evaluation2)+parseInt(r.evaluation3)+parseInt(r.evaluation4)+parseInt(r.evaluation5);
                    showcusflag = false;
                    var html = '',
                            o = r.labels,
                            reg1 = new RegExp(',','g'),
                            reg2 = new RegExp('"','g'),
                            str = JSON.stringify(r.skilles);

                    if (o && o.length>0) {
                        o.map(function(item, index){
                            html += '<div>'+item+'</div>';
                        });
                    };

                    str = str.split('[')[1];
                    str = str.split(']')[0];
                    str = str.replace(reg1,'、');
                    str = str.replace(reg2,'');
                    //$('.J-UserImg').attr('src', imgpath+r.image);
                    $('.J-UserImg').attr('src', imgpath);
                    $('.J-Sex').attr('src', seximg);
                    $('.J-UserName').text(r.displayname);
                    $('.J-Skilles').text('技能：'+str);
                    $('.J-ServiceCount').text(r.serviceCount +'人');
                    $('.J-Evaluationpercent').text(r.evaluationpercent);
                    $('.J-ServiceTime').text(r.serviceTime + '分钟');
                    $('.J-AsseList').html(html);
                    $('.J-Eval5').text(((r.evaluation5/evaluation)*100).toFixed(0)+'%');
                    $('.J-EvalWid5').css('width', parseInt(r.evaluation5)/evaluation*w);
                    $('.J-Eval4').text(((r.evaluation4/evaluation)*100).toFixed(0)+'%');
                    $('.J-EvalWid4').css('width', parseInt(r.evaluation4)/evaluation*w);
                    $('.J-Eval3').text(((r.evaluation3/evaluation)*100).toFixed(0)+'%');
                    $('.J-EvalWid3').css('width', parseInt(r.evaluation3)/evaluation*w);
                    $('.J-Eval2').text(((r.evaluation2/evaluation)*100).toFixed(0)+'%');
                    $('.J-EvalWid2').css('width', parseInt(r.evaluation2)/evaluation*w);
                    $('.J-Eval1').text(((r.evaluation1/evaluation)*100).toFixed(0)+'%');
                    $('.J-EvalWid1').css('width', parseInt(r.evaluation1)/evaluation*w);
                }else{
                    alert('获取客服信息异常');
                }
            },
            error: function(err){
                alert('获取客服信息异常');
                //console.log('err', err);
            }
        });
    }
    //上传弹框、进度条
    var uploadDialog = dialog({
      title: '提示',
      content: '<center>文件上传中，请稍后......</center><div class="progress"><span class="bar" style="width: 0%;">0%</span></div>',
      cancel: false,
      width: 300
    });
</script>
<!--客服信息弹窗 end-->

<style>
  .specialContent{color: #368ee0}
  .webuploader-pick{opacity: 0 !important;padding-right: 0.8rem;}
</style>
</body>
</html>






