<?php
include_once ("../connection/db.php");

session_start();
// Check, if user is already login, then jump to secured page
if (isset($_SESSION['logname']) && ($_SESSION['rank'])) {
    switch($_SESSION['rank']) {

        case 1:
            header('location:../admin/index.php');//redirect to  page
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


if (isset($_POST['add'])) {

    
    $Customer_Name_=$_POST['Customer_Name'];
    $Customer_Number_=$_POST['Customer_Number'];
    $Customer_Address_=$_POST['Customer_Address'];
    $Customer_Email_=$_POST['Customer_Email'];

    mysqli_query($con,"INSERT INTO Customer_Table(Customer_Id,Customer_Name,Customer_Number,Customer_Address,Customer_Email)
      values ('$id','$Customer_Name_','$Customer_Number_','$Customer_Address_','$Customer_Email_')
      ") or die(mysqli_error($con));

    $msg = "<div class='alert alert-success'>
						<span class='glyphicon glyphicon-info-sign'></span> &nbsp; Success!
					</div>";
    echo '<meta content="4;index.php" http-equiv="refresh" >';

}

include'header.php';?>
<!-- Add content -->
<!--********************Add content here *******************-->
<div class="row">

    <div class="span12">

        <div class="widget ">

            <div class="widget-header">
                <i class="icon-plus-sign"></i>
                <h3><a href="#">Update profile</a> </h3>
            </div> <!-- /widget-header -->

            <div class="widget-content">
<!--********************Add content here *******************-->
                <?php
                if (isset($msg)) {
                    echo $msg;
                }
                ?>
                <form class="form-horizontal" method="POST" enctype="multipart/form-data">
                    <div class="control-group">
                        <label for="Customer_Name" class="col-sm-2 control-label">Full Name:</label>

                        <div class="controls">
                            <input type="text" class="span6" id="Customer_Name" name="Customer_Name" pattern="[a-zA-Z\s]{4,}" title="Use letters ONLY" placeholder="John Doe">
                        </div>
                    </div>
                    
                   <div class="control-group">
                        <label for="Customer_Number" class="col-sm-2 control-label">Mobile Number:</label>

                        <div class="controls">
                            <input type="tel" class="span6" pattern="^[0-9\-\+\s\(\)]*$" title="Input the correct contact as our example" id="Customer_Number" name="Customer_Number" placeholder="+254724090774">
                        </div>
                    </div>
                    
                    <div class="control-group">
                       <label for="Customer_Email" class="col-sm-2 control-label">Your e-mail:</label>

                       <div class="controls">
                           <input type="email" class="span6" title="Input the correct email as our example" id="" name="Customer_Email" placeholder="skingori@github.com">
                       </div>
                    </div>
                   <div class="control-group">
                        <label for=Customer_Address"" class="col-sm-2 control-label">Your Address:</label>

                        <div class="controls">
                            <input type="text" class="span6"  title="" id="" name="Customer_Address" placeholder="135-10105 Mweiga">
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                            </label>
                        </div>
                        </div>
                    </div>
                    
                    
                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" class="btn btn-danger" name="add" id="add">Submit</button>
                        </div>
                    </div>
<!--********************Add content here *******************-->

</div> <!-- /widget-content -->

</div> <!-- /widget -->

</div> <!-- /span8 -->




</div> <!-- /row -->

<!---- add there --->

<!--********************Add content here *******************-->

<?php
include 'footer.php';

?>
<script type="text/javascript">
    function checkAge(bday)
    {
        if(bday<18)
        {
            alert('You must be 18 or older to continue');
            document.getElementById('add').disabled=true;
        }
        else
        {
            document.getElementById('add').disabled=false;
        }
    }
</script>

