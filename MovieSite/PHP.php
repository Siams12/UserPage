<html>
<head><title> Test </title></head>
<body>

<?php
try
{
$pdo = new PDO(
'mysql:host=localhost;dbname=moviesite','CoolUser', 
'CoolUser');

$pdo->setAttribute(PDO:ATTR_ERRMODE, PDO::
ERRMODE_EXCEPTION);
$pdo->exec('SET NAMES utf8');
}
catch(PDOException $e)
{
	echo "Unable to connect to database";
	exit();
}
while ($row = $result->fetch()){
	echo $row('customerName'].'<br>';
}
//How to do user input correctly DONT DO QUERY

$stmt = $pdo-> prepare ($sql);

$stmt->bindValue(' :name', $_POST('customerName']);

$stmt->execut();

$pdo->query('SELECT * FROM User');

foreach ($stmt as $row)
{
}
?>

<?php
//day 2
$factor = 2;

function multiplyByTwo($value)
{
	global $factor;
	
	return $value*factor;
}
echo multiply(10);
?>
<body>
</html>