<section class="pricing">
    <div class="container">
        <?php if(isset($plans)) { ?>
            <div class="row">
            <?php foreach ($plans as $plan) { ?>

                    <div class="col-md-4">
                      <div class="price-box">
                        <h2><?php echo currencyFormat($plan->price, getSession('currency')['code']);?></h2>
                          <p>For <?php echo $plan->frequency_interval;?> <?php echo $plan->frequency;?></p>
                        <h3><?php echo $plan->name;?></h3>
                          <h6 class="description"><?php echo $plan->description;?></h6>
                        <a href="<?php echo base_url('plan/'.$plan->slug);?>" class="btn sub-button">Subscribe</a>
                      </div>
                    </div>

            <?php } ?>
            </div>
        <?php } else { ?>

            <div class="row"></div>
        <?php } ?>
    </div>
  </section>

