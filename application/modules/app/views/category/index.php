<section class="skill-inner">
	<div class="container">
		<div class="logo"> <img src="<?php echo base_url('assets/images/scuba-logo.png');?>"> </div>
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
			</div>
		</div>
	</div>
</section>
<script>
var myLabel = myLabel || {};
myLabel.baseUrl = '<?php echo base_url();?>';
</script>