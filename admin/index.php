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
//AUTO GENERATE NUMBER

$chars = array(0,1,2,3,4,5,6,7,8,9);
$serial = '';
$max = count($chars)-1;
for($i=0;$i<10;$i++){
    $serial .= (!($i % 5) && $i ? '' : '').$chars[rand(0, $max)];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>User - Homepage</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="../css/bootstrap.min.css" rel="stylesheet">
<link href="../css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
        rel="stylesheet">
<link href="../css/font-awesome.css" rel="stylesheet">
<link href="../css/style.css" rel="stylesheet">
<link href="../css/pages/dashboard.css" rel="stylesheet">
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->

<!-- MY CUSTOM CSS-->
<link href="../css/shopping.css" type="text/css" rel="stylesheet" />
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- CUSTOM CODE -->
</head>
<body>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" href="index.php">Agri-Business </a>
      <div class="nav-collapse">
        <ul class="nav pull-right">
          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                            class="icon-cog"></i> Account <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="javascript:;">Settings</a></li>
              <li><a href="javascript:;">Help</a></li>
            </ul>
          </li>
          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                            class="icon-user"></i>&nbsp;<?php echo $username; ?><b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="profile.php">Profile</a></li>
              <li><a href="../logout.php?logout">Logout</a></li>
            </ul>
          </li>
        </ul>
        <form class="navbar-search pull-right">
          <input type="text" class="search-query" placeholder="Search">
        </form>
      </div>
      <!--/.nav-collapse --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /navbar-inner --> 
</div>
<!-- /navbar -->
<div class="subnavbar">
    <div class="subnavbar-inner">
        <div class="container">
            <ul class="mainnav">
                <li class="active"><a href=""><i class="icon-sort-by-alphabet"></i><span>Products</span> </a> </li>
                <li><a href="orders.php"><i class="icon-shopping-cart"></i><span>Orders</span> </a> </li>
                <li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-list-alt"></i><span>Reports</span> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="orders.php">Orders</a></li>
                        <li><a href="payments.php">Payments</a></li>
                        <li><a href="invoice.php">Invoice</a></li>


                    </ul>
                </li>
                <li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon icon-print"></i><span>Actions</span> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="" onclick="printData()"> Print &nbsp; ⌘+p</a></li>
                        <li><a href="" onclick="printData()"> Convert &nbsp; ⌘+p</a></li>

                    </ul>
                </li>
            </ul>
        </div>
        <!-- /container -->
    </div>
  <!-- /subnavbar-inner --> 
</div>
<!-- /subnavbar -->
<div class="main">
    <div class="container">
        <!--********************Add content here *******************-->

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

    <?php

    require '../connection/db.php';

    if (isset($_POST['submit'])) {

        $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
        $image_name = addslashes($_FILES['image']['name']);
        $image_size = getimagesize($_FILES['image']['tmp_name']);

        move_uploaded_file($_FILES["image"]["tmp_name"], "../upload/" . $_FILES["image"]["name"]);

        $location = "../upload/" . $_FILES["image"]["name"];
        //$product_id_=$_POST['Product_Id'];
        $product_name_=$_POST['Product_Name'];
        $product_desc_=$_POST['product_desc'];
        $product_price_=$_POST['product_price'];
        $product_quantity_=$_POST['product_quantity'];

        mysqli_query($con,"INSERT INTO Farm_Product_Table(Farm_Product_Id,Farm_Product_Image,Farm_Product_Name,Farm_Product_Description,Farm_Product_Price,Farm_Product_Quantity)
      values ('$serial','$location','$product_name_','$product_desc_','$product_price_','$product_quantity_')
      ") or die(mysqli_error($con));

        $msg = "<div class='alert alert-success'>
						<span class='glyphicon glyphicon-info-sign'></span> &nbsp; New Product Added !
					</div>";
        echo '<meta content="4;index.php" http-equiv="refresh" />';

    }


    ?>
        
    <!--********************Add content here *******************-->
        <div class="row">

            <div class="span12">

                <div class="widget ">

                    <div class="widget-header">
                        <i class="icon-plus-sign"></i>
                        <h3>Add new product</h3>&nbsp;<a href="all_products.php"><span class="label label-info">Get all products</span> </a>
                    </div> <!-- /widget-header -->

                    <div class="widget-content">
                        <!--********************Add content here *******************-->

                        <form  method="POST" enctype="multipart/form-data" id="mytable" class="form-horizontal">
                            <?php
                            if (isset($msg)) {
                                echo $msg;
                            }
                            ?>

                            <div class="control-group">
                                <label class="control-label">Product Name:</label>
                                <div class="controls">
                                    <input type="text" name="Product_Name" placeholder="Tomato" id="in" required class="span6">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Product Price:</label>
                                <div class="controls">
                                    <input type="text" name="product_price"  id="in" placeholder="In Kenya Shillings" required class="span6">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Product Quantity:</label>
                                <div class="controls">
                                    <input type="text" name="product_quantity" placeholder="Quantity available"  id="in" required class="span6">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Product description:</label>
                                <div class="controls">
                                    <textarea name="product_desc" col="5" rows="7" class="span6" placeholder="Add your description here"></textarea>
                                </div>
                            </div>

                            <div class="control-group">
                                <div class="controls">
                                    <input type="file" name="image"  id="in" required class="span6">
                                </div>

                            </div>
                            <div class="control-group">
                                <div class="controls">
                                    <input type="submit" name="submit" value="Upload" class="btn btn-primary" >
                                    <input type="reset" name="reset" value="Cancel Upload" class="btn btn-primary" >
                                </div>

                            </div>

                        </form>
                        <!--********************Add content here *******************-->

                    </div> <!-- /widget-content -->

                </div> <!-- /widget -->

            </div> <!-- /span8 -->




        </div> <!-- /row -->

        <!---- add there --->

    <!--********************Add content here *******************-->
    </div>
  <!-- /main-inner -->
</div>

<!-- /main -->
<div class="extra">
  <div class="extra-inner">
    <div class="container">
      <div class="row">
                    <div class="span3">
                        <h4>
                            About us</h4>
                        <ul>
                            <li><a href="javascript:;">Careers</a></li>
                            <li><a href="javascript:;">Ethical Sourcing Policy</a></li>
                            <li><a href="javascript:;">Our History</a></li>
                            <li><a href="javascript:;">Quality Assurance</a></li>
                        </ul>
                    </div>
                    <!-- /span3 -->
                    <div class="span3">
                        <h4>
                            Support</h4>
                        <ul>
                            <li><a href="javascript:;">Frequently Asked Questions</a></li>
                            <li><a href="javascript:;">Ask a Question</a></li>
                            <li><a href="javascript:;">Video Tutorial</a></li>
                            <li><a href="javascript:;">Feedback</a></li>
                        </ul>
                    </div>
                    <!-- /span3 -->
                    <div class="span3">
                        <h4>
                            Our Terms</h4>
                        <ul>
                            <li><a href="javascript:;">Read License</a></li>
                            <li><a href="javascript:;">Terms of Use</a></li>
                            <li><a href="javascript:;">Privacy Policy</a></li>
                            <li><a href="javascript:;">Returns</a></li>
                        </ul>
                    </div>
                    <!-- /span3 -->
                    <div class="span3">
                        <h4>
                            What's Happening</h4>
                        <ul>
                            <li><a href="">Blog</a></li>
                            <li><a href="">Competitions and Events</a></li>
                            <li><a href="">Supporting the Community</a></li>
                            <li><a href="">Farmers Club</a></li>
                        </ul>
                    </div>
                    <!-- /span3 -->
                </div>
      <!-- /row -->
    </div>
    <!-- /container -->
  </div>
  <!-- /extra-inner -->
</div>
<!-- /extra -->
<div>
  <div class="footer-inner">
    <div class="container">
      <div class="row">
        <div class="span12"> &copy; 2017 <a href="https://www.github.com/skingori">Tarclink co by skingori</a>. </div>
        <!-- /span12 -->
      </div>
      <!-- /row -->
    </div>
    <!-- /container -->
  </div>
  <!-- /footer-inner -->
</div>
<!-- /footer -->
<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="../js/jquery-1.7.2.min.js"></script>
<script src="../js/excanvas.min.js"></script>
<script src="../js/chart.min.js" type="text/javascript"></script>
<script src="../js/bootstrap.js"></script>
<script language="javascript" type="text/javascript" src="../js/full-calendar/fullcalendar.min.js"></script>
<script>
    function printData()
    {
        var divToPrint=document.getElementById("table1");
        newWin= window.open("");
        newWin.document.write(divToPrint.outerHTML);
        newWin.print();
        newWin.close();
    }

</script>
</body>
</html>
