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

?>

<?php include 'header.php'; ?>

<!--********************Add content here *******************-->
<div class="row">

    <div class="span12">

        <div class="widget ">

            <div class="widget-header">
                <i class="icon-plus-sign"></i>
                <h3><a href="index.php">Add new product</a> </h3>
            </div> <!-- /widget-header -->

            <div class="widget-content">
<!--********************Add content here *******************-->

<?php
//including the database connection file
include_once("../connection/db.php");

//fetching data in descending order (lastest entry first)
//$result = mysql_query("SELECT * FROM users ORDER BY id DESC"); // mysql_query is deprecated
$result = mysqli_query($con, "SELECT * FROM Farm_Product_Table ORDER BY Farm_Product_Id ASC"); // using mysqli_query instead
?>

<table  border=0 cellpadding="1" cellspacing="1" id="table1" class="table table-striped">
    <thead class="alert-success">
    <tr bgcolor=''>
        <td>Image</td>
        <td>Product Code</td>
        <td>Product Name</td>
        <td>Product Price</td>
        <td>Description</td>
        <td></td>
    </tr>
    </thead>
    <tbody>
    <?php
    //while($res = mysql_fetch_array($result)) { // mysql_fetch_array is deprecated, we need to use mysqli_fetch_array
    while($res = mysqli_fetch_array($result)) {
        echo "<tr class=\"\">";
        echo "<td><img class='image-cover' src=".$res['Farm_Product_Image']."></td>";
        echo "<td class=''>".$res['Farm_Product_Id']."</td>";
        echo "<td class=''>".$res['Farm_Product_Name']."</td>";
        echo "<td>".$res['Farm_Product_Price']."</td>";
        //echo "<td>".$res['product_price']."</td>";
        //echo "<td>".$res['product_quantity']."</td>";
        echo "<td>".$res['Farm_Product_Description']."</td>";
        echo "<td><a href=\"edit_prod.php?id=$res[Farm_Product_Id]\" style='color: lightcoral' class='icon icon-edit'> Edit</a>&nbsp; <a href=\"del.php?prod=$res[Farm_Product_Id]\" onClick=\"return confirm('Are you sure you want to delete?')\" class='icon icon-trash'> Del</a></td>";
    }
    ?>
    </tbody>
    <tfoot class="alert-info">
    <tr bgcolor=''>

        <td>Image</td>
        <td>Product Code</td>
        <td>Product Name</td>
        <td>Product Price</td>
        <td>Description</td>
        <td></td>
    </tr>
    </tfoot>

</table>

<!--********************Add content here *******************-->
<!--********************Add content here *******************-->

</div> <!-- /widget-content -->

</div> <!-- /widget -->

</div> <!-- /span8 -->




</div> <!-- /row -->

<!---- add there --->

<!--********************Add content here *******************-->
<?php include 'footer.php'; ?>






