<?php 
  //$this->Paginator->options(array('update'=>'memberList','indicator'=>'loaderIDast'));
//pr($donationData);
?>
<div id="container_left"><div class="dashbrd-right">
                
                	<!--White Box Start-->
                	<div class="white-box">
                    
                    	<!--White Box Top Start-->
                        <div class="grey-head-tleft">
                        	<div class="grey-head-tright"><span>Reports</span></div>
                        </div>
                        <!--White Box Top Closed-->
                        
                        <!--White Box Middle Start-->
                        <div class="white-box-mid">
                        	
                            <!--Property Details Box Start-->
                        	<div class="prperties-detailbox">
<table border="0" width="100%">
	<tr>
		<td><b><?php echo $this->Html->link('Selected Time Frame','/reports/timeFrame',array('class'=>"green_link")); ?></b></td>
		<td><b><?php echo $this->Html->link('Last Donation','/reports/lastDonation',array('class'=>"green_link")); ?></b></td>
		<td><b><?php echo $this->Html->link('Total Event Donations','/reports/eventDonation',array('class'=>"green_link")); ?></b></td>
	</tr>
</table>
</div>

                            <!--Property Details Box Closed-->
 <?php echo $this->Form->create(null,array('action'=>'','method'=>'post','id'=>'frmMsg','name'=>'frmMsg')); ?> 
                         <div class="search_widget">&nbsp;
                              <div class="right_left" >
<label>Start Date:</label>
<?php echo $this->Form->input('date',array('id'=>'date','type'=>'text','div'=>false,'label'=>false,'class'=>'required')); ?>
&nbsp;<label>End Date:</label>
<?php echo $this->Form->input('enddate',array('id'=>'enddate','type'=>'text','div'=>false,'label'=>false,'class'=>'required')); ?>&nbsp;
<?php echo $this->Form->submit('Search',array('id'=>'sendMsg','class'=>'button_input','div'=>false)); ?>
</div>
                         </div>

                            <!--Flag Alerts Start-->
                        
                          <div class="flag-alert">
                              <table width="100%" border="0" cellspacing="1" id="eventTable" cellpadding="0" class="table-widget">
                                    
                                    <tr>
                                    <td width="4%" class="theading"><?php //echo $this->Form->input('chkAll',array('type'=>'checkbox','id'=>'chkAll','label'=>false,'div'=>false,'legend'=>false,'hiddenfield'=>false)); ?></td>
                                      <td width="12%" class="theading"><strong>Sr. No.</strong></td>
                                      <td width="35%" class="theading"><strong>Name</strong></td>
                                      <td width="30%" class="theading"><strong>Aggregate Donation</strong></td> 
                                      <td width="10%" class="theading"><strong></strong></td>
                                      <td width="8%" class="theading"><strong><!--Action--></strong></td>
                                    </tr>
                     
						<tbody id="tbBody">
						  <?php

               if(isset($donationData[0][0]['total']) && !empty($donationData)){
						          $i = 0;
                      foreach($donationData as $key => $value){
                      $i++;
                      if($i % 2 == 0){
                        $class = 'even-col';
                      }else{
                        $class = 'odd-col';
                      }

              ?>
                                    <tr class="<?php echo $class; ?>">                                    
                                      <td><?php //echo $this->Form->input('Message.chkRec.'.$i,array('type'=>'checkbox','value'=>$value['Member']['email'],'id'=>'chkRec.'.$i,'label'=>false,'div'=>false,'legend'=>false,'hiddenfield'=>false)); ?></td>
                                      <td><?php echo $i; ?>.</td>
                                      <td><?php echo $value['Member']['name']; ?></td>
                                      <td><?php echo ucfirst($value['0']['total']); ?></td>
                                      <td><?php //echo date(Configure::read('npoDateFormat'),strtotime($value['NpoMember']['created'])); ?></td>
                                      <td><?php //echo $ajax->link($this->Html->image('/img/delete.png',array('width'=>'16','height'=>'16')),array('controller'=>'members','action'=>'deletemember',$value['NpoMember']['id'],'inbox'),array('update' => 'memberList','indicator'=>'loaderIDast','escape'=>false),'Are you sure to delete this message?')?>&nbsp;<?php
                                           /* if($value['NpoMember']['status'] ==='Active'){
                                              echo $ajax->link($this->Html->image('cross_circle.png',array('alt'=>__('DEACTIVATE'),'title'=>__('DEACTIVATE'))),array('controller'=>'members','action'=>'toggle_status','disable',$value['NpoMember']['id']),array( 'update' => 'memberList','indicator'=>'loaderIDast','escape'=>false),__("ARE_YOU_SURE_YOU_WANT_TO_CHANGE_THE_STATUS")); 
                                            }else{
                                              echo $ajax->link($this->Html->image('green.png',array('alt'=>__('ACTIVATE'),'title'=>__('ACTIVATE'))),array('controller'=>'members','action'=>'toggle_status','enable',$value['NpoMember']['id']),array( 'update' => 'memberList','indicator'=>'loaderIDast','escape'=>false),__("ARE_YOU_SURE_YOU_WANT_TO_CHANGE_THE_STATUS"));
                                            } */
                                          ?>
                                    </td>
                                    </tr>
              <?php  } ?>
              <tr><td colspan="5"><?php 
              //echo $this->Form->submit('Send Notification',array('id'=>'sendMsg','class'=>'button_input')); ?></td></tr>
             <?php  } else{?>
                <tr class="even-col">
                  <td colspan="6" align="center"><strong>No Report(s) Found </strong></td>
              <?php } ?> 
						</tbody>
                              </table>

                            </div>
<?php echo $this->Form->end(); ?>
                            <!--Flag Alerts Closed--> <div id="pagination" class="paging_section">
                <?php
                        
                         // echo $this->Paginator->prev($title = '<< Previous',array('recCount'=>$recCount)); 
                        //  echo $this->Paginator->numbers(array('separator'=>' ','recCount'=>$recCount)); 
                         // echo '&nbsp;'.$this->Paginator->next($title = 'Next >>',array('recCount'=>$recCount));
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
<?php echo $this->Form->end(); ?>
<script type="text/javascript">
  jQuery(document).ready(function (){
    jQuery('#frmEvent').validate({
      errorClass:'regError',
      rules :{
        'data[Npo][image]':{
            accept: "gif|jpg|jpeg|png"
        }
        }
  });
    jQuery('#date').datepicker({
      dateFormat: 'dd-mm-yy'
    });

    jQuery('#enddate').datepicker({
        dateFormat: 'dd-mm-yy'
    });
    
  });
</script>