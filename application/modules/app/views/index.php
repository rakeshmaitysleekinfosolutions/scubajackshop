

<!------------header end----------->
  <section>
    <div class="bluebg">
      <h3>Majestic Learning</h3> </div>
<!--       <div class="continent"> <img src="--><?php //echo base_url();?><!--assets/images/world-map.png" usemap="#imagemap">-->
<!--          <map name="imagemap">-->
<!--            <area coords="650,20,100,100" shape="rect" href="https://getbootstrap.com/" title="Greenland" alt="greeen" target="_blank">-->
<!--            <area coords="150,100,300,350" shape="rect" href="https://www.wikipedia.org/" title="United states" alt="test333" target="_blank">-->
<!--            <area coords="700,100,300,350" shape="rect" href="https://www.w3schools.com/" title="Brazil" alt="test" target="_blank">-->
<!--              <area coords="1000,100,300,350" shape="rect" href="https://es.wikipedia.org/wiki/Wikipedia:Portada" title="africa" alt="test" target="_blank">-->
<!--            <area coords="1450,100,300,350" shape="rect" href="https://www.w3schools.com/" title="Test" alt="test" target="_blank"> </area>-->
<!--            </map>-->
<!---->
<!--        </div>-->
<!--      <div id="chartdiv"></div>-->


          <div class="continent" id="map">
              <div class="map__image">
                  <svg xmlns="https://www.w3.org/2000/svg" xmlns:amcharts="https://amcharts.com/ammap" xmlns:xlink="https://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 597 585" width="100%" height="505" id="worldMap">
                      <g>
                          <?php
                          if(isset($maps)) { ?>
                              <?php foreach ($maps as $map) { ?>
                                  <a data-tooltip="<?php echo $map['tooltip']?>" xlink:href="javascript:void(0);" data-iso="<?php echo $map['countryIsoCode2'];?>" data-url="<?php echo base_url('auth/check');?>" data-subscriberid="<?php echo userId();?>" >
                                      <path  id="<?php echo $map['countryIsoCode2'].'_'.$map['countryId'];?>" title="<?php echo $map['countryName']?>"  d="<?php echo $map['d']?>" /></a>
                              <?php } ?>
                          <?php } ?>
                      </g>
                  </svg>
              </div>
          </div>


    <div class="tagline">
      <div class="darkbluebg">
        <h4>where the world and reading collide</h4>
        <p>Each booklet come with activities,video's and quizzes.</p>
      </div>
      <div class="yellowbg"> </div>
  </section>
  <!-----------banner part end-------->
  <section class="pre-school">
    <h3>We provide a <span>variety of  quality</span> of Pre-school and elementary</h3>
    <p>education for children</p>
    <div class="pre-banner">
        <ul class="activityBooks">
            <li data-src="<?php echo getSession('settings')['video'];?>" data-poster="<?php echo makeThumbnail(getSession('settings')['video'],'HIGH');?>"  >
                <a href="<?php echo getSession('settings')['video'];?>" >
                    <img src="<?php echo base_url('assets/images/play-button-2.png');?>">
                </a>
            </li>
        </ul>
    </div>
    <div class="elementary">
      <div class="container">
        <div class="row">
          <div class="col-md-6"> <img src="<?php echo base_url();?>assets/images/p1.jpg">
            <p>Preschool <span>learning</span></p>
          </div>
          <div class="col-md-6"> <img src="<?php echo base_url();?>assets/images/p2.jpg">
            <p>Elementary <span>learning</span></p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!------------preschool part end--------->
  <section class="sub">
    <div class="subscription">
      <p>Start your subscription today and get access to<br/>
      <span>your Virtual Field Trips, books, video’s, activities and FUN!</span></p>
        <?php if(getSession('subscribe')) { ?>
            <button type="button" onclick="(function(){
                    window.location.href = '<?php echo base_url('subscribed');?>';
                    return false;
                    })();return false;" class="btn start-sub">Subscribed</button>
        <?php } else { ?>
      <button type="button" onclick="(function(){
    window.location.href = '<?php echo base_url('viewplans');?>';
    return false;
})();return false;" class="btn start-sub">Start Subscription</button>
        <?php } ?>
    </div>
    <div class="sub-banner"> </div>
  </section>
  <!------------- subscription part end--------->
<?php if($products) { ?>
  <section class="world_reading">
    <h3>Where<span> the world and Reading</span> Collide!</h3>
    <p>Comes with Quizzes & Videos!</p>
    <div class="container">
      <div class="row">
              <?php foreach ($products as $product) { ?>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="books"> <img src="<?php echo $product['img'];?>" alt="<?php echo $product['name'];?>">
            <div class="books-details">
              <p><?php echo $product['name'];?></p>
                <?php if($product['quiz'] && isSubscribe()) {?>
                    <p class="qu"><a href="<?php echo $product['quiz'];?>">quiz</a></p>
                <?php } else { ?>
                    <p class="qu"><a href="javascript:void(0);">quiz</a></p>
                <?php } ?>
            </div>
            <div class="more">

                <?php  if($product['video']) {?>
                    <a href="#headerPopup<?php echo $product['id'];?>" class="btn  watch btn popup-modal headerVideoLink" data-subscriberId="<?php echo (userId()) ? userId() : ''?>" data-url="<?php echo url('auth/check');?>"><i class="fab fa-youtube"></i>Watch</a>
                    <div id="headerPopup<?php echo $product['id'];?>" class="mfp-hide embed-responsive embed-responsive-21by9">
                        <iframe class="embed-responsive-item" width="854" height="480" src="<?php echo embedUrl($product['video']);?>?rel=0&enablejsapi=1" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture; frameborder="0"; fullscreen;"></iframe>
                    </div>
                <?php } else { ?>
                    <a href="javascript:void(0);" id="" class="btn  watch btn"><i class="fab fa-youtube"></i>Watch</a>
                <?php } ?>
                <?php if($product['pdf'] && isSubscribe()) {?>
                     <a target="_blank" href="<?php echo site_url('image/'.$product['pdf']);?>" class="btn craft download-btn"><i class="far fa-arrow-alt-circle-down"></i></i>Download</a>

                <?php } else {?>
                    <a href="javascript:void(0);" class="btn craft download-btn"><i class="far fa-arrow-alt-circle-down"></i></i>Download</a>
                <?php } ?>

            </div>
          </div>
        </div>
        <?php } ?>

      </div>
<!--      <center><a class="btn see-more">See more</a></center>-->
    </div>
  </section>
<?php } ?>
  <!------------------- world & reading part end ------->
  <section class="skill">
    <div class="container">
      <div class="logo"> <img src="<?php echo base_url();?>assets/images/scuba-logo.png"> </div>
      <div class="skill-list">
        <div class="row">
            <?php if($categories) { ?>
                <?php foreach ($categories as $category) {?>
                    <div class="col-md-6">
                        <div class="skillbox">
                            <img src="<?php echo $category['img'];?>">
                          <div class="s-link">
                            <a href="<?php echo base_url($category['slug']);?>" class="btn whitebtn"><?php echo $category['name'];?></a>
                          </div>
                        </div>
                    </div>
                <?php } ?>
            <?php }  ?>
            <?php
            /*
           <div class="col-md-6">
                <div class="skillbox">
                  <div class="s-link">
                    <button type="button" class="btn whitebtn">story books</button>
                  </div>
                </div>
            </div>
          <div class="col-md-6">
            <div class="skillbox2">
              <div class="s-link">
                <button type="button" class="btn whitebtn">Learn to read</button>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="skillbox3">
              <div class="s-link">
                <button type="button" class="btn whitebtn">Number</button>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="skillbox4">
              <div class="s-link">
                <button type="button" class="btn whitebtn">Color</button>
              </div>
            </div>
          </div>
            */?>
        </div>
        <center><a href="<?php echo base_url('all');?>" class="btn see-more">See all</a></center>
      </div>
    </div>
  </section>
  <!----------------------- skill part end----------------->

<?php if($activityBooks) {?>
  <section class="adventure">
    <h3>Learn to READ with<span>The Adventures</span> of Scuba Jack.</h3>
    <div class="container">
      <div class="activity-wrapper">
        <div class="row demo-gallery">
            <ul class="activityBooks">
            <?php foreach ($activityBooks as $activityBook) { ?>
                <li class="col-lg-3 col-md-6 col-sm-6 col-12" data-poster="<?php echo makeThumbnail($activityBook['video'],'HIGH');?>" data-src="<?php echo $activityBook['video'];?>" data-name="<?php echo $activityBook['name'];?>">
                    <div class="activity-box">
                        <a  href="">
                            <img class="img-responsive" src="<?php echo makeThumbnail($activityBook['video'],'HIGH');?>" />
                            <div class="demo-gallery-poster">
                                <img src="<?php echo base_url('assets/images/play-button-2.png');?>">
                            </div>
                        </a>
                        <center>
                            <button type="button" class="btn activity-book"><i class="far fa-arrow-alt-circle-down"></i>activity book</button>
                        </center>
                    </div>
                </li>
            <?php } ?>
            </ul>
        </div>
      </div>
    </div>
  </section>
<?php } ?>
<script>
    var myLabel = myLabel || {};
    myLabel.baseUrl = '<?php echo base_url();?>';
    myLabel.checkLogin = '<?php echo base_url("auth/check");?>';
    myLabel.viewplans = '<?php echo base_url("viewplans");?>';
    myLabel.stampToPassport = '<?php echo base_url("stampToPassport");?>';
    myLabel.postGems = '<?php echo base_url("postGems");?>';
</script>
