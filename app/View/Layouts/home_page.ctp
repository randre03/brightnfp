<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $title_for_layout; ?></title>
<!--[if lt IE 9]>
<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<?php
  echo $javascript->link(array('jquery','jquery.min','jquery.validate','jquery.alerts'));
  echo $this->Html->css(array('frontendstyle','jquery.alerts')); 
  
?>


<!-- jquery Slider Banner -->
<script type="text/javascript">
var jQuery = $.noConflict();
jQuery(document).ready(function(){
  var currentPosition = 0;
  var slideWidth = 990;
  var slides = $('.slide');
  var numberOfSlides = slides.length;

  // Remove scrollbar in JS
  jQuery('#slidesContainer').css('overflow', 'hidden');

  // Wrap all .slides with #slideInner div
  slides
    .wrapAll('<div id="slideInner"></div>')
    // Float left to display horizontally, readjust .slides width
	.css({
      'float' : 'left',
      'width' : slideWidth
    });

  // Set #slideInner width equal to total width of all slides
  jQuery('#slideInner').css('width', slideWidth * numberOfSlides);

  // Insert controls in the DOM
  jQuery('#slideshow')
    .prepend('<span class="control" id="leftControl">Clicking moves left</span>')
    .append('<span class="control" id="rightControl">Clicking moves right</span>');

  // Hide left arrow control on first load
  manageControls(currentPosition);

  // Create event listeners for .controls clicks
  jQuery('.control')
    .bind('click', function(){
    // Determine new position
	currentPosition = ($(this).attr('id')=='rightControl') ? currentPosition+1 : currentPosition-1;
    
	// Hide / show controls
    manageControls(currentPosition);
    // Move slideInner using margin-left
    jQuery('#slideInner').animate({
      'marginLeft' : slideWidth*(-currentPosition)
    });
  });

  // manageControls: Hides and Shows controls depending on currentPosition
  function manageControls(position){
    // Hide left arrow if position is first slide
	if(position==0){ jQuery('#leftControl').hide() } else{ jQuery('#leftControl').show() }
	// Hide right arrow if position is last slide
    if(position==numberOfSlides-1){ jQuery('#rightControl').hide() } else{ jQuery('#rightControl').show() }
  }	
});
</script>
<!-- jquery Slider Banner Ends Here-->
</head>

<body>
<!-- Header Start -->
<?php echo $this->element('header'); ?>
<!-- Header Ends -->
<?php echo $content_for_layout; ?>
<!-- Footer Starts -->
<?php echo $this->element('footer'); ?>
<!-- Footer Ends -->

<script type="text/javascript">
  jQuery('.success,.fail').append('<a class="close" href="#">Close</a>');
  jQuery('.close').click(function (){
      jQuery('.success,.fail').fadeOut('slow');
  });
</script>
</body>
</html>
