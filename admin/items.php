<?php 
/*  
====================================
ITEM PAGE
====================================
*/
ob_start(); /* Output Buffering Start */
session_start();
$pageTitle = 'Items';

        if(isset($_SESSION['Username'])){
            include 'init.php';
             $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

if($do == 'Manage') {  //Manage PAge
        $stmt = $con->prepare("SELECT items.* ,categories.Name AS Category_name , users.Username
                               FROM items
                               INNER JOIN categories on categories.ID = items.Cat_ID
                               INNER JOIN users      on  users.UserID =  items.Member_ID
                               ORDER BY Item_ID DESC");
        $stmt->execute();
        $items = $stmt->fetchAll();    
    ?>
        <h1 class="text-center">Manage Items</h1>
        <div class="container">
            <table class="table-responsive">
                <table class="main-table text-center table table-bordered">
                    <tr>
                        <th style="background-color: Violet;">#ID</th>
                        <th style="background-color: Violet;">Image</th>
                        <th style="background-color: Violet;">Name</th>
                        <th style="background-color: Violet;">Description</th>
                        <th style="background-color: Violet;">Price</th>
                        <th style="background-color: Violet;">Adding Date</th>
                        <th style="background-color: Violet;">Category</th>
                        <th style="background-color: Violet;">Username</th>
                        <th style="background-color: Violet;">Control</th>
                    </tr>
                        <?php
                            foreach($items as $item) {
                            echo "<tr>";
                                echo "<td>" . $item['Item_ID']        . "</td>";
                                echo "<td>";
                                    if(empty($item['Image'])){
                                        echo "<img src='uploads/items/default_item.PNG' width=50px height=50px alt=''/>";
                                    }else {
                                        echo "<img src='uploads/items/" . $item['Image'] . "' width=50px height=50px alt=''/>";
                                    }
                                echo "<td>" . $item['Name']           . "</td>";
                                echo "<td>" . $item['Description']    . "</td>";
                                echo "<td>" . $item['Price']          . "</td>";
                                echo "<td>" . $item['Add_Date']       . "</td>";
                                echo "<td>" . $item['Category_name']         . "</td>";
                                echo "<td>" . $item['Username']      . "</td>";
                                echo "<td>" . "<a href='items.php?do=Edit&itemid=" . $item['Item_ID'] ."' class='btn btn-success'><i class ='fa fa-edit'></i>Edit</a>" . '  ' .
                                              "<a href='items.php?do=Delete&itemid=" . $item['Item_ID'] ."' class='confirm btn btn-danger'><i class ='fa fa-close'></i>Delete</a>";
                                    if ($item['Approve']==0)  {
                                        echo "<a 
                                        href='items.php?do=Approve&itemid=" . $item['Item_ID'] ."' 
                                        class='activate btn btn-info' style='margin-left=5px'>
                                        <i class ='fa fa-check'></i>Approve</a>";

                                             }
                                echo "</td>";
                            echo "</tr>";

                            }

                        ?>
                        
                    </tr>
                    </table>
            </table>
        <a href="items.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> New Item</a>
        </div>

<?php






}elseif ($do == 'Add') {  ?>
            <h1 class="text-center">Add New Item</h1>
                 <div class="container">
                    <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
                    <div class="form-group form-group-lg">
                            <label class="required">Name:</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="name" class="form-control" autocomplete="off" required "/>
                            </div>
                    </div>

                    <div class="form-group form-group-lg">
                            <label class="required">Description:</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="description" class="form-control" autocomplete="off" required "/>
                            </div>
                    </div>
                           
                    <div class="form-group form-group-lg">
                            <label class="required">Price:</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="price" class="form-control" autocomplete="off" required "/>
                            </div>
                    </div>

                    <div class="form-group form-group-lg">
                            <label class="required">Country of Made:</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="country" class="form-control" autocomplete="off" required/>
                            </div>
                    </div>

                    <div class="form-group form-group-lg">
                            <label class="required">Status:</label>
                            <div class="col-sm-10 col-md-6">
                                <select name="status">
                                    <option value="0">...</option>
                                    <option value="1">New</option>
                                    <option value="2">Like New</option>
                                    <option value="3">Used</option>
                                    <option value="4">Very Old</option>

                                </select>
                            </div>
                    </div>
                    <div class="form-group form-group-lg">
                            <label class="required">Member:</label>
                            <div class="col-sm-10 col-md-6">
                                <select name="member">
                                    <option value="0">...</option>
                                    <?php
                                    $stmt = $con->prepare("SELECT * FROM users");
                                    $stmt->execute();
                                    $users = $stmt->fetchAll();
                                    foreach($users as $user){
                                        echo "<option value='" .$user['UserID'] . "'>" . $user['Username'] . "</option>";
                                    }

                                    ?>

                                </select>
                            </div>
                    </div>

                    <div class="form-group form-group-lg">
                            <label class="required">Category:</label>
                            <div class="col-sm-10 col-md-6">
                                <select name="category">
                                    <option value="0">...</option>
                                    <?php
                                    $stmt = $con->prepare("SELECT * FROM categories");
                                    $stmt->execute();
                                    $cats = $stmt->fetchAll();
                                    foreach($cats as $cat){
                                        echo "<option value='" .$cat['ID'] . "'>" . $cat['Name'] . "</option>";
                                    }

                                    ?>

                                </select>
                            </div>
                    </div>
                    
                    <div class="form-group form-group-lg">
                            <label class="required">Image Item:</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="file" name="image" class="form-control" required/>
                            </div>
                    </div>

                    <div class="form-group form-group-lg">
                            <div class="col-sm-10 com-sm-10">
                                <input type="submit" value="Add Item" class="btn btn-primary btn-sm" style="margin-top: 10px;" />
                            </div>
                    </div>

                    </form>
                </div> 
    <?php 
                
}elseif ($do == 'Insert'){ 
    echo "<h1 class='text-center'>Insert Item</h1>";
                echo "<div class = 'container'>";
                if($_SERVER['REQUEST_METHOD']=='POST'){
                    $image = $_FILES['image'];
                    $imageName = $_FILES['image']['name'];
                    $imageSize = $_FILES['image']['size'];
                    $imageTmp = $_FILES['image']['tmp_name'];
                    $imageType = $_FILES['image']['type'];
                    $imageAllowedExtension = array("jpeg","png","jpg","gif");
                    //get avatar extension
                    $imageexplod = explode('.',$imageName);
                    $imageExtension = strtolower(end($imageexplod)); // strtolower: change small caracters
                    
                    $name    = $_POST['name'];
                    $desc    = $_POST['description'];
                    $price   = $_POST['price'];
                    $country = $_POST['country'];
                    $status  = $_POST['status'];
                    $member  = $_POST['member'];
                    $cat     = $_POST['category'];
                    // VAlidate the Form
                    $formErrors = array();
                    if (empty($name))      { $formErrors[] = 'Name can be <strong>empty</strong>';}
                    if (empty($desc))      { $formErrors[] = 'Description can be <strong>empty</strong>';}
                    if (empty($price))      { $formErrors[] = 'Price can be <strong>empty</strong>';}
                    if (empty($country))      { $formErrors[] = 'Country can be <strong>empty</strong>';}
                    if ($status == 0)      { $formErrors[] = 'You must be choose <strong>Status</strong>';}
                    if ($member == 0)      { $formErrors[] = 'You must be choose <strong>Member</strong>';}
                    if ($cat == 0)      { $formErrors[] = 'You must be choose <strong>Category</strong>';}
                    if(! empty($imageName) && ! in_array($imageExtension,$imageAllowedExtension)){ $formErrors[] = 'This extension file not <strong>Allowed</strong>';}
                    if(empty($imageName)){ $formErrors[] = 'Image Item is <strong>Required</strong>';}
                    if($imageSize>4190304){ $formErrors[] = 'Image Item Size can be larger than <strong>4MB</strong>';}

                foreach($formErrors as $error) {
                         echo '<div class= "alert alert-danger">' . $error . '</div>';
                        }

                    if (empty($formErrors)){                                                       
                        $image = rand(0,100000) . '_' . $imageName;
                        move_uploaded_file($imageTmp,"uploads\items\\" . $image);

                        $stmt = $con->prepare("INSERT INTO 
                        items(Name, Description, Price, Country_Made, Status, Add_Date,Cat_ID,Member_ID,Image)
                        VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus , now(),:zcat,:zmember,:zimage)");
                        $stmt->execute(array(
                            'zname'     => $name,
                            'zdesc'     => $desc,
                            'zprice'    => $price,
                            'zcountry'  => $country,
                            'zstatus'   => $status,
                            'zcat'      => $cat,
                            'zmember'   => $member,
                            'zimage'   => $image
                        ));
                        if($stmt){
                        $theMsg = "<div class='alert alert-success'>" . 'You have been registered successfully </div>';
                        redirectHome($theMsg, 'back' ,7);
                        }                                              
                    }
                
                }else{
                    $theMsg = "<div class='alert alert-danger'>Sorry you cant browse this page directly</div>";
                    redirectHome($theMsg,6);
                }
                echo "</div>";        
                           
 }elseif ($do == 'Edit') {  
                    $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
                    $stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ? LIMIT 1");
                    $stmt->execute(array($itemid));
                    $item = $stmt->fetch();
                    $count = $stmt->rowCount();
                    if($count > 0){
                        ?>
                        <h1 class="text-center">Edit Item</h1>
                             <div class="container">
                                <form class="form-horizontal" action="?do=Update" method="POST" >
                                <input type="hidden" name="itemid" value="<?php echo $itemid ?>" />
                                <div class="form-group form-group-lg">
                                        <label class="required">Name:</label>
                                        <div class="col-sm-10 col-md-6">
                                            <input type="text" name="name" value="<?php echo $item['Name'] ?>" class="form-control" autocomplete="off" required "/>
                                        </div>
                                </div>
            
                                <div class="form-group form-group-lg">
                                        <label class="required">Description:</label>
                                        <div class="col-sm-10 col-md-6">
                                            <input type="text" name="description" value="<?php echo $item['Description'] ?>" class="form-control" autocomplete="off" required "/>
                                        </div>
                                </div>
                                       
                                <div class="form-group form-group-lg">
                                        <label class="required">Price:</label>
                                        <div class="col-sm-10 col-md-6">
                                            <input type="text" name="price" value="<?php echo $item['Price'] ?>" class="form-control" autocomplete="off" required "/>
                                        </div>
                                </div>
            
                                <div class="form-group form-group-lg">
                                        <label class="required">Country of Made:</label>
                                        <div class="col-sm-10 col-md-6">
                                            <input type="text" name="country" value="<?php echo $item['Country_Made'] ?>" class="form-control" autocomplete="off" required/>
                                        </div>
                                </div>
            
                                <div class="form-group form-group-lg">
                                        <label class="required">Status:</label>
                                        <div class="col-sm-10 col-md-6">
                                            <select name="status">
                                                <option value="0" <?php if($item['Status']==0) {echo 'selected';}?>>...</option>
                                                <option value="1" <?php if($item['Status'] ==1) {echo 'selected';}?>>New</option>
                                                <option value="2" <?php if($item['Status']==2) {echo 'selected';}?>>Like New</option>
                                                <option value="3" <?php if($item['Status']==3) {echo 'selected';}?>>Used</option>
                                                <option value="4" <?php if($item['Status']==4) {echo 'selected';}?>>Very Old</option>
            
                                            </select>
                                        </div>
                                </div>
                                <div class="form-group form-group-lg">
                                        <label class="required">Member:</label>
                                        <div class="col-sm-10 col-md-6">
                                            <select name="member">
                                                <option value="0">...</option>
                                                <?php
                                                $stmt = $con->prepare("SELECT * FROM users");
                                                $stmt->execute();
                                                $users = $stmt->fetchAll();
                                                foreach($users as $user){
                                                    echo "<option value='" .$user['UserID'] . "'";
                                                    if($item['Member_ID']== $user['UserID']) {echo 'selected';}
                                                    echo ">". $user['Username'] . "</option>";
                                                }
            
                                                ?>
            
                                            </select>
                                        </div>
                                </div>
            
                                <div class="form-group form-group-lg">
                                        <label class="required">Category:</label>
                                        <div class="col-sm-10 col-md-6">
                                            <select name="category">
                                                <option value="0">...</option>
                                                <?php
                                                $stmt = $con->prepare("SELECT * FROM categories");
                                                $stmt->execute();
                                                $cats = $stmt->fetchAll();
                                                foreach($cats as $cat){
                                                    echo "<option value='" .$cat['ID'] . "'";
                                                    if($item['Cat_ID']== $cat['ID']) {echo 'selected';}
                                                    echo ">" . $cat['Name'] . "</option>";
                                                }
            
                                                ?>
            
                                            </select>
                                        </div>
                                </div>
            
                                <div class="form-group form-group-lg">
                                        <div class="col-sm-offset-2 com-sm-10">
                                            <input type="submit" value="Save Item" class="btn btn-primary btn-sm" style="margin-top: 10px;" />
                                        </div>
                                </div>
            
                                </form>
            <?php
            $stmt = $con->prepare("SELECT comments.*,users.Username 
            FROM comments
            INNER JOIN users ON  users.UserID = comments.user_id
            WHERE item_id = ?");
            $stmt->execute(array($itemid));
            $rows = $stmt->fetchAll();        
        ?>
           
        <h1 class="text-center">Manage "<?php echo $item['Name'] ?>" Comments</h1>
                <table class="table-responsive">
                    <table class="main-table text-center table table-bordered">
                        <tr>
                            <th style="background-color: Violet;">Comment</th>
                            <th style="background-color: Violet;">User Name</th>
                            <th style="background-color: Violet;">Added Date</th>
                            <th style="background-color: Violet;">Control</th>
                        </tr>
                            <?php
                                foreach($rows as $row) {
                                    echo "<tr>";
                                    echo "<td>" . $row['Comment'] . "</td>";
                                    echo "<td>" . $row['Username'] . "</td>";
                                    echo "<td>" . $row['Comment_Date']     . "</td>";
                                    echo "<td>" . "<a href='comments.php?do=Edit&comid=" . $row['C_ID'] ."' class='btn btn-success'><i class ='fa fa-edit'></i>Edit</a>" . '  ' .
                                                  "<a href='comments.php?do=Delete&comid=" . $row['C_ID'] ."' class='confirm btn btn-danger'><i class ='fa fa-close'></i>Delete</a>";
                                                if ($row['Status']==0)  {
                                                   echo "<a
                                                    href='comments.php?do=Approve&comid=" . $row['C_ID'] ."'
                                                     class='activate btn btn-info' style='margin-left=5px'>
                                                     <i class ='fa fa-check'></i>Approve</a>";
                                                }
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            ?>                            
                        </tr>
                        </table>
                </table>
                </div> 
                <?php 
                    
                    
                    
                    }else {
                            echo '';
                            $theMsg = "<div class='alert alert-danger'>There is No Such ID</div>";
                            redirectHome($theMsg,'back',6);
                        }


} elseif ($do == 'Update') {
            echo "<h1 class='text-center'>Update Item</h1>";
            echo "<div class = 'container'>";
                if($_SERVER['REQUEST_METHOD']=='POST'){
                        $id     = $_POST['itemid'];
                        $name   = $_POST['name'];
                        $desc  = $_POST['description'];
                        $price  = $_POST['price'];
                        $country   = $_POST['country'];
                        $status   = $_POST['status'];
                        $member   = $_POST['member'];
                        $cat   = $_POST['category'];
                        // VAlidate the Form
                        $formErrors = array();
                        if (empty($name))      { $formErrors[] = 'Name can be <strong>empty</strong>';}
                        if (empty($desc))      { $formErrors[] = 'Description can be <strong>empty</strong>';}
                        if (empty($price))      { $formErrors[] = 'Price can be <strong>empty</strong>';}
                        if (empty($country))      { $formErrors[] = 'Country can be <strong>empty</strong>';}
                        if ($status == 0)      { $formErrors[] = 'You must be choose <strong>Status</strong>';}
                        if ($member == 0)      { $formErrors[] = 'You must be choose <strong>Member</strong>';}
                        if ($cat == 0)      { $formErrors[] = 'You must be choose <strong>Category</strong>';}
    
                        foreach($formErrors as $error) {
                             echo '<div class= "alert alert-danger">' . $error . '</div>';
                            }
                        
                if (empty($formErrors)){
                    $stmt = $con->prepare("UPDATE items
                                           SET Name = ? ,Description = ? , Price = ? , Country_Made = ? ,Status = ?,Member_ID = ?, Cat_ID = ? WHERE Item_ID = ? ");
                    $stmt->execute(array($name,$desc,$price,$country,$status,$member,$cat,$id));
                    $theMsg = "<div class='alert alert-success'>" . 'This member has been updated </div>';
                    redirectHome($theMsg, 'back' ,6);
                }
              
            }else{
                $theMsg = "<div class='alert alert-danger'>Sorry you cant browse this page directly</div>";
                redirectHome($theMsg, 'back',6);
            }
            echo "</div>";

} elseif ($do == 'Approve') { 
                    echo "<h1 class='text-center'>Approve Item</h1>";
                    echo "<div class = 'container'>";
                    $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
                    $stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ? LIMIT 1");
                    $stmt->execute(array($itemid));
                    $count = $stmt->rowCount();
                    if($count > 0){
                        $stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE Item_ID = ?");
                        $stmt->execute(array($itemid));
                        $theMsg = "<div class='alert alert-success'>" .'This member has been Approved </div>';
                        redirectHome($theMsg, 'back',6);              

                    }else {
                                    $theMsg = "<div class='alert alert-danger'>This is Item_ID Not Exisist</div>";
                                        redirectHome($theMsg,6);              
                                        }
                    echo "</div>"; 

}elseif ($do == 'Delete') {
    echo "<h1 class='text-center'>Delete Item</h1>";
                echo "<div class = 'container'>";
                    $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
                    $stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ? LIMIT 1");
                    $stmt->execute(array($itemid));
                    $count = $stmt->rowCount();
                    if($count > 0){
                        $stmt = $con->prepare("DELETE FROM items WHERE Item_ID = :zitem");
                        $stmt->bindParam(":zitem",$itemid);
                        $stmt->execute();
                        $theMsg = "<div class='alert alert-success'>" . 'This Item has been deleted </div>';
                        redirectHome($theMsg,'back',6);          
                    }else {
                                       $theMsg = "<div class='alert alert-danger'>This is Item_ID Not Exisist</div>";
                                        redirectHome($theMsg,6);              
                                        }
                echo "</div>";

}else {
        header('location: index.php');
        exit();
            }

    include $tpl .'footer.php';
}

ob_end_flush();
?>
