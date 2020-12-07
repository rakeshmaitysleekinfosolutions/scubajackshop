<section class="country text-center nocont-page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="404-logo pb-5">
                    <img src="<?php echo resizeAssetImage('empty-cart.png',500,400);?>" alt="<?php echo getSession('settings')['company_name'];?>" style="width:100px">
                </div>
                <h2>Your Shopping Bag Is Empty</h2>
                <a class="btn btn-primary" href="<?php echo url('/home-store');?>">Go To Home Page</a>
            </div>
        </div>
    </div>
</section>