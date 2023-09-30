<?php 
ob_start(); /* Output Buffering Start */
session_start();
$pageTitle = 'Categories';

        if(isset($_SESSION['Username'])){
            include 'init.php';
             $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

if($do == 'Manage') {  //Manage PAge
        
        $sort = 'ASC';
        $sort_array = array('ASC','DESC');
        if(isset($_GET['sort']) && in_array($_GET['sort'],$sort_array)){
            $sort = $_GET['sort'];
        }   
        $stmts2 = $con->prepare("SELECT * FROM categories ORDER BY Ordering $sort");
        $stmts2->execute();
        $cats = $stmts2->fetchAll(); ?>

    <h1 class="text-center">Manage Categories</h1>
    <div class="container categories">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-edit"></i>Manage Categories
                <div class="option pull-right">
                    Ordering:[
                    <a class="<?php if($sort == 'ASC'){echo 'active';} ?>" href="?sort=ASC">ASC</a>/
                    <a class="<?php if($sort == 'DESC'){echo 'active';} ?>" href="?sort=DESC">DESC</a>]
                    View:[
                    <span class="active" data-view="full">Full</span>/
                    <span data-view="classic">Classic</span>]
                </div>
            </div>
            <div class="panel-body" style="background-color: #EEE;">
           <?php
                foreach($cats as $cat){
                    echo "<div class='cat'>";
                    echo "<div class='hidden-buttons'>";
                    echo "<a href='categories.php?do=Edit&catid=" . $cat['ID'] . "' class='btn btn-xs btn-primary pull-right'><i class ='fa fa-edit'></i>Edit</a>";
                    echo "<a href='categories.php?do=Delete&catid=" . $cat['ID'] . "' class='confirm btn btn-xs btn-danger'><i class ='fa fa-close'></i>Delete</a>";
                                                
                    echo "</div>";
                        echo  "<h3>" .$cat['Name'] . '</h3>';
                         echo "<div class ='full-view'>";
                            echo "<p>"; if($cat['Description']==''){echo "This is categorie has not description";}else{echo $cat['Description'];}  echo "</p>";                    
                            if ($cat['Visibility']==1){ echo '<span class = "visibility"><i class = "fa fa-eye"></i>Hidden</span>';}
                            if ($cat['Allow_Comment']==1){ echo '<span class = "commenting"><i class = "fa fa-close"></i>Comment Disabel</span>';}
                            if ($cat['Allow_Ads']==1){ echo '<span class = "advertise"><i class = "fa fa-close"></i>Ads Disabel</span>';}
                         echo "</div>";
                        echo "</div>";
                    echo "<hr>";
                }
            ?>
        </div>
        </div>
        <a class="add-category btn btn-primary" href="categories.php?do=Add"><i class="fa fa-plus"></i>Add New Category</a>
    </div>

        
<?php
}elseif ($do == 'Add') {  ?>
<h1 class="text-center">Add New Categories</h1>
                 <div class="container">
                    <form class="form-horizontal" action="?do=Insert" method="POST">
                    <div class="form-group form-group-lg">
                            <label class="required">Name:</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="name" class="form-control" autocomplete="off" required="required"/>
                            </div>
                    </div>

                    <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Description:</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="description" class="form-control" autocomplete="off" />                    </div>

                    <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Ordering:</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="ordering"  class="form-control"  />
                            </div>
                    </div>

                    <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Visible:</label>
                            <div class="col-sm-10 col-md-6">
                                <div>
                                    <input id="vis-yes" type="radio" name="visibility" value="0" checked />
                                    <label for="vis-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="vis-no" type="radio" name="visibility" value="1"  />
                                    <label for="vis-no">No</label>
                                </div>

                            </div>
                    </div>

                    <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Allow Commenting:</label>
                            <div class="col-sm-10 col-md-6">
                                <div>
                                    <input id="com-yes" type="radio" name="commenting" value="0" checked />
                                    <label for="com-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="com-no" type="radio" name="commenting" value="1"  />
                                    <label for="com-no">No</label>
                                </div>

                            </div>
                    </div>

                    <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Allow Ads:</label>
                            <div class="col-sm-10 col-md-6">
                                <div>
                                    <input id="ads-yes" type="radio" name="ads" value="0" checked />
                                    <label for="ads-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="ads-no" type="radio" name="ads" value="1"  />
                                    <label for="ads-no">No</label>
                                </div>

                            </div>
                    </div>

                    <div class="form-group form-group-lg">
                            <div class="col-sm-offset-2 com-sm-10">
                                <input type="submit" value="Add Category" class="btn btn-primary btn-lg" />
                            </div>
                    </div>

                    </form>
                </div> 
                 <?php                
}elseif ($do == 'Insert'){  
    echo "<h1 class='text-center'>Insert Category</h1>";
    echo "<div class = 'container'>";
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $name   = $_POST['name'];
        $desc   = $_POST['description'];
        $order  = $_POST['ordering'];
        $visible   = $_POST['visibility'];
        $comment   = $_POST['commenting'];
        $ads   = $_POST['ads'];     

        $check = checkItem("Name","categories",$name);
        if($check == 1){
            
            $theMsg = '<div class= "alert alert-danger">' . "Sorry this Category name exist!" . '</div>';
            redirectHome($theMsg, 'back' ,6);

        }else {
            $stmt = $con->prepare("INSERT INTO 
                                    categories(Name, Description, Ordering, Visibility, Allow_Comment, Allow_Ads)
                                    VALUES(:zname, :zdesc, :zorder, :zvisible, :zcomment, :zads)
                                ");
            $stmt->execute(array(
                'zname'   => $name,
                'zdesc'   => $desc,
                'zorder'   => $order,
                'zvisible'   => $visible,
                'zcomment'   => $comment,
                'zads'   => $ads
            ));
            $theMsg = "<div class='alert alert-success'>" . 'You have been registered successfully </div>';
            redirectHome($theMsg, 'back' ,7);

        }                      

        
    
    }else{
        $theMsg = "<div class='alert alert-danger'>Sorry you cant browse this page directly</div>";
        redirectHome($theMsg,6);
    }
    echo "</div>";               

                          
 }elseif ($do == 'Edit') { 
    $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
    $stmt = $con->prepare("SELECT * FROM categories WHERE ID = ?");
    $stmt->execute(array($catid));
    $cat = $stmt->fetch();
    $count = $stmt->rowCount();
    if($count > 0){
        ?>
        <h1 class="text-center">Edit Categories</h1>
                 <div class="container">
                    <form class="form-horizontal" action="?do=Update" method="POST">
                    <input type="hidden" name="catid" value="<?php echo $catid ?>" />
                    <div class="form-group form-group-lg">
                            <label class="required">Name:</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" value="<?php echo $cat['Name']; ?>" name="name" class="form-control" autocomplete="off" required="required"/>
                            </div>
                    </div>

                    <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Description:</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" value="<?php echo $cat['Description']; ?>" name="description" class="form-control" autocomplete="off" />                    </div>

                    <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Ordering:</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" value="<?php echo $cat['Ordering']; ?>" name="ordering"  class="form-control"  />
                            </div>
                    </div>

                    <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Visible:</label>
                            <div class="col-sm-10 col-md-6">
                                <div>
                                    <input id="vis-yes" type="radio" name="visibility" value="0" <?php  if($cat['Visibility']==0){echo 'checked';} ?> />
                                    <label for="vis-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="vis-no" type="radio" name="visibility" value="1" <?php  if($cat['Visibility']==1){echo 'checked';} ?> />
                                    <label for="vis-no">No</label>
                                </div>

                            </div>
                    </div>

                    <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Allow Commenting:</label>
                            <div class="col-sm-10 col-md-6">
                                <div>
                                    <input id="com-yes" type="radio" name="commenting" value="0" <?php  if($cat['Allow_Comment']==0){echo 'checked';} ?> />
                                    <label for="com-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="com-no" type="radio" name="commenting" value="1"  <?php  if($cat['Allow_Comment']==1){echo 'checked';} ?> />
                                    <label for="com-no">No</label>
                                </div>

                            </div>
                    </div>

                    <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Allow Ads:</label>
                            <div class="col-sm-10 col-md-6">
                                <div>
                                    <input id="ads-yes" type="radio" name="ads" value="0" <?php  if($cat['Allow_Ads']==0){echo 'checked';} ?> />
                                    <label for="ads-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="ads-no" type="radio" name="ads" value="1" <?php  if($cat['Allow_Ads']==1){echo 'checked';} ?> />
                                    <label for="ads-no">No</label>
                                </div>

                            </div>
                    </div>

                    <div class="form-group form-group-lg">
                            <div class="col-sm-offset-2 com-sm-10">
                                <input type="submit" value="Save" class="btn btn-primary btn-lg" />
                            </div>
                    </div>

                    </form>
                </div> 
    <?php  
      }else {
            echo '';
            $theMsg = "<div class='alert alert-danger'>There is No Such ID</div>";
            redirectHome($theMsg,'back',6);
           } 

} elseif ($do == 'Update') {
    echo "<h1 class='text-center'>Update category</h1>";
                echo "<div class = 'container'>";
                      if($_SERVER['REQUEST_METHOD']=='POST'){
                            $id     = $_POST['catid'];
                            $name   = $_POST['name'];
                            $desc  = $_POST['description'];
                            $order   = $_POST['ordering'];
                            $visible   = $_POST['visibility'];
                            $comment   = $_POST['commenting'];
                            $ads   = $_POST['ads'];
                            
                                $stmt = $con->prepare("UPDATE categories SET
                                                             Name = ? ,
                                                             Description = ? ,
                                                             Ordering = ? ,
                                                             Visibility= ?,
                                                             Allow_Comment = ? ,
                                                             Allow_Ads= ?
                                                               WHERE ID = ? ");
                                $stmt->execute(array($name,$desc,$order,$visible,$comment,$ads,$id));
                                $theMsg = "<div class='alert alert-success'>" . 'This category has been updated </div>';
                                redirectHome($theMsg, 'back' ,6);
                            }
                          
                       
                        echo "</div>";
   

} elseif ($do == 'Activate') { 

}elseif ($do == 'Delete') {
    echo "<h1 class='text-center'>Delete Category</h1>";
    echo "<div class = 'container'>";
        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
        $stmt = $con->prepare("SELECT * FROM categories WHERE ID = ? LIMIT 1");
        $stmt->execute(array($catid));
        $count = $stmt->rowCount();
        if($count > 0){
            $stmt = $con->prepare("DELETE FROM categories WHERE ID = :zuser");
            $stmt->bindParam(":zuser",$catid);
            $stmt->execute();
            $theMsg = "<div class='alert alert-success'>" . 'This Category has been deleted </div>';
            redirectHome($theMsg,'back',6);          
        }else {
                           $theMsg = "<div class='alert alert-danger'>This is Category ID Not Exisist</div>";
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
