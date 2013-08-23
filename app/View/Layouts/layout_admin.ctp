<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title_for_layout; ?></title>
<?php
  echo $this->Html->css(array('theme','style'));
  echo $javascript->link(array('jquery','jquery.min','jquery.validate','prototype'));
?>
<!--[if IE]>
<link rel="stylesheet" type="text/css" href="css/ie-sucks.css" />
<![endif]-->
</head>
<script type="text/javascript">   
    var jQuery = jQuery.noConflict();
</script>

<body>
<div id="loaderIDast" style="background:#fff;opacity:0.5;filter: alpha(opacity=50);padding-top:20%;position:absolute;top:0;left:0;text-align:center;vertical-align:middle; height:80%;width:100%;display:none;position:fixed;"><img src="/img/ajax-loader.gif" style="opacity:1.0 !important;filter: alpha(opacity=100) !important" alt="" /></div>
	<div id="container">
    	<div id="header">
        	<h2>Admin area</h2>
        	<div id="topmenu">
        	<?php
        	   if(isset($admin_user_id) && $admin_user_id !==''){
                echo $this->element('top_menu'); 
                $contentWidth = 'width:75%';
             }else{
                $contentWidth = '';
             }           
           ?>
           &nbsp;
          </div>
      </div>
        
        <div id="wrapper">
            <div style="<?php echo $contentWidth; ?>">
            <div id="content">
              <div align="center">
        				<?php if($this->Session->check('Message.flash')){ ?>
        					<div align="center" class="messageBlock">
        						<?php echo $this->Session->flash();?>
        					</div>
        					<?php
        				}?>
        			</div>
            <?php  echo $content_for_layout;?>
            </div>
            </div>
            <?php 
        	   if(isset($admin_user_id) && $admin_user_id !==''){
                echo $this->element('right_panel');
                } 
            ?>
      </div>
        <div id="footer">
        <div id="credits">
   		Template by <a href="http://www.bloganje.com">Bloganje</a>
        </div>
        <div id="styleswitcher">
            <ul>
                <li><a href="javascript: document.cookie='theme='; window.location.reload();" title="Default" id="defswitch">d</a></li>
                <li><a href="javascript: document.cookie='theme=1'; window.location.reload();" title="Blue" id="blueswitch">b</a></li>
                <li><a href="javascript: document.cookie='theme=2'; window.location.reload();" title="Green" id="greenswitch">g</a></li>
                <li><a href="javascript: document.cookie='theme=3'; window.location.reload();" title="Brown" id="brownswitch">b</a></li>
                <li><a href="javascript: document.cookie='theme=4'; window.location.reload();" title="Mix" id="mixswitch">m</a></li>
            </ul>
        </div><br />

        </div>
</div>
<script type="text/javascript">
  jQuery('.success,.fail').append('<a class="close" href="#">Close</a>');
  jQuery('.close').click(function (){
      jQuery('.success,.fail').fadeOut('slow');
  });
</script>
<?php //echo $this->element('sql_dump');?>
</body>
</html>
