<?php
date_default_timezone_set('PRC');
set_time_limit(30);
include('include.php');
///////////////////////////////////////////////////////////////////////////////////////////////
$domain = $_SERVER['HTTP_HOST'];
$domain = explode('.',$domain,2);
$domain = $domain[1];
$if_off = false;
for($i = 0; $i < count($off); $i ++)
{
    if(in_array($domain,$off[$i]))
    {
        $if_off = $i;
        break;
    }
}
if($if_off !== false)
{
    $k = $if_off;
    $domain = $final[$k][rand(0,count($final[$k]) - 1)];
    $url = 'http://' . get_rand_str(2,6) . '.' . $domain . '/index.php?' . get_rand_str(1,6) . '=' . rand(1,9) . (time() * 3);
    header('location:' . $url);
}
///////////////////////////////////////////////////////////////////////////////////////////////
$diyversion = str_replace("==","",base64_encode(time()));
//$result_url = 'result.php?qid={qid}&t=' . time() . '&s=1&v=' . base64_encode(time());
//$result_url = 'result.php?qid={qid}&t=' . time() . '&s=1&v=' . $diyversion;
$result_url = 'result-{qid}-' . time() . '-1-' . $diyversion.'.html';
if(isset($_SESSION['qid']))
{
    $qid = intval($_SESSION['qid']);
    $result_url = str_replace('{qid}',$qid,$result_url);
}else{
    $qid = rand(1,16);
    $_SESSION['qid'] = $qid;
    $result_url = str_replace('{qid}',$qid,$result_url);
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>抽取你的七夕签！</title>
    <link rel="stylesheet" href="http://www.erkgh.cn/cdn/05/css/dream.css?v=2" />
    <link rel="stylesheet" href="http://www.erkgh.cn/cdn/05/css/qr.css" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
</head>

<body style="background:url(https://qqpublic.qpic.cn/qq_public/0/0-2378631136-E3A5F32D7D453AABE23BA2D4AA4CD34C/0) no-repeat center center  / cover #E8DFD0;" onload="init()">

<div class="do" onclick="start()">摇一摇手机</div>


<div class="cover result" id="result">
    <div class="item">
        <div class="sprite a1"></div>
    </div>
</div>
<div class="cover decode" id="decode">
    <div class="inner"></div>
</div>
<div style="display:none;">
    <audio id="media" src="http://www.erkgh.cn/cdn/05/images/voice.mp3"  controls=""></audio>
</div>

<script src="http://libs.baidu.com/zepto/0.8/zepto.min.js" type="text/javascript"></script>
<script type="text/javascript">
    new Image().src = "http://ww3.sinaimg.cn/large/0067vO9zgw1ez755dvqozj30fj08cjrw.jpg";
    new Image().src = "http://ww4.sinaimg.cn/large/0067vO9zgw1ez755cz4pbj30ok08gq4p.jpg";
    var isStarted = false;


    function start() {
        if (isStarted) {
            return true;
        }
        isStarted = true;
        document.getElementById("decode").style.display = "none";
        document.getElementById("result").style.display = "block";
        setTimeout(showDecode, 3000);
        var media=document.getElementById("media");media.play();
        //showDecode();
    }

    function showDecode() {
        document.getElementById("result").style.display = "none";
        document.getElementById("decode").style.display = "block";
        setTimeout(jumpToDecode, 3000);
        //jumpToDecode();
    }

    function jumpToDecode() {
        var resultUrl = "<?php echo $result_url;?>";
        window.location.href = resultUrl;
    }

    var SHAKE_THRESHOLD = 5000;
    var last_update = 0;
    var x = y = z = last_x = last_y = last_z = 0;

    function init() {
        if (window.DeviceMotionEvent) {
            window.addEventListener('devicemotion', deviceMotionHandler, false);
        }
        setTimeout(start, 5000);
        //start();
    }

    function deviceMotionHandler(eventData) {
        if (isStarted) {
            return true;
        }

        var acceleration = eventData.accelerationIncludingGravity;
        var curTime = new Date().getTime();
        if ((curTime - last_update) > 10) {
            var diffTime = curTime - last_update;
            last_update = curTime;
            x = acceleration.x;
            y = acceleration.y;
            z = acceleration.z;
            var speed = Math.abs(x + y + z - last_x - last_y - last_z) / diffTime * 10000;

            if (!isStarted && speed > SHAKE_THRESHOLD) {
                start();
            }
            last_x = x;
            last_y = y;
            last_z = z;
        }
    }
</script>
<div style="display:none"><script src="https://s22.cnzz.com/z_stat.php?id=1274356344&web_id=1274356344" language="JavaScript"></script></div>
</body>
</html>