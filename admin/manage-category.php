<?php include('patials/menu.php'); ?>


        <!-- Main content -->
        <div class="main-content">
            <div class="wrapper">
                <h1>Manage Category</h1>

                <br /><br />
                <?php
                   if (isset($_SESSION['add'])) {
                     echo $_SESSION['add'];
                     unset($_SESSION['add']);
                   }
                ?>
                <?php
                   if (isset($_SESSION['remove'])) {
                     echo $_SESSION['remove'];
                     unset($_SESSION['remove']);
                   }
                ?>
                <?php
                   if (isset($_SESSION['delete'])) {
                     echo $_SESSION['delete'];
                     unset($_SESSION['delete']);
                   }
                ?>
                <?php
                   if (isset($_SESSION['no-category-found'])) {
                     echo $_SESSION['no-category-found'];
                     unset($_SESSION['no-category-found']);
                   }
                ?>
                <?php
                   if (isset($_SESSION['update'])) {
                     echo $_SESSION['update'];
                     unset($_SESSION['update']);
                   }
                ?>
                <?php
                   if (isset($_SESSION['upload'])) {
                     echo $_SESSION['upload'];
                     unset($_SESSION['upload']);
                   }
                ?>
                <?php
                   if (isset($_SESSION['update_remove_img'])) {
                     echo $_SESSION['update_remove_img'];
                     unset($_SESSION['update_remove_img']);
                   }
                ?>
               <br /><br />

                <a href="<?php echo SITEURL;?>admin/add-category.php" class="btn-add">Add category</a>
                <br /><br />

                <table class="table-full">
                    <tr>
                        <th>S.N</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Featured</th>
                        <th>Action</th>
                    </tr>

                    <?php 
                       $sql = "SELECT * FROM category";
                       $res = mysqli_query($conn, $sql);
                       $count = mysqli_num_rows($res);
                       $sn = 1;

                       // test  have data
                       if ($count>0) {
                        # have database
                        //get data and display
                    
                        while ($row = mysqli_fetch_assoc($res)) {
                            $id = $row['id'];
                            $title = $row['title'];
                            $image = $row['image'];
                            $show_on_home	= $row['show_on_home'];
                            $active = $row['active'];

                            ?>
                             <tr>
                               
                               <td><?php echo $sn++; ?></td>
                               <td><?php echo $title; ?></td>
                               <td>
                                <?php
                                if ($image == "") {
                                    # display img
                                    echo "<div class='error'>Image not Added</div>";
                                    
                                }
                                else {
                                    ?>
                                    <img src="<?php echo SITEURL;?>/images/category/<?php echo $image; ?> " width="150px">
                                    <?php
                                }
                                ?>
                               </td>
                               <td><?php echo $show_on_home; ?></td>
                               <td><?php echo $active; ?></td>
                               <td>
                                  <a href="<?php echo SITEURL;?>admin/update-category.php?id=<?php echo $id; ?>&image=<?php echo $image;?>" class="btn-update">Update Category</a>
                                  <a href="<?php echo SITEURL;?>admin/delete-category.php?id=<?php echo $id; ?>&image=<?php echo $image;?>" class="btn-delete">Delete Category</a>
                               </td>
                              </tr>
                            <?php

                        }
                       }
                       else {
                        # not have
                        ?>
                        <tr>
                             <td colspan="6"><div class="error">No Category Added</div></td>
                        </tr>
                        <?php
                       }

                    ?>
                    
                </table>

            </div>
        </div>


<?php include('patials/footer.php'); ?>