<?php include("database.php");?>
<?php
if(isset($_POST['email'])) {
	$sql = "select * from `users` where `email`='".mysqli_real_escape_string($link, $_POST['email'])."'";
	$res = mysqli_query($link, $sql);
	if(mysqli_num_rows($res) == 1) echo "exists";
	else echo "notexists";
}
?>
