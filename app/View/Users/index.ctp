<!-- Banner Starts -->
<section id="banner_full">
      <section id="banner_wrap">
       <div id="slideshow">
        <div class="subscribe_blue_btn"><?php  
  echo $this->Paypal->button('Subscribe',array('type'=>'subscribe','period'=>1,'term'=>'month','amount'=>$fee,'class'=>'input-bg','return' => 'http://'.$_SERVER['HTTP_HOST'].'/users/subscribe')); ?><</div>
    <div id="slidesContainer">
    
    <!-- Slide 1 -->
      <div class="slide">
         <div class="slide-text">
         <h2>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </h2>
         <p>If you're into developing web apps, you should check out the tutorial called "Using XAMPP for Local WordPress Theme Development" which shows you how to set up a local testing server for developing PHP/Perl based applications locally on your computer. The example also shows you how to set up WordPress locally!</p>
         <br><a href="#"></a>
         </div>
          <div class="slide-img"><?php echo $this->Html->image('/img/banner_img.png',array('title'=>'Mobile and Web Services')); ?></div>
      </div>
      
      <!-- Slide 2 -->
       <div class="slide">
        <div class="slide-text">
         <h2>Web Development Tutorial</h2>
         <p>If you're into developing web apps, you should check out the tutorial called "Using XAMPP for Local WordPress Theme Development" which shows you how to set up a local testing server for developing PHP/Perl based applications locally on your computer. The example also shows you how to set up WordPress locally!</p>
         </div>
          <div class="slide-img"><?php echo $this->Html->image('/img/banner_img.png',array('title'=>'Mobile and Web Services')); ?></div>
      </div>
      
      <!-- Slide 3 -->
      <div class="slide">
         <div class="slide-text">
         <h2>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </h2>
         <p>If you're into developing web apps, you should check out the tutorial called "Using XAMPP for Local WordPress Theme Development" which shows you how to set up a local testing server for developing PHP/Perl based applications locally on your computer. The example also shows you how to set up WordPress locally!</p>
         <br><a href="#"></a>
         </div>
          <div class="slide-img"><?php echo $this->Html->image('/img/banner_img.png',array('title'=>'Mobile and Web Services')); ?></div>
      </div>
      
    </div>
  </div>
      </section>
</section>
<!-- Banner Ends -->

<!-- Container Starts -->
<section id="content_container_home">
      <section id="container_wrap">
        <div class="threebox_bg">
           <div class="box_wrap1">
               <h2>Lorem Ipsum is not simply random text.</h2>
               <?php echo $this->Html->image('/img/box1_img.jpg',array('title'=>'gallery')); ?>
               <p>Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, </p><a href="#"></a>
           </div>
           <div class="box_wrap2">
               <h2>More-or-less normal distribu tion of letters </h2> 
               <?php echo $this->Html->image('/img/video_thumb.jpg',array('title'=>'Watch this Video')); ?>
               <a href="#">&raquo; Watch this Video</a>
           </div>
           <div class="box_wrap3">
               <h2>Passage of Lorem Ipsum </h2> 
               <?php echo $this->Html->image('/img/passage-icon.jpg',array('title'=>'Mobile Services')); ?>
               <p>Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested</p>
             <a href="#"></a>
           </div>
        </div>
      </section>
</section>
<!-- Container Ends -->
