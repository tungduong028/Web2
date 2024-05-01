<?php include('patials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update category</h1>

        <br> <br>
       <?php 
       //include('./config/constants.php');
        //check wherther id set or not
        if (isset($_GET['id'])) {
            # get id and all other
            //echo "getting data";
            $id = $_GET['id'];
            $sql = "SELECT * FROM category WHERE id = '$id'";

            $res = mysqli_query($conn, $sql);

            $count = mysqli_num_rows($res);

            if ($count == 1) {
                # get all data
                $row = mysqli_fetch_assoc($res);
                $title = $row['title'];
                $current_image = $row['image'];
                $featured = $row['show_on_home'];
                $active = $row['active'];
            }
            else {
                # code...
                $_SESSION['no-category-found'] = "<div class='error'>Category not found</div>";
                header('location:'.SITEURL.'admin/manage-category.php');
                //die();
            }
        }
        else {
            # code...
            //$_SESSION['id'] = "<div class='error'></div>";
            header('location:'.SITEURL.'admin/manage-category,php');
        }
       
       ?> 
     

       <form action="" method="POST" enctype="multipart/form-data">
         <table class="tbl-30">
            <tr>
                <td>title:</td>
                <td>
                    <input type="text" name="title" value="<?php echo $title; ?>">
                </td>
            </tr>

            <tr>
                <td>current img:</td>
                <td> 
                    <?php 
                       if( $current_image != '') {
                        ?>
                          <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="150px">
                        <?php
                       }
                       else {
                         echo "<div class='error'>img not Added</div>";
                       }
                    ?>
                </td>
            </tr>

            <tr>
                 <td>New img:</td>
                 <td>
                    <input type="file" name="image">
                 </td>
            </tr>

            <tr>
                <td>Featured:</td>
                <td>
                    <input <?php if ($featured == "Yes") { echo "checked"; } ?> type="radio" name="show_on_home" value="Yes">Yes
                    <input <?php if ($featured == "No") { echo "checked"; } ?> type="radio" name="show_on_home" value="No">No
                </td>
            </tr>

            <tr>
                <td>Active:</td>
                <td>
                    <input <?php if ($active == "Yes") { echo "checked"; } ?> type="radio" name="active" value="Yes">Yes
                    <input <?php if ($active == "No") { echo "checked"; } ?> type="radio" name="active" value="No">No
                </td>
            </tr>

            <tr>
                <td>
                <input type="hidden" name="current_image" value="<?php echo $current_image;?>"> 
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="submit" name="submit" value=" update category" class="btn-secondary">
                </td>
            </tr>

         </table>
        </form>
        <?php
           if (isset($_POST['submit'])) {
            //echo "<div class='success'> Update Done </div>";
            $title = $_POST['title'];
            $current_image = $_POST['current_image'];
            $featured = $_POST['show_on_home'];
            $active = $_POST['active'];
            //upate img
            // echo $title;
            // echo $current_image;
            // echo $featured;
            // echo $active;
            // die();
            //check img
            if (isset($_FILES['image']['name'])) {
                # get details
                $image = $_FILES['image']['name'];
                //check wherther img exists
                if ($image != "") {
                    //auto rename + get (jpg,jpeg, png, gif, etc...)
                    $ext = end(explode('.', $image));
                    //rename
                    $image = "Food_category_". uniqid().'.'.$ext;
                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = "../images/category/".$image;
                    //finally upload the file
                    $upload = move_uploaded_file($source_path,$destination_path);
                    //check whether img is selected
                    if ($upload == false) {
                    # code...
                    $_SESSION['upload'] = "<div class='error'>failed to Update image </div> ";
                    header('location:'.SITEURL.'admin/add-category.php');
                    // stop pocess 
                    die();
                    }

                    //remove old img
                    // echo $current_image;
                    // die();

                    if ($current_image != "" ) {
                        $remove_path = "../images/category/".$current_image;
                        $remove = unlink($remove_path);
                        //check whether remove img
                        echo $remove;
                        if ($remove == false) {
                        $_SESSION['update_remove_img'] = "<div class='error'> Faile to remove current img </div>";
                        //header('location:'.SITEURL.'admin/manage-category.php');
                        die();
                        }
                    }
                    

                }
                else{
                    $image = $current_image;
                }
                
            }
            else {
                $image = $current_image;
            }
            //update new data
            $sql2 = "UPDATE category SET 
            title = '$title',
            image = '$image',
            show_on_home = '$featured',
            active = '$active'
            WHERE id = '$id'";

            $res2 = mysqli_query($conn, $sql2);

            if ($res2 == true) {
                # code...
                $_SESSION['update'] = "<div class='success'>Update success </div>";
                header('location:'.SITEURL.'admin/manage-category.php');
            }
            else {
                $_SESSION['update'] = "<div class='error'>Update false </div>";
                header('location:'.SITEURL.'admin/manage-category.php');
            }
 
           }
        ?>
    </div>
</div>






<?php include('../admin/patials/footer.php') ?>
