<?php 
  $this->Paginator->options(array('update'=>'box','indicator'=>'loaderIDast'));
?><h3><?php echo __('NPO/CHURCHES') ?></h3>
<table width="100%" class="grid_widget">
						<thead>
							<tr>
            	 <th class="a-center" width="10%"><a href="#"><?php echo __('SRNO'); ?></th>
            	 <th  class="a-center" width="25%"><?php echo $this->Paginator->sort(__("TITLE"),'Npo.title'); 
                    if(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Npo.title' && $this->request->params['named']['direction'] =='asc'){
                      echo $this->Html->image('/img/icons/arrow_up_mini.png',array('alt'=>'Up','title'=>'Up'));
                    }elseif(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Npo.title' && $this->request->params['named']['direction'] =='desc'){
                      echo $this->Html->image('/img/icons/arrow_down_mini.gif',array('alt'=>'Down','title'=>'Down'));
                    }
               ?></th>
               <th  class="a-center" width="25%"><?php echo $this->Paginator->sort(__("EMAIL"),'Npo.email');
                     if(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Npo.email' && $this->request->params['named']['direction'] =='asc'){
                      echo $this->Html->image('/img/icons/arrow_up_mini.png',array('alt'=>'Up','title'=>'Up'));
                    }elseif(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Npo.email' && $this->request->params['named']['direction'] =='desc'){
                      echo $this->Html->image('/img/icons/arrow_down_mini.gif',array('alt'=>'Down','title'=>'Down'));
                    }?></th>
               <th  class="a-center" width="15%"><?php echo __('TEMPLATE'); ?></th>
               <th  class="a-center" width="10%">View Id</th>
               <th  class="a-center" width="5%"><?php echo __('ACTION'); ?></th>
            </tr>
						</thead>
						<tbody>
						  <?php if(isset($npoList) && !empty($npoList)){
						          $i = 0;
                      foreach($npoList as $key => $value){
                      $i++;
              ?>
							<tr>
                	<td class="a-center"><?php echo $i; ?>.</td>
                	<td class="a-center"><?php echo $value['Npo']['title']; ?></td>
                  <td class="a-center"><?php echo $value['Npo']['email']; ?></td>
                  <td class="a-center"><?php echo isset($value['NpoTemplate']['Template']['name']) ? ucfirst($value['NpoTemplate']['Template']['name']) : ''; ?></td>
                  <td class="a-center"><?php echo $this->Html->link('View',array('controller'=>'Npo','action'=>'detail',$value['Npo']['id'],'admin'=>true),array('class'=>'iframe cboxElement')); ?></td>
                  <td class="a-center"><?php
                    if($value['Npo']['status'] ==='Active'){
                      echo $ajax->link($this->Html->image('cross_circle.png',array('alt'=>__('DEACTIVATE'),'title'=>__('DEACTIVATE'))),array('controller'=>'npo','action'=>'toggle_status','disable',$value['Npo']['id']),array( 'update' => 'box','indicator'=>'loaderIDast','escape'=>false),__("ARE_YOU_SURE_YOU_WANT_TO_CHANGE_THE_STATUS")); 
                    }else{
                      echo $ajax->link($this->Html->image('green.png',array('alt'=>__('ACTIVATE'),'title'=>__('ACTIVATE'))),array('controller'=>'npo','action'=>'toggle_status','enable',$value['Npo']['id']),array( 'update' => 'box','indicator'=>'loaderIDast','escape'=>false),__("ARE_YOU_SURE_YOU_WANT_TO_CHANGE_THE_STATUS"));
                    }
                   ?></td>
              </tr>
              <?php 
                }
              }else{ ?>
                	<tr>
                	 <td style="text-align:center" colspan="6"><strong><?php echo __('NO_RECORDS_FOUND'); ?></strong></td>
                  </tr>
              <?php } ?>
              </tbody>
</table>
<?php
echo $this->Paginator->prev($title = '<< Previous',array('recCount'=>$recCount)); 
echo $this->Paginator->numbers(array('separator'=>' ','recCount'=>$recCount)); 
echo '&nbsp;'.$this->Paginator->next($title = 'Next >>',array('recCount'=>$recCount));
if(isset($npoList) && !empty($npoList)){
?>
&nbsp;&nbsp;&nbsp;&nbsp;View <?php 
                              //$options = array('1'=>'1','2'=>'2','3'=>'3');
                              echo $this->Form->input('pagecount',array('type'=>'select','options'=>$options,'div'=>false,'label'=>false));
                              echo $ajax->observeField('pagecount',array('url'=>array('controller'=>'npo','action'=>'manage_npo'),'update'=>'box','indicator'=>'loaderIDast'));
                             ?> 
<?php } ?>
</div>
<script type="text/javascript">
  jQuery('.grid_widget tr:even').addClass('even_col');
</script>