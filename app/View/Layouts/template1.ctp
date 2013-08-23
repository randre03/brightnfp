<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $title; ?></title>
<!--[if lt IE 9]>
<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<?php
  echo $javascript->link('prototype');
     
?>
<?php echo $this->Html->css('template1/'.$theme.'/style.css'); ?>
</head>

<body>
<div id="loaderIDast" style="background:#fff;opacity:0.5;filter: alpha(opacity=50);padding-top:20%;position:absolute;top:0;left:0;text-align:center;vertical-align:middle; height:80%;width:100%;display:none;position:fixed;"><img src="/img/ajax-loader.gif" style="opacity:1.0 !important;filter: alpha(opacity=100) !important" alt="" /></div>
<!-- Wrapper -->
<section id="wrapper">
  <!-- Header-->
 <header id="header">
  <div id="logo"><h1><?php echo $pageTitle; ?></h1></div>
  <div id="nav-align">
   <nav id="nav">
    <ul><?php echo $menu; ?>
    </ul>
    </nav>
  </div>
 </header>
 <!-- Header End-->
 
 <section id="content">
      <div align="center">
        				<?php if($this->Session->check('Message.flash')){ ?>
        					<div align="center" class="messageBlock">
        						<?php echo $this->Session->flash();?>
        					</div>
        					<?php
        				}?>
        </div>
  <div id="content_wrap">
  <!-- Left Widget-->
   <div id="left-widget">
 <!-- Content Starts-->
 <?php echo $content_for_layout; ?>
 
   </div>
   <!-- Left Widget Ends -->
   
   <!-- Right Widget -->
   <div id="right-widget">
     <!-- Search Start -->
     <div class="search">
           
     <!-- Category-->
     <div class="category">
      <h1 class="line">Categories</h1>
      <ul class="listing">
       <li><a href="#">Aliquam libero</a></li>
       <li><a href="#">Consectetuer adipiscing elit</a></li>
       <li><a href="#">Metus aliquam pellentesque</a></li>
       <li><a href="#">Suspendisse iaculis mauris</a></li>
       <li><a href="#">Urnanet non molestie semper</a></li>
       <li><a href="#">Proin gravida orci porttitor</a></li>
       <li><a href="#">Suspendisse iaculis mauris</a></li>
       <li><a href="#">Urnanet non molestie semper</a></li>
     </ul>
     </div>
     
     <!-- Blogroll-->
     <div class="blogroll">
      <h1 class="line">Blogroll</h1>
      <ul class="listing">
       <li><a href="#">Aliquam libero</a></li>
       <li><a href="#">Consectetuer adipiscing elit</a></li>
       <li><a href="#">Metus aliquam pellentesque</a></li>
       <li><a href="#">Suspendisse iaculis mauris</a></li>
       <li><a href="#">Urnanet non molestie semper</a></li>
       <li><a href="#">Proin gravida orci porttitor</a></li>
       <li><a href="#">Suspendisse iaculis mauris</a></li>
       <li><a href="#">Urnanet non molestie semper</a></li>
     </ul>
     </div>
     
     <!-- Archieves -->
     <div class="Archieves">
      <h1 class="line">Archieves</h1>
      <ul class="listing">
       <li><a href="#">Aliquam libero</a></li>
       <li><a href="#">Consectetuer adipiscing elit</a></li>
       <li><a href="#">Metus aliquam pellentesque</a></li>
       <li><a href="#">Suspendisse iaculis mauris</a></li>
       <li><a href="#">Urnanet non molestie semper</a></li>
       <li><a href="#">Proin gravida orci porttitor</a></li>
       <li><a href="#">Suspendisse iaculis mauris</a></li>
       <li><a href="#">Urnanet non molestie semper</a></li>
     </ul>
     </div>
   </div>
   </div>
   <!-- Right Widget end-->
  </div>
 </section>
 <!-- Content Ends -->
 
 
 <!-- Main Footer Starts -->
 <footer id="footer">
    <section id="footer-wrap">
     <!-- Footer Left -->
     <!--<div class="foot_left">
      <h1 class="foot_h1">About us</h1>
      <p class="foot_p">
       Standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make. dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make.
      </p>
      <p align="right"><a href="#">Read More</a></p>
     </div>-->
      <!-- Footer left ends -->
      
      <!-- Footer Right -->
     <!--<div class="foot_right">
       <h1 class="foot_h1">Gallery</h1>
       <ul id="gallery">
        <li><a href="#"><img src="images/img1.png"></a></li>
        <li><a href="#"><img src="images/img2.png"></a></li>
        <li><a href="#"><img src="images/img3.png"></a></li>
        <li><a href="#"><img src="images/img1.png"></a></li>
        <li><a href="#"><img src="images/img2.png"></a></li>
        <li><a href="#"><img src="images/img3.png"></a></li>
       </ul>
     </div>-->
    </section>
     <!-- Footer right ends -->
    
     <!-- Footer Bottom -->
      <section id="footer_btm">
     <div id="footer_btm_wrap">
      <ul class="foot_nav"><?php echo $menu; ?>
      </ul>
      <span class="foot_copy">Copyright&copy;2011. All rights reserved</span>
     </div>
    </section>
    
 </footer>
 
  <!--Main Footer Ends -->
</section>
 <!-- Wrapper Ends -->

</body>
</html>
