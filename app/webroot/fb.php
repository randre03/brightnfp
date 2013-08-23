<?php
 require_once("facebook.php");

  $config = array();
  $config['appId'] = '336667089705815';
  $config['secret'] = '68a833666be2c7768fdce0b1fcc28912';
  $config['fileUpload'] = false; // optional

  $facebook = new Facebook($config); 
  $session = $facebook->getUser();
  if($session){
    $friends = $facebook->api('/me/friends');
   /* $fql = 'SELECT email FROM user where is_app_user = 1';
    $friends = $facebook->api(array(
                  'method'       => 'fql.query',
                  'query'        => $fql,
                ));
      */
    $logoutUrl = $facebook->getLogoutUrl();
    echo '<a href="'.$logoutUrl.'">Logout</a>';
    echo "<pre>".print_r($friends,TRUE)."</pre>";
    }else{
    $loginUrl = $facebook->getLoginUrl(array('req_perms'=>'read_stream,','canvas'=>1,'fbconnect'=>0));
    echo '<script> top.location.href="'.$loginUrl.'"; </script>>';
    }

?>