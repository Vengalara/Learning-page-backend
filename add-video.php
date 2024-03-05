<<?php

session_start();

// only Admin can make video
if(!isset($_SESSION['admin_data'])){
    header('Location: index.php');
}

include("classes/db_conn.php");
include("classes/video.php");


$db_conn = new DatabaseConn();

$video = new Video($db_conn->get_db_conn()); 

$videos = $video->get_all_videos();


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(
        empty($_POST["link"]) 
        || empty($_POST["title"]) 
        || empty($_POST["description"]) 
        
    ) {
        
        header("Location: add-video.php?msg=error");

    } else {


        $db_conn = new DatabaseConn();
        $db = $db_conn->get_db_conn();

        $video_obj = new Video($db);
        $video = $video_obj->create_video($_POST);

        header("Location: add-video.php?msg=success");

    }

}







include("includes/header.php");

?>

<!-- Main Content -->
<div class="container col-md-8 mt-5">

<div class="container">

   <div class="text-center">

   
      <h2 class="mt-5 mb-4">Add Video</h2>

        
        <?php

            if(isset($_GET["msg"]) && $_GET["msg"] == "error") {
            echo '<p class="fw-bold text-danger">All Fields are Required.<p>';
            }

            if(isset($_GET["msg"]) && $_GET["msg"] == "success") {
                echo '<p class="fw-bold text-success">New Video Added.<p>';
            }
    


        ?>

   </div>


    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="mb-5">
      <div class="mb-3">
        <label for="link" class="form-label">Video Link</label>
        <input type="text" class="form-control" id="videoLink" name="link" placeholder="https://www.youtube.com/embed/OVtjG6DawxE">
      </div>
      <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="videoTitle" name="title" placeholder="Title">
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="videoDescription" name="description" rows="3" placeholder="Description"></textarea>
      </div>
      <button type="submit" class="btn btn-dark">Add</button>
    </form>
  </div>

    
</div>



<?php include("includes/footer.php"); ?>