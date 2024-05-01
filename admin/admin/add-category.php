<?php 
include('../admin/patials/menu.php')
?>



<div class="main-content">
    <div class="wrapper">

    <h1>ADD CATEGORY</h1> <br><br>
    <?php
       if (isset($_SESSION['add'])) {
        echo $_SESSION['add'];
        unset($_SESSION['add']);
       }
    ?> 
    <?php 
       if (isset($_SESSION['upload'])) {
        echo $_SESSION['upload'];
        unset($_SESSION['upload']);
       }
    ?> 
    
    <br><br>

    <!-- add category starts-->
    <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">
            <tr>
                <td>Title: </td>
                <td>
                    <input type="text" name="title" placeholder="Category Title">
                </td>
            </tr>
            <tr>
                <td>Image:</td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>
            <tr>
                <td>Featured: </td>
                <td>
                    <input type="radio" name="show_on_home" value="Yes"> Yes
                    <input type="radio" name="show_on_home" value="No"> No
                </td>
            </tr>
            <tr>
                <td>Action: </td>
                <td>
                    <input type="radio" name="active" value="Yes"> Yes
                    <input type="radio" name="active" value="No"> No

                </td>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </tr>
        </table>
    </form>
    <!-- add category ends-->
    <?php 
    //check wheter the submit button is clickde or not
    if(isset($_POST['submit']))
    {
        //echo "clicked";
        //1. get the value from the category form
        $title = $_POST['title'];
        
        //for radio input, we need check wheter the button is selected or not
        if(isset($_POST['show_on_home']))
        {
            //get the value from form
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
            $active = "No";
        }
        // check whether img is selected or not
        //print_r($_FILES['image']);
        //die(); //break out code
        if (isset($_FILES['image']['name'])) {
            # upload the img 
            $image = $_FILES['image']['name'];

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
                $_SESSION['upload'] = "<div class='error'>failed to upload image </div> ";
                header('location:'.SITEURL.'admin/add-category.php');
                // stop pocess 
                die();
            }
        }
        }
        else {
            # don't upload the img and set img_name value is blank
            $image = "";
        }
        //2. create a SQL query to insert category into database
        $sql = "INSERT INTO category SET 
        title = '$title',
        image = '$image',
        show_on_home = '$show_on_home',
        active = '$active'
        ";
        //3. execute the query and save in database
        $res = mysqli_query($conn, $sql);
        //4. check whether the query executed  or not  and data  added or  not
        if ($res==true) {
            //query executed and category added
            $_SESSION['add'] = "<div class='success'>Category Added successfully </div> ";
            header('location:'.SITEURL.'admin/manage-category.php');
            
        }
        else {
            //faile to add category
        }
    }
    ?>
    </div>
</div>



<?php 
include('../admin/patials/footer.php')
?>