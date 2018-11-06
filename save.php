
<div class="container">	
    <h2>Create Bootstrap Tags Input with jQuery, PHP & MySQL</h2>
    <br>
    <br>
    <?php
    session_start();
    include_once("database.php");


//
//    $insert_query = $link->prepare("INSERT INTO posts ('post_title','content','comment','tag_name') VALUES (?,?,?,?)");
//    $insert_query->bind_param($post_title, $content, $comment, $tags);
////        mysqli_query($link, $insert_query) or die("database error: " . mysqli_error($link));
    $post_id=null;
    $user_id=$_SESSION['user_id'];
        $tags = $_POST['skills'];
    $post_title = $_POST['post_title'];
    $content = $_POST['content'];
    $comment = $_POST['comment'];
$likes="0";
$dislikes="0";
//    $insert_query->execute();
//    
    //
         $insert_query = "INSERT INTO posts (post_title,content,user_id,disable_comments,tags,likes,dislikes) VALUES ('".$post_title."','".$content."','".$user_id."','".$comment."','".$tags."','".$likes."','".$dislikes."')";
       
        mysqli_query($link, $insert_query) or die("database error: " . mysqli_error($link));
    
    echo "Your details saved successfully. Thanks!";
    header("Location: index.php");
    ?>
<!--    <br>
    <br>
    <div style="margin:50px 0px 0px 0px;">
        <a class="btn btn-default read-more" style="background:#3399ff;color:white" href="index.php">Back to Tutorial</a>		
    </div>
</div>-->





