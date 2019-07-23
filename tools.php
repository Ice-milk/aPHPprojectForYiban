<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>管理工具</title>
		<style type="text/css">
			hr{
				margin-right: 30%;
				margin-top: 20px;
				margin-bottom: 20px;
			}
			form{
				margin-top: 20px;
			}
		</style>
	</head>
	<body style="margin-left: 30%;margin-top: 50px;">
		重新检查日期区间内的数据并更新：</br>
		日期格式：2019.02.03-2019.02.13，注意前小后大</br>
		区间尽量小一点10天左右可以很快出结果</br>
		<form action="check1.php" method="get">
			<input type="text" name="date" id="date" value="" />-
			<input type="text" name="Date" id="Date" value="" />
			<input type="submit" value="执行"/>
		</form>
		<hr>
		计算任意时间区间内各个学院的egpa总和（比如计算月数据）：</br>
		日期格式同上（2019.07.01-2019.07.31）
		<form action="xy_month.php" method="get">
			<input type="text" name="date" id="date" value="" />-
			<input type="text" name="Date" id="Date" value="" />
			<input type="submit" value="执行"/>
		</form>
		<hr>
		批量删除“学院榜”日期区间内的数据（应对日期写错导致的问题）：
		<form action="delete.php" method="get">
			<input type="text" name="date" id="date" value="" />-
			<input type="text" name="Date" id="Date" value="" />
			<input type="submit" value="执行"/>
		</form>
	</body>
</html>