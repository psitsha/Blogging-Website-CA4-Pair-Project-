<?php
if (!isset($_GET['post_id'])) {
    header('location: index.php');
    exit();
} else {
    $post_id = $_GET['post_id'];
}

include('database.php');
if (!is_numeric($post_id)) {
    header('location: index.php');
}


$sql = "SELECT post_title, content, disable_comments,likes,dislikes FROM posts WHERE post_id='$post_id'";
$query = $link->query($sql);

$q = $link->prepare("SELECT disable_comments FROM posts WHERE post_id='$post_id'");
$q->execute();
$q->bind_result($c);
//echo $query->num_rows;  one for each post_id
//
if ($query->num_rows != 1) {
    header('location: index.php');
    exit();
}
?>

<?php
session_start();
include("include/header.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="js/mtb.js"></script>

        <script src="js/jquery.min.js"></script>
        <script src="bootstrap/js/popper.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <style>
            .post-title { font-size:20px; }
            .mtb-margin-top { margin-top: 20px; }
            .top-margin { border-bottom:2px solid #ccc; margin-bottom:20px; display:block; font-size:1.2rem; line-height:1.7rem;}
            .like {
                background-image: url('img/like.png');
                margin-right: 30px;
            }
            .like:hover {
                background-image: url('img/liked.png');
            }
            .dislike {
                background-image: url('img/dislike.png');

            }
            .dislike:hover {
                background-image: url('img/disliked.png');
            }
            .like,.dislike {
                /*height:55px;*/
                width:74px;
                background-repeat: no-repeat;
                float: left;
                background-size: 35%;
                cursor: pointer;
            }
            .counter {
                /*position: absolute;
                bottom: 0;*/
                padding-left:35px;
            }




            #popUpWindow{
                /*background: #ccc; 
                opacity:0.5;*/
            }

            @media (min-width: 576px) {
                .modal-dialog {
                    max-width:300px;
                }
            }
            .modal-header form {
                width: 100%;
            }

            .mtb-post {
                border:1px solid #ccc;
            }
            .post-info {
                padding:10px;
            }
            .caption {
                margin-top:10px;
            }
            .caption h1 {
                font-size:1.1rem;
            }
            .excerpt {
                line-height: 1.1rem;
                font-size: 13px;
            }
            .clearfix {
                clear:both;
            }
            .like-dislike {
                padding:10px 0;
            }
            .modal-title {
                width: 100%;
            }
        </style>
    </head>
    <body>
        <br />
        <!--        <h2 align="center"><a href="#">Blog Title</h2></a></h2>-->

        <div id="wrapper">
            <?php
            $row = $query->fetch_object();

//            $likes = $row->likes;
//            $dislikes = $row->dislikes;
//                 $likes1=sizeof($likes);
//            $dislikes1=sizeof($dislikes);

            echo "<h2>" . $row->post_title . "<h2>";
            echo "<p>" . $row->content . "<p>";
            echo "</div>
<hr /><br />";
            // echo"<h2>$post_id <h2>";
            //echo "<p>" . $row->disable_comments . "<p>";
            if ($row->disable_comments == 0) {
                echo"<div class='container'>
    <h4>Leave a Comment:</h4>
    <form method='POST' id='comment_form'>
        <div class='form-group'>
           
        </div>
        <div class='form-group'>
            <textarea name='comment_content'id='comment_content' class='form-control' placeholder='Enter Comment'rows='5'></textarea>
        </div>
        <div class='form-group'>
            <input type='hidden' name='comment_id' id='comment_id'value='0' />
            <input type='hidden'name='post_id' id='post_id' value='" . $post_id . "' />
            <input type='submit'name='submit' id='submit' class='btn btn-info' value='Post Comment' />
        </div>
    </form>
    <span id='comment_message'></span>
    <br />
    <div id='display_comment'></div>
</div>
    
"
                ;
            } else {
                echo "Comments Are Disabled For This Post ";
            }
            ?>

            <?php
            if ($row->disable_comments == 0 ) {
                $q = "SELECT sum(likes) ,sum(dislikes) FROM likes where post_id=".$post_id;
                $result = mysqli_query($link, $q);
                while ($row = mysqli_fetch_array($result)) {
                   $likes=$row["sum(likes)"];
                     $dislikes=$row["sum(dislikes)"];
                }
                echo
                "<form action = '' method = 'post' id = '" . $post_id . "'>
                <input type = 'hidden' name = 'post_id' id = 'post_id' value = '" . $post_id . "'>

                <div class = 'post-info'>

                    <div class = 'like-dislike'>
                        <div class = 'like'><div class = 'counter'>" . $likes . "</div></div>
                        <div class='dislike'><div class='counter'>" . $dislikes . "</div></div>
                        <div class='clearfix'></div>
                    </div>
                </div>
                <div class='clearfix'></div>
            </form>
            ";
            }
            ?>
    </body>
</html>

<script>
    $(document).ready(function () {

        $('#comment_form').on('submit', function (event) {
            alert("submited");
            event.preventDefault();
            var form_data = $(this).serialize();
            $.ajax({
                url: "add_comment.php",
                method: "POST",
                data: form_data,
                dataType: "text",
                success: function (data)
                {
                    if (data.error != '')
                    {
                        $('#comment_form')[0].reset();
                        $('#comment_message').html(data.error);
                        $('#comment_id').val('0');
                        load_comment();
                    }
                }
            })
        });

        load_comment();

        function load_comment()
        {
            $.ajax({
                url: "fetch_comment.php?post_id=<?php echo $post_id ?>",
                method: "POST",
                success: function (data)
                {
                    $('#display_comment').html(data);
                }
            })
        }

        $(document).on('click', '.reply', function () {
            var comment_id = $(this).attr("id");
            $('#comment_id').val(comment_id);
            $('#comment_name').focus();
        });

    });
</script>

