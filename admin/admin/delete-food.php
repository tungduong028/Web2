<?php
    //echo "delete food page"
    include('../admin/config/constants.php');

    if(isset($_GET['id']) && isset($_GET['image'])){ //either 'use' && or 'AND'
        //process to delete
        
        //1. get ID and image name
        $id = $_GET['id'];
        $image = $_GET['image'];


        //2. remove the image if available
        //check whether the image is available or not and delete only if available
        if($image != ""){
            //it has image and need to remove from folder
            //get the image path
            $path = "../images/food/".$image;

            //remmove image file from folder
            $remove = unlink($path);

            //check whether the image is removed or not
            if($remove==false){
                //failed to remove img
                $_SESSION['upload'] = "<div claas='error'>Failed to remove image</div>";
                //redirect to manage food
                header('location:'.SITEURL.'admin/manage-food.php');
                //stop the process of delete food
                die();
            }
        }

        //3. delete food from db
        $sql = "DELETE FROM food WHERE id=$id";
        //execute the query
        $res = mysqli_query($conn, $sql);
        
        //check whether the query executed or not and set the session message respectively
        if ($res==true){
            //food deleted
            $_SESSION['delete'] = "<div class='success'>Food deleted successfully.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }else{
            $_SESSION['delete'] = "<div class='success'>Food deleted successfully.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }


        //4. redirect to manage food with session message


    }else{
        //redirect to manage food page
        //echo "redirect"
        $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }
?>