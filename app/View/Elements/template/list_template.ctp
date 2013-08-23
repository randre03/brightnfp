<?php 
  $this->Paginator->options(array('update'=>'templateTable','indicator'=>'loaderIDast'));
?><h3><?php echo __('TEMPLATES') ?></h3>

<table width="100%" class="grid_widget">
						<thead>
							<tr>
            	 <th class="a-center" width="10%"><?php echo __('SRNO'); ?></th>
            	 <th class="a-center" width="35%"><?php echo $this->Paginator->sort(__("TITLE"),'Template.name'); 
                    if(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Template.name' && $this->request->params['named']['direction'] =='asc'){
                      echo $this->Html->image('/img/icons/arrow_up_mini.png',array('alt'=>'Up','title'=>'Up'));
                    }elseif(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Template.name' && $this->request->params['named']['direction'] =='desc'){
                      echo $this->Html->image('/img/icons/arrow_down_mini.gif',array('alt'=>'Down','title'=>'Down'));
                    }
               ?></th>               
               <th class="a-center" width="25%"><?php echo __('NO_OF_THEMES'); ?></th>
               <th class="a-center" width="5%"><?php echo __('ACTION'); ?></th>
            </tr>
						</thead>
						<tbody>
						  <?php if(isset($template) && !empty($template)){
						          $i = 0;
                      foreach($template as $key => $value){
                      $i++;
              ?>
							<tr>
                	<td class="a-center"><?php echo $i; ?>.</td>
                	<td class="a-center"><?php echo $value['Template']['name']; ?></td>
                  <td class="a-center"><?php $countThemes = isset($value['Template']['themeCount']) ? $value['Template']['themeCount']: 0; echo $countThemes > 0 ? $this->Html->link($countThemes,array('controller'=>'templates','action'=>'themes',$value['Template']['id']),array('escape'=>false)) : $countThemes;  ?></td>
                  <td class="a-center"><?php
                    if($value['Template']['status'] ==='Active'){
                      echo $ajax->link($this->Html->image('cross_circle.png',array('alt'=>__('DEACTIVATE'),'title'=>__('DEACTIVATE'))),array('controller'=>'templates','action'=>'toggle_status','disable',$value['Template']['id']),array( 'update' => 'templateTable','indicator'=>'loaderIDast','escape'=>false),__("ARE_YOU_SURE_YOU_WANT_TO_CHANGE_THE_STATUS")); 
                    }else{
                      echo $ajax->link($this->Html->image('green.png',array('alt'=>__('ACTIVATE'),'title'=>__('ACTIVATE'))),array('controller'=>'templates','action'=>'toggle_status','enable',$value['Template']['id']),array( 'update' => 'templateTable','indicator'=>'loaderIDast','escape'=>false),__("ARE_YOU_SURE_YOU_WANT_TO_CHANGE_THE_STATUS"));
                    }
                   ?></td>
              </tr>
              <?php 
                }
              }else{ ?>
                	<tr>
                	 <td style="text-align:center" colspan="4"><strong><?php echo __('NO_RECORDS_FOUND'); ?></strong></td>
                  </tr>
              <?php } ?>
              </tbody>
</table>
<?php
  echo $this->Paginator->prev($title = '<< Previous',array('recCount'=>$recCount)); 
  echo $this->Paginator->numbers(array('separator'=>' ','recCount'=>$recCount)); 
  echo '&nbsp;'.$this->Paginator->next($title = 'Next >>',array('recCount'=>$recCount));
if(isset($template) && !empty($template)){
?>
&nbsp;&nbsp;&nbsp;&nbsp;View <?php 
                                //$options = array('1'=>'1','2'=>'2','3'=>'3');
                              echo $this->Form->input('pagecount',array('type'=>'select','options'=>$options,'div'=>false,'label'=>false));
                              echo $ajax->observeField('pagecount',array('url'=>array('controller'=>'templates','action'=>'manage_templates'),'update'=>'templateTable','indicator'=>'loaderIDast'));
                              } ?>
</div>
<script type="text/javascript">
  jQuery('.grid_widget tr:even').addClass('even_col');
</script>