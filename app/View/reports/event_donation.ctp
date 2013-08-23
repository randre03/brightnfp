<div id="container_left"><div class="dashbrd-right">
                
                	<!--White Box Start-->
                	<div class="white-box">
                    
                    	<!--White Box Top Start-->
                        <div class="grey-head-tleft">
                        	<div class="grey-head-tright"><span>Donation By Events</span></div>
                        </div>
                        <!--White Box Top Closed-->
                        
                        <!--White Box Middle Start-->
                        <div class="white-box-mid">
                        	
                            <!--Property Details Box Start-->
                        	<div class="prperties-detailbox">

                  			</div>

                            <!--Property Details Box Closed-->
 <?php echo $this->Form->create(null,array('action'=>'','method'=>'post','id'=>'frmMsg','name'=>'frmMsg')); ?> 
                         <div class="search_widget"><div style="float:right;text-align:center;" ><b><?php echo $this->Html->link('Back','/reports/',array('class'=>"green_link")); ?></b></div>
                              <div class="right_left" >

</div>
                         </div>

                            <!--Flag Alerts Start-->
                        
                          <div class="flag-alert">
                              <table width="100%" border="0" cellspacing="1" id="eventTable" cellpadding="0" class="table-widget">
                                    
                                    <tr>
                                      <td width="10%" class="theading"><strong>Sr. No.</strong></td>
                                      <td width="45%" class="theading"><strong>Event Title</strong></td>
                                      <td width="30%" class="theading"><strong>Amount</strong></td>
					<td width="14%" class="theading"><strong>Date</strong></td> 
                                    </tr>
                     
						<tbody id="tbBody">
						  <?php

               if(isset($eventdonationData) && !empty($eventdonationData)){
						          $i = 0;
                      foreach($eventdonationData as $key => $value){
                      $i++;
                      if($i % 2 == 0){
                        $class = 'even-col';
                      }else{
                        $class = 'odd-col';
                      }

              ?>
                                    <tr class="<?php echo $class; ?>">                                    
                                     <td><?php echo $i; ?>.</td>
                                      <td><?php echo $value['Attribute']['title']; ?></td>
                                      <td><?php echo ucfirst($value['0']['total']); ?></td>
                                      <td><?php echo date(Configure::read('npoDateFormat'),strtotime($value['Donation']['created'])); ?></td>

                                    </tr>
              <?php  } ?>
              <tr><td colspan="5"><?php 
              //echo $this->Form->submit('Send Notification',array('id'=>'sendMsg','class'=>'button_input')); ?></td></tr>
             <?php  } else{?>
                <tr class="even-col">
                  <td colspan="6" align="center"><strong>No Event Report(s) Found </strong></td>
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