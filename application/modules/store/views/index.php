<section class="product-listing">
    <div class="container">
      <div class="row">
      <?php foreach ($products as $product) { ?>
        <div class="col-md-3">
          <div class="cards product">
            <div class="book-details product-img"> 
              <a href="#"><img src="<?php echo base_url(); ?>image/<?php echo $product['image']; ?>" alt="product-images"></a> 
              <div class="quick-view-button">
                <a href="<?php echo base_url(); ?>product/<?php echo $product['slug']; ?>" class="btn btn-info btn-sm">View Detail</a>
              </div>
            </div>
            <div class="card-body">
               <div class="books-details">
               <p><a href="#"><?php echo $product['name']; ?></a></p>
                <p class="wishlist"><a href="javascript:void(0);"> <i class="fas fa-heart"></i> Add to wishlist</a></p>
              </div>
              <!-- Lorem ipsum dolor sit amet, consectetur adipiscing elit. -->
               <div class="rightprice">
                Price :
                <span>$<?php echo number_format($product['price']); ?></span>
                </div>
                <div class="add-to-cart-butt">
                   <a href="#" class="btn  watch mt-3">Buy Now</a> 
                   <a href="#" class="btn  btn-primary mt-3 ml-2">Add to Cart</a>
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
</script>