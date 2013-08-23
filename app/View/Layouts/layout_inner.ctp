<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $title_for_layout; ?></title>
<!--[if lt IE 9]>
<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<?php
  echo $javascript->link(array('jquery','jquery.min','jquery.validate','jquery.alerts','jquery-ui-1.8.16.custom.min','jquery-ui-timepicker-addon','prototype'));
  echo $this->Html->css(array('frontendstyle','jquery.alerts','jquery-ui-1.8.16.custom'));
 ;
     
?>
<script type="text/javascript">
var jQuery = jQuery.noConflict();
</script>
<!-- jquery Slider Banner Ends Here-->
</head>

<body>
<!-- Header Start -->
<?php echo $this->element('header'); ?>
<!-- Header Ends -->

<div id="loaderIDast" style="background:#fff;opacity:0.5;filter: alpha(opacity=50);padding-top:20%;position:absolute;top:0;left:0;text-align:center;vertical-align:middle; height:80%;width:100%;display:none;position:fixed;"><img src="/img/ajax-loader.gif" style="opacity:1.0 !important;filter: alpha(opacity=100) !important" alt="" /></div>
<!-- Container Starts -->
<section id="content_container">
      <section id="container_wrap">
      <?php
       echo $content_for_layout;
       $memberLog  = $this->Session->read('SESSION_USER.Member');
       $npoLog = $this->Session->read('SESSION_USER.Npo');
       if(isset($npoLog) && !empty($npoLog)){
          echo $this->element('inner_right_panel'); 
       }elseif(isset($memberLog) && !empty($memberLog)){
          echo $this->element('member_right_panel'); 
       }
       ?>
         
      </section>
</section>
<!-- Container Ends -->
          <?php echo $this->element('inner_footer'); ?>

<script type="text/javascript">
  jQuery('.success,.fail').append('<a class="close" href="#">Close</a>');
  jQuery('.close').click(function (){
      jQuery('.success,.fail').fadeOut('slow');
  });
</script>
</body>
</html>
