<section class="product-listing">
    <div class="container">
<!--        <div class="breadcrumb">-->
<!--            --><?php //if(count($breadcrumbs) > 0) {?>
<!--                --><?php //foreach ($breadcrumbs as $breadcrumb) {?>
<!--                    <li><a href="--><?php //echo $breadcrumb['href'];?><!--">--><?php //echo $breadcrumb['text'];?><!--</a></li>-->
<!--                --><?php //} ?>
<!--            --><?php //} ?>
<!--        </div>-->
      <div class="row">
      <?php foreach ($products as $product) { ?>
        <div class="col-md-3">
          <div class="cards product">
            <div class="book-details product-img"> 
              <a href="#"><img src="<?php echo $product['img']; ?>" alt="<?php echo $product['name'];?>"></a>
              <div class="quick-view-button">
                <a href="<?php echo base_url(); ?>product/<?php echo $product['slug']; ?>" class="btn btn-info btn-sm">View Detail</a>
              </div>
            </div>
            <div class="card-body">
               <div class="books-details">
               <p><a href="<?php echo $product['url']; ?>"><?php echo $product['name']; ?></a></p>
<!--                <p class="wishlist"></p>-->
              </div>
               <div class="rightprice">
                  <span><?php echo $product['price']; ?></span>
                </div>
                <div class="add-to-cart-butt">
                    <a href="javascript:void(0);" data-product_id="<?php echo $product['id'];?>" data-quantity="1" class="btn  watch mt-3 buy-now">Buy Now</a>
                    <a href="javascript:void(0);" data-product_id="<?php echo $product['id'];?>" data-quantity="1" class="btn  btn-primary mt-3 ml-2 add-to-cart">Add to Cart</a>
                    <a href="javascript:void(0);" data-product_id="<?php echo $product['id'];?>" class="btn  btn-primary mt-3 ml-2 add-to-wishlist"> <i class="fas fa-heart"></i> Add to wishlist</a>
                </div>       
            </div>       
           </div>
        </div>
        <?php } ?>
      </div>
    </div>
  </section>
<script>
var myLabel = myLabel || {};
myLabel.baseUrl = '<?php echo base_url();?>';
myLabel.cart = '<?php echo url('/cart');?>';
myLabel.wishlist = '<?php echo url('/wishlist/add');?>';
</script>
