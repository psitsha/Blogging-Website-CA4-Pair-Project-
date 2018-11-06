<?php

//add_comment.php
//$connect = new PDO('mysql:host=localhost;dbname=webetest1', 'root', '');

include ("database.php");
session_start();
if (isset($_SESSION['log_on'])) {
$error = '';
$comment_name = $_SESSION['username'];
$comment_content = '';
$comment_id = $_POST["comment_id"];
//if (empty($_POST["comment_name"])) {
//    $error .= '<p class="text-danger">*Name is required</p>';
//
//


    if (empty($_POST["comment_content"])) {
        $error .= '<p class="text-danger">*Comment is required</p>';
    } else {
        $comment_content = $_POST["comment_content"];
    }

    if (!empty($_POST['post_id'])) {
        $post_id = $_POST['post_id'];
    } else {
        $post_id = -1;
    }

    if ($error == '') {
// $query = "
// INSERT INTO comments 
// (parent_comment_id, comment, name, post_id) 
// VALUES (:parent_comment_id, :comment, :name, :post_id)
// ";
// $statement = $link->prepare($query);
// $statement->execute(
//  array(
//   ':parent_comment_id' => $_POST["comment_id"],
//   ':comment'    => $comment_content,
//   ':name' => $comment_name,
//   ':post_id' => $post_id
//  )
// );
// $error = '<label class="text-success">Comment Added</label>';
// 
         $query = "INSERT INTO comments 
 (parent_comment_id, comment, name, post_id) 
 VALUES ('$comment_id','$comment_content','$comment_name','$post_id')";
        $result = mysqli_query($link, $query);
        while ($row = mysqli_fetch_array($result)) {
            $error = '<label class="text-success">Comment Added</label>';
        }
    }

    $data = array(
        'error' => $error
    );

    echo json_encode($data);
}
else {
    alert("Please Login First To Comment");
}
?>