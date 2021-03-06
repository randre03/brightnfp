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
  echo $this->Html->css('template3/'.$theme.'/style.css'); ?>
</head>

<div id="loaderIDast" style="background:#fff;opacity:0.5;filter: alpha(opacity=50);padding-top:20%;position:absolute;top:0;left:0;text-align:center;vertical-align:middle; height:80%;width:100%;display:none;position:fixed;"><img src="/img/ajax-loader.gif" style="opacity:1.0 !important;filter: alpha(opacity=100) !important" alt="" /></div>
<body>
<!-- Wrapper -->
<section id="wrapper">
    
    <!-- Header-->
    <header id="header">
    <div id="logo"><?php echo $pageTitle; ?></h1></div>
    <nav id="nav">
    <ul><?php echo $menu; ?>
    </ul>
    </nav>
      <div align="center">
        				<?php if($this->Session->check('Message.flash')){ ?>
        					<div align="center" class="messageBlock">
        						<?php echo $this->Session->flash();?>
        					</div>
        					<?php
        				}?>
        </div>
    </header>
    <!-- Header End-->
 
    <!--Banner Start-->
    <section id="banner">
    
        <section class="banner_content">
            <h1><?php echo $title1; ?></h1>
            <p><?php echo $desc1; ?></p>
        </section>
        
        <!--Banner Slider Start-->
        <figure class="slider_widget"><img src="<?php echo $imgUrl; ?>" width="563" height="264" alt=""></figure>
        <!--Banner Slider Closed-->
    
    </section>
    <!--Banner Closed-->
 <section id="content">
    
        <!-- Left Widget-->
        <aside id="left-widget">
        
        <!--Search-->
        <div class="module">
            <div class="search">
              <input name="" type="text" class="search_text">
              <input name="" type="submit" value="Search" class="search_btn">
             </div>
        </div>
        
        <!-- Category-->
        <div class="module">
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
        <div class="module">
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
        <div class="module">
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
        
        
        </aside>
        <!-- Left Widget Ends --> 
        
         <!-- Right Widget -->
        <div id="right-widget">
        
    <!-- Content Starts-->
 <?php echo $content_for_layout; ?>
    <!-- Content Ends -->

        
        </div>
        <!-- Right Widget end-->  
    
    </section>
</section>
 <!-- Wrapper Ends -->
 
<!--Footer Start-->
<footer id="footer_wrap">
    <section id="footer">
        <ul class="foot_nav"><?php echo $menu; ?>
        </ul>
        <span class="foot_copy">Copyright&copy;2011. All rights reserved</span>
    </section>
</footer>
<!--Footer Closed-->


</body>
</html>
