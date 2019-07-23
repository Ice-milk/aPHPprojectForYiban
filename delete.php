<?php
//1.连接数据库
$key = "sangeng@php";
try {
	$pdo = new PDO("mysql:host=localhost;dbname=bang;", "root", $key);
} catch (PDOException $e) {
	die("数据库连接失败" . $e -> getMessage());
}
//2.解决中文乱码问题
$pdo -> query("SET NAMES 'UTF8'");

$date = $_GET['date'];
$Date = $_GET['Date'];
echo"{$date}-{$Date}";
$SQL = "delete from xy_egpa where date between '{$date}' and '{$Date}'";
$res = $pdo->query($SQL);
echo"success";
?>