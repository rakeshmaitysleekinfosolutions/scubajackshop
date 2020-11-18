<?php if(!$country) { ?>
    <section class="gallery-box">
        <div class="container">
            <h3 class="gallery"><?php echo $message;?></h3>
        </div>
    </section>
<?php } ?>

<?php if($isContent) { ?>
<section class="country">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="city-text">
                    <img src="<?php echo resize($countryDescription->image,445,450);?>" alt="city-image" 
                    class="city-picture">
                    <h3><?php echo $countryDescription->title;?></h3>
                    <p><?php echo $countryDescription->description;?></p>
                </div>
            </div>
        </div>
    </div>
</section>
    <?php if($blogs) { ?>
        <section class="gallery-box">
            <div class="container">
                <h3 class="gallery">Explore</h3>
                <div class="row">
                    <?php foreach ($blogs as $blog) { ?>
                        <div class="col-md-4">
                            <a href="javascript:void(0);" class="c-blog">
                            <div class="card blog">
                               <img class="img-fluid" src="<?php echo $blog['image'];?>" alt="Card image cap">
                                <div class="card-body">
                                    <a href="<?php echo $blog['slug'];?>"><h4><?php echo $blog['title'];?></h4></a>
                                    <p><?php echo $blog['smallDescription'];?></p>
                                </div>
                            </div>
                            </a>
                        </div>
                    <?php  } ?>
                </div>
            </div>
        </section>
    <?php } ?>

<?php } else {?>
    <section class="country text-center nocont-page">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="404-logo pb-5">
                        <img src="<?php echo resize(getSession('settings')['logo'],200,200);?>" alt="<?php echo getSession('settings')['company_name'];?>" style="width:100px">
                    </div>
                    <h2>Sorry! This content is not available in this country yet.</h2>
                </div>
            </div>
        </div>
    </section>
<?php } ?>