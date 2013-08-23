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
</div>

                            <!--Property Details Box Closed-->
 <?php echo $this->Form->create(null,array('action'=>'','method'=>'post','id'=>'frmMsg','name'=>'frmMsg')); ?> 
                         <div class="search_widget"><div style="float:right;text-align:center;" ><b><?php echo $this->Html->link('Back','/reports/',array('class'=>"green_link")); ?></b></div>
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
                                      <td width="12%" class="theading"><strong>Sr. No.</strong></td>
                                      <td width="35%" class="theading"><strong>Payer</strong></td>
                                      <td class="theading"><strong>Aggregate Donation</strong></td>
                                      
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
                                      <td><?php echo $i; ?>.</td>
                                      <td><?php echo $value['Donation']['payer_email']; ?></td>
                                      <td><?php echo $value['0']['total']; ?></td>
                                     
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
      errorClass:'regError'
  });
    jQuery('#date').datepicker({
      dateFormat: 'dd-mm-yy'
    });

    jQuery('#enddate').datepicker({
        dateFormat: 'dd-mm-yy'
    });
    
  });
</script>