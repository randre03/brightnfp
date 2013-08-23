<?php
 echo $javascript->link('fileuploader');
 echo $this->Html->css('fileuploader');
?>
<div id="fileUploader">		
		<noscript>			
			<p>Please enable JavaScript to use file uploader.</p>
			<!-- or put a simple form for upload here -->
		</noscript>         
	</div>
<script>        
    function createUploader(){            
        var uploader = new qq.FileUploader({
            element: document.getElementById('fileUploader'),
            action: '/php.php?npo_id=1&dest=events',
            debug: true,
            onComplete : function (){
              jQuery('#clrLi').remove();
              jQuery('.qq-upload-list').append('<li id="clrLi" style="list-style: none;"><a href="#" id="clrList">Clear List</a></li>');
              jQuery('#clrList').click(function (){
              jQuery('.qq-upload-list li').remove()
            }); 
            }
        });           
    }
    
    // in your app create uploader as soon as the DOM is ready
    // don't wait for the window to load  
    window.onload = createUploader; 
    
      
</script> 