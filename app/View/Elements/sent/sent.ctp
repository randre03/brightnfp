<?php 
  $this->Paginator->options(array('update'=>'sentTable','indicator'=>'loaderIDast'));
?>
<h3 class="heading"><?php echo __('SENT_ITEMS') ?></h3>
<?php echo $this->Form->create(null,array('action'=>'deleteAll','method'=>'post','id'=>'frmMsg','name'=>'frmMsg')); 
      echo $this->Form->input('type',array('type'=>'hidden','value'=>'sent'));
?>
<table width="100%" id="inboxTabel" cellspacing="0" class="grid_widget">
						<thead>
							<tr>
							 <th width="2%">
							   <?php echo $this->Form->input('chkAll',array('type'=>'checkbox','id'=>'chkAll','label'=>false,'div'=>false,'legend'=>false,'hiddenfield'=>false)); ?>
							 </th>
            	 <th class="a-center" width="7%"><?php echo __('SRNO'); ?></th>
            	 <th  class="a-center" width="26%"><?php echo $this->Paginator->sort(__("SUBJECT"),'Message.subject'); 
                    if(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Message.subject' && $this->request->params['named']['direction'] =='asc'){
                      echo $this->Html->image('/img/icons/arrow_up_mini.png',array('alt'=>'Up','title'=>'Up'));
                    }elseif(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Message.subject' && $this->request->params['named']['direction'] =='desc'){
                      echo $this->Html->image('/img/icons/arrow_down_mini.gif',array('alt'=>'Down','title'=>'Down'));
                    }
               ?></th>
               <th  class="a-center" width="19%"><?php echo $this->Paginator->sort(__("RECIPENT"),'Npo.email');
                     if(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Npo.email' && $this->request->params['named']['direction'] =='asc'){
                      echo $this->Html->image('/img/icons/arrow_up_mini.png',array('alt'=>'Up','title'=>'Up'));
                    }elseif(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Npo.email' && $this->request->params['named']['direction'] =='desc'){
                      echo $this->Html->image('/img/icons/arrow_down_mini.gif',array('alt'=>'Down','title'=>'Down'));
                    }?></th>
               <th  class="a-center" width="12%"><?php
                     echo $this->Paginator->sort(__("SENT_ON"),'Message.created');
                     if(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Message.created' && $this->request->params['named']['direction'] =='asc'){
                       echo $this->Html->image('/img/icons/arrow_up_mini.png',array('alt'=>'Up','title'=>'Up'));
                    }elseif(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Message.created' && $this->request->params['named']['direction'] =='desc'){
                      echo $this->Html->image('/img/icons/arrow_down_mini.gif',array('alt'=>'Down','title'=>'Down'));
                    } ?></th>
               <th  class="a-center" width="19%"><?php
                     echo $this->Paginator->sort(__("READ_BY_RECIPENT"),'Message.read');
                     if(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Message.read' && $this->request->params['named']['direction'] =='asc'){
                      echo $this->Html->image('/img/icons/arrow_up_mini.png',array('alt'=>'Up','title'=>'Up'));
                    }elseif(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Message.read' && $this->request->params['named']['direction'] =='desc'){
                      echo $this->Html->image('/img/icons/arrow_down_mini.gif',array('alt'=>'Down','title'=>'Down'));
                    } ?></th>
               <th  class="a-center" width="8%"><?php echo __('READ_ON'); ?></th>
               <th  class="a-center" width="8%"><?php echo __('ACTION'); ?></th>
            </tr>
						</thead>
						<tbody id="tbBody">
						  <?php if(isset($sentMsg) && !empty($sentMsg)){
						          $i = 0;
                      foreach($sentMsg as $key => $value){
                      $i++;
              ?>
							<tr>
                	<td class="a-center"><?php echo $this->Form->input('Npo.chkRec.'.$i,array('type'=>'checkbox','value'=>$value['Message']['id'],'id'=>'chkRec.'.$i,'label'=>false,'div'=>false,'legend'=>false,'hiddenfield'=>false)); ?></td>
                	<td class="a-center"><?php echo $i; ?>.</td>
                	<td class="a-center"><?php echo strlen($value['Message']['subject']) > 50 ? $this->Html->link(substr($value['Message']['subject'],0,50).'....',array('controller'=>'message','action'=>'view_message',$value['Message']['id'],'adminSent')) : $this->Html->link($value['Message']['subject'],array('controller'=>'message','action'=>'view_message',$value['Message']['id'],'adminSent')) ?></td>
                  <td class="a-center"><?php echo $value['Npo']['email']; ?></td>
                  <td class="a-center"><?php echo date(Configure::read('adminDateFormat'),strtotime($value['Message']['created'])); ?></td>
                  <td class="a-center"><?php echo $value['Message']['read']; ?></td>
                  <td class="a-center"><?php echo $value['Message']['read'] === 'Yes' ? date('d/m/Y',strtotime($value['Message']['modified'])):'N/A' ?></td>
                  
                  <td class="a-center"><?php
                     // echo $this->Html->link($this->Html->image('icon_view.gif',array('alt'=>__('VIEW'),'title'=>__('VIEW'))),array('controller'=>'message','action'=>'view_message',$value['Message']['id']),array('escape'=>false));
                      echo $ajax->link($this->Html->image('cross_circle.png',array('alt'=>__('DELETE'),'title'=>__('DELETE'))),array('controller'=>'message','action'=>'admin_delete_message',$value['Message']['id']),array( 'update' => 'sentTable','indicator'=>'loaderIDast','escape'=>false),__("ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_RECORD")); 
                    
                   ?></td>
              </tr>
              <?php 
                }
              ?>
                
						  
              <?php 
              }else{ ?>
                	<tr>
                	 <td style="text-align:center" colspan="8"><strong><?php echo __('NO_RECORDS_FOUND'); ?></strong></td>
                  </tr>
              <?php } ?>
              </tbody>
</table>

<p><?php echo $this->Form->submit('Delete',array('type'=>'submit','id'=>'deleteAll','div'=>false,'label'=>false)); ?></p>

<?php echo $this->Form->end(); ?>
<div id="pagination">
<?php
      echo $this->Paginator->prev($title = '<< Previous', $options = array('recCount'=>$recCount)); 
      echo $this->Paginator->numbers(array('separator'=>' - ','recCount'=>$recCount)); 
      echo '&nbsp;'.$this->Paginator->next($title = 'Next >>', $options = array('recCount'=>$recCount));
if(isset($sentMsg) && !empty($sentMsg)){
?>
&nbsp;&nbsp;&nbsp;&nbsp;View <?php 
                               //$options = array('1'=>'1','2'=>'2','3'=>'3');
                              echo $this->Form->input('pagecount',array('type'=>'select','options'=>$options,'div'=>false,'label'=>false));
                              echo $ajax->observeField('pagecount',array('url'=>array('controller'=>'message','action'=>'sent'),'update'=>'sentTable','indicator'=>'loaderIDast'));
                             ?> 
<?php } ?>
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
  
  jQuery('.grid_widget tr:even').addClass('even_col');
</script>