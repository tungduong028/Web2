


<?php 
//include constans file
include('../admin/config/constants.php');
//check id and img value is set or not
  if (isset($_GET['id']) AND isset($_GET['image'])) {
    # get value and delete
    $id = $_GET['id'];
    $image = $_GET['image'];
    //remove physical img is valaible
    if ($image != "") {
        # remove img
        $path="../images/category/".$image;
        if ($path != "") {
          $remove = unlink($path);
            
        }
        if ($remove == false) {
            # set session message
            
            $_SESSION['remove'] = "<div class='error'> Faile to remove category </div>";
            header('location:'.SITEURL.'admin/manage-category.php');
            die();
        }
    }
    //delete data from database

    //redirect to manage category page
    $sql = "DELETE FROM category WHERE id=$id";
    $res = mysqli_query($conn, $sql);
    //check result of delete
    if ($res==true) {
        $_SESSION['delete'] = "<div class='success'>Delete success</div>";
        header('location:'.SITEURL.'admin/manage-category.php');
        //die();
        
    }
    else {
        $_SESSION['delete'] = "<div class='error'>Delete faile</div>";
        header('location:'.SITEURL.'admin/manage-category.php');
        //die();
    }
  }
  else {
    # redirect to maneger category page
    header('location:'.SITEURL.'admin/manage-category.php');
    //die();
  }
?>