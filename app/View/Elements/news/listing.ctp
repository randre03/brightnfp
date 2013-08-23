<?php 
  $this->Paginator->options(array('update'=>'newList','indicator'=>'loaderIDast'));
?>
<div id="container_left"><div class="dashbrd-right">
                
                	<!--White Box Start-->
                	<div class="white-box">
                    
                    	<!--White Box Top Start-->
                        <div class="grey-head-tleft">
                        	<div class="grey-head-tright"><span>News</span></div>
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
                                  <li>Search: <?php echo $this->Form->input('searchElement',array('type'=>'text','div'=>false,'label'=>false));?></li><li> Type:<?php $searchOptions = array('shortdescription'=>'Short Description','description'=>'Description','published'=>'Published on'); echo $this->Form->input('searchType',array('type'=>'select','options'=>$searchOptions,'selected'=>'title','div'=>false,'label'=>false));?></li><li><?php 
                                          echo $this->Form->submit('Search',array('class'=>'button_input'));
                                          ?>
                                          </li></ul>
                                          <?php
                                          echo $this->Form->end();
                                        ?>
                              
                            <div class="right_link">
                            <?php echo $this->Html->image('/img/icons/add1.png');?>
                              <?php echo $this->Html->link('Add News','/news/addnews',array('class'=>"green_link")); ?>
                            </div>
                          </div>
                            <!--Flag Alerts Start-->
                          <div class="flag-alert">
                              <table width="100%" border="0" cellspacing="1" cellpadding="0" class="table-widget">
                                    <tr>
                                      <td width="44%" class="theading"><strong><?php echo $this->Paginator->sort('Short Description','Attribute.short_description'); 
                                                                      if(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Attribute.short_description' && $this->request->params['named']['direction'] =='asc'){
                                                                         echo $this->Html->image('/img/icons/arrow_up_mini.png',array('alt'=>'Up','title'=>'Up'));
                                                                      }elseif(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Attribute.short_description' && $this->request->params['named']['direction'] =='desc'){
                                                                        echo $this->Html->image('/img/icons/arrow_down_mini.gif',array('alt'=>'Down','title'=>'Down'));
                                                                      }
                                                                 ?></strong></td>
                                      <td width="20%" class="theading"><strong><?php echo $this->Paginator->sort('Published On','Attribute.created'); 
                                                                      if(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Attribute.created' && $this->request->params['named']['direction'] =='asc'){
                                                                         echo $this->Html->image('/img/icons/arrow_up_mini.png',array('alt'=>'Up','title'=>'Up'));
                                                                      }elseif(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] =='Attribute.created' && $this->request->params['named']['direction'] =='desc'){
                                                                        echo $this->Html->image('/img/icons/arrow_down_mini.gif',array('alt'=>'Down','title'=>'Down'));
                                                                      }
                                                                 ?></strong></td>                                      
                                      <td width="8%" class="theading"><strong>Delete</strong></td>
                                    </tr>
                                    
						  <?php
               if(isset($newsList) && !empty($newsList)){
						          $i = 0;
                      foreach($newsList as $key => $value){
                      $i++;
                      if($i % 2 === 0){
                        $class = 'even-col';
                      }else{
                        $class = 'odd-col';
                      }
              ?>
                                    <tr class="<?php echo $class; ?>">
                                      <td><?php echo $value['Attribute']['short_description']; ?></td>
                                      <td><?php echo date(Configure::read('npoDateFormat'),strtotime($value['Attribute']['created'])); ?></td>
                                      <td><?php echo $this->Html->link($this->Html->image('/img/delete.png',array('width'=>'16','height'=>'16')),array('controller'=>'news','action'=>'deletenews',$value['Attribute']['id']),array('update' => 'newList','indicator'=>'loaderIDast','escape'=>false),'Are you sure to delete this news?'); echo $this->Html->link($this->Html->image('/img/icons/gtk-edit.png'),'/news/editnews/'.$value['Attribute']['id'],array('escape'=>false));?></td>
                                    </tr>
              <?php }
              } else{?>
                <tr class="even-col">
                  <td colspan="3" align="center"><strong>No News found.Add one <?php echo $this->Html->link('here','/news/addnews',array('class'=>"green_link")); ?> </strong></td>                                    
                </tr>
              <?php } ?> 
                              </table>

                            </div>
                            <!--Flag Alerts Closed--> <div id="pagination" class="paging_section">
                <?php
                          echo $this->Paginator->prev($title = '<< Previous',array('recCount'=>$recCount)); 
                          echo $this->Paginator->numbers(array('separator'=>' ','recCount'=>$recCount)); 
                          echo '&nbsp;'.$this->Paginator->next($title = 'Next >>',array('recCount'=>$recCount));
                    if(isset($newsList) && !empty($newsList)){
                    ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;View <?php 
                                                    $options=array('1'=>'1','2'=>'2','3'=>'3','4'=>'4');
                                                  echo $this->Form->input('pagecount',array('type'=>'select','options'=>$options,'div'=>false,'label'=>false));
                                                  echo $ajax->observeField('pagecount',array('url'=>array('controller'=>'news','action'=>'index'),'update'=>'newList','indicator'=>'loaderIDast'));
                                                 ?> 
                    <?php } ?>
                    </div>
                    
                        
                        </div>
                        <!--White Box Middle Closed-->  
                    </div>
                    <!--White Box Closed-->
               
                </div></div>