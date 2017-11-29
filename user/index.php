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

        case 1:
            header('location:../admin/index.php');//redirect to  page
            break;
        case 3:
            header('location:../officer/index.php');//redirect to  page
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


$check_ = $con->query("SELECT Customer_Id FROM Customer_Table WHERE Customer_Id='$id' ");
$count=$check_->num_rows;

if ($count==0) {

    header('Location:profile.php');
}else{

null;

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
                <li><a href="payment.php"><i class="icon-money"></i><span>Payments</span> </a> </li>
                <li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-list-alt"></i><span>My Orders</span> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="unconfirmed.php">Waiting</a></li>
                        <li><a href="confirm_order.php">Confirmed</a></li>

                    </ul>
                </li>
                <li><a href=""><i class="icon-question-sign"></i><span>Help</span> </a> </li>
            </ul>
        </div>
        <!-- /container -->
    </div>
  <!-- /subnavbar-inner --> 
</div>
<!-- /subnavbar -->
<div class="main">
        <!--********************Add content here *******************-->
<div class="container">
    <!--********************Add content here *******************-->
    <div class="row">

        <div class="span12">

            <div class="widget ">

                <div class="widget-header">
                    <i class="icon-qrcode"></i>
                    <h3>Available Products</h3>
                </div> <!-- /widget-header -->

                <div class="widget-content">
                    <!--********************Add content here *******************-->
    <?php

    $results = $con->query("SELECT * FROM Farm_Product_Table ORDER BY Farm_Product_Id ASC");
    if($results){
        $products_item = '<ul class="products">';
//fetch results set as object and output HTML
        while($obj = $results->fetch_object())
        {
            $products_item .= <<<EOT
	<li class="product">
	<form method="post" action="cart_update.php">
	<div class="product-content"><h3>{$obj->Farm_Product_Name}</h3>
	<div><img class='image-cover' src="{$obj->Farm_Product_Image}" ALT=""></div>
	<div class="product-desc">About:{$obj->Farm_Product_Description}</div>
	<div class="product-info">Price: {$obj->Farm_Product_Price}

	<fieldset>

    
	</fieldset>
	<input type="hidden" name="product_code" value="{$obj->Farm_Product_Id}" >
	<input type="hidden" name="type" value="add" />
	<input type="hidden" name="return_url" value="{$current_url}" >
	<div align="center"><a href="view_cart.php?pid={$obj->Farm_Product_Id}" class="btn btn-primary">Buy</a></div>
	</div></div>
	</form>
	</li>
EOT;
        }
        $products_item .= '</ul>';
        echo $products_item;
    }
    ?>
</div>
    <!--********************Add content here *******************-->

            </div> <!-- /widget-content -->

        </div> <!-- /widget -->

    </div> <!-- /span8 -->


    <!--********************Add content here *******************-->

</div> <!-- /row -->

    <!---- add there --->

    <!--********************Add content here *******************-->
  <!-- /main-inner -->
</div>
</body>
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

</html>
