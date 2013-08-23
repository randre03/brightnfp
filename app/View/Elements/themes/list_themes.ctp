<?php $this->Paginator->options(array('update'=>'themeTable','indicator'=>'loaderIDast')); ?>
<h3><?php echo __('THEMES') ?></h3>

<table width="100%" class="grid_widget">
						<thead>
							<tr>
            	 <th class="a-center" width="10%"><?php echo __('SRNO'); ?></th>
            	 <th  class="a-center" width="35%"><?php echo $this->Paginator->sort(__("TITLE"),'TemplateTheme.name'); 
                    if(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='TemplateTheme.name' && $this->request->params['named']['direction'] =='asc'){
                      echo $this->Html->image('/img/icons/arrow_up_mini.png',array('alt'=>'Up','title'=>'Up')); 
                    }elseif(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='TemplateTheme.name' && $this->request->params['named']['direction'] =='desc'){
                      echo $this->Html->image('/img/icons/arrow_down_mini.gif',array('alt'=>'Down','title'=>'Down'));
                    }
               ?></th>
               <th class="a-center" width="25%"><?php echo __('NO_OF_USERS'); ?></th>
               <th  class="a-center" width="5%"><?php echo __('ACTION'); ?></th>
            </tr>
						</thead>
						<tbody>
						  <?php if(isset($templateTheme) && !empty($templateTheme)){
						          $i = 0;
                      foreach($templateTheme as $key => $value){//echo Configure::read('SITE_URL').'templates/'.$value['Template']['name'].'/'.$value['TemplateTheme']['name'].'/index.htm';die(); 
                      $i++;
              ?>
							<tr>
                	<td class="a-center"><?php echo $i; ?>.</td>
                	<td class="a-center"><?php echo $this->Html->link(ucfirst(strtolower($value['TemplateTheme']['name'])),Configure::read('SITE_URL').'templates/'.$value['Template']['name'].'/'.$value['TemplateTheme']['name'].'/theme.jpg',array('escape'=>false,'class'=>'iframe cboxElement')); ?></td>
                	<td class="a-center"><?php echo isset($value['NpoTemplate'][0]['NpoTemplate'][0]['members']) ? $value['NpoTemplate'][0]['NpoTemplate'][0]['members']: 0; ?></td>
                  <td class="a-center"><?php
                    if($value['TemplateTheme']['status'] ==='Active'){
                      echo $ajax->link($this->Html->image('cross_circle.png',array('alt'=>__('DEACTIVATE'),'title'=>__('DEACTIVATE'))),array('controller'=>'templates','action'=>'admin_toggle_theme_status','disable',$value['TemplateTheme']['id'],$template_id),array( 'update' => 'themeTable','indicator'=>'loaderIDast','escape'=>false),__("ARE_YOU_SURE_YOU_WANT_TO_CHANGE_THE_STATUS")); 
                    }else{
                      echo $ajax->link($this->Html->image('green.png',array('alt'=>__('ACTIVATE'),'title'=>__('ACTIVATE'))),array('controller'=>'templates','action'=>'admin_toggle_theme_status','enable',$value['TemplateTheme']['id'],$template_id),array( 'update' => 'themeTable','indicator'=>'loaderIDast','escape'=>false),__("ARE_YOU_SURE_YOU_WANT_TO_CHANGE_THE_STATUS"));
                    }
                   ?></td>
              </tr>
              <?php 
                }
              }else{ ?>
                	<tr>
                	 <td style="text-align:center" colspan="3"><strong><?php echo __('NO_RECORDS_FOUND'); ?></strong></td>
                  </tr>
              <?php } ?>
              </tbody>
</table>
<?php
                          echo $this->Paginator->prev($title = '<< Previous',array('recCount'=>$recCount)); 
                          echo $this->Paginator->numbers(array('separator'=>' ','recCount'=>$recCount)); 
                          echo '&nbsp;'.$this->Paginator->next($title = 'Next >>',array('recCount'=>$recCount));
      if(isset($templateTheme) && !empty($templateTheme)){
?>
&nbsp;&nbsp;&nbsp;&nbsp;View <?php 
                              //$options = array('1'=>'1','2'=>'2','3'=>'3','4'=>'4');
                              echo $this->Form->input('pagecount',array('type'=>'select','options'=>$options,'div'=>false,'label'=>false));
                              echo $ajax->observeField('pagecount',array('url'=>array('controller'=>'templates','action'=>'themes',$template_id),'update'=>'themeTable','indicator'=>'loaderIDast'));
                             ?> 
<?php } ?>
</div>
<script type="text/javascript">
  jQuery('.grid_widget tr:even').addClass('even_col');
</script>