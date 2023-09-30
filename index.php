<?php 
    ob_start();
    session_start();
    $pageTitle = 'Homepage';
    include '../eCommerce/init.php';
    ?>
        <div class="container">
        <div class="row">
        <?php
        $allItems = getAllFrom('*','items','WHERE Approve = 1','','Item_ID');
            foreach($allItems as $item){
                echo '<div class="col-sm-6 col-md-3">';
                    echo '<div class="thumbnail item-box">';
                    echo '<span class = "price-tag">$' . $item['Price'] . '</span>';
                    if(empty($item['Image'])){
                        echo "<img src='admin/uploads/items/default_item.PNG' width=200px height=200px alt=''/>";
                    }else {
                        echo "<img src='admin/uploads/items/" . $item['Image'] . "' width=200px height=200px alt=''/>";
                    }
                        echo '<div class="caption">';
                            echo '<h4><a href = "items.php?itemid='. $item['Item_ID'] . '">' . $item['Name'] . '</a></h4>';
                            echo '<p>' . $item['Description'] . '</p>';
                            echo '<div class = "date">' . $item['Add_Date'] . '</div>';

                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            }
        ?>
        </div>
        </div>

    <?php
    include $tpl .'footer.php';
    ob_end_flush(); 
    ?>