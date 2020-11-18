
<section class="pricing">
    <div class="container">
            <div class="row">
                <div class="sub-plan">
                    <h2 class="notice">You have already subscribed <?php echo (isset($plan['name'])) ? $plan['name'] : '';?> plan</h2>
                    <p class="prange">Price: <?php echo $plan['price'];?></p>
                    <h3 class="exp-date">Expire Date: <?php echo (isset($plan['end_at'])) ? $plan['end_at'] : '';?></h3>
                    <h3 class="day-left">Day Left: <?php echo (isset($plan['daysLeft'])) ? $plan['daysLeft'] : '';?></h3>
                    <h6 class="description"><?php echo (isset($plan['description'])) ? $plan['description'] : '';?></h6>

                    <p class="sub-name">Subscriber Name: <?php echo (isset($subscriber['name'])) ? $subscriber['name'] : '';?></p>
                    <h3 class="sub-add">Subscriber Email: <?php echo (isset($subscriber['email'])) ? $subscriber['email'] : '';?></h3>
                </div>
            </div>
    </div>
</section>

