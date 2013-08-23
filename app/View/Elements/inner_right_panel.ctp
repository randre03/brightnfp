<div id="container_right">
                     <ul id="menu">        
                      <li id="compose"><?php echo $this->Html->link('Compose','/message/compose'); ?></li>
                      <li id="inbox"><span id="unreadMsg" style ="display:none;margin-left:21px" title="<?php echo $innerUnreadCount ?> unread message(s) in your inbox" class="unreadCount"><?php echo $innerUnreadCount; ?></span><?php echo $innerUnreadCount > 0 ? '<script type="text/javascript">jQuery("#unreadMsg").fadeIn(2000) </script>' : '' ?><?php echo $this->Html->link('Inbox','/message/inbox'); ?></li>
                      <li id="sent"><?php echo $this->Html->link('Sent','/message/sent'); ?></li>
                      <li id="reports"><?php echo $this->Html->link('Reports','/reports/'); ?></li>
                      <li id="news"><?php echo $this->Html->link('Manage News','/news/'); ?></li>    
                      <li id="members"><?php echo $this->Html->link('Members','/members/'); ?></li>
                      <li id="events"><?php echo $this->Html->link('Manage Events','/events/'); ?></li>       
                      <li id="site"><?php echo $this->Html->link('Manage Site','/npo/managesite/'); ?></li>       
                      <!--<li id="activities"><a href="#">Manage Activitites</a> </li>-->
                      <li id="donation"><?php echo $this->Html->link('Donation Recieved','/donations/'); ?></li>
	                </ul></div>