<?php include('patials/menu.php'); ?>


        <!-- Main content -->
        <div class="main-content">
            <div class="wrapper">
                <h1>Manage Food</h1>

                <br /><br />
                <a href="<?php echo SITEURL; ?>admin/add-food.php" class="btn-add">Add Food</a>
                <br /><br /><br />

                <?php
                    if(isset($_SESSION['add']))
                    {
                        echo $_SESSION['add'];
                        unset($_SESSION['add']);
                    }
                ?>

                <?php
                    if(isset($_SESSION['upload']))
                    {
                        echo $_SESSION['upload'];
                        unset($_SESSION['upload']);
                    }
                ?>

                <table class="table-full">
                    <tr>
                        <th>S.N</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>show on home</th>
                        <th>Active</th>
                        <th>Action</th>
                    </tr>

                    <?php
                        //create a SQL Query to get all the food
                        $sql = "SELECT * FROM food";

                        //execute the quey
                        $res = mysqli_query($conn, $sql);

                        //count rows to check whether we have foods or not
                        $count = mysqli_num_rows($res);

                        //create serial number variable and set default as 1 
                        $sn=1;

                        if($count > 0){
                            // we have food in database
                            // get thge foods from database and display
                            while($row=mysqli_fetch_assoc($res))
                            {
                                $id = $row['id'];
                                $name = $row['name'];
                                $price = $row['price'];
                                $image = $row['image'];
                                $show_on_home = $row['show_on_home'];
                                $active = $row['active'];

                                ?> 
                                    <tr>
                                        <td> 
                                            <?php
                                                echo $sn++;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                echo $name;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                echo $price;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                if($image=="")
                                                {
                                                    echo "<div class='error'>Image not added.</div>";
                                                }
                                                else
                                                {
                                                    ?>
                                                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $image; ?>" width="100px">
                                                    <?php
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                echo $show_on_home;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                echo $active;
                                            ?>
                                        </td>
                                        <td>
                                            <a href="#" class="btn-update">Update </a>
                                            <a href="#" class="btn-delete">Delete</a>
                                        </td>
                                    </tr>
                                <?php

                            }
                        }
                        else
                        {
                            echo "<tr>
                                <td colspan='7' class='error'>
                                    Food not added yet
                                </td>
                            </tr>";
                        }
                    ?>

                    <tr>
                        <td>1. </td>
                        <td>Burger King</td>
                        <td>50.000vnd</td>
                        <td>Image</td>
                        <td>Yes</td>
                        <td>Yes</td>
                        <td>
                            <a href="#" class="btn-update">Update </a>
                            <a href="#" class="btn-delete">Delete</a>
                        </td>
                    </tr>

                </table>
            </div>
        </div>


<?php include('patials/footer.php'); ?>