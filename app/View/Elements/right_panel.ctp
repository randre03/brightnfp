<div id="sidebar">
  				<ul>
                    <li><h3><span class="church"><?php echo __('NPO/CHURCHES'); ?></span></h3>
          				    <ul>
                        	<li><?php echo $this->Html->link(__('MANAGE_NPO'),array('controller'=>'npo','action'=>'admin_manage_npo'),array('escape'=>false)); ?></li>
                      </ul>
                    </li>
                    <li><h3><span class="admin_message"><?php echo __('MESSAGES'); ?></span></h3>
          				      <ul>
                            <li><?php echo $this->Html->link(__('COMPOSE'),array('controller'=>'message','action'=>'admin_compose'),array('escape'=>false)); ?></li>
                            <li><span id="unreadMsg" style ="display:none" title="<?php echo $unreadCount ?> unread message(s) in your inbox" class="unreadCount"><?php echo $unreadCount; ?></span><?php echo $unreadCount > 0 ? '<script type="text/javascript">jQuery("#unreadMsg").fadeIn(2000) </script>' : '' ?><?php echo $this->Html->link(__('INBOX'),array('controller'=>'message','action'=>'admin_inbox'),array('escape'=>false)); ?></li>
                            <li><?php echo $this->Html->link(__('SENT'),array('controller'=>'message','action'=>'admin_sent'),array('escape'=>false)); ?></li>
            				
                        </ul>
                    </li>
                  <li><h3><span href="#" class="content"><?php echo __('CMS'); ?></span></h3>
          				  <ul>
                       <li><?php echo $this->Html->link(__('MANAGE_TEMPLATES'),array('controller'=>'templates','action'=>'manage_templates')); ?></li>                           
                    </ul>
                    </li>
                  <li><h3><span href="#" class="fees"><?php echo __('FEES'); ?></span></h3>
          				  <ul>
                       <li><?php echo $this->Html->link(__('MANAGE_FEES'),array('controller'=>'admin','action'=>'fee')); ?></li>                           
                    </ul>
                    </li>
                  <li><h3>&nbsp;</h3>
          				    <ul>
                            <li><?php echo $this->Html->link(__('LOGOUT'),array('controller'=>'admin','action'=>'logout'),array('escape'=>false)); ?></li>
                        </ul>
                    </li>
				</ul>       
          </div>