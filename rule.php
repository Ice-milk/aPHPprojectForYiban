<!DOCTYPE html>
<html>

<head>
    <title>专题合辑</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <style type="text/css">
    	*, ::after, ::before{
    		box-sizing: initial;}
    </style>
    <script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
    <script src="js/jquery.js"></script>
	<script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
    <!--
		<?php
		$key="sangeng@php";
         try {
            $pdo = new PDO("mysql:host=localhost;dbname=yiban;","root",$key);
        } catch (PDOException $e) {
            die("数据库连接失败" . $e->getMessage());
        }
        //2.解决中文乱码问题
        $pdo->query("SET NAMES 'UTF8'");
		?>
		导入验证码：yian666
		修改验证码：CDUTyiban
	-->
</head>

<body>
    <nav class="navbar navbar-expand-md bg-danger navbar-dark">
        <a class="navbar-brand" href="#">激励规则说明</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
            	<li class="nav-item">
                    <a class="nav-link" href="index.php">每日飙升榜</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="month.php">月度累计榜</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="year.php">年度累计榜</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="xueyuan.php">学院数据查询</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="rule.php">激励规则说明</a>
                </li>
            </ul>
        </div>
    </nav>
    <br>
    <div class="container-fluid" style="margin-top:10px">
        <div id="main">
        	<img src="./images/0.jpg"/ width="100%"><br /><br />
        	
            <div class="card">
                <!-- 分类 -->
                <div class="card-header">
                    <a class="card-link" data-toggle="collapse" data-parent="#main" href="#leader">
                        月度奖励
                    </a>
                </div>
                <div id="leader" class="collapse show">
                    <div class="card-block">
                    	<img src=""/>
                    		<p style="padding-left: 40px;font-size: 16px;">
                    		<strong>月度冠军班级</strong>颁发<strong>“月度冠军”奖牌</strong>并获得500元易班活动经费<br /><br />
                    		<strong>月度亚军班级</strong>颁发奖状和400元易班活动经费<br /><br />
                    		<strong>月度季军班级</strong>获得奖状和300元易班活动经费<br /><br />
                    		月度第四名班级获得奖状和200元易班活动经费<br /><br />
                    		月度第五名班级获得奖状和100元易班活动经费
                    		</p>
                    </div>
                </div>
            </div>
            <br />
            <div class="card">
                <div class="card-header">
                    <a class="collapsed card-link" data-toggle="collapse" data-parent="#main" href="#teacher">
                        年度奖励
                    </a>
                </div>
                <div id="teacher" class="collapse show">
                    <div class="card-block">
                    	<p style="padding: 10px;font-size: 16px;">
                    		敬请期待
						</p>
                        
                    </div>
                </div>
            </div>
            <br />
            
        </div>
    </div>
</body><br />
<?php
include "copyright.php";
?>
</html>