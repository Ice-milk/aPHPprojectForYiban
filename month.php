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
		<style type="text/css">*,
::after,
::before {
	box-sizing: initial;
}</style>
		<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
		<script src="js/jquery.js"></script>
		<script src="js/popper.js"></script>
		<script src="js/bootstrap.js"></script>
		<script type="text/javascript">$(function() {

	$(".weekly-list li").bind("mouseenter", weekly_ani).bind("mouseleave", function() {
		clearTimeout(
			$(this).data("setTime")
		);
	});

	function weekly_ani(e) {
		var me = $(e.target).closest("li");
		if(me.hasClass("current"))
			return;
		var orili = me.parent().find(".current");
		$(this).data("setTime", setTimeout(function() {
			weekly_move(me, orili, 100, 39)
		}, 150));
	}

	function weekly_move(me, orili, h, h2) {
		me.addClass("current");
		$(".weekly-list li").unbind("mouseenter", weekly_ani);
		setTimeout(function() {
			var cur_h = me.height();
			if(cur_h < h - 2) {
				var cur_orih = orili.height();
				var dh = Math.round((h - cur_h) / 2.5);
				me.css("height", cur_h + dh);
				orili.css("height", cur_orih - dh);
				setTimeout(arguments.callee, 25);
			} else {
				me.addClass("current").css("height", h);
				orili.css("height", h2);
				$(".weekly-list li").bind("mouseenter", weekly_ani);
				orili.removeClass("current");
			}
		}, 25);
	}

	$(".weekly-list").find("li:first").addClass("current").animate({
		height: 100
	}, 300);

});</script>
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
						<a class="nav-link" href="year.php">
							年度累计榜
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="xueyuan.php">
							学院数据查询
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
$time=get_timestamp($datebang);
$arr=getdate($time);
//获取当前时间数组
//获取并判断月份，每月前两天显示上月数据，月份格式需要两位数字
if ($arr['mday'] < 2) {$month = $arr['mon'] - 1;
	if ($month < 10) {$month = '0' . $month;
	}
} else {$month = $arr['mon'];
	if ($month < 10) {$month = '0' . $month;
	}
}
$date = $arr['year'] . '.' . $month;
?>

		<p align="center">
			<?php $sql1 = "select date,max(if(date REGEXP '^{$date}',date,0)) as max from bang";
			$s = $pdo -> query($sql1);
			foreach ($s as $c) {
				echo "数据库更新至{$c['max']}";
			}
		?>
</p>
<div class="s-index-side">


<div class="title">
<h3>egpa月度累计榜(<strong><?php echo $month; ?>月</strong>)</h3>
<span class="s-index-icon game-top10-icon">icon图标</span>
</div>
<ul class="weekly-list cls">

<?php
//3.执行sql语句，并实现解析和遍历

$a = 0;
$sql = "SELECT class,xueyuan,sum(if(date REGEXP '^{$date}',egpa,0)) as sum FROM bang group by class ORDER BY sum DESC limit 30";
foreach ($pdo->query($sql) as $row) {
	$a++;
	$egpa = round($row['sum'] * 100) / 100;
	echo "<li>";
	echo "<div class='app-show-title'>";
	echo "<span class='num s-index-org'>{$a}.</span>";
	echo "<a href='##'>{$row['class']}</a>";
	echo "</div>";
	echo "<div class='app-show-block'><a href='#' class='pic'><img src='images/120.png' alt='班级'></a><a href='###' class='s-index-down s-index-icon'>egpa={$egpa}</a></div></li>";
}
			?>

			</ul>
			</div>
	</body>
	<?php
	include 'copyright.php';
?>
</html>