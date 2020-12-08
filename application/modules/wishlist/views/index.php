<section class="blogsec wishlist">
    <div class="container">
        <?php if(count($products) > 0) {?>
            <h3>My Wishlist(<?php echo $totalWishListed;?>)</h3>
        <?php
            foreach ($products as $product) {
                ?>
        <div class="add-border-bottom">
            <div class="row">
                <div class="col-md-2">
                    <a href="<?php echo $product['url'];?>"><img src="<?php echo $product['img'];?>" alt="<?php echo $product['name'];?>" /></a>
                </div>
                <div class="col-md-6">
                    <div class="wishlist-txt pt-3">
                        <h4><?php echo $product['name'];?></h4>
                        <div class="price">
                            <?php echo $product['price'];?>
                            <span> <?php echo $product['mrp'];?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-right delete-icon remove-wishlist" data-shop_id="<?php echo $product['id'];?>">
                    <i class="fas fa-trash" data-toggle="tooltip" data-placement="top" title="Remove"></i>
                </div>
            </div>
        </div>
        <?php
            }
        }
        ?>
    </div>
</section>
<script>
    var myLabel = {};
    myLabel.removeWishlist = '<?php echo url('/wishlist/remove');?>';
</script>