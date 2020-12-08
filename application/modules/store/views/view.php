<section class="product-listing mb-4">

    <div class="container">
        <div class="breadcrumb">
            <?php if(count($breadcrumbs) > 0) {?>
                <?php foreach ($breadcrumbs as $breadcrumb) {?>
                    <li><a href="<?php echo $breadcrumb['href'];?>"><?php echo $breadcrumb['text'];?></a></li>
                <?php } ?>
            <?php } ?>
        </div>
      <div class="row">
        <div class="col-md-6">
             <div class="gallery">
                <div class="image-preview">
                    <img id="preview" src="<?php echo $product['img']; ?>" alt="<?php echo $product['name'];?>"/>
                </div>
                  <ul id="carousel" class="elastislide-list">
                      <?php foreach ($images as $image) { ?>
                        <li data-preview="<?php echo resize($image['image'],526,310); ?>"><a href="#"><img src="<?php echo resize($image['image'],107,65); ?>" alt="" /></a></li>
                      <?php } ?>
                  </ul>
                </div>
            </div>
        <div class="col-md-6">
           <div class="card-body pt-0">
              <h5 class="text-left"><?php echo $product['name'];?></h5>
              <div class="single-product-price">
                  <h2><?php echo $product['price'];?></h2>
                  <small>&nbsp;<s><?php echo $product['mrp'];?></s></small>
              </div>
                <div class="row">
                    <div class="col-md-4 mt-3">
                        <a class="cart-btn btn-danger py-3 px-4 add-to-cart" data-product_id="<?php echo $product['id'];?>" data-quantity="1" href="javascript:void(0);">
                            <i class="fa fa-cart-plus"></i> Add to Cart
                        </a>
                    </div>
                    <div class="col-md-4 mt-3">
                        <a class="cart-btn btn-success py-3 px-4 buy-now" data-product_id="<?php echo $product['id'];?>" data-quantity="1" href="javascript:void(0);">
                            <i class="fa fa-bolt"></i> Buy Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="product-desc">
         <h3>Product Description</h3>
         Duis bibendum tincidunt urna eget luctus. Duis vestibulum porta erat, sed egestas neque congue sed. Curabitur auctor rutrum erat, sit amet convallis purus posuere sit amet. Nullam velit orci, tempor nec pulvinar et, tempus sed lacus. Nullam aliquet dictum nunc quis molestie. Proin dapibus massa quis tristique ultricies. Mauris tempor diam eget tellus accumsan fermentum.
      </div>

    </div>
  </section>
<script>
    var myLabel = {};
    myLabel.cart = '<?php echo url('/cart');?>';
</script>