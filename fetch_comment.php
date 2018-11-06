<?php

//fetch_comment.php

//$connect = new PDO('mysql:host=localhost;dbname=webtest1', 'root', '');
include ("database.php");

if( isset($_GET['post_id'])){
    $post_id = $_GET['post_id'];
}else{
    echo "This is not how it works";
    die();
}
//$query = "
//SELECT * FROM comments 
//WHERE post_id = ".$post_id." 
//ORDER BY comment_id DESC
//";

$sql = "SELECT * FROM comments 
WHERE post_id = ".$post_id." 
ORDER BY comment_id DESC";
$result = mysqli_query($link, $sql);
//
//$statement = $link->prepare($query);
//
//$statement->execute();
//
//$result = $statement->fetchAll();
$output = '';
while ($row = mysqli_fetch_array($result)) 
{
 $output .= '
 <div class="panel panel-default">
  <div class="panel-heading">By <b>'.$row["name"].'</b> on <i>'.$row["date"].'</i></div>
  <div class="panel-body">'.$row["comment"].'</div>
  <div class="panel-footer" align="right"><button type="button" class="btn btn-default reply" id="'.$row["comment_id"].'">Reply</button></div>
 </div>
 ';
 $output .= get_reply_comment($link, $row["comment_id"]);
}

echo $output;

function get_reply_comment($link, $parent_id = 0, $marginleft = 0)
{
 $query = "
 SELECT * FROM comments WHERE parent_comment_id = '".$parent_id."'
 ";
 $result = mysqli_query($link, $query);
 $output = '';
// $statement = $link->prepare($query);
// $statement->execute();
 
// 
// $result = $statement->fetchAll();
// $count = $statement->rowCount();
 if($parent_id == 0)
 {
  $marginleft = 0;
 }
 else
 {
  $marginleft = $marginleft + 48;
 }
// if($count > 0)
// {
// {
while ($row = mysqli_fetch_array($result)) 
{
   $output .= '
   <div class="panel panel-default" style="margin-left:'.$marginleft.'px">
    <div class="panel-heading">By<a href="view_profile.php?name='.$row["name"].'"> '.$row["name"].'</a>on <i>'.$row["date"].'</i></div>
    <div class="panel-body">'.$row["comment"].'</div>
    <div class="panel-footer" align="right"><button type="button" class="btn btn-default reply" id="'.$row["comment_id"].'">Reply</button></div>
   </div>
   ';
   $output .= get_reply_comment($link, $row["comment_id"], $marginleft);
  }
 }
 return $output;
//}

?>