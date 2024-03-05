<<?php

session_start();

include("classes/db_conn.php");
include("classes/video.php");


$db_conn = new DatabaseConn();

$video = new Video($db_conn->get_db_conn()); 

$videos = $video->get_all_videos();


if ($_SERVER["REQUEST_METHOD"] == "POST" || isset($_POST["video_id"])) {


    $video_obj = new Video($db_conn->get_db_conn());
    $video = $video_obj->delete_video($_POST['video_id']);

    header("Location: learning.php?msg=success");


}




include("includes/header.php");

?>

<!-- Main Content -->
<div class="container col-md-8 mt-5">

        <div class="mb-4 text-center">

        <h2 class="mb-3 pb-1">Ceramics Learning Centre</h2>

        <?php if(isset($_SESSION["admin_data"])): ?>
            <a href="add-video.php" class="btn btn-success mb-3">Add Video</a>
        <?php endif; ?>

        <?php
        
        if(isset($_GET["msg"]) && $_GET["msg"] == "success") {
            echo '<p class="fw-bold text-success">Video Deleted.<p>';
        }

        
        
        ?>

        </div>


      <?php foreach($videos as $video): ?>
        <div class="card mb-4">
            
            <iframe class="card-img-top" height="400" src="<?php echo $video['video_link']; ?>"></iframe>
            
                <div class="card-body">
                <h5 class="card-title"><?php echo $video['title']; ?></h5>
                <p class="card-text text-muted"><?php echo $video['description']; ?></p>

                <a href="https://www.youtube.com/watch?v=<?php echo basename(parse_url($video['video_link'], PHP_URL_PATH)); ?>" 
                target="_blank" class="btn btn-danger">
                    Watch On YouTube &RightArrow;
                </a>

                <?php // Only Admin can see an edit and delete video  ?>

                <?php if(isset($_SESSION["admin_data"])): ?>

                    <hr>

                    <a href="edit-video.php?video_id=<?php echo $video['id']; ?>" class="btn btn-success">Edit</a>

                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="d-inline-block"
                    onsubmit="return confirm('Delete Video?');" method="POST">
                        <input type="hidden" name="video_id" value="<?php echo $video['id']; ?>">
                        <button type="submit" name="delete_video" class="btn btn-danger">Delete</button>
                    </form>

                <?php endif; ?>


            </div>
        </div>
        
      <?php endforeach; ?>


    
</div>



<?php include("includes/footer.php"); ?>