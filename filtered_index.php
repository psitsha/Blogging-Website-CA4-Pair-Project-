<?php
//connect to the database
include('database.php');
session_start();

// If session variable is not set it will redirect to login page
//if (!isset($_SESSION['name']) || empty($_SESSION['name'])) {
//    header("Location: login.php");
//    exit;
//}
//get record count of posts in database
$record_count = $link->query("SELECT * FROM posts");

//amount displayed
$per_page = 2;

//number of pages
$pages = ceil($record_count->num_rows / $per_page);  //round up next highest integers 
//get page number and find out which page we are on
if (isset($_GET['p']) && is_numeric($_GET['p'])) {
    $page = $_GET['p'];
} else {
    $page = 1;
}
//starting point
if ($page <= 0) {
    $start = 0;
} else {
    $start = $page * $per_page - $per_page;
}
$prev = $page - 1;
$next = $page + 1;

$search=$_POST['search'];

$query = $link->prepare("SELECT u.name,u.avatar, p.date, p.post_id, p.post_title, LEFT(p.content, 200) AS content "
        . "FROM users as u, posts as p WHERE u.user_id = p.user_id and (p.post_title like '%$search%' or u.name like '%$search%') "
        . "ORDER BY p.post_id DESC LIMIT $start, $per_page"  );
$query->execute();
$query->bind_result($name, $avatar, $date, $post_id, $post_title, $content);




include("include/header.php");
?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

<?php
while ($query->fetch()):
    $lastspace = strrpos($content, ' ')
    ?>
                <div class="card mb-4">
                    <img class="card-img-top" src="img/blog.png" alt="Card image cap">
                    <div class="card-body">
                        <h2 class="card-title"><?php echo $post_title ?></h2>

    <!--                  <a href=<?php echo 'view_post.php?post_id=' . $post_id ?>class="btn btn-primary" class="btn btn-primary">Read More &rarr;</a>-->
    <?php echo substr($content, 0, $lastspace) . "<a href='view_post.php?post_id=$post_id' class='btn btn-primary' class='btn btn-primary'> READ MORE...</a>" ?>
                    </div>
                    <div class="card-footer text-muted">
                        Posted on <?php echo $date ?> by
                        <a href="#"><?php echo $name ?></a>  <img src='uploads/<?php echo$avatar ?>' style='margin-right: 0%; height:24px;width: 24px;'>
                    </div>
                </div>
<?php endwhile ?>


            <!-- Blog Post -->
            <!--          <div class="card mb-4">
                        <img class="card-img-top" src="http://placehold.it/750x300" alt="Card image cap">
                        <div class="card-body">
                          <h2 class="card-title">Post Title</h2>
                          <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis aliquid atque, nulla? Quos cum ex quis soluta, a laboriosam. Dicta expedita corporis animi vero voluptate voluptatibus possimus, veniam magni quis!</p>
                          <a href="#" class="btn btn-primary">Read More &rarr;</a>
                        </div>
                        <div class="card-footer text-muted">
                          Posted on January 1, 2017 by
                          <a href="#">Blog</a>
                        </div>
                      </div>-->


            <!-- Pagination -->
            <!--          <ul class="pagination justify-content-center mb-4">
                        <li class="page-item">
                          <a class="page-link" href="#">&larr; Older</a>
                        </li>
                        <li class="page-item disabled">
                          <a class="page-link" href="#">Newer &rarr;</a>
                        </li>
                      </ul>-->

        </div>

        <!-- Sidebar Widgets Column -->
        <div class="col-md-4">

            <!-- Search Widget -->
            <form method="post" action="filtered_index.php" >
            <div class="card my-4">
                <h5 class="card-header">Search</h5>
                <div class="card-body">
                    <div class="input-group">
                     
                            <input type="text" class="form-control" placeholder="Search for..." name='search'>
                            <span class="input-group-btn">
                                <!--                  <button class="btn btn-secondary" type="button">Go!</button>-->
                                <input class="btn btn-secondary"  name="submit" type="submit" value="Search">
                                
                            </span>
                    </div>
                </div>
            </div>
               </form>
            <!-- Categories Widget -->
            <div class="card my-4">
                <h5 class="card-header">Tags</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-unstyled mb-0">
                                <li>
                                    <a href="#">Web Design</a>
                                </li>
                                <li>
                                    <a href="#">HTML</a>
                                </li>
                                <li>
                                    <a href="#">Freebies</a>
                                </li>

                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <ul class="list-unstyled mb-0">
                                <li>
                                    <a href="#">JavaScript</a>
                                </li>
                                <li>
                                    <a href="#">CSS</a>
                                </li>
                                <li>
                                    <a href="#">Tutorials</a>
                                </li>
                            </ul>
                        </div>


                    </div>
                </div>
            </div>

            <!-- Side Widget -->
            <div class="card my-4">
                <h5 class="card-header">Side Widget</h5>
                <div class="card-body">
                    You can put anything you want inside of these side widgets. They are easy to use, and feature the new Bootstrap 4 card containers!
                </div>
            </div>

        </div>

    </div>
    <!-- /.row -->

</div>
<!-- /.container -->

<!-- Footer -->
<footer class="py-5 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Your Website 2018</p>
    </div>
    <!-- /.container -->
</footer>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
