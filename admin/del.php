<?php

include '../connection/db.php';

if (isset($_GET['in'])) {

    $con = mysqli_query($con, "DELETE FROM Invoice_Table WHERE Invoice_Number='".($_GET['in'])."'");

    header("Location:invoice.php");
}


elseif (isset($_GET['pay'])){
    $con = mysqli_query($con, "DELETE FROM Payment_Table WHERE Payment_Id='".($_GET['pay'])."'");

    header("Location:payments.php");

}
elseif (isset($_GET['ord'])){
    $con = mysqli_query($con, "DELETE FROM Order_table WHERE Order_Id='".($_GET['ord'])."'");

    header("Location:orders.php");

}
elseif (isset($_GET['sup'])){
    $con = mysqli_query($con, "DELETE FROM Supplier_table WHERE Supplier_Id='".($_GET['sup'])."'");

    header("Location:suppl.php");

}
elseif (isset($_GET['sup1'])){
    $con = mysqli_query($con, "DELETE FROM Supplier_products WHERE Sup_Prod_Id='".($_GET['sup1'])."'");

    header("Location:sup_prd.php");

}
elseif (isset($_GET['pur'])){
    $con = mysqli_query($con, "DELETE FROM purchase_table WHERE purchase_id='".($_GET['pur'])."'");

    header("Location:purchases.php");

}
elseif (isset($_GET['fed'])){
    $con = mysqli_query($con, "DELETE FROM feedback_table WHERE feedback_id='".($_GET['fed'])."'");

    header("Location:feedback.php");

}

