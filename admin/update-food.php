<?php include('../config/menu.php'); ?> 

<?php
    //check whether id is set or not
    if(isset($_GET['id'])){
        $id = $_GET['id'];

        //SQL query to get the selected food
        $sql2 = "SELECT *FROM tbl_food WHERE id=$id";
        //execute the query
        $res2 = mysqli_query($conn, $sql2);
        
        $row2 = mysqli_fetch_assoc($res2);

        //get the individual vale of selected food
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];

    }else{

    }
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="echo <?php $title; ?>" placeholder="Title of the Food">
                    </td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the Food">echo <?php $description; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" value="echo <?php $price; ?>" placeholder="Price of the Food">
                    </td>
                </tr>
                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php 
                            if($current_image == ""){
                                echo "<div class='error'>Image not avilable.</div>";
                            }else{
                                ?>
                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                                <?php
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Select New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">
                            <?php
                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                                //execute the query
                                $res = mysqli_query($conn, $sql);

                                //count rows
                                $count = mysqli_num_rows($res);
                                
                                if($count > 0){
                                    while($row=mysqli_fetch_assoc($res)){
                                        $category_title = $row['title'];
                                        $category_id = $row['id'];

                                        // echo "<option value='$category_id'>$category_title.</option>";
                                        ?>
                                        <option <?php if($current_category==$category_id){echo "selected";} ?> value="<?php echo $category_id; ?>">
                                            <?php echo $category_title; ?>
                                        </option>
                                        <?php
                                    }

                                }else{
                                    echo "<option value='0'>Category Not available.</option>";
                                }
                            ?>
                            <option value="0">Test category</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured=="Yes") {echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes
                        <input  <?php if($featured=="No") {echo "checked";} ?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                    <input <?php if($active=="Yes") {echo "checked";} ?> type="radio" name="active" value="Yes"> Yes
                        <input  <?php if($active=="No") {echo "checked";} ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        
        <?php
            if(isset($_POST['submit'])){
                //1. get all the details from the form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //2. upload the img if selected
                if(isset($_FILES['image']['name'])){
                    $image_name = $_FILES['image']['name'];
                    if($image_name != ""){

                        //A. Upload new img
                        $ext = end(explode('.', $image_name));
                        $image_name = "Food-Name".rand(0000,9999).'.'.$ext;

                        //get the src path and destination path
                        $src_path= $_FILES(['image']['tmp_name']);
                        $dest_path = "../images/food/".$image_name;

                        //upload the img
                        $upload = move_uploaded_file($src_path, $dest_path);

                        if ($upload=false){
                            //failed to upload
                            $_SESSION['upload'] = "<div class'error'>failed to upload new image</div>";
                            header('location'.SITEURL.'admin/manage-food.php');
                            die();
                        }
                        //3. remove the img if new img is uploaded and current img exists

                        //B. Remove current img if available
                        if($current_image1=""){
                            //remove the img
                            $remove_path = "../images/food/".$current_image;

                            $remove = unlink(remove_path);
                            if ($remove == false){
                                $_SESSION['remove-failed'] = "<div class'error'>Fail to remove current image</div>";
                                hearder('location'.SITEURL.'admin/manage-food.php');
                                die();
                            }
                        }
                    }
                }else{
                    $image_name = $current_image;
                }

                //4. update the food in db
                $sql3 = "UPDATE tbl_food SET
                    title = '$title', 
                    description = '$description', 
                    price = $price, 
                    image_name = '$image_name', 
                    category_id = '$category', 
                    featured = '$featured', 
                    active = '$active', 
                    WHERE id=$id
                ";
                //execute the SQL query
                $res3 = mysqli_query($conn, $sql3);

                if($res3==true){
                    $_SESSION['update'] = "<div class='success'>Food updated successfully.</div>";
                    header('location'.SITEURL.'admin/manage-food.php');
                }else{
                    $_SESSION['update'] = "<div class='error'>Failed to updated food.</div>";
                    header('location'.SITEURL.'admin/manage-food.php');
                }
                //redirect to manage food with session msg
            }
        ?>

    </div>
</div>

<?php include('../config/footer.php'); ?> 