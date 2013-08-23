<?php 
  $this->Paginator->options(array('update'=>'inboxList','indicator'=>'loaderIDast'));
   
?>
<div id="container_left"><div class="dashbrd-right">
                
                	<!--White Box Start-->
                	<div class="white-box">
                    
                    	<!--White Box Top Start-->
                        <div class="grey-head-tleft">
                        	<div class="grey-head-tright"><span>Inbox</span></div>
                        </div>
                        <!--White Box Top Closed-->
                        
                        <!--White Box Middle Start-->
                        <div class="white-box-mid">
                        	
                            <!--Property Details Box Start-->
                        	<div class="prperties-detailbox">
                                
                  			</div>
                            <!--Property Details Box Closed-->
                            <div class="search_widget">
                                  <?php echo $this->Form->create(null,array('action'=>'','method'=>'post')); ?>
                                <ul class="search_fields_widget">
                                  <li>Search: <?php echo $this->Form->input('searchElement',array('type'=>'text','div'=>false,'label'=>false));?></li><li> Type:<?php $searchOptions = array('subject'=>'Subject','created'=>'Received On','message'=>'Message'); echo $this->Form->input('searchType',array('type'=>'select','options'=>$searchOptions,'selected'=>'title','div'=>false,'label'=>false)); ?></li>
                                  <li><?php 
                                          echo $this->Form->submit('Search',array('class'=>'button_input'));
                                        ?></li>
                                        </ul>
                                        <?php 
                                          echo $this->Form->end(); ?>
                              </div>
                            <!--Flag Alerts Start-->
                          
                         <?php echo $this->Form->create(null,array('action'=>'deleteallmessage','method'=>'post','id'=>'frmMsg','name'=>'frmMsg'));
                               echo $this->Form->hidden('Message.type',array('type'=>'hidden','value'=>'inbox'));
                          ?> 
                          <div class="flag-alert">
                              <table width="100%" border="0" cellspacing="1" id="eventTable" cellpadding="0" class="table-widget">
                                    <tr>
                                    <td width="4%" class="theading"><?php echo $this->Form->input('chkAll',array('type'=>'checkbox','id'=>'chkAll','label'=>false,'div'=>false,'legend'=>false,'hiddenfield'=>false)); ?></td>
                                      <td width="8%" class="theading"><strong>Sr. No.</strong></td>
                                      <td width="35%" class="theading"><strong><?php echo $this->Paginator->sort('Subject','Message.subject'); 
                                                                      if(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Message.subject' && $this->request->params['named']['direction'] =='asc'){
                                                                         echo $this->Html->image('/img/icons/arrow_up_mini.png',array('alt'=>'Up','title'=>'Up'));
                                                                      }elseif(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Message.subject' && $this->request->params['named']['direction'] =='desc'){
                                                                        echo $this->Html->image('/img/icons/arrow_down_mini.gif',array('alt'=>'Down','title'=>'Down'));
                                                                      }
                                                                 ?></strong></td>
                                      <td width="20%" class="theading"><strong><?php echo $this->Paginator->sort('Read','Message.read'); 
                                                                      if(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Message.read' && $this->request->params['named']['direction'] =='asc'){
                                                                         echo $this->Html->image('/img/icons/arrow_up_mini.png',array('alt'=>'Up','title'=>'Up'));
                                                                      }elseif(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Message.read' && $this->request->params['named']['direction'] =='desc'){
                                                                        echo $this->Html->image('/img/icons/arrow_down_mini.gif',array('alt'=>'Down','title'=>'Down'));
                                                                      }
                                                                 ?></strong></td>  
                                      <td width="20%" class="theading"><strong><?php echo $this->Paginator->sort('Recieved On','Message.created'); 
                                                                      if(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Message.created' && $this->request->params['named']['direction'] =='asc'){
                                                                         echo $this->Html->image('/img/icons/arrow_up_mini.png',array('alt'=>'Up','title'=>'Up'));
                                                                      }elseif(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Message.created' && $this->request->params['named']['direction'] =='desc'){
                                                                        echo $this->Html->image('/img/icons/arrow_down_mini.gif',array('alt'=>'Down','title'=>'Down'));
                                                                      }
                                                                 ?></strong></td>                                    
                                      <td width="8%" class="theading"><strong>Action</strong></td>
                                    </tr>
                     
						<tbody id="tbBody">               
						  <?php
               if(isset($inboxMsg) && !empty($inboxMsg)){
						          $i = 0;
                      foreach($inboxMsg as $key => $value){
                      $i++;
                      if($value['Message']['read'] === 'Yes'){
                        $class = 'even-col';
                      }else{
                        $class = 'odd-col';
                      }
              ?>
                                    <tr class="<?php echo $class; ?>">                                    
                                      <td><?php echo $this->Form->input('Message.chkRec.'.$i,array('type'=>'checkbox','value'=>$value['Message']['id'],'id'=>'chkRec.'.$i,'label'=>false,'div'=>false,'legend'=>false,'hiddenfield'=>false)); ?></td>
                                      <td><?php echo $i; ?>.</td>
                                      <td><?php echo $this->Html->link($value['Message']['subject'],'/message/read/'.$value['Message']['id'].'/inbox'); ?></td>
                                      <td><?php echo $value['Message']['read']; ?></td>
                                      <td><?php echo date(Configure::read('npoDateFormat'),strtotime($value['Message']['created'])); ?></td>
                                      <td><?php echo $ajax->link($this->Html->image('/img/delete.png',array('width'=>'16','height'=>'16')),array('controller'=>'message','action'=>'deletemessage',$value['Message']['id'],'inbox'),array('update' => 'inboxList','indicator'=>'loaderIDast','escape'=>false),'Are you sure to delete this message?')?></td>
                                    </tr>
              <?php } ?>
              <tr><td colspan="5"><?php 
              echo $this->Form->submit('Delete',array('id'=>'sendMsg','class'=>'button_input')); ?></td></tr>
             <?php } else{?>
                <tr class="even-col">
                  <td colspan="6" align="center"><strong>No Message(s) found. </strong></td>                                    
                </tr>
              <?php } ?> 
						</tbody>
                              </table>

                            </div>
<?php echo $this->Form->end(); ?>
                            <!--Flag Alerts Closed--><div id="pagination" class="paging_section">
                <?php
                          echo $this->Paginator->prev($title = '<< Previous',array('recCount'=>$recCount)); 
                          echo $this->Paginator->numbers(array('separator'=>' ','recCount'=>$recCount)); 
                          echo '&nbsp;'.$this->Paginator->next($title = 'Next >>',array('recCount'=>$recCount));
                    if(isset($inboxMsg) && !empty($inboxMsg)){
                    ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;View <?php 
                                                  $options = array('1'=>'1','2'=>'2','3'=>'3','4'=>'4');
                                                  echo $this->Form->input('pagecount',array('type'=>'select','options'=>$options,'div'=>false,'label'=>false));
                                                  echo $ajax->observeField('pagecount',array('url'=>array('controller'=>'message','action'=>'inbox'),'update'=>'inboxList','indicator'=>'loaderIDast'));
                                                 ?> 
                    <?php } ?>
                    </div>
                    
                        
                        </div>
                        <!--White Box Middle Closed-->  
                    </div>
                    <!--White Box Closed-->
               
                </div></div>
                
<script type="text/javascript">
  jQuery('#chkAll').change(function (){
    var checkboxes = jQuery('#eventTable').find(':checkbox');
      if(jQuery(this).is(':checked')){
        checkboxes.attr('checked', 'checked');
      }else{
        checkboxes.removeAttr('checked');
      }
  });  
  jQuery('#tbBody').find(':checkbox').change(function (){
        var i = 0;
      jQuery('#tbBody').find(':checkbox').each(function (){
        if(this.checked){
          i=i+1;
        }
      });
      if(jQuery('#tbBody').find(':checkbox').length === i){
        jQuery('#chkAll').attr('checked', 'checked');
      }else{
        jQuery('#chkAll').removeAttr('checked');
      }
  });
  jQuery('#sendMsg').click(function(){
  var arr = new Array();
    var chked = jQuery('#eventTable').find(':checkbox').each(function (){
      if(this.checked){
        chked = true;
      }else{
        chked = false;
      }
      arr.push(chked);
    });
    if(jQuery.inArray(true,arr) === -1){
      jAlert('Please select atleast one Message','Message Required');return false;
    }else{
      jConfirm('Are you sure to delete this message?','Confirmation',function(r){
        if(r){
          jQuery('#frmMsg').submit();
          return true;
        }else{
          return false;
        }
      });
      return false;
    }  
  });
</script>