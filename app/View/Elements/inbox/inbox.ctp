<?php 
  $this->Paginator->options(array('update'=>'inboxTable','indicator'=>'loaderIDast'));
?>
<h3><?php echo __('INBOX') ?></h3>
<?php echo $this->Form->create(null,array('action'=>'deleteAll','method'=>'post','id'=>'frmMsg','name'=>'frmMsg')); 
      echo $this->Form->input('type',array('type'=>'hidden','value'=>'inbox'));
?>
<table width="100%" id="inboxTabel" class="grid_widget">
						<thead>
							<tr>
							 <th class="a-center" width="5%">
							   <?php echo $this->Form->input('chkAll',array('type'=>'checkbox','id'=>'chkAll','label'=>false,'div'=>false,'legend'=>false,'hiddenfield'=>false)); ?>
							 </th>
            	 <th class="a-center" width="10%"><?php echo __('SRNO'); ?></th>
            	 <th  class="a-center" width="25%"><?php echo $this->Paginator->sort(__("SUBJECT"),'Message.subject'); 
                    if(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Message.subject' && $this->request->params['named']['direction'] =='asc'){
                      
                    }elseif(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Message.subject' && $this->request->params['named']['direction'] =='desc'){
                      echo $this->Html->image('/img/icons/arrow_down_mini.gif',array('alt'=>'Down','title'=>'Down'));
                    }
               ?></th>
               <th  class="a-center" width="10%"><?php echo $this->Paginator->sort(__("READ"),'Message.read'); 
                    if(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Message.read' && $this->request->params['named']['direction'] =='asc'){
                      
                    }elseif(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Message.read' && $this->request->params['named']['direction'] =='desc'){
                      echo $this->Html->image('/img/icons/arrow_down_mini.gif',array('alt'=>'Down','title'=>'Down'));
                    }
               ?></th>
               <th  class="a-center" width="15%"><?php echo $this->Paginator->sort(__("SENDER"),'Npo.email');
                     if(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Npo.email' && $this->request->params['named']['direction'] =='asc'){
                      echo $this->Html->image('/img/icons/arrow_up_mini.png',array('alt'=>'Up','title'=>'Up'));
                    }elseif(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Npo.email' && $this->request->params['named']['direction'] =='desc'){
                      echo $this->Html->image('/img/icons/arrow_down_mini.gif',array('alt'=>'Down','title'=>'Down'));
                    }?></th>
               <th  class="a-center" width="15%"><?php
                     echo $this->Paginator->sort(__("SENT_ON"),'Message.created');
                     if(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Message.created' && $this->request->params['named']['direction'] =='asc'){
                      echo $this->Html->image('/img/icons/arrow_up_mini.png',array('alt'=>'Up','title'=>'Up'));
                    }elseif(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Message.created' && $this->request->params['named']['direction'] =='desc'){
                      echo $this->Html->image('/img/icons/arrow_down_mini.gif',array('alt'=>'Down','title'=>'Down'));
                    } ?></th>
               
               <th  class="a-center" width="10%"><?php echo __('ACTION'); ?></th>
            </tr>
						</thead>
						
						<tbody id="tbBody">
						  <?php if(isset($inboxMsg) && !empty($inboxMsg)){
						          $i = 0;
                      foreach($inboxMsg as $key => $value){
                      $i++;
                      $value['Message']['read'] === 'Yes' ? $bgColor = '#E5E5E5' : $bgColor = ''; 
              ?>
							<tr bgcolor="<?php echo $bgColor; ?>">
                	<td class="a-center"><?php echo $this->Form->input('Npo.chkRec.'.$i,array('type'=>'checkbox','value'=>$value['Message']['id'],'id'=>'chkRec.'.$i,'label'=>false,'div'=>false,'legend'=>false,'hiddenfield'=>false)); ?></td>
                	<td class="a-center"><?php echo $i; ?>.</td>
                	<td class="a-center"><?php echo strlen($value['Message']['subject']) > 50 ? $this->Html->link(substr($value['Message']['subject'],0,50).'....',array('controller'=>'message','action'=>'view_message',$value['Message']['id'],'adminInbox','admin'=>true)) : $this->Html->link($value['Message']['subject'],array('controller'=>'message','action'=>'view_message',$value['Message']['id'],'adminInbox','admin'=>true)) ?></td>
                  <td class="a-center"><?php echo $value['Message']['read']; ?></td>
                  <td class="a-center"><?php echo $value['Npo']['email']; ?></td>
                  <td class="a-center"><?php echo date(Configure::read('adminDateFormat'),strtotime($value['Message']['created'])); ?></td>
                  
                  <td class="a-center"><?php                      
                      //echo $this->Html->link($this->Html->image('icon_view.gif',array('alt'=>__('VIEW'),'title'=>__('VIEW'))),array('controller'=>'message','action'=>'view_message',$value['Message']['id'],'adminInbox'),array('escape'=>false));
                      echo $ajax->link($this->Html->image('cross_circle.png',array('alt'=>__('DELETE'),'title'=>__('DELETE'))),array('controller'=>'message','action'=>'delete_message',$value['Message']['id'],'adminInbox'),array( 'update' => 'inboxTable','indicator'=>'loaderIDast','escape'=>false),__("ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_RECORD")); 
                    
                   ?></td>
                   
              </tr>
              <?php 
                }
                ?>
              <?php
              }else{ ?>
                	<tr>
                	 <td style="text-align:center" colspan="6"><strong><?php echo __('NO_RECORDS_FOUND'); ?></strong></td>
                  </tr>
              <?php } ?>
              </tbody>
</table>
<p><?php echo $this->Form->submit('Delete',array('type'=>'submit','id'=>'deleteAll','div'=>false,'label'=>false)); ?></p>
<?php echo $this->Form->end(); ?>
<div id="pagination">
                <?php
                          echo $this->Paginator->prev($title = '<< Previous',array('recCount'=>$recCount)); 
                          echo $this->Paginator->numbers(array('separator'=>' ','recCount'=>$recCount)); 
                          echo '&nbsp;'.$this->Paginator->next($title = 'Next >>',array('recCount'=>$recCount));
if(isset($inboxMsg) && !empty($inboxMsg)){
?>
&nbsp;&nbsp;&nbsp;&nbsp;View <?php 
                              echo $this->Form->input('pagecount',array('type'=>'select','options'=>$options,'div'=>false,'label'=>false));
                              echo $ajax->observeField('pagecount',array('url'=>array('controller'=>'message','action'=>'inbox'),'update'=>'inboxTable','indicator'=>'loaderIDast'));
} ?>
</div>
<script type="text/javascript">
  jQuery('#chkAll').change(function (){
    var checkboxes = jQuery('#inboxTabel').find(':checkbox');
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
  jQuery('#deleteAll').click(function(){
  var arr = new Array();
    var chked = jQuery('#inboxTabel').find(':checkbox').each(function (){
      if(this.checked){
        chked = true;
      }else{
        chked = false;
      }
      arr.push(chked);
    });
    if(jQuery.inArray(true,arr) === -1){
      alert('Please select atleast one message');return false;
    } else{
      var conf =  confirm('Are you sure to delete these messages?');
        if(conf){
          return true;
        }else{
          return false;
        }
    }   
  });
</script>