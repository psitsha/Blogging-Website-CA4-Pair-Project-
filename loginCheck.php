<?php include("database.php");?>
<?php
if(isset($_POST['lu'])) {
	$sql = "select * from `users` where `name`='".mysqli_real_escape_string($link, $_POST['lu'])."'";
	$res = mysqli_query($link, $sql);
	if(mysqli_num_rows($res) == 1) echo "exists";
	else echo "notexists";
}
?>
