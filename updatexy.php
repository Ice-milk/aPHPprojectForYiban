<html>
	<p>哇，你是今天第一个浏览数据的人哦~数据正在更新，请耐心等待...</p>
	<!--<a href="http://119.23.243.80/yiban/bang/updatexy.php">
		执行
	</a>-->
</html>
<?php
header("Content-Type: text/html; charset=UTF-8");
set_time_limit(0); 
//1.连接数据库
$key = "sangeng@php";
try {
	$pdo = new PDO("mysql:host=localhost;dbname=bang;", "root", $key);
} catch (PDOException $e) {
	die("数据库连接失败" . $e -> getMessage());
}
//2.解决中文乱码问题
$pdo -> query("SET NAMES 'UTF8'");
//3.获取class
$sql = "select class,xueyuan from `bang`";
$s = $pdo -> query($sql);
$a = 0;
$b = 0;
foreach ($s as $c) {
	$class = $c['class'];
	$xueyuan1 = $c['xueyuan'];
	#echo $class;
	$xueyuan = "";
	$sql3 = "select * from `class_xy` where class='{$class}'";
	$result = $pdo -> query($sql3);
	foreach ($result as $xu) {
			$xueyuan = $xu['xueyuan'];}
	#echo $xueyuan;
	if(empty($xueyuan)) {
		$xueyuan = get_xueyuan($class);
		$b++;
		echo "b:".$b."\n";
		if($xueyuan){
		$sql2 = "insert into `class_xy` values('{$class}','{$xueyuan}')";
		$res = $pdo -> query($sql2);}else{echo "未查询到班级:".$class;
		$sql2 = "insert into `class_xy` values('{$class}','非机构群')";
		$res = $pdo -> query($sql2);
		}
	}else{if(!$xueyuan){break;}}
	if($xueyuan){
		if($xueyuan1 != $xueyuan) {
			$sql1 = "update `bang` set xueyuan='{$xueyuan}' where class='{$class}'";
			$q = $pdo -> query($sql1);
			$a++;
			echo "a".$a."\n";
		}
	}
	if($b == 20){
		$b=0;
		ob_flush(); //将数据从php的buffer中释放出来
		flush(); //将释放出来的数据发送给浏览器
	}
	/*if($a == 45){
		$a=0;
		sleep(10);
	}
	ob_flush();
	flush();*/
}echo "success,<a href='xueyuan.php'>请点击返回继续浏览数据</a>";
/*if(!$_GET['class'])
 {return -1 ;}
 $class = $_GET['class'];*/
function get_xueyuan($class) {
	$url = "http://mp.yiban.cn/groups/query";
	$data = array("name" => $class, "kind" => "", "group" => "0", "type" => "pub", "page" => "1", "user_id" => "0");
	$data = http_build_query($data);
	$opt = array('http' => array('method' => "POST", 'header' => "Host:mp.yiban.cn\r\n" . "User-Agent:Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:62.0) Gecko/20100101 Firefox/62.0\r\n" . "Accept:application/json, text/javascript, */*; q=0.01\r\n" . "Accept-Language:zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2\r\n" . "Referer:http://mp.yiban.cn/groups/pubGroup\r\n" . "Content-Type:application/x-www-form-urlencoded; charset=UTF-8\r\n" . "X-Requested-With:XMLHttpRequest\r\n" . "Content-Length:" . strlen($data) . "\r\n" . "cookie:__SDID=05aafc38e67c4c8f; CNZZDATA1254640428=595016516-1525319314-%7C1543892357; __guid=92401857.2558918256517303000.1534562480621.327; UM_distinctid=166ce6979cc449-021f429e979453-4c312979-144000-166ce6979cd172; YB_SSID=417a55620577c61f0956b3db67f7ba41; ___YID=Nhli040hjQ0mZx0f; timezone=-8; GZPT=dvnwdlJ-0h00n3o0\r\n" . "Connection:keep-alive\r\n", "content" => $data));
	$context = stream_context_create($opt);
	$return_content = file_get_contents("$url", FALSE, $context);
	$obj = json_decode($return_content);
	$result = $obj -> data -> list[0] -> group_name;
	return $result;
}
?>