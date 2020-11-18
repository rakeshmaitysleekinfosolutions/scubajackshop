<section class="book-list">
    <h3><span><?php echo ($category['name']) ? $category['name'] : "";?> </span></h3>
	<p><?php echo ($category['description']) ? $category['description'] : "";?></p>
	<div class="container">
        <?php if(isset($products)) {?>
		<div class="row">
            <?php foreach ($products as $product) {?>
                <div class="col-md-3">
                    <div class="cards ">
                        <div class="book-details"> <img src="<?php echo $product['img'];?>" alt="<?php echo $product['name'];?>"> </div>
                        <div class="card-body">
                            <h5><?php echo $product['name'];?></h5>

                            <?php  if($product['video']) {?>
                                <a href="#headerPopup<?php echo $product['id'];?>" class="btn  watch btn popup-modal headerVideoLink" data-subscriberId="<?php echo (userId()) ? userId() : ''?>" data-url="<?php echo url('auth/check');?>"><i class="fab fa-youtube"></i>Watch</a>
                                <div id="headerPopup<?php echo $product['id'];?>" class="mfp-hide embed-responsive embed-responsive-21by9">
                                    <iframe class="embed-responsive-item" width="854" height="480" src="<?php echo embedUrl($product['video']);?>?rel=0&enablejsapi=1" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture; frameborder="0"; fullscreen;"></iframe>
                                </div>
                            <?php } else { ?>
                                <a href="javascript:void(0);" id="" class="btn  watch btn"><i class="fab fa-youtube"></i>Watch</a>
                            <?php } ?>
<!--                            <a href="#" class="btn  craft"><i class="fas fa-puzzle-piece"></i>Craft</a>-->
                            <?php if($product['pdf'] && isSubscribe()) {?>
                                <a target="_blank" href="<?php echo site_url('image/'.$product['pdf']);?>" class="btn craft download-btn"><i class="far fa-arrow-alt-circle-down"></i></i>Download</a>
                            <?php } else {?>
                                <a href="javascript:void(0);" class="btn craft download-btn"><i class="far fa-arrow-alt-circle-down"></i></i>Download</a>
                            <?php } ?>

                            <!-- <center> <a href="#" class="btn  order"><i class="fas fa-download"></i>Order now</a></center> -->
                        </div>
                    </div>
                </div>
            <?php } ?>
		</div>
        <?php } else { ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="404-logo pb-5">
                        <img src="<?php echo resize(getSession('settings')['logo'],200,200);?>" alt="<?php echo getSession('settings')['company_name'];?>" style="width:100px">
                    </div>
                    <h2>Product Not Found!</h2>
                </div>
            </div>

        <?php } ?>
	</div>
</section>
<!-- book-list part end -->

<script>
var myLabel = myLabel || {};
myLabel.baseUrl = '<?php echo base_url();?>';
</script>