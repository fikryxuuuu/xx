<?php
header("Content-Type: text/html; charset=UTF-8");
libxml_use_internal_errors(true);

//建议php版本7 开启curl扩展
$typeid =$_GET["t"];
$page = $_GET["pg"];
$ids = $_GET["ids"];
$burl = $_GET["url"];
$wd = $_GET["wd"];

$movietype = '{"class":[{"type_id":134,"type_name":"宅舞"},{"type_id":135,"type_name":"综合舞蹈"},{"type_id":129,"type_name":"偶像"},{"type_id":208,"type_name":"中国舞"},{"type_id":215,"type_name":"治愈音乐"},{"type_id":136,"type_name":"原创·翻唱"},{"type_id":137,"type_name":"演奏·乐器"},{"type_id":103,"type_name":"Vocaloid"},{"type_id":139,"type_name":"综合音乐"},{"type_id":185,"type_name":"音乐选集·电台"},{"type_id":89,"type_name":"美食"},{"type_id":204,"type_name":"旅行"},{"type_id":205,"type_name":"美妆·造型"}]}';
$header = array(
'accept-language: zh-CN,zh;q=0.9',
'cookie: csrfToken=ek3Z9-YokCYTC0fQ9sjGea81; _did=web_115813365EDA22D5; webp_supported=%7B%22lossy%22%3Atrue%2C%22lossless%22%3Atrue%2C%22alpha%22%3Atrue%2C%22animation%22%3Atrue%7D; Hm_lvt_2af69bc2b378fb58ae04ed2a04257ed1=1703473470; safety_id=AAL9uVW73Syo1M8rHolEVNxV; _did=web_115813365EDA22D5; lsv_js_player_v2_main=e4d400; cur_req_id=8789957617941EF3_self_8f7de42e6e3921fc19f4e8b1865b7945; cur_group_id=8789957617941EF3_self_8f7de42e6e3921fc19f4e8b1865b7945_0; Hm_lpvt_2af69bc2b378fb58ae04ed2a04257ed1=1703474559',
'referer: https://www.acfun.cn/',
'sec-fetch-mode: cors',
'sec-fetch-site: same-origin',
'user-agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.79 Safari/537.36',
'x-requested-with: XMLHttpRequest'
    );
if ($typeid<> null && $page<>null){
$liebiao = "https://www.acfun.cn/v/list$typeid/index.htm?sortField=createTime&duration=all&date=default&page=$page&quickViewId=listwrapper&reqID=3&ajaxpipe=1&sortField=createTime&duration=all&date=default&page=$page";


$query="//div[@class='list-content-data']";
$picAttr="//img/@src";
$titleAttr="//h1";
$linkAttr="//h1//@href";
$query2 ="//span[@class='video-time']";

$html = file_get_contents($liebiao);$html=str_replace('\\','',$html);
$dom = new DOMDocument();
$html= mb_convert_encoding($html ,'HTML-ENTITIES',"UTF-8");
$dom->loadHTML($html);
$dom->normalize();
$xpath = new DOMXPath($dom);
$texts = $xpath->query($query2);
$events = $xpath->query($query);
$titleevents= $xpath->query($titleAttr);
$linkevents= $xpath->query($linkAttr);
$picevents= $xpath->query($picAttr);
$length=$events->length;
$result='{"code":1,"page":1,"pagecount":999,"total":'. $length.',"list":[';
for ($i = 0; $i < $events->length; $i++) {
    $event = $events->item($i);
    $text = $texts->item($i)->nodeValue;
    $link = $linkevents->item($i)->nodeValue;
    $title = $titleevents->item($i)->nodeValue;
    $pic = $picevents->item($i)->nodeValue;

    $result=$result.'{"vod_id":"'.$link.'","vod_name":"'.$title.'","vod_pic":"'.$pic.'","vod_remarks":"'.$text.'"},';
}
$result=substr($result, 0, strlen($result)-1).']}';

echo $result;

}else if ($wd<> null){
$file_name = "https://www.acfun.cn/search?type=video&keyword=".urlencode($wd)."&pCursor=";
$sourceAry = array();
for($i = 1;$i < 6; $i++){
$sourceAry[] = $file_name . $i .'&sortType=5&channelId=0&requestId=&quickViewId=video-list&reqID=1&ajaxpipe=1';
}
$dddd=async_get_url($sourceAry,$header);$dddd=str_replace('\\','',$dddd);
$dddd=implode(",",$dddd);

$searchquery="//div[@class='search-video-card']";
$searchpicAttr=$searchquery."//img/@src";
$searchtitleAttr=$searchquery."//div[@class='video__main']/div/a";
$searchlinkAttr=$searchquery."//div[@class='video__main']/div/a/@href";
$searchquery2 =$searchquery."//span[@class='video__duration']";

$dom = new DOMDocument();
$html= mb_convert_encoding($dddd ,'HTML-ENTITIES',"UTF-8");
$dom->loadHTML($html);
$dom->normalize();
$xpath = new DOMXPath($dom);
$texts = $xpath->query($searchquery2);
$events = $xpath->query($searchquery);
$titleevents= $xpath->query($searchtitleAttr);
$linkevents= $xpath->query($searchlinkAttr);
$picevents= $xpath->query($searchpicAttr);
$length=$events->length;
$result='{"code":1,"page":1,"pagecount":1,"total":'. $length.',"list":[';
for ($i = 0; $i < $events->length; $i++) {
    $event = $events->item($i);
    $text = $texts->item($i)->nodeValue;
    $link = $linkevents->item($i)->nodeValue;
    $title = $titleevents->item($i)->nodeValue;
    $pic = $picevents->item($i)->nodeValue;
    
    if($searchurl1<>null){
        $link2 =getSubstr($link,$searchurl1,$searchurl2);
    }else{
    $link2 =$link;
    }
    $result=$result.'{"vod_id":"'.$link2.'","vod_name":"'.$title.'","vod_pic":"'.$pic.'","vod_remarks":"'.$text.'"},';
}
$result=substr($result, 0, strlen($result)-1).']}';

echo $result;

}else if ($ids<> null){
$detail="https://www.acfun.cn$ids";
$html = file_get_contents($detail);
$json = getSubstr($html,'window.videoInfo =','window.videoResource');$json=str_replace(';','',$json);

$arr=json_decode($json,true);
$title=$arr['title'];
$type=$arr['channel']['name'];
$pic=$arr['coverUrl'];
$actor=$arr['user']['name'];
$text=$arr['user']['signature'];
$result='{"list":[{"vod_id":"'.$ids.'",';
$result=$result.'"vod_name":"'.$title.'",';
$result=$result.'"vod_type":"'.$type.'",';
$result=$result.'"vod_pic":"'.$pic.'",';
$result=$result.'"vod_actor":"'.$actor.'",';
$result=$result.'"vod_content":"'.$text.'",';
$play=$arr['currentVideoInfo']['ksPlayJson'];
$brr=json_decode($play,true);
$pu=$brr['adaptationSet']['0']['representation']['0'];
$pu1=$pu['url'];$pu2=$pu['backupUrl']['0'];
$ddd='默认线路$'.$pu1.'#备用线路$'.$pu2;

$uid=$arr['user']['href'];
$num=$arr['user']['contributeCount'];
$m = ceil($num / 100)+1;

$sourceAry = array();
for($page=1;$page<$m;$page++){
$sourceAry[] = 'https://www.acfun.cn/u/'.$uid.'?quickViewId=ac-space-video-list&reqID=1&ajaxpipe=1&type=video&order=newest&page='.$page.'&pageSize=100';
}

$total=async_get_url($sourceAry,$header);$total=str_replace('\\','',$total);
$total=implode(',',$total);
$dom = new DOMDocument();
$html= mb_convert_encoding($total ,'HTML-ENTITIES',"UTF-8");
$dom->loadHTML($html);
$dom->normalize();
$xpath = new DOMXPath($dom);
$vn="//p[@class='title line']";
$vp="//a/@href";
$linkevents= $xpath->query($vp);
$titleevents= $xpath->query($vn);
$length=$linkevents->length;

for ($i = 0; $i < $length; $i++) {
    $link = 'https://www.acfun.cn'.$linkevents->item($i)->nodeValue;
    $title = $titleevents->item($i)->nodeValue;
$ttt.=$title.'$'.$link.'#';
}
$ttt=substr($ttt, 0, strlen($ttt)-1);

$result= $result.'"vod_play_from":"本视频直链$$$'.'UP主所有视频嗅探",';
$result= $result.'"vod_play_url":"'.$ddd.'$$$'.$ttt.'"}]}';

echo $result;


}else{
echo $movietype;
}

function async_get_url($url_array, $header)

{

if (!is_array($url_array))

return false;

$wait_usec = intval($wait_usec);

$data    = array();

$handle  = array();

$running = 0;

$mh = curl_multi_init(); // multi curl handler

$i = 0;

foreach($url_array as $url) {

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return don't print

curl_setopt($ch, CURLOPT_TIMEOUT, 30);

curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_REFERER, 'https://www.acfun.cn/');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // 302 redirect

curl_setopt($ch, CURLOPT_MAXREDIRS, 7);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_multi_add_handle($mh, $ch); // 把 curl resource 放进 multi curl handler 里

$handle[$i++] = $ch;

}

/* 执行 */

do {

curl_multi_exec($mh, $running);

if ($wait_usec > 0) /* 每个 connect 要间隔多久 */

usleep($wait_usec); // 250000 = 0.25 sec

} while ($running > 0);

/* 读取资料 */

foreach($handle as $i => $ch) {

$content  = curl_multi_getcontent($ch);

$data[$i] = (curl_errno($ch) == 0) ? $content : false;

}

/* 移除 handle*/

foreach($handle as $ch) {

curl_multi_remove_handle($mh, $ch);

}

curl_multi_close($mh);

return $data;

}
function deCFEmail($encode){

$k = hexdec(substr($encode,0,2));

for($i=2, $m=''; $i < strlen($encode) - 1; $i += 2){

$m.=chr(hexdec(substr($encode, $i, 2))^$k);

}

return $m;

}
function getSubstr($str, $leftStr, $rightStr) 
{
if($leftStr<>null && $rightStr<>null){
$left = strpos($str, $leftStr);
$right = strpos($str, $rightStr,$left+strlen($left));
if($left < 0 or $right < $left){
return '';
}
return substr($str, $left + strlen($leftStr),$right-$left-strlen($leftStr));
}else{
$str2=$str;
if($leftStr<>null){
$str2=str_replace($leftStr,'',$str2);
}
if($rightStr<>null){
$str2=str_replace($rightStr,'',$str2);
}
return $str2;
}
}
?>
