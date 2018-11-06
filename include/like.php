<div class="container-fluid">
     <div class="row">
       <?php
       $qry = "select * from `post_list`";
       $res = mysqli_query($con, $qry);
       if(mysqli_num_rows($res) > 0) {
         while($row = mysqli_fetch_object($res)) {
           $likes = array_filter(explode(',', $row->likes), function($value) { return $value !== ''; });
           $dislikes = array_filter(explode(',', $row->dislikes), function($value) { return $value !== ''; });
         ?>
           <div class="col-md-3">
             <div class="mtb-post">
               <form action="" method="post" id="<?php echo $row->id;?>">
                 <input type="hidden" name="post_id" id="post_id" value="<?php echo $row->id;?>">
                 <img class="img-fluid" src="images/<?php echo $row->image;?>">
                 <div class="post-info">
                   <div class="caption"><a href="<?php echo $row->link;?>" target="_blank"><h1><?php echo $row->title;?><h1></a></div>
                   <div class="excerpt"><?php echo $row->excerpt;?></div>
                   <div class="like-dislike">
                     <div class="like"><div class="counter"><?php echo sizeof($likes);?></div></div>
                     <div class="dislike"><div class="counter"><?php echo sizeof($dislikes);?></div></div>
                     <div class="clearfix"></div>
                   </div>
                 </div>
                 <div class="clearfix"></div>
               </form>
             </div>
           </div>
         <?php
         }
       }
       ?>
     </div>
     </div>