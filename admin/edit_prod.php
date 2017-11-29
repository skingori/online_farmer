<?php
/**
 * Created by PhpStorm.
 * User: king
 * Date: 01/04/2017
 * Time: 11:24
 */
// Inialize session
session_start();

// Check, if user is already login, then jump to secured page
if (isset($_SESSION['logname']) && isset($_SESSION['rank'])) {
    switch($_SESSION['rank']) {

        case 2:
            header('location:../user/index.php');//redirect to  page
            break;

    }
}
else
{

    header('Location:index.php');
}
include '../connection/db.php';
$username=$_SESSION['logname'];

$result1 = mysqli_query($con, "SELECT * FROM Login_table WHERE Login_Username='$username'");

while($res = mysqli_fetch_array($result1))
{
    $name= $res['Login_Username'];

}

$id = $_GET['id'];
$result1 = mysqli_query($con, "SELECT * FROM Farm_Product_Table WHERE Farm_Product_Id='$id'");

while($res = mysqli_fetch_array($result1))
{
    $Farm_Product_Id= $res['Farm_Product_Id'];
    $Farm_Product_Name= $res['Farm_Product_Name'];
    $Farm_Product_Image= $res['Farm_Product_Image'];
    $Farm_Product_Price= $res['Farm_Product_Price'];
    $Farm_Product_Quantity= $res['Farm_Product_Quantity'];
    $Farm_Product_Description= $res['Farm_Product_Description'];

}

?>

<?php

require '../connection/db.php';

if (isset($_POST['submit'])) {

    $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
    $image_name = addslashes($_FILES['image']['name']);
    $image_size = getimagesize($_FILES['image']['tmp_name']);

    move_uploaded_file($_FILES["image"]["tmp_name"], "../upload/" . $_FILES["image"]["name"]);

    $location = "../upload/" . $_FILES["image"]["name"];

    $Farm_Product_Id_= $_POST['Farm_Product_Id'];
    $Farm_Product_Name_= $_POST['Farm_Product_Name'];
    $Farm_Product_Price_= $_POST['Farm_Product_Price'];
    $Farm_Product_Quantity_= $_POST['Farm_Product_Quantity'];
    $Farm_Product_Description_= $_POST['Farm_Product_Description'];

    //$product_quantity_=$_POST['product_quantity'];

    $result = mysqli_query($con, "UPDATE Farm_Product_Table SET Farm_Product_Name='$Farm_Product_Name_',Farm_Product_Image='$location',Farm_Product_Price='$Farm_Product_Price_',Farm_Product_Quantity='$Farm_Product_Quantity_',Farm_Product_Price='$Farm_Product_Price_' WHERE Farm_Product_Id='$id'");

    $msg = "<div class='alert alert-success'>
						<span class='glyphicon glyphicon-info-sign'></span> &nbsp; New Product Added !
					</div>";
    echo '<meta content="4;all_products.php" http-equiv="refresh" />';

}


?>
<?php include 'header.php'; ?>
<!--********************Add content here *******************-->
<?php
if (isset($msg)) {
    echo $msg;
}
?>

<div class="row">

    <div class="span12">

        <div class="widget ">

            <div class="widget-header">
                <i class="icon-plus-sign"></i>
                <h3>All Payments:</h3>
            </div> <!-- /widget-header -->

            <div class="widget-content">
                <!--********************Add content here *******************-->
<form  method="POST" enctype="multipart/form-data" id="mytable">

    <div class="form-group has-feedback">
        <label>Product Name:</label>
        <input type="text" name="Farm_Product_Name" value="<?php echo $Farm_Product_Name;?>" id="in" required class="span6"/>
    </div>
    <div class="form-group has-feedback">
        <label>Product Quantity:</label>
        <input type="text" name="Farm_Product_Quantity" value="<?php echo $Farm_Product_Quantity;?>" id="in" required class="span6"/>
    </div>
    <div class="form-group has-feedback">
        <label>Product Price:</label>
        <input type="text" name="Farm_Product_Price" value="<?php echo $Farm_Product_Price;?>"  id="in" required class="span6"/>
    </div>
    <div class="form-group has-feedback">
        <input type="file" name="image" value="<?php echo $Farm_Product_Image;?>" id="in" required class="span6"/>
    </div>
    <div class="form-group has-feedback">
        <input type="submit" name="submit" value="Update" class="btn btn-primary" />
        <input type="reset" name="reset" value="Cancel Upload" class="btn btn-primary" />
    </div>

</form>

                <!--********************Add content here *******************-->

            </div> <!-- /widget-content -->

        </div> <!-- /widget -->

    </div> <!-- /span8 -->




</div> <!-- /row -->

<!---- add there --->

<!--********************Add content here *******************-->
<?php include 'footer.php';?>
<!--********************Add content here *******************-->


