<?php
 echo $this->Html->css('colorbox');
 echo $javascript->link(array('jquery.colorbox'));
?>
<div id="themeTable">
<?php	
	echo $this->element('themes/list_themes');
?>	
</div>
<script type="text/javascript">
  jQuery(document).ready(function(){
    jQuery(".iframe").colorbox({photo:true, width:"90%", height:"90%"});
  });
</script>
