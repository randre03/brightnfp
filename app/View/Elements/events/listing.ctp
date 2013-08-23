<?php 
  $this->Paginator->options(array('update'=>'eventList','indicator'=>'loaderIDast'));
   
?>
<div id="container_left"><div class="dashbrd-right">
                
                	<!--White Box Start-->
                	<div class="white-box">
                    
                    	<!--White Box Top Start-->
                        <div class="grey-head-tleft">
                        	<div class="grey-head-tright"><span>Events</span></div>
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
                                  <li>Search: <?php echo $this->Form->input('searchElement',array('type'=>'text','div'=>false,'label'=>false));?></li> <li> Type:<?php $searchOptions = array('title'=>'Title','date'=>'Date','time'=>'Time','description'=>'Description'); echo $this->Form->input('searchType',array('type'=>'select','options'=>$searchOptions,'selected'=>'title','div'=>false,'label'=>false));?></li><li><?php  
                                          echo $this->Form->submit('Search',array('class'=>'button_input'));
                                          ?>
                                          </li></ul>
                                          <?php
                                          echo $this->Form->end();
                                        ?>
                              
                            <!--Flag Alerts Start-->
                            <div class="right_link">
                            <?php echo $this->Html->image('/img/icons/add1.png');?>
                              <?php echo $this->Html->link('Add Events','/events/addevents',array('class'=>"green_link")); ?>
                            </div>
                          </div>
                         <?php echo $this->Form->create(null,array('action'=>'eventsmessage','method'=>'post','id'=>'frmMsg','name'=>'frmMsg')); ?> 
                          <div class="flag-alert">
                              <table width="100%" border="0" cellspacing="1" id="eventTable" cellpadding="0" class="table-widget">
                                    <tr>
                                    <td width="4%" class="theading"><?php echo $this->Form->input('chkAll',array('type'=>'checkbox','id'=>'chkAll','label'=>false,'div'=>false,'legend'=>false,'hiddenfield'=>false)); ?></td>
                                      <td width="44%" class="theading"><strong><?php echo $this->Paginator->sort('Title','Attribute.title'); 
                                                                      if(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Attribute.title' && $this->request->params['named']['direction'] =='asc'){
                                                                         echo $this->Html->image('/img/icons/arrow_up_mini.png',array('alt'=>'Up','title'=>'Up'));
                                                                      }elseif(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Attribute.title' && $this->request->params['named']['direction'] =='desc'){
                                                                        echo $this->Html->image('/img/icons/arrow_down_mini.gif',array('alt'=>'Down','title'=>'Down'));
                                                                      }
                                                                 ?></strong></td>
                                      <td width="20%" class="theading"><strong><?php echo $this->Paginator->sort('Date of occurence','Attribute.date'); 
                                                                      if(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Attribute.date' && $this->request->params['named']['direction'] =='asc'){
                                                                         echo $this->Html->image('/img/icons/arrow_up_mini.png',array('alt'=>'Up','title'=>'Up'));
                                                                      }elseif(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Attribute.date' && $this->request->params['named']['direction'] =='desc'){
                                                                        echo $this->Html->image('/img/icons/arrow_down_mini.gif',array('alt'=>'Down','title'=>'Down'));
                                                                      }
                                                                 ?></strong></td>  
                                      <td width="20%" class="theading"><strong><?php echo $this->Paginator->sort('Time of occurence','Attribute.time'); 
                                                                      if(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Attribute.time' && $this->request->params['named']['direction'] =='asc'){
                                                                         echo $this->Html->image('/img/icons/arrow_up_mini.png',array('alt'=>'Up','title'=>'Up'));
                                                                      }elseif(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Attribute.time' && $this->request->params['named']['direction'] =='desc'){
                                                                        echo $this->Html->image('/img/icons/arrow_down_mini.gif',array('alt'=>'Down','title'=>'Down'));
                                                                      }
                                                                 ?></strong></td>                                    
                                      <td width="8%" class="theading"><strong>Delete</strong></td>
                                    </tr>
                     
						<tbody id="tbBody">               
						  <?php
               if(isset($eventsList) && !empty($eventsList)){
						          $i = 0;
                      foreach($eventsList as $key => $value){
                      $i++;
                      if($i % 2 === 0){
                        $class = 'even-col';
                      }else{
                        $class = 'odd-col';
                      }
              ?>
                                    <tr class="<?php echo $class; ?>">                                    
                                      <td><?php echo $this->Form->input('Attribute.chkRec.'.$i,array('type'=>'checkbox','value'=>$value['Attribute']['id'],'id'=>'chkRec.'.$i,'label'=>false,'div'=>false,'legend'=>false,'hiddenfield'=>false)); ?></td>
                                      <td><?php echo $value['Attribute']['title']; ?></td>
                                      <td><?php echo date(Configure::read('npoDateFormat'),strtotime($value['Attribute']['date'])); ?></td>
                                      <td><?php echo date(Configure::read('npoTimeFormat'),strtotime($value['Attribute']['time'])); ?></td>
                                      <td><?php echo $this->Html->link($this->Html->image('/img/delete.png',array('width'=>'16','height'=>'16')),array('controller'=>'events','action'=>'deleteevents',$value['Attribute']['id']),array('update' => 'newList','indicator'=>'loaderIDast','escape'=>false),'Are you sure to delete this event?')?>&nbsp;<?php echo $this->Html->link($this->Html->image('/img/icons/gtk-edit.png'),'/events/editevents/'.$value['Attribute']['id'],array('escape'=>false)); ?></td>
                                    </tr>
              <?php } ?>
              <tr><td colspan="5"><?php 
              echo $this->Form->submit('Send Message',array('id'=>'sendMsg','class'=>'button_input')); ?></td></tr>
             <?php } else{?>
                <tr class="even-col">
                  <td colspan="5" align="center"><strong>No Event(s) found.Add one <?php echo $this->Html->link('here','/events/addevents',array('class'=>"green_link")); ?> </strong></td>                                    
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
                    if(isset($eventsList) && !empty($eventsList)){
                    ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;View <?php 
                                                  //$options = array('1'=>'1','2'=>'2','3'=>'3');
                                                  echo $this->Form->input('pagecount',array('type'=>'select','options'=>$options,'div'=>false,'label'=>false));
                                                  echo $ajax->observeField('pagecount',array('url'=>array('controller'=>'events','action'=>'index'),'update'=>'eventList','indicator'=>'loaderIDast'));
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
      jAlert('Please select atleast one event','Event Required');return false;
    }  
  });
</script>