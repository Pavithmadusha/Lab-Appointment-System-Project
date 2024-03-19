<?php 
   
    include "connection.php";


	$payment_id = $statusMsg = ''; 
	$ordStatus = 'error';
	$id = '';

	// Check whether stripe token is not empty

	if(!empty($_POST['stripeToken'])){

		// Get Token, Card and User Info from Form
		$token = $_POST['stripeToken'];
		$name = $_POST['name'];
		$email = $_POST['email'];
		$course = $_POST['course'];
		$card_no = $_POST['card_number'];
		$card_cvc = $_POST['card_cvc'];
		$card_exp_month = $_POST['card_exp_month'];
		$card_exp_year = $_POST['card_exp_year'];
		$price = $_POST['amount'];

		

		// Include STRIPE PHP Library
		require_once('stripe-php/init.php');

		// set API Key
		$stripe = array(
		"SecretKey"=>"sk_test_51OuU2lKXhwA6DzLB3NThWPYRJ16E3YWraKFhxFu1M8n5Of3aP4l4mqxgYuBkJpmBuaVJK77dLIbrQcTdbnOgpHni00saVPvfKz",
		"PublishableKey"=>"pk_test_51OuU2lKXhwA6DzLBVrSiBHc9y5i0RCpyg1UczlA9vTZRURlselAJ1FXWHsOJBfycpTgLgM40G2sD6h4eL20Xqlxg00wcgnesze"
		);

		// Set your secret key: remember to change this to your live secret key in production
		// See your keys here: https://dashboard.stripe.com/account/apikeys
		\Stripe\Stripe::setApiKey($stripe['SecretKey']);

		// Add customer to stripe 
	    $customer = \Stripe\Customer::create(array( 
	        'email' => $email, 
	        'source'  => $token,
	        'name' => $name,
	        'description'=>$course
	    ));

	    // Generate Unique order ID 
	    $orderID = strtoupper(str_replace('.','',uniqid('', true)));
	     
	    // Convert price to cents 
	    $itemPrice = ($price*300);
	    $currency = "usd";
	   

	    // Charge a credit or a debit card 
	    $charge = \Stripe\Charge::create(array( 
	        'customer' => $customer->id, 
	        'amount'   => $itemPrice, 
	        'currency' => $currency, 
	        'description' => $course, 
	        'metadata' => array( 
	            'order_id' => $orderID 
	        ) 
	    ));

	    // Retrieve charge details 
    	$chargeJson = $charge->jsonSerialize();

    	// Check whether the charge is successful 
    	if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1){ 

	        // Order details 
	        $transactionID = $chargeJson['balance_transaction']; 
	        $paidAmount = $chargeJson['amount']; 
	        $paidCurrency = $chargeJson['currency']; 
	        $payment_status = $chargeJson['status'];
	        $payment_date = date("Y-m-d H:i:s");
	        $dt_tm = date('Y-m-d H:i:s');

	        // Insert tansaction data into the database

	        $sql = "INSERT INTO registration (name,email,coursename,fees,card_number,card_expirymonth,card_expiryyear,status,paymentid,added_date) VALUES ('".$name."','".$email."','".$course."','".$price."','".$card_no."','".$card_exp_month."','".$card_exp_year."','".$payment_status."','".$transactionID."','".$dt_tm."')";

	        mysqli_query($con,$sql) or die("Mysql Error Stripe-Charge(SQL)".mysqli_error($con));

    		

	        // If the order is successful 
	        if($payment_status == 'succeeded'){ 
	            $ordStatus = 'success'; 
	            $statusMsg = 'Your Payment has been Successful!'; 
	    	} else{ 
	            $statusMsg = "Your Payment has Failed!"; 
	        } 
	    } else{ 
	        //print '<pre>';print_r($chargeJson); 
	        $statusMsg = "Transaction has been failed!"; 
	    } 
	} else{ 
	    $statusMsg = "Error on form submission."; 
	} 
	
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Success</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/stripe.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
			background-color:#080808; 
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .status {
            text-align: center;
        }
        .heading {
            margin-top: 30px;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .info {
            margin-bottom: 20px;
        }
        .btn-continue {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-continue:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 style="text-align: center; color: #007bff;">Payment Success</h2>
    <div class="status">
        <h1><?php echo $ordStatus; ?></h1>
        <p><?php echo $statusMsg; ?></p>
    </div>
    <div class="info">
        <h3 class="heading">Payment Information</h3>
        <p><strong>Transaction ID:</strong> <?php echo $transactionID; ?></p>
        <p><strong>Paid Amount:</strong> <?php echo $paidAmount.' '.$paidCurrency; ?> ($<?php echo $price; ?>.00)</p>
        <p><strong>Payment Status:</strong> <?php echo $payment_status; ?></p>
    </div>
    <div class="info">
        <h3 class="heading">Product Information</h3>
        <p><strong>Doctor's Name:</strong> <?php echo $course; ?></p>
        <p><strong>Price:</strong> <?php echo $price.' '.$currency; ?> ($<?php echo $price; ?>.00)</p>
    </div>
    <a href="../schedule.php" class="btn-continue">Back to Home</a>
</div>

</body>
</html>
