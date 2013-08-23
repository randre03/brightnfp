<?php 
  $this->Paginator->options(array('update'=>'donationList','indicator'=>'loaderIDast'));
   
?>
<div id="container_left"><div class="dashbrd-right">
                
                	<!--White Box Start-->
                	<div class="white-box">
                    
                    	<!--White Box Top Start-->
                        <div class="grey-head-tleft">
                        	<div class="grey-head-tright"><span>Donation</span></div>
                        </div>
                        <!--White Box Top Closed-->
                        
                        <!--White Box Middle Start-->
                        <div class="white-box-mid">
                        	
                            <!--Property Details Box Start-->
                        	<div class="prperties-detailbox">
                                
                  			   </div>
                            <!--Property Details Box Closed-->                            
                            <!--Flag Alerts Start-->
                         <?php echo $this->Form->create(null,array('action'=>'deleteallmessage','method'=>'post','id'=>'frmMsg','name'=>'frmMsg'));
                               echo $this->Form->hidden('Message.type',array('type'=>'hidden','value'=>'inbox'));
                          ?> 
                          <div class="flag-alert">
                              <table width="100%" border="0" cellspacing="1" id="eventTable" cellpadding="0" class="table-widget">
                                    <tr>
                                    <td width="4%" class="theading"><?php echo $this->Form->input('chkAll',array('type'=>'checkbox','id'=>'chkAll','label'=>false,'div'=>false,'legend'=>false,'hiddenfield'=>false)); ?></td>
                                      <td width="8%" class="theading"><strong>Sr. No.</strong></td>
                                      <td width="5%" class="theading"><strong><?php echo $this->Paginator->sort('Amount','Donation.amount'); 
                                                                      if(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Donation.amount' && $this->request->params['named']['direction'] =='asc'){
                                                                        
                                                                      }elseif(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Donation.amount' && $this->request->params['named']['direction'] =='desc'){
                                                                        echo $this->Html->image('/img/icons/arrow_down_mini.gif',array('alt'=>'Down','title'=>'Down'));
                                                                      }
                                                                 ?></strong></td>
                                      <td width="20%" class="theading"><strong><?php echo $this->Paginator->sort('Donated by','Member.email'); 
                                                                      if(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Member.email' && $this->request->params['named']['direction'] =='asc'){
                                                                        
                                                                      }elseif(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Member.email' && $this->request->params['named']['direction'] =='desc'){
                                                                        echo $this->Html->image('/img/icons/arrow_down_mini.gif',array('alt'=>'Down','title'=>'Down'));
                                                                      }
                                                                 ?></strong></td>  
                                      <td width="30%" class="theading"><strong><?php echo $this->Paginator->sort('Event','Attribute.title'); 
                                                                      if(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Attribute.title' && $this->request->params['named']['direction'] =='asc'){
                                                                        
                                                                      }elseif(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Attribute.title' && $this->request->params['named']['direction'] =='desc'){
                                                                        echo $this->Html->image('/img/icons/arrow_down_mini.gif',array('alt'=>'Down','title'=>'Down'));
                                                                      }
                                                                 ?></strong></td> 
                                      <td width="20%" class="theading"><strong><?php echo $this->Paginator->sort('Donated On','Donation.created'); 
                                                                      if(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Donation.created' && $this->request->params['named']['direction'] =='asc'){
                                                                        
                                                                      }elseif(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Donation.created' && $this->request->params['named']['direction'] =='desc'){
                                                                        echo $this->Html->image('/img/icons/arrow_down_mini.gif',array('alt'=>'Down','title'=>'Down'));
                                                                      }
                                                                 ?></strong></td>                                    
                                      <td width="8%" class="theading"><strong>Action</strong></td>
                                    </tr>
                     
						<tbody id="tbBody">               
						  <?php
               if(isset($donationList) && !empty($donationList)){
						          $i = 0;
                      foreach($donationList as $key => $value){
                      $i++;
                      if($i % 2 === 0){
                        $class = 'even-col';
                      }else{
                        $class = 'odd-col';
                      }
              ?>
                                    <tr class="<?php echo $class; ?>">                                    
                                      <td><?php echo $this->Form->input('Message.chkRec.'.$i,array('type'=>'checkbox','value'=>$value['Donation']['id'],'id'=>'chkRec.'.$i,'label'=>false,'div'=>false,'legend'=>false,'hiddenfield'=>false)); ?></td>
                                      <td><?php echo $i; ?>.</td>
                                      <td><?php echo $value['Donation']['amount']; ?></td>
                                      <td><?php echo $value['Member']['email']; ?></td>
                                      <td><?php echo $value['Attribute']['title'] == '' ? 'N/A' : $value['Attribute']['title']; ?></td>
                                      <td><?php echo date(Configure::read('npoDateFormat'),strtotime($value['Donation']['created'])); ?></td>
                                      <td></td>
                                    </tr>
              <?php } ?>
              <tr><td colspan="7"><?php 
              echo $this->Form->submit('Delete',array('id'=>'sendMsg')); ?></td></tr>
             <?php } else{?>
                <tr class="even-col">
                  <td colspan="7" align="center"><strong>No Donation(s) found. </strong></td>                                    
                </tr>
              <?php } ?> 
						</tbody>
                              </table>

                            </div>
<?php echo $this->Form->end(); ?>
                            <!--Flag Alerts Closed--> <div id="pagination">
                <?php
                          echo $this->Paginator->prev($title = '<< Previous',array('recCount'=>$recCount)); 
                          echo $this->Paginator->numbers(array('separator'=>' ','recCount'=>$recCount)); 
                          echo '&nbsp;'.$this->Paginator->next($title = 'Next >>',array('recCount'=>$recCount));
                    if(isset($donationList) && !empty($donationList)){
                    ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;View <?php
                                                  echo $this->Form->input('pagecount',array('type'=>'select','options'=>$options,'div'=>false,'label'=>false));
                                                  echo $ajax->observeField('pagecount',array('url'=>array('controller'=>'donations','action'=>'index'),'update'=>'donationList','indicator'=>'loaderIDast'));
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
    }  
  });
</script>