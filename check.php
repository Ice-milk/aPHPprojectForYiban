<html>
	<p>哇，你是今天第一个浏览数据的人哦~数据正在更新，请耐心等待...</p>
	<!--<a href="http://119.23.243.80/yiban/bang/updatexy.php">
		执行
	</a>-->
</html>
<?php
//本页用于同步各个数据库之间的数据
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

//同步bang与class_xy，检查班级对应学院数据是否存在问题
//获取bang班级和学院
$sql = "select class,xueyuan from `bang`";
$s = $pdo -> query($sql);
$a = 0;
$b = 0;
foreach ($s as $c) {
	$class = $c['class'];
	$xueyuan1 = $c['xueyuan'];
	#echo $class;
	$xueyuan = "";
	//获取class_xy中对应班级的学院
	$sql3 = "select * from `class_xy` where class='{$class}'";
	$result = $pdo -> query($sql3);
	foreach ($result as $xu) {
			$xueyuan = $xu['xueyuan'];}
	#echo $xueyuan;
	//学院为空，未查询到相应班级，更新class_xy
	if(empty($xueyuan)) {
		$xueyuan = get_xueyuan($class);
		$b++;
		echo "b:".$b."\n";
		//更新所得学院不为空，插入到class_xy，为空写入非机构群
		if($xueyuan){
		$sql2 = "insert into `class_xy` values('{$class}','{$xueyuan}')";
		$res = $pdo -> query($sql2);}else{echo "未查询到班级:".$class;
		$sql2 = "insert into `class_xy` values('{$class}','非机构群')";
		$res = $pdo -> query($sql2);
		}
	}else{
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

//同步bang与xy_egpa
$array = array("地球科学学院" => "56", "马克思主义学院" => "9", "网络安全学院" => "10", "环境学院" => "13", "外国语学院" => "27", "能源学院" => "32", "环境与土木工程学院" => "33", "地球物理学院" => "45", "管理科学学院" => "54", "法学院" => "64", "信息科学与技术学院" => "66", "核技术与自动化工程学院" => "71", "商学院" => "72", "传播科学与艺术学院" => "79", "旅游与城乡规划学院" => "40", "体育学院" => "11", "材料与化学化工学院" => "51", "非机构群" => "20");
//获取xyegpa
$sql = "select * from xy_egpa";
$a = 0;
foreach ($pdo->query($sql) as $c){
	$date = $c['date'];
	$egpa = $c['egpa'];
	$xy = $c['xy'];
	#echo $xy,$egpa;
	//获取bang
	$sql2 = "select sum(egpa) as sum from bang where xueyuan='{$xy}' and date='{$date}'";
	foreach ($pdo->query($sql2) as $s){
		$egpa1 = round($s['sum'] / $array[$xy] * 1000) / 1000;
		#echo $egpa1;
		if($egpa1 != $egpa){
			$sql3 = "update `xy_egpa` set egpa='{$egpa1}' where xy='{$xy}' and date='{$date}'";
			$re = $pdo->query($sql3);
			$a++;
			echo "a:".$a."\n";
		}
	}
}echo "success";
?>