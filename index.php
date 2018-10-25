<!DOCTYPE html>
<html lang="en">
<head>
  <title>Tracker Time</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>
<center>
<?php 
include('DB.php');
if (isset($_POST['starttime'])) {
	DB::query("INSERT INTO timer VALUES(:starttime, endtime, :datetime, :active, total)", array(
		':starttime'=>date('H:i:s'),
		':datetime'=>date('Y-M-D'), 
		':active'=>1
	));
	echo "Time start at ". date('Y-M-D H:i:s');
}


if (isset($_POST['endtime'])) {
	DB::query("UPDATE timer SET endtime=:endtime WHERE datetime=:datetime AND endtime = ''", array(
		':endtime'=>date('H:i:s'),
		':datetime'=>date('Y-M-D')
	));
	echo "Time end at ". date('Y-M-D H:i:s');
}

// if (isset($_POST['total'])) {
// 	DB::query("UPDATE timer set active=0 WHERE datetime=:datetime", array(':datetime'=>date('Y-M-D')));
// }
?>
	<hr>
	<h5>Trcaker Time</h5>
	<hr>
<form method="post">
	<input type="submit" class="btn btn-success" name="starttime" value="Start Time <?php echo date('Y-M-D h:i:s'); ?>">
</form>

<form method="post">
	<input type="submit" class="btn btn-danger" name="endtime" value="Stop Time <?php echo date('Y-M-D h:i:s'); ?>">
</form>
<hr>

<?php 
$starttime = DB::query("SELECT * FROM timer WHERE datetime=:datetime AND active=1 AND endtime <> ''", array(':datetime'=>date('Y-M-D')));
foreach ($starttime as $key) {
	//echo "<hr>";
	//echo $key['datetime']."<br>";
	$loginTime = strtotime($key['starttime']);
	$logoutTime = strtotime($key['endtime']);
	//echo 'Login Time : '.date('H:i:s', $loginTime).'<br>';
	//echo 'Logout Time : '.date('H:i:s', $logoutTime).'<br>';
	//echo "TOTAL TIME: <br>";
	$diff = $logoutTime - $loginTime;
	$sec = abs($diff);
	$min = $sec / 60;
	//echo $min . " min";
	$m += $min;
}

echo "<h5>TIME REMAIN</h5>";
echo substr(180 - $m, 0, 3) . " minutes<br><br>";


$total = DB::query("SELECT * FROM timer WHERE active=1 AND endtime <> ''", array());
$arr = [];
foreach ($total as $key) {
	$loginTime = strtotime($key['starttime']);
	$logoutTime = strtotime($key['endtime']);
	$diff = $logoutTime - $loginTime;
	$sec = abs($diff);
	$min = ($sec / 60);
	$m += $min;
	$tot = 1200 - $m;
	$hr = $tot / 60;
	array_push($arr, $hr);  
}
$c = count($arr);
for ($i=0; $i < $c-1; $i++) { 
	$co = $c-1;
}
echo substr($arr[$co], 0, 5) ." hours left<br>";
?>
</center>
</body>
</html>