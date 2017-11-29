<?php

/**
 * Created by PhpStorm.
 * User: king
 * Date: 10/10/2017
 * Time: 10:44
 */

session_start();
// Check, if user is already login, then jump to secured page
if (isset($_SESSION['logname']) && ($_SESSION['rank'])) {
    switch($_SESSION['rank']) {

        case 2:
            header('location:../user/index.php');//redirect to  page
            break;

    }
}elseif(!isset($_SESSION['logname']) && !isset($_SESSION['rank'])) {
    header('Location:../sessions.php');
}
else
{

    header('Location:index.php');
}

include '../connection/db.php';
$username=$_SESSION['logname'];

$result1 = mysqli_query($con, "SELECT * FROM Login_Table WHERE Login_Username='$username'");

while($res = mysqli_fetch_array($result1))
{
    $username= $res['Login_Username'];
    $id= $res['Login_Id'];

}
?>
<?php include "header.php";?>

<!-- -->

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

<?php

    $result = mysqli_query($con, "SELECT * FROM Payment_Table");


?>
<div class="box-body">
    <table border="1" id="table1" class="table table-bordered table-hover table-condensed" style="font-family: consolas; font-size: small">
        <thead class="alert-success">
        <th>Confirmation Code</th>
        <th>Payment Date</th>
        <th>Payment Mode</th>
        <th>Invoice Paid for</th>
        <th></th>

        </thead>
        <tbody>

        <?php
        //while($res = mysql_fetch_array($result)) { // mysql_fetch_array is deprecated, we need to use mysqli_fetch_array
        while($res = mysqli_fetch_array($result)) {
            echo "<tr class=''>";
            echo "<td class=''>".$res['Payment_Code']."</td>";
            echo "<td class=''>".$res['Payment_Date']."</td>";
            echo "<td>".$res['Payment_Mode']."</td>";
            echo "<td class=''>".$res['Payment_Invoice_Number']."</td>";
            echo "<td><a href=\"del.php?pay=$res[Payment_Id]\" onClick=\"return confirm('Are you sure you want to delete?')\" class='btn btn-google icon-trash'></a></td>";
        }
        ?>
        </tbody>
        <tfoot>
        <tr class="bg-info">
            <th>Confirmation Code</th>
            <th>Payment Date</th>
            <th>Payment Mode</th>
            <th>Invoice Paid for</th>
            <th></th>


        </tr>
        </tfoot>
    </table>
</div>
<!-- -->
<!--********************Add content here *******************-->

</div> <!-- /widget-content -->

</div> <!-- /widget -->

</div> <!-- /span8 -->




</div> <!-- /row -->

<!---- add there --->

<!--********************Add content here *******************-->
<?php include "footer.php";?>

