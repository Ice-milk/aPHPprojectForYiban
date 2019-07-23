<?php
//设置页面内容的格式是HTML编码格式utf-8
header("Content-Type:text/html;charset=utf-8");
//1.连接数据库
$key = "sangeng@php";
try {
	$pdo = new PDO("mysql:host=localhost;dbname=bang;", "root", $key);
} catch (PDOException $e) {
	die("数据库连接失败" . $e -> getMessage());
}
//2.解决中文乱码问题
$pdo -> query("SET NAMES 'UTF8'");
//获取学院
if ($_GET['time']) {
	$time = $_GET['time'];
}

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

$array = array("地球科学学院" => "56", "马克思主义学院" => "9", "网络安全学院" => "10", "环境学院" => "13", "外国语学院" => "27", "能源学院" => "32", "环境与土木工程学院" => "33", "地球物理学院" => "45", "管理科学学院" => "54", "法学院" => "64", "信息科学与技术学院" => "66", "核技术与自动化工程学院" => "71", "商学院" => "63", "传播科学与艺术学院" => "79", "旅游与城乡规划学院" => "40", "体育学院" => "11", "材料与化学化工学院" => "51", "非机构群" => "1");

#获取更新日期的unix时间戳
$timesql = $time;
//计算第几周星期几
//此处输入开学时间
$date1 = strtotime('2018-08-27');
//开学时间，把日期转换成时间戳
$date2 = $timesql;
//取更新时间的时间戳
$days = ($date2 - $date1) / 3600 / 24;
//数据都是到前一天的
$week = ceil($days / 7);
//向上取整
$xingqi = ($days + 1) % 7;
//日期相减会少算一天
if ($xingqi == 0) {$xingqi = 7;
}
#echo "(周" . $xingqi . ")";
/*知识注记：
 1.直接取整，舍弃小数，保留整数：intval()
 2.四舍五入取整：round()
 3.向上取整，有小数就加1：ceil()
 4.向下取整：floor()
 */
 
 echo "<div class='title'>
<h3>egpa每周累计榜(<strong>第{$week}周</strong>)</h3>
<span class='s-index-icon game-top10-icon'>icon图标</span>
</div>
<ul class='weekly-list cls' id = 'list'>";
 
//使用egpa_xy的date数据
$wtimesql = $timesql - $xingqi * 3600 * 24;
//上周日的时间戳
$Ltimesql = $wtimesql-3600*24;
//上周六的时间戳
echo "<input type='hidden' id='time' value='{$Ltimesql}'>";
$Ntimesql = $timesql + (13-$xingqi)*3600*24;
//下周六的时间戳
echo "<input type='hidden' id='Ntime' value='{$Ntimesql}'>";

/*
 * getdate();用法
 ['seconds'] - 秒
 ['minutes'] - 分
 ['hours'] - 小时
 ['mday'] - 一个月中的第几天
 ['wday'] - 一周中的某天
 ['mon'] - 月
 ['year'] - 年
 ['yday'] - 一年中的某天
 ['weekday'] - 星期几的名称
 ['month'] - 月份的名称
 [0] - 自 Unix 纪元以来经过的秒数
 */
//3.执行sql语句，并实现解析和遍历
$Date = get_date($timesql);
//昨天
$date = get_date($wtimesql);
//周一
echo $date . '-' . $Date;

$a = 0;
#$sql2 = "SELECT xueyuan,sum(if(date between '{$date}' and '{$Date}',egpa,0)) as sum FROM bang group by xueyuan ORDER BY sum DESC";

$sql3 = "SELECT xy,sum(if(date between '{$date}' and '{$Date}',egpa,0)) as sum FROM xy_egpa group by xy ORDER BY sum DESC";
#$sql3 = "SELECT xueyuan,sum(if(date between '2018.10.07' and '2018.10.13',egpa,0)) as sum FROM bang group by xueyuan ORDER BY sum DESC";
foreach ($pdo->query($sql3) as $row) {
	$a++;
	$num = $array[$row['xy']];
	$avr = round($row['sum'] * 100) / 100;
	$zong = $avr * $num;
	echo "<li name='tag'>";
	echo "<div class='app-show-title'>";
	echo "<span class='num s-index-org'>{$a}.</span>";
	echo "<a onclick=xueyuan() class='xueyuan'>{$row['xy']}</a><p style='float: right;'>平均egpa={$avr}</p>";
	#echo "<a href='##'>{$row['xueyuan']}<p style='float: right;'>egpa={$avr}</p></a>";
	echo "</div>";
	echo "<div class='app-show-block' id='search'><a href='#' class='pic'><img src='images/120.png' alt='班级'></a><a href='###' class='s-index-down s-index-icon'>总egpa={$zong}<p>班级数：{$num}</a></div></li>";
	#echo "<div class='app-show-block'><a href='#' class='pic'><img src='images/120.png' alt='班级'></a><a href='###' class='s-index-down s-index-icon'>egpa={$avr}<p>班级数：</a></div></li>";
}
echo "</ul>";
?>