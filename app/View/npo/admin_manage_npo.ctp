<?php 
echo $javascript->link('jquery.colorbox');
echo $this->Html->css('colorbox'); 
?>
<div id="box">
<?php echo $this->element('npo/npo_list'); ?>
</div>
<script type="text/javascript">
  jQuery(document).ready(function(){
    jQuery(".iframe").colorbox({iframe:true, width:"90%", height:"90%"});
  });
</script>