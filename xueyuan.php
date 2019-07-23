<!DOCTYPE html>
<html>
	<head>
		<title>易班班级风云榜</title>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="css/bootstrap.css">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/style1.css">
		<link rel="stylesheet" href="css/font-awesome.css">
		<style type="text/css">*,::after,::before {box-sizing: border-box;}</style>
		<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
		<script src="js/jquery.js"></script>
		<script src="js/popper.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/texiao.js" type="text/javascript" charset="utf-8"></script>
		<!--
		<?php
		//1.连接数据库
		$key="sangeng@php";
		try {
		$pdo = new PDO("mysql:host=localhost;dbname=bang;","root",$key);
		} catch (PDOException $e) {
		die("数据库连接失败" . $e->getMessage());
		}
		//2.解决中文乱码问题
		$pdo->query("SET NAMES 'UTF8'");

		if($_GET['xueyuan']){
		$xueyuan = $_GET['xueyuan'];
		}else{
		$xueyuan = "";
		}
		?>
		首页消息：message
		排名：ranking
		推送：url
		class='sports'
		-->
	</head>

	<body>
		<div id="images" class="carousel slide" data-ride="carousel">
			<!-- 指示符 -->
			<ul class="carousel-indicators">
				<li data-target="#images" data-slide-to="0" class="active"></li>
				<!-- <li data-target="#images" data-slide-to="1"></li>
				<li data-target="#images" data-slide-to="2"></li>-->

			</ul>

			<!-- 轮播图片 -->
			<div class="carousel-inner">
				<div class="carousel-item active">
					<a href="#">
						<img src="images/0.jpg">
						<div class="carousel-caption">

							<!-- 投票 -->
						</div>
					</a>
				</div>
			</div>

			<!-- 左右切换按钮 -->
			<a class="carousel-control-prev" href="#images" data-slide="prev">
				<span class="carousel-control-prev-icon"></span>
			</a>
			<a class="carousel-control-next" href="#images" data-slide="next">
				<span class="carousel-control-next-icon"></span>
			</a>
		</div>
		<!-- 导航栏 -->
		<nav class="navbar navbar-expand-md bg-danger navbar-dark">
			<a class="navbar-brand" href="#">
				“星耀成理”班级风云榜
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
			<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="collapsibleNavbar">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" href="index.php">
							每日飙升榜
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="month.php">
							月度累计榜
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="xueyuan.php">
							学院数据查询
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="year.php">
							年度累计榜
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="rule.php">
							激励规则说明
						</a>
					</li>
				</ul>
			</div>
		</nav>
		<br>
		<button onclick=last_week() style="margin-left: 15px;">
		上个周
		</button>
		<button onclick=expand() style="margin-left:26%;margin-right:auto;">
		全部展开
		</button>
		<button onclick=next_week() style="float:right;margin-right: 15px;">
		下个周
		</button>
		<br />
		<br />

		<script type="text/javascript">function xueyuan(xy) {
	//发送Ajax查询请求并处理
	var request = new XMLHttpRequest();
	request.open("GET", "xyaction.php?xueyuan=" + xy);
	request.send();
	request.onreadystatechange = function() {
		if(request.readyState === 4) {
			if(request.status === 200) {
				document.querySelector("#list").innerHTML = request.response;
				loadJs("js/texiao.js");
			} else {
				alert("erro:" + request.status);
			}
		}
	}

}

function last_week() {
	var req = new XMLHttpRequest();
	req.open("GET", "the_last.php?time=" + document.getElementById("time").value);
	req.send();
	req.onreadystatechange = function() {
		if(req.readyState === 4) {
			if(req.status === 200) {
				document.querySelector("#bang").innerHTML = req.response;
				loadJs("js/texiao.js");
			} else {
				alert("erro:" + req.status);
			}
		}
	}
}

function next_week() {
	var req = new XMLHttpRequest();
	req.open("GET", "the_last.php?time=" + document.getElementById("Ntime").value);
	req.send();
	req.onreadystatechange = function() {
		if(req.readyState === 4) {
			if(req.status === 200) {
				document.querySelector("#bang").innerHTML = req.response;
				loadJs("js/texiao.js");
			} else {
				alert("erro:" + req.status);
			}
		}
	}
}</script>

		<p align="center">
			<?php
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

			//获取bang数据库最新更新时间$datebang
			$sql1 = "select max(date) as max from bang";
			$s = $pdo -> query($sql1);
			foreach ($s as $c) {
				$datebang = $c['max'];
				#echo "数据库更新至{$datebang}";
			}
			//获取xy_egpa数据库最新更新时间$datesql
			$sql2 = "select max(date) as max from xy_egpa";
			$s = $pdo -> query($sql2);
			foreach ($s as $c) {
				echo "数据库更新至{$c['max']}";
				$datesql = $c['max'];
			}
			//获取更新日期的unix时间戳
			$timebang = get_timestamp($datebang);
			$timesql = get_timestamp($datesql);
			//计算第几周星期几
			//此处输入开学时间
			$date1 = strtotime('2019-02-25');
			//开学时间，把日期转换成时间戳
			$date2 = $timesql;
			//取更新时间的时间戳
			$days = ($date2 - $date1) / 3600 / 24;
			//数据都是到前一天的
			$week = ceil(($days + 1) / 7);
			//向上取整
			$xingqi = ($days + 1) % 7;
			//日期相减会少算一天
			if ($xingqi == 0) {$xingqi = 7;
			}
			echo "(周" . $xingqi . ")";
			/*知识注记：
			 1.直接取整，舍弃小数，保留整数：intval()
			 2.四舍五入取整：round()
			 3.向上取整，有小数就加1：ceil()
			 4.向下取整：floor()
			 */
			$array = array("地球科学学院" => "56", "马克思主义学院" => "9", "网络安全学院" => "10", "环境学院" => "13", "外国语学院" => "27", "能源学院" => "32", "环境与土木工程学院" => "33", "地球物理学院" => "45", "管理科学学院" => "54", "法学院" => "64", "信息科学与技术学院" => "66", "核技术与自动化工程学院" => "72", "商学院" => "72", "传播科学与艺术学院" => "79", "旅游与城乡规划学院" => "40", "体育学院" => "11", "材料与化学化工学院" => "51", "非机构群" => "1");
			if (!$timesql) {$timesql = strtotime('2018-06-18');
			}
			#echo strtotime('2018-06-18');
			$d = ($timebang - $timesql) / 3600 / 24;
			if ($d > 0) {
				for ($b = $d; $b >= 0; $b--) {
					$uptime = $b * 3600 * 24;
					$update = get_date($timebang - $uptime);
					echo $update;
					$sql = "SELECT xueyuan,sum(if(date='{$update}',egpa,0)) as sum FROM bang group by xueyuan;";
					foreach ($pdo->query($sql) as $row) {
						$xy = $row['xueyuan'];
						if (empty($xy)) {
							include 'updatexy.php';
						}
						$egpa = round($row['sum'] / $array[$xy] * 100) / 100;
						//四舍五入，保留两位小数
						$date = $update;
						echo $xy, $egpa, $date;
						$SQL = "insert into `xy_egpa` values('{$xy}','{$egpa}','{$date}');";
						$res = $pdo -> query($SQL);
					}

				}
				echo "success";
			}
		?>
</p>
<div class="s-index-side" id ="bang">

<?php
//使用egpa_xy的date数据

$wtimesql = $timesql - $xingqi * 3600 * 24;
//上周日的时间戳
$Ltimesql = $wtimesql - 3600 * 24;
//上周六的时间戳
echo "<input type='hidden' id='time' value='{$Ltimesql}'>";
$Ntimesql = $timesql + (13 - $xingqi) * 3600 * 24;
//下周六的时间戳
echo "<input type='hidden' id='Ntime' value='{$Ntimesql}'>";

if ($xingqi == 7) {$timesql = $timesql - 3600 * 24;
}
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
?>
	

<div class="title">
<h3>egpa每周累计榜(<strong>第<?php echo $week; ?>周</strong>)</h3>
<span class="s-index-icon game-top10-icon">icon图标</span>
</div>
<ul class="weekly-list cls" id = "list">

<?php
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
	if ($row['xy']!="非机构群"){
		$a++;
	$num = $array[$row['xy']];
	$avr = round($row['sum'] * 100) / 100;
	$zong = $avr * $num;
	echo "<li name='tag'>";
	echo "<div class='app-show-title'>";
	echo "<span class='num s-index-org'>{$a}.</span>";
	echo "<a onclick=xueyuan('{$row['xy']}') class='xueyuan'>{$row['xy']}</a><p style='float: right;'>平均egpa={$avr}</p>";
	#echo "<a href='##'>{$row['xueyuan']}<p style='float: right;'>egpa={$avr}</p></a>";
	echo "</div>";
	echo "<div class='app-show-block' id='search'><a href='#' class='pic'><img src='images/120.png' alt='班级'></a><a href='###' class='s-index-down s-index-icon'>总egpa={$zong}<p>班级数：{$num}</a></div></li>";
	#echo "<div class='app-show-block'><a href='#' class='pic'><img src='images/120.png' alt='班级'></a><a href='###' class='s-index-down s-index-icon'>egpa={$avr}<p>班级数：</a></div></li>";
	}
}
			?>
			</ul>

			</div>
	</body>
	<?php
	include 'copyright.php';
	/*
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
?>
</html>
