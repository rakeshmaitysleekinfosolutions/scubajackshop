<section class="country">
    <div class="container">
        <div class="city-picture">
            <img src="<?php echo resize($blog['image'],1110,450);?>" alt="city-image">
        </div>
        <div class="city-text">
            <h3><?php echo $blog['title'];?></h3>
            <h4><?php echo $blog['smallDescription'];?></h4>
            <p><?php echo $blog['description'];?></p>
        </div>
    </div>
</section>
<?php if($blogImages) {?>
    <section class="gallery-box">
        <div class="container">
        <h3 class="gallery">Image Gallery</h3>
        <div class="row">
               <div class="demo-gallery">
                    <ul id="imageGallery" class="list-unstyled row">
                        <?php foreach ($blogImages as $blogImage) {?>
                        <li class="col-xs-6 col-sm-4 col-md-3" data-responsive="img/1-375.jpg 375, img/1-480.jpg 480, img/1.jpg 800" data-src="<?php echo base_url('image/'.$blogImage['image']);?>">
                            <a href="javascript:void(0);">
                                <img class="img-responsive" src="<?php echo base_url('image/'.$blogImage['image']);?>">
                            </a>
                        </li>
                        <?php  } ?>
                    </ul>
                </div>

        </div>
    </div>
    </section>
<?php } ?>
<?php if($blogVideos) {?>
    <section class="gallery-box">
        <div class="container">
            <h3 class="gallery">Video Gallery</h3>
            <div class="row">
                <div class="demo-gallery">
                    <ul id="videoGallery" class="list-unstyled row">
                        <?php foreach ($blogVideos as $blogVideo) {?>
                            <li class="col-xs-6 col-sm-4 col-md-3" data-responsive="img/1-375.jpg 375, img/1-480.jpg 480, img/1.jpg 800" data-src="<?php echo $blogVideo['video'];?>">
                                <a href="javascript:void(0);" >
                                    <img class="img-responsive" src="<?php echo makeThumbnail($blogVideo['video'],'HIGH');?>">
                                    <div class="demo-gallery-poster">
                                        <img src="<?php echo base_url('assets/images/play-button-2.png');?>">
                                    </div>
                                </a>
                            </li>
                        <?php  } ?>
                    </ul>
                </div>

            </div>
        </div>
    </section>
<?php } ?>
