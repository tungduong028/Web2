<?php
include('../admin/patials/menu.php'); 

// Check whether id is set or not
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // SQL query to get the selected food
    $sql2 = "SELECT * FROM food WHERE id=$id";
    // Execute the query
    $res2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($res2);

    // Get the individual value of selected food
    $name = $row2['name'];
    $description = $row2['description'];
    $price = $row2['price'];
    $current_image = $row2['image'];
    $current_category = $row2['category_id'];
    $show_on_home = $row2['show_on_home'];
    $active = $row2['active'];
}

// Xử lý form trước khi xuất bất kỳ HTML nào
if (isset($_POST['submit'])) {
    //1. get all the details from the form
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $current_image = $_POST['current_image'];
    $category = $_POST['category'];
    $show_on_home = $_POST['show_on_home'];
    $active = $_POST['active'];

    //2. upload the img if selected
    if (isset($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        if ($image != "") {
            // A. Upload new img
            $image_parts = explode('.', $image);
            $ext = end($image_parts);

            // Create New name for image
            $image = "Food-Name" . rand(0000, 9999) . "." . $ext;

            // Get the src path and destination path
            $src_path = $_FILES['image']['tmp_name'];
            $dest_path = "../images/food/" . $image;

            // Upload the img
            $upload = move_uploaded_file($src_path, $dest_path);

            if ($upload == false) {
                // Failed to upload
                $_SESSION['upload'] = "<div class='error'>Failed to upload new image</div>";
                header('location:' . SITEURL . 'admin/manage-food.php');
                die();
            }

            // B. Remove current img if available
            if ($current_image != "") {
                // Remove the img
                $remove_path = "../images/food/" . $current_image;

                $remove = unlink($remove_path);
                if ($remove == false) {
                    $_SESSION['remove-failed'] = "<div class='error'>Failed to remove current image</div>";
                    header('location:' . SITEURL . 'admin/manage-food.php');
                    die();
                }
            }
        } else {
            $image = $current_image;
        }
    } else {
        $image = $current_image;
    }

    //4. update the food in db
    $sql3 = "UPDATE food SET
        name = '$name', 
        description = '$description', 
        price = $price, 
        image = '$image', 
        category_id = '$category', 
        show_on_home = '$show_on_home', 
        active = '$active'
        WHERE id= $id";

    // Execute the SQL query
    $res3 = mysqli_query($conn, $sql3);

    if ($res3 == true) {
        $_SESSION['update'] = "<div class='success'>Food updated successfully.</div>";
        header('location:' . SITEURL . 'admin/manage-food.php');
    } else {
        $_SESSION['update'] = "<div class='error'>Failed to update food.</div>";
        header('location:' . SITEURL . 'admin/manage-food.php');
    }
    // Redirect to manage food with session message
    exit(); // Ensure script stops after redirection
}
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Name: </td>
                    <td>
                        <input type="text" name="name" value="<?php echo $name; ?>" placeholder="Name of the Food">
                    </td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the Food"><?php echo $description; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price; ?>" placeholder="Price of the Food">
                    </td>
                </tr>
                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php 
                            if ($current_image == "") {
                                echo "<div class='error'>Image not available.</div>";
                            } else {
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
                                $sql = "SELECT * FROM category WHERE active='Yes'";
                                // Execute the query
                                $res = mysqli_query($conn, $sql);
                                // Count rows
                                $count = mysqli_num_rows($res);

                                if ($count > 0) {
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        $category_title = $row['title'];
                                        $category_id = $row['id'];
                                        ?>
                                        <option <?php if ($current_category == $category_id) { echo "selected"; } ?> value="<?php echo $category_id; ?>">
                                            <?php echo $category_title; ?>
                                        </option>
                                        <?php
                                    }
                                } else {
                                    echo "<option value='0'>Category Not available.</option>";
                                }
                            ?>
                            <option value="0">Test category</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Show on home: </td>
                    <td>
                        <input <?php if ($show_on_home == "Yes") { echo "checked"; } ?> type="radio" name="show_on_home" value="Yes"> Yes
                        <input <?php if ($show_on_home == "No") { echo "checked"; } ?> type="radio" name="show_on_home" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if ($active == "Yes") { echo "checked"; } ?> type="radio" name="active" value="Yes"> Yes
                        <input <?php if ($active == "No") { echo "checked"; } ?> type="radio" name="active" value="No"> No
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
    </div>
</div>

<?php include('../admin/patials/footer.php'); ?> 
