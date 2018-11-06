<?php session_start(); ?>
<?php include('db.php');?>
<?php
if(isset($_POST) && !empty($_POST)) {
  $action = trim($_POST['action']);
  $post_id = trim($_POST['post_id']);
  if($action != "" && $post_id != "") {
    try {
      $qry = "select * from `post_list` where `id`=$post_id";
      $res = mysqli_query($con, $qry);
      if(mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_object($res);
        $likers = array_filter(explode(',', $row->likes), function($value) { return $value !== ''; });
        $dislikers = array_filter(explode(',', $row->dislikes), function($value) { return $value !== ''; });
        $like_count = count($likers);
        $dislike_count = count($dislikers);
        if($action == 'like') {
          if(!in_array($_SESSION['sess_user_id'], $likers)) {
            array_push($likers, $_SESSION['sess_user_id']);
            $like_count += 1;
          }
          $index = array_search(''.$_SESSION['sess_user_id'].'', $dislikers);
          if($index !== false) {
            unset($dislikers[$index]);
            $dislike_count -= 1;
          }
        } else if($action == 'dislike') {
          if(!in_array($_SESSION['sess_user_id'], $dislikers)) {
            array_push($dislikers, $_SESSION['sess_user_id']);
            $dislike_count += 1;
          }
          $index = array_search($_SESSION['sess_user_id'], $likers);
          if($index !== false) {
            unset($likers[$index]);
            $like_count -= 1;
          }          
        }
        $qry = "update `post_list` set `likes`='".implode(',', $likers)."', `dislikes`='".implode(',', $dislikers)."' where `id`=$post_id";
        mysqli_query($con, $qry);
        if(mysqli_affected_rows($con) == 1) {
          echo $like_count.'|'.$dislike_count;
        }
      }
    } catch (Exception $e) {
      echo "Error : " .$e->getMessage();
    }
  }
}
?>