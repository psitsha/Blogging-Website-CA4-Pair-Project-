<?php session_start(); ?>
<?php include('database.php'); ?>

<?php

$user_id = $_SESSION['user_id'];
//$action = "like";
//$post_id = 29;
if (isset($_POST) && !empty($_POST)) {
    $action = trim($_POST['action']);
    $post_id = trim($_POST['post_id']);
//   echo "<h2>a" + $action + "    p" + $post_id+"</h2>";
    if ($action != "" && $post_id != "") {
        try {
            $qry = "select * from likes where post_id=$post_id and user_id=$user_id";
            $res = mysqli_query($link, $qry);
            if (mysqli_num_rows($res) == 1) {
//                $row = mysqli_fetch_object($res);
//                $likers = array_filter(explode(',', $row->likes), function($value) {
//                    return $value !== '';
//                });
//                $dislikers = array_filter(explode(',', $row->dislikes), function($value) {
//                    return $value !== '';
//                });
//                $like_count = count($likers);
//                $dislike_count = count($dislikers);

                if ($action == 'like') {
//                    if (!in_array($_SESSION['user_id'], $likers)) {
//                        array_push($likers, $_SESSION['user_id']);
//                        $like_count += 1;
//                    }
//
//                    $index = array_search('' . $_SESSION['user_id'] . '', $dislikers);
//                    if ($index !== false) {
//                        unset($dislikers[$index]);
//                        $dislike_count -= 1;
//                    }
                    $qry = "update likes set likes =1, dislikes=0 where post_id=$post_id and user_id=$user_id";
                } else if ($action == 'dislike') {
//                if (!in_array($_SESSION['user_id'], $dislikers)) {
//                    array_push($dislikers, $_SESSION['user_id']);
//                    $dislike_count += 1;
//                }
//
//                $index = array_search($_SESSION['user_id'], $likers);
//                if ($index !== false) {
//                    unset($likers[$index]);
//                    $like_count -= 1;
//                }
                    $qry = "update likes set likes =0, dislikes=1 where post_id=$post_id and user_id=$user_id";
                }
            } else {
                if ($action == 'like') {
                    $qry = "insert into likes (post_id,user_id,likes,dislikes) VALUES ($post_id,$user_id, 1, 0)";
                } else if ($action == 'dislike') {

                    $qry = "insert into likes (post_id,user_id,likes,dislikes) VALUES ($post_id,$user_id, 0, 1)";
                }
            }


//            $qry = "update posts set likes ='" . implode(',', $likers) . "', dislikes='" . implode(',', $dislikers) . "' where post_id=$post_id";
            mysqli_query($link, $qry);

            $q = "SELECT sum(likes)  as likes,sum(dislikes) as dislikes FROM likes where post_id=" . $post_id;
            $result = mysqli_query($link, $q);
            while ($row = mysqli_fetch_array($result)) {
                $likes = $row["likes"];
                $dislikes = $row["dislikes"];
            }
            if (mysqli_affected_rows($link) == 1) {
                echo $likes . '|' . $dislikes;
            }  
        } catch (Exception $e) {
            echo "Error : " . $e->getMessage();
        }
    }
}
?>