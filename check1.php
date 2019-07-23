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

//数据库中日期数据格式转时间戳
			function get_timestamp($date) {
				if (empty($date)) {
					return false;
				}
				$y = ((int)substr($date, 0, 4));
				//取得年份
				$m = ((int)substr($date, 5, 2));
				//取得月份
				$d = ((int)substr($date, 8, 2));
				//取得几号
				$time = mktime(0, 0, 0, $m, $d, $y);
				return $time;
				#echo $time;
			}
			
			//时间戳转数据库中日期数据格式
			function get_date($time) {
				$date = getdate($time);
				$mday = $date['mday'];
				//日
				$mon = $date['mon'];
				//月
				$year = $date['year'];
				//年
				//月，日均需为两位数
				if ($mon < 10) {$mon = '0' . $mon;
				}
				if ($mday < 10) {$mday = '0' . $mday;
				}
				$Date = $year . '.' . $mon . '.' . $mday;
				return $Date;
			}

//同步bang与xy_egpa
$array = array("地球科学学院" => "56", "马克思主义学院" => "9", "网络安全学院" => "10", "环境学院" => "13", "外国语学院" => "27", "能源学院" => "32", "环境与土木工程学院" => "33", "地球物理学院" => "45", "管理科学学院" => "54", "法学院" => "64", "信息科学与技术学院" => "66", "核技术与自动化工程学院" => "71", "商学院" => "72", "传播科学与艺术学院" => "79", "旅游与城乡规划学院" => "40", "体育学院" => "11", "材料与化学化工学院" => "51", "非机构群" => "20");


$date=$_GET['date'];
$Date=$_GET['Date'];
$cou=(get_timestamp($Date)-get_timestamp($date))/3600/24;
//echo $cou;
for($i=0;$i<=$cou;$i++){
	$Date=get_date($i*3600*24+get_timestamp($date));
	echo $Date;
	/*$sql="select * from xy_egpa where date='{$Date}'";
	foreach ($pdo->query($sql) as $c){
	//$date = $c['date'];
	$egpa = $c['egpa'];
	$xy = $c['xy'];
	echo $xy;
	if(!$r) {*/
		echo 'ok';
		$sql2 = "SELECT xueyuan,sum(if(date='{$Date}',egpa,0)) as sum FROM bang group by xueyuan;";
					foreach ($pdo->query($sql2) as $row) {
						$xy = $row['xueyuan'];
						if (empty($xy)) {
							include 'updatexy.php';
						}
						$egpa = round($row['sum'] / $array[$xy] * 100) / 100;
						//四舍五入，保留两位小数
						echo $xy, $egpa, $Date;
						
						$SQL = "insert into `xy_egpa` values('{$xy}','{$egpa}','{$Date}');";
						$res = $pdo -> query($SQL);
					}
		}
	
//	}
//}

echo "success";
?>