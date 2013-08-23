<?php 
echo $paypal->button('Donate', array('type' => 'donate','item_name'=>'church abc','npo_id'=>'1','return' => 'http://172.24.0.9:9678/paypal_ipn/process')); 
?>