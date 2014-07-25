<?php
/* Paypal IPN plugin */
Router::connect('/paypal_ipn/process', array(
	'plugin' => 'paypal_ipn',
	'controller' => 'instant_payment_notifications',
	'action' => 'process'
));

/* Optional Route, but nice for administration */
Router::connect('/paypal_ipn/:action/*', array(
	'admin' => 'true',
	'plugin' => 'paypal_ipn',
	'controller' => 'instant_payment_notifications',
));

Router::connect('/paypal_items/:action/*', array(
	'admin' => 'true',
	'plugin' => 'paypal_ipn',
	'controller' => 'paypal_items',
));
/* End Paypal IPN plugin */