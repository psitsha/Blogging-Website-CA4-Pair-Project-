
<?php
require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_POST["keyword"])) {
$query ="SELECT post_title from posts where post_title like '". $_POST["keyword"] ."%'";
//echo($query);
$result = $db_handle->runQuery($query);
if(!empty($result)) {
?>
<ul id="country-list">
<?php
foreach($result as $title) {
?>
<li onClick="selectCountry('<?php echo $title["post_title"]; ?>');"><?php echo $title["post_title"]; ?></li>
<?php } ?>
</ul>
<?php } } ?>