<?php
$plan=$_POST['plan'];
//print_r($_POST);
//echo "plan:".$plan;
if($plan=="select-basic")
{
$amnt=18;
$period=3;
$time="M";
$plan_name="Basic";
$plan_no=1;
}
else
{
$amnt=33;
$period=6;
$time="M";
$plan_name="Business";
$plan_no=2;
}
?>
<div>
<p><span>You have selected plan:</span><span></span><span><?php echo $plan_name ?></span></p>
<p><span>Plan details:</span><span></span><span><?php echo $amnt." USD" ?> every <?php echo $period.$time?></span></p>

</div>
<!-- <form action="https://www.paypal.com/cgi-bin/webscr" method="post"> -->
<form action="http://www.sandbox.paypal.com/cgi-bin/webscr" method="post">  

    <!-- Identify your business so that you can collect the payments. -->
   <!-- <input type="hidden" name="business" value="alice@mystore.com"> -->
	<input type="hidden" name="business" value="training.ideabytes-facilitator@gmail.com">

    <!-- Specify a Subscribe button. -->
    <input type="hidden" name="cmd" value="_xclick-subscriptions">

    <!-- Identify the subscription. -->
    <input type="hidden" name="item_name" value="<?php echo $plan_name ?>">
    <input type="hidden" name="item_number" value="<?php echo $plan_no ?>">

<!-- Set the terms of the 1st trial period. -->
    <input type="hidden" name="currency_code" value="USD">
  <!--  <input type="hidden" name="a1" value="0">
    <input type="hidden" name="p1" value="30">
    <input type="hidden" name="t1" value="D"> -->

    <!-- Set the revised subscription price and terms. -->
    <input type="hidden" name="a3" value="<?php echo $amnt ?>">
    <input type="hidden" name="p3" value="<?php echo $period ?>">
    <input type="hidden" name="t3" value="<?php echo $time ?>">

    <!-- Set recurring payments until canceled. -->
    <input type="hidden" name="src" value="1">

    <!-- Let current subscribers modify only. -->
    <input type="hidden" name="modify" value="2">

    <!-- Display the payment button. -->
    <input type="image" name="submit"
    src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribe_LG.gif"
    alt="PayPal - The safer, easier way to pay online">
    <img alt="" width="1" height="1"
    src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >
</form>
<!--<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_subscr-find&alias=SGGGX43FAKKXN&switch_classic=true">
<img src="https://www.paypalobjects.com/en_US/i/btn/btn_unsubscribe_LG.gif">
</a>-->
