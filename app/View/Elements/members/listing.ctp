<?php 
  $this->Paginator->options(array('update'=>'memberList','indicator'=>'loaderIDast'));
   
?>
<div id="container_left"><div class="dashbrd-right">
                
                	<!--White Box Start-->
                	<div class="white-box">
                    
                    	<!--White Box Top Start-->
                        <div class="grey-head-tleft">
                        	<div class="grey-head-tright"><span>Members</span></div>
                        </div>
                        <!--White Box Top Closed-->
                        
                        <!--White Box Middle Start-->
                        <div class="white-box-mid">
                        	
                            <!--Property Details Box Start-->
                        	<div class="prperties-detailbox">
                                
                  			</div>
                            <!--Property Details Box Closed-->
                         <div class="search_widget">&nbsp;
                              <div class="right_link">
                              <?php echo $this->Html->image('/img/icons/add1.png');?>
                          <?php echo $this->Html->link('Add Member','/members/addmember',array('class'=>"green_link")); ?></div>
                         </div>   
                            <!--Flag Alerts Start-->
                         <?php echo $this->Form->create(null,array('action'=>'sendmessage','method'=>'post','id'=>'frmMsg','name'=>'frmMsg'));
                          ?> 
                          <div class="flag-alert">
                              <table width="100%" border="0" cellspacing="1" id="eventTable" cellpadding="0" class="table-widget">
                                    
                                    <tr>
                                    <td width="4%" class="theading"><?php echo $this->Form->input('chkAll',array('type'=>'checkbox','id'=>'chkAll','label'=>false,'div'=>false,'legend'=>false,'hiddenfield'=>false)); ?></td>
                                      <td width="8%" class="theading"><strong>Sr. No.</strong></td>
                                      <td width="35%" class="theading"><strong><?php echo $this->Paginator->sort('Email','Member.email'); 
                                                                      if(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Member.email' && $this->request->params['named']['direction'] =='asc'){
                                                                         echo $this->Html->image('/img/icons/arrow_up_mini.png',array('alt'=>'Up','title'=>'Up'));
                                                                      }elseif(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Member.email' && $this->request->params['named']['direction'] =='desc'){
                                                                        echo $this->Html->image('/img/icons/arrow_down_mini.gif',array('alt'=>'Down','title'=>'Down'));
                                                                      }
                                                                 ?></strong></td>
                                      <td width="20%" class="theading"><strong><?php echo $this->Paginator->sort('Name','Member.name'); 
                                                                      if(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Member.name' && $this->request->params['named']['direction'] =='asc'){
                                                                         echo $this->Html->image('/img/icons/arrow_up_mini.png',array('alt'=>'Up','title'=>'Up'));
                                                                      }elseif(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Member.name' && $this->request->params['named']['direction'] =='desc'){
                                                                        echo $this->Html->image('/img/icons/arrow_down_mini.gif',array('alt'=>'Down','title'=>'Down'));
                                                                      }
                                                                 ?></strong></td>  
                                      <td width="20%" class="theading"><strong><?php echo $this->Paginator->sort('Member Since','NpoMember.created'); 
                                                                      if(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='NpoMember.created' && $this->request->params['named']['direction'] =='asc'){
                                                                         echo $this->Html->image('/img/icons/arrow_up_mini.png',array('alt'=>'Up','title'=>'Up'));
                                                                      }elseif(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='NpoMember.created' && $this->request->params['named']['direction'] =='desc'){
                                                                        echo $this->Html->image('/img/icons/arrow_down_mini.gif',array('alt'=>'Down','title'=>'Down'));
                                                                      }
                                                                 ?></strong></td>                                    
                                      <td width="8%" class="theading"><strong>Action</strong></td>
                                    </tr>
                     
						<tbody id="tbBody">               
						  <?php
               if(isset($npoMember) && !empty($npoMember)){
						          $i = 0;
                      foreach($npoMember as $key => $value){
                      $i++;
                      if($i % 2 == 0){
                        $class = 'even-col';
                      }else{
                        $class = 'odd-col';
                      }
              ?>
                                    <tr class="<?php echo $class; ?>">                                    
                                      <td><?php echo $this->Form->input('Message.chkRec.'.$i,array('type'=>'checkbox','value'=>$value['Member']['email'],'id'=>'chkRec.'.$i,'label'=>false,'div'=>false,'legend'=>false,'hiddenfield'=>false)); ?></td>
                                      <td><?php echo $i; ?>.</td>
                                      <td><?php echo $value['Member']['email']; ?></td>
                                      <td><?php echo ucfirst($value['Member']['name']); ?></td>
                                      <td><?php echo date(Configure::read('npoDateFormat'),strtotime($value['NpoMember']['created'])); ?></td>
                                      <td><?php echo $ajax->link($this->Html->image('/img/delete.png',array('width'=>'16','height'=>'16')),array('controller'=>'members','action'=>'deletemember',$value['NpoMember']['id'],'inbox'),array('update' => 'memberList','indicator'=>'loaderIDast','escape'=>false),'Are you sure to delete this message?')?>&nbsp;<?php
                                            if($value['NpoMember']['status'] ==='Active'){
                                              echo $ajax->link($this->Html->image('cross_circle.png',array('alt'=>__('DEACTIVATE'),'title'=>__('DEACTIVATE'))),array('controller'=>'members','action'=>'toggle_status','disable',$value['NpoMember']['id']),array( 'update' => 'memberList','indicator'=>'loaderIDast','escape'=>false),__("ARE_YOU_SURE_YOU_WANT_TO_CHANGE_THE_STATUS")); 
                                            }else{
                                              echo $ajax->link($this->Html->image('green.png',array('alt'=>__('ACTIVATE'),'title'=>__('ACTIVATE'))),array('controller'=>'members','action'=>'toggle_status','enable',$value['NpoMember']['id']),array( 'update' => 'memberList','indicator'=>'loaderIDast','escape'=>false),__("ARE_YOU_SURE_YOU_WANT_TO_CHANGE_THE_STATUS"));
                                            }
                                          ?>
                                    </td>
                                    </tr>
              <?php } ?>
              <tr><td colspan="5"><?php 
              echo $this->Form->submit('Send Notification',array('id'=>'sendMsg','class'=>'button_input')); ?></td></tr>
             <?php } else{?>
                <tr class="even-col">
                  <td colspan="6" align="center"><strong>No Member(s) found.Add one <?php echo $this->Html->link('here',array('controller'=>'members','action'=>'addmember'),array('class'=>'green_link')); ?> </strong></td>                                    
                </tr>
              <?php } ?> 
						</tbody>
                              </table>

                            </div>
<?php echo $this->Form->end(); ?>
                            <!--Flag Alerts Closed--> <div id="pagination" class="paging_section">
                <?php
                        
                          echo $this->Paginator->prev($title = '<< Previous',array('recCount'=>$recCount)); 
                          echo $this->Paginator->numbers(array('separator'=>' ','recCount'=>$recCount)); 
                          echo '&nbsp;'.$this->Paginator->next($title = 'Next >>',array('recCount'=>$recCount));
                    if(isset($npoMember) && !empty($npoMember)){
                    ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;View <?php
                                                  echo $this->Form->input('pagecount',array('type'=>'select','options'=>$options,'div'=>false,'label'=>false));
                                                  echo $ajax->observeField('pagecount',array('url'=>array('controller'=>'members','action'=>'index'),'update'=>'memberList','indicator'=>'loaderIDast'));
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
      jAlert('Please select atleast one Member','Member Required');return false;
    }  
  });
</script>