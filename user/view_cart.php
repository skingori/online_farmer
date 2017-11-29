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
//For order number
$chars = array(0,1,2,3,4,5,6,7,8,9);
$order = '';
$max = count($chars)-1;
for($i=0;$i<10;$i++){
    $order .= (!($i % 15) && $i ? '' : '').$chars[rand(0, $max)];
}
//For invoice code
$chars = array(0,1,2,3,4,5,6,7,8,9,'A','B','C','D','E','F','G','H','I','J','K','L','M','N');
$in_code = '';
$max = count($chars)-1;
for($i=0;$i<10;$i++){
    $in_code .= (!($i % 15) && $i ? '-' : '').$chars[rand(0, $max)];
}
//for invoice number
$chars = array(0,1,2,3,4,5,6,7,8,9);
$invoice = '';
$max = count($chars)-1;
for($i=0;$i<10;$i++){
    $invoice .= (!($i % 10) && $i ? '' : '').$chars[rand(0, $max)];
}
//for order id
$chars = array(0,1,2,3,4,5,6,7,8,9);
$order_id = '';
$max = count($chars)-1;
for($i=0;$i<10;$i++){
    $order_id .= (!($i % 11) && $i ? '' : '').$chars[rand(0, $max)];
}
//INSERT DATA ON DB
$data =$_GET['pid'];
$result = mysqli_query($con, "SELECT * FROM Farm_Product_Table WHERE Farm_Product_Id='$data'");

while($res = mysqli_fetch_array($result))
{
    $Farm_Product_Name_=$res['Farm_Product_Name'];
    $Farm_Product_Price_=$res['Farm_Product_Price'];
    $Farm_Product_Quantity_=$res['Farm_Product_Quantity'];
    $Farm_Product_Image_=$res['Farm_Product_Image'];

}

if(isset($_POST['finish'])) {

    $Payment_Code_=$_POST['Payment_Code'];
    $Payment_Mode_=$_POST['Payment_Mode'];
    $Payment_Invoice_Number_=$_POST['Payment_Invoice_Number'];

    $sql = "INSERT INTO Payment_Table(Payment_Code,Payment_Mode,Payment_Invoice_Number,Payment_Date)
VALUES ('$Payment_Code_', '$Payment_Mode_', '$Payment_Invoice_Number_',NOW());";
    $sql .= "INSERT INTO Order_table(Order_Id,Order_Number ,Order_Placement_Date ,Order_Fulfilment_Date,Order_Customer_Id)
VALUES ('$order_id', '$order', NOW(),NOW(),'$id');";

    $sql .= "INSERT INTO Order_Details_Table(Order_Details_Order_Number,Order_Details_Farm_Product_Id)
VALUES ('$order','$data');";

    $sql .= "INSERT INTO Invoice_Table(Invoice_Number,Invoice_Code,Invoice_Order_Number)
VALUES ('$Payment_Invoice_Number_', '$in_code','$order')";

    if ($con->multi_query($sql) === TRUE) {
        
        $msg = "<div class='alert alert-success'>
						<span class='glyphicon glyphicon-info-sign'></span> &nbsp; Success!
					</div>";
        
        echo '<meta content="4;index.php" http-equiv="refresh" >';
    
        
    } else {
        
        $msg = "<div class='alert alert-warning'>
						<span class='glyphicon glyphicon-info-sign'></span> $con->error
					</div>";
     
    }

    $con->close();

}

?>

<?php include 'header.php';?>

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
                <h3>Thank you for choosing us:</h3>
            </div> <!-- /widget-header -->

            <div class="widget-content">
<!--********************Add content here *******************-->
                <!-- ADD CONTENT HERE -->
                <ul id="registration-step">
                    <li id="account" class="highlight icon-shopping-cart"> Cart</li>
                    <li id="password">Payment</li>
                    <li id="general" class="li">Confirm</li>
                </ul>
                <form name="frmRegistration" id="registration-form" method="POST">
                    <div id="account-field">
                        <div class="control-group">
                            <label class="control-label">Product Name:</label>
                            <div class="controls">
                                <input type="text" name="Farm_Product_Name" readonly id="in" value="<?php echo $Farm_Product_Name_; ?>" required class="span6">
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Product Image:</label>
                            <div>
                                <div class="controls">
                                    <img class='image-cover' src="<?php echo $Farm_Product_Image_; ?>" ALT="">
                                    <img class='image-cover' src="<?php echo $Farm_Product_Image_; ?>" ALT="">
                                </div>
                            </div>
                        </div>


                        <div class="control-group">
                            <label class="control-label">Product Price/ Kg:</label>
                            <div class="controls">
                                <input type="text" name="Farm_Product_Price" readonly id="Farm_Product_Price" value="<?php echo $Farm_Product_Price_; ?>" required class="span6">
                            </div>
                        </div>
                        <div class="control-group">

                            <div class="controls">
                                <label class="control-label">Add Quantity in Kg[s]: <span id="confirmMessage" class="confirmMessage"></span></label>
                                <input class="span6" name="Farm_Product_Id" id="quantity">
                            </div>

                        </div>

                    </div>

                    <div id="password-field" style="display:none;">
                        <div class="control-group">
                            <label for="Payment_Amount">Total Amount to pay:</label>
                            <input type="text" class="span6" name="" placeholder="e.g. 70000" id="payment" required="" readonly>
                        </div>

                        <div class="form-group">
                            <label for="Payment_Id">Confirmation Code:</label>
                            <input type="text" class="span6" name="Payment_Code" placeholder="e.g. XiUGGH9977VC" required="">
                        </div>
                        <div class="form-group">
                            <label for="Payment_Id">Invoice Number:</label>
                            <input type="text" readonly class="span6" name="Payment_Invoice_Number" value="<?php echo $invoice; ?>" >
                        </div>

                        <div class="control-group">
                            <label for="Payment_Mode">Application type:</label>
                            <select class="span6" name="Payment_Mode" id="Payment_Mode">
                                <option value="MPESA"> M-PESA </option>
                                <option value="AIRTEL-MONEY"> AIRTEL-MONEY </option>
                                <option value="BANK"> BANK </option>
                            </select>
                        </div>
                    </div>
                    
                    <div id="terms" style="display:none;" class="terms">

                        <div class="control-group">
                            <label for="Payment_Amount">* Item paid for: <?php echo $Farm_Product_Name_;?></label>
                        </div>
                        <div class="control-group">
                            <span id="confirmMessage2" class="confirmMessage2"></span>
                        </div>
                        <hr>
                        <div class="col-xs-8">
                            <div class="checkbox icheck">
                                <label>
                                    <input type="checkbox" required> I confirm and agree to the <a href="#">terms & conditions</a>
                                </label>
                            </div>
                        </div>
                        <hr>
                    </div>
                    
                    <div>
                        
                        <input class="btn btn-primary" type="button" name="back" id="back" value="Back" style="display:none;">
                        <input class="btn btn-primary" type="button" name="next" id="next" value="Next">
                        <input class="btn btn-default" type="submit" name="finish" id="finish" value="Finish" style="display:none;">
                    </div>

                </form>
                <style>
                    #registration-step{margin:0;padding:0;}
                    #registration-step li{list-style:none; float:left;padding:5px 10px;border-top:#EEE 1px solid;border-left:#EEE 1px solid;border-right:#EEE 1px solid;}
                    #registration-step li.highlight{background-color:#418EBA;}
                    #registration-form{clear:both;border:1px #EEE solid;padding:20px;}
                    .demoInputBox{padding: 10px;border: #F0F0F0 1px solid;border-radius: 4px;background-color: #FFF;width: auto;}
                    .registration-error{color:#FF0000; padding-left:15px;}
                    .message {color: #00FF00;font-weight: bold;width: 100%;padding: 10px;}
                    .btnAction{padding: 5px 10px;background-color: #09F;border: 0;color: #FFF;cursor: pointer; margin-top:15px;}
                </style>
            </div>
            <!--END ADD CONTENT HERE -->
     <!--********************Add content here *******************-->

</div> <!-- /widget-content -->

</div> <!-- /widget -->

</div> <!-- /span8 -->




</div> <!-- /row -->

<!---- add there --->

<!--********************Add content here *******************-->
 
<?php include 'footer.php';?>
<script>
        function validate() {
            var output = true;

            return output;
        }
        $(document).ready(function() {
            $("#next").click(function(){
                var output = validate();
                if(output) {
                    var current = $(".highlight");
                    var next = $(".highlight").next("li");
                    if(next.length>0) {
                        $("#"+current.attr("id")+"-field").hide();
                        $("#"+next.attr("id")+"-field").show();
                        $("#back").show();
                        $("#finish").hide();
                        $(".highlight").removeClass("highlight");
                        next.addClass("highlight");
                        if($(".highlight").attr("id") === $("#general").last().attr("id")) {
                            $("#next").hide();
                            $("#finish").show();
                            $("#terms").show();
                        }
                    }
                }
            });
            $("#back").click(function(){
                var current = $(".highlight");
                var prev = $(".highlight").prev("li");
                if(prev.length>0) {
                    $("#"+current.attr("id")+"-field").hide();
                    $("#"+prev.attr("id")+"-field").show();
                    $("#next").show();
                    $("#finish").hide();
                    $("#terms").hide();
                    $(".highlight").removeClass("highlight");
                    prev.addClass("highlight");
                    if($(".highlight").attr("id") == $("li").first().attr("id")) {
                        $("#back").hide();
                    }
                }
            });
        });


    </script>
<script>
    $('input#quantity').keyup(function() {
        var message = document.getElementById('confirmMessage');
        var message2 =document.getElementById('confirmMessage2');

        message.style.color = "#66cc66";
        $('#payment').val($(this).val() * $('#Farm_Product_Price').val());

        message.innerHTML ="Your total payment is = "+ $(this).val() * $('#Farm_Product_Price').val();

        message2.innerHTML ="* Your total payment is = "+ $(this).val() * $('#Farm_Product_Price').val();

    });
</script>
