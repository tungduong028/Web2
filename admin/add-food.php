<?php include('../admin/patials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br><br>

        <?php
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset ($_SESSION['upload']);
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data"> 
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the Food">
                    </td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the Food"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" placeholder="Price of the Food">
                    </td>
                </tr>
                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">
                            <?php
                                // Create PHP Code to display categories from Database
                                //1. Create SQL to get all active categories from Database
                                $sql = "SELECT * FROM category WHERE active='Yes'";
                                // echo $sql;
                                // die();

                                $res = mysqli_query($conn, $sql);

                                //Count Rows to check wherther we have categories or not
                                $count = mysqli_num_rows($res);

                                //If count is greater than zero, we have categories else we donot have categories
                                if($count>0){
                                    //We have categories
                                    while($row=mysqli_fetch_assoc($res)){
                                        //get the details of categories
                                        $id = $row['id'];
                                        $title = $row['title'];
                                        ?>
                                        <option value="<?php echo $id; ?>">
                                            <?php echo $title; ?>
                                        </option>
                                        <?php
                                    }
                                }else{
                                    //We donot have categories
                                    ?>
                                    <option value ="0">No Category Found</option>
                                    <?php
                                }

                                //2. Display on dropdown
                            ?>

                        </select>
                    </td>
                </tr>
                <tr>
                    <td>show_on_home: </td>
                    <td>
                        <input type="radio" name="show_on_home" value="Yes"> Yes
                        <input type="radio" name="show_on_home" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>                    
                </tr>
            </table>
        </form>

        <?php
            //Check whether the button is clicked or not
            if(isset($_POST['submit']))
            {
                //add the Food in Database
                //echo clicked

                //1. Get the data from form
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category_id = $_POST['category'];

                //Check whether radio button for show_on_home and active are checked or not
                if(isset($_POST['show_on_home']))
                {
                    $show_on_home = $_POST['show_on_home'];
                }
                else
                {
                    $show_on_home = "No";
                }
                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No"; //Setting default value
                }
            
                //2. Upload the image if selected
                // Check whether the select image is clicked or not and upload the image only if the image is selected
                if(isset($_FILES['image']['name']))
                {
                    //Get the details of the selected image
                    $image = $_FILES['image']['name'];

                    //check whether the image is selected or not and upload image only if selected
                    if($image!="")
                    {
                        //Image is selected
                        // A. Rename the 
                        //Get the extention of selectec image (jpg, png, gif, etc,... ) "fast-food.jpg"

                        ### $ext = end(explode('.', $image));

                        $image_name_parts = explode('.', $image);
                        $ext = end($image_name_parts);
                        // echo $ext;
                        // die();

                        //Create New name for image
                        $image = "Food-Name".rand(0000,9999).".".$ext; //New

                        // B. upload the 
                        //get the src path and destination path

                        //src path is the current location of the image
                        $src = $_FILES['image']['tmp_name'];
                        // echo $src;
                        // die();

                        //destination path for the image to be uploaded
                        $dst = "../images/food/".$image;
                        echo $dst;

                        //finally upload the food image
                        $upload = move_uploaded_file($src, $dst);

                        //check whether image uploaded of not
                        // echo $upload;
                        // die();

                        if($upload==false)
                        {
                            //failed to upload the image
                            //redirect to add foor page with error message
                            $_SESSION['upload']="<div class='error'>Failed to upload image.</div>";
                            header('location: '.SITEURL.'admin/add-food.php');
                            
                            //stop the process
                            die();
                        }

                    }
                }
                else
                {
                    $image = ""; //setting default value as blank
                }
                

                //3. Insert into database

                // create a SQL query to save or add food
                // for numerical we do not need to pass value inside quotes ''. But for string value it is compulsory to add quotes ''
                $sql2 = "INSERT INTO food SET
                    name = '$title',
                    description = '$description',
                    price = $price,
                    image = '$image',
                    category_id = '$category_id',
                    show_on_home = '$show_on_home',
                    active = '$active'
                ";
                
                //execute the query
                $res2 = mysqli_query($conn, $sql2);

                //check whether data inserted or not
                //4. redirect with message to manage food page
                if($res2 == true)
                {
                    $_SESSION['add'] = "<div class='success'>Added Successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    $_SESSION['add'] = "<div class='error'>Failed to add food.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }

            }
        ?>

    </div>
</div>

<?php include('../admin/patials/footer.php'); ?> 

