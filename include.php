<?php
session_start();

$final = array(
    '0' => array('chinadachen.cn.','qiaoxiaoyang.cn.','yiyuantianxia.com.cn.','jsanke.cn.',),
);
$off = array(
    '0' => array(
        'qq.com.',
    ),
    '1' => array(
        '51.xuntu.com',
    ),
);

function get_final_domain()
{
    global $final;
    $arr = $final[rand(0,count($final) - 1)];
    return $arr[rand(0,count($arr) - 1)];
}
function strict($str)
{
    if(get_magic_quotes_gpc())
    {
        $str = stripslashes($str);
    }
    $str = str_replace('&#','{vv}',$str);
    $str = str_replace('#','&#35;',$str);
    $str = str_replace('--','-&#45;',$str);
    $str = str_replace('/*','/&#42;',$str);
    $str = str_replace('*/','&#42;/',$str);
    $str = str_replace('<','&#60;',$str);
    $str = str_replace('>','&#62;',$str);
    $str = str_replace('(','&#40;',$str);
    $str = str_replace(')','&#41;',$str);
    $str = str_replace("'",'&#39;',$str);
    $str = str_replace('"','&#34;',$str);
    $str = str_replace('\\','&#92;',$str);
    $str = str_replace('%20','&nbsp;',$str);
    $str = str_replace(chr(13).chr(10),'<br />',$str);
    $str = str_replace('{vv}','&#',$str);
    return $str;
}
function post($val,$filter = 'strict')
{
    return $filter(isset($_POST[$val])?$_POST[$val]:'');
}
function get($val,$filter = 'strict')
{
    return $filter(isset($_GET[$val])?$_GET[$val]:'');
}
function https_request($url,$data = NULL)
{
    $curl = curl_init();
    curl_setopt($curl,CURLOPT_URL,$url);
    curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);
    if (!empty($data))
    {
        curl_setopt($curl,CURLOPT_POST,1);
        curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
        //curl_setopt($curl,CURLOPT_POSTFIELDS,http_build_query($data));
    }
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}
function get_random_str($len = 32)
{
    $str = '';
    $start = ord('a');
    for($i = 0; $i < $len; $i ++)
    {
        $num = mt_rand($start,$start + 25);
        $str .= chr($num);
    }
    return $str;
}
function get_rand_str($min,$max)
{
    $str = '';
    $rand = rand($min,$max);
    for($i = 0; $i < $rand; $i ++)
    {
        $rand2 = rand(0,1) ? rand(65,90) : rand(97,122);
        $str .= chr($rand2);
    }
    return $str;
}
function cut_str($string,$sublen,$start = 0)
{
    $pr = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
    preg_match_all($pr,$string,$t_string);
    $arr = $t_string[0];
    $arr_len = count($arr);
    for($i = 0; $i < $arr_len; $i ++)
    {
        if($arr[$i] != 'delete')
        {
            if(strlen($arr[$i]) == 1)
            {
                if($i < $arr_len - 1)
                {
                    $arr[$i] .= $arr[$i + 1];
                    $arr[$i + 1] = 'delete';
                }
            }
        }
    }
    $arr2 = array();
    foreach($arr as $key => $value)
    {
        if($value != 'delete')
        {
            $arr2[] = $value;
        }
    }
    $return = '';
    for($i = $start; $i < $sublen && $i < count($arr2); $i ++)
    {
        $return .= $arr2[$i];
    }
    if(count($arr2) - $start > $sublen)
    {
        return $return.'...';
    }else{
        return $return;
    }
}

//获取指定数量随机字符串
function getARandLetter($number = 1) {
    if ($number == 0)
        return FALSE; //去除0
    $number = $number < 0 ? - $number : $number; //如果小于零取正值
    $letterArr = array ('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z' );
    $returnStr ='';
    for($i= 0; $i < $number; $i ++) {
        $returnStr .= $letterArr [rand ( 0, 51 )];
    }
    return $returnStr;
}

//php程序处理path_info
function mod_rewrite(){
    global $_GET;
    $nav=$_SERVER["REQUEST_URI"];
    $script_name=$_SERVER["SCRIPT_NAME"];
    $nav=substr(ereg_replace("^$script_name","",urldecode($nav)),1);
    $nav=preg_replace("/^.ht(m){1}(l){0,1}$/","",$nav);//这句是去掉尾部的.html或.htm
    $vars = explode("/",$nav);
    for($i=0;$i<Count($vars);$i+=2){
        $_GET["$vars[$i]"]=$vars[$i+1];
    }
    return $_GET;
}
?>