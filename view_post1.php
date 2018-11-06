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


$sql = "SELECT post_title, content, disable_comments FROM posts WHERE post_id='$post_id'";
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
include("include/header.php");
?>
<!DOCTYPE html>

<div id="wrapper">
    <?php
    $row = $query->fetch_object();
    echo "<h2>" . $row->post_title . "<h2>";
    echo "<p>" . $row->content . "<p>";
    echo "</div>
<hr />

<br />";



    //echo "<p>" . $row->disable_comments . "<p>";
    if ($row->disable_comments == 0) {
        echo"<div class='container'>
    <h4>Leave a Comment:</h4>
    <form method='POST' id='comment_form'>
        <div class='form-group'>
            <input type='text' name='comment_name' id='comment_name' class='form-control'placeholder='Enter Name'/>
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

</body>
</html>

<script>
    $(document).ready(function () {

        $('#comment_form').on('submit', function (event) {
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

