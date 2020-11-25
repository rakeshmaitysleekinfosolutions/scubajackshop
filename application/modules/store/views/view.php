<section class="product-listing mb-4">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
             <div class="gallery">
                <div class="image-preview">
            <img id="preview" src="<?php echo base_url(); ?>image/<?php echo $product['image']; ?>" />
          </div>
          <!-- Elastislide Carousel -->
          <ul id="carousel" class="elastislide-list">
          <?php foreach ($images as $image) { ?>
            <li data-preview="<?php echo resize($image['image'],526,310); ?>"><a href="#"><img src="<?php echo resize($image['image'],107,65); ?>" alt="" /></a></li>            
          <?php } ?>
          </ul>
          <!-- End Elastislide Carousel -->          
        </div>            
        </div>
        <div class="col-md-6">
           <div class="card-body pt-0">
              <h5 class="text-left"><?php echo $product['name'];   ?></h5> 
              <h4>in stock</h4>
              <p>hello<?php echo $description['description']; ?></p>
              <div class="single-product-price">
                           <h2>$50.66</h2>
                           <small>&nbsp;&nbsp;&nbsp;<s>40% off</s></small>
              </div>   
               

            <div class="row">
               <div class="col-md-4">
                 <div class="input-group p-1 border">
                                    <span class="input-group-btn">
                                        <button type="button" class="quantity-left-minus btn btn-number" data-type="minus" data-field="">
                                          <i class="fas fa-plus"></i>
                                        </button>
                                    </span>
                                    <input type="text" id="quantity" name="quantity" class="form-control input-number" value="10" min="1" max="100">
                                    <span class="input-group-btn">
                                        <button type="button" class="quantity-right-plus btn btn-number" data-type="plus" data-field="">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </span>
                     </div> 
               </div>
               <div class="col-md-4 mt-3">
                  <a class="cart-btn btn-danger py-3 px-4" href="#">
                    <i class="fa fa-cart-plus"></i> Add to Cart
                  </a>
               </div>
               <div class="col-md-4 mt-3">
                  <a class="cart-btn btn-success py-3 px-4" href="#">
                    <i class="fa fa-bolt"></i> Buy Now
                  </a>
               </div>
            </div> 
            <div class="single-product-categories">
                           <label>Categories:</label>
                           FootwearMen's &gt; FootwearCasual &gt; ShoesClarks &gt; Casual
                           <div class="clear"></div>
                           <label>Services:</label>
                           Cash On Delivery available?
                           <div class="clear"></div>
                           <label>Categories:</label>
                           30 Days Exchange Policy?
                           <div class="clear"></div>
                           <label>Payment Method</label>
                           Safe and Secure Payments. Easy returns.
                        </div>      
            </div>
        </div>
      </div>
      <div class="product-desc">
         <h3>Product Description</h3>
         Duis bibendum tincidunt urna eget luctus. Duis vestibulum porta erat, sed egestas neque congue sed. Curabitur auctor rutrum erat, sit amet convallis purus posuere sit amet. Nullam velit orci, tempor nec pulvinar et, tempus sed lacus. Nullam aliquet dictum nunc quis molestie. Proin dapibus massa quis tristique ultricies. Mauris tempor diam eget tellus accumsan fermentum.
      </div>
      <div class="related-product mt-4">
        <h3>Related Product</h3>
         <div class="row">
            <div class="col-md-3">
          <div class="cards product">
            <div class="book-details product-img"> 
              <a href="#"><img src="<?php echo base_url(); ?>assets/images/pd1.jpg" alt="product-images"></a> 
              <div class="quick-view-button">
                <a href="#" class="btn btn-info btn-sm">View Detail</a>
              </div>
            </div>
            <div class="card-body">
               <div class="books-details">
               <p><a href="#">Be One of Kind</a></p>
                <p class="wishlist"><a href="javascript:void(0);"> <i class="fas fa-heart"></i> Add to wishlist</a></p>
              </div>
              <!-- Lorem ipsum dolor sit amet, consectetur adipiscing elit. -->
               <div class="rightprice">
                Price :
                <span>$37</span>
                </div>
                <div class="add-to-cart-butt">
                   <a href="#" class="btn  watch mt-3">Buy Now</a> 
                   <a href="#" class="btn  btn-primary mt-3 ml-2">Add to Cart</a>
                </div>       
            </div>       
           </div>
        </div>
        <div class="col-md-3">
          <div class="cards product">
            <div class="book-details product-img"> 
              <a href="#"><img src="<?php echo base_url(); ?>assets/images/pd1.jpg" alt="product-images"></a> 
              <div class="quick-view-button">
                <a href="#" class="btn btn-info btn-sm">View Detail</a>
              </div>
            </div>
            <div class="card-body">
               <div class="books-details">
               <p><a href="#">Be One of Kind</a></p>
                <p class="wishlist"><a href="javascript:void(0);"> <i class="fas fa-heart"></i> Add to wishlist</a></p>
              </div>
              <!-- Lorem ipsum dolor sit amet, consectetur adipiscing elit. -->
               <div class="rightprice">
                Price :
                <span>$37</span>
                </div>
                <div class="add-to-cart-butt">
                   <a href="#" class="btn  watch mt-3">Buy Now</a> 
                   <a href="#" class="btn  btn-primary mt-3 ml-2">Add to Cart</a>
                </div>       
            </div>       
           </div>
        </div>
        <div class="col-md-3">
          <div class="cards product">
            <div class="book-details product-img"> 
              <a href="#"><img src="<?php echo base_url(); ?>assets/images/pd1.jpg" alt="product-images"></a> 
              <div class="quick-view-button">
                <a href="#" class="btn btn-info btn-sm">View Detail</a>
              </div>
            </div>
            <div class="card-body">
               <div class="books-details">
               <p><a href="#">Be One of Kind</a></p>
                <p class="wishlist"><a href="javascript:void(0);"> <i class="fas fa-heart"></i> Add to wishlist</a></p>
              </div>
              <!-- Lorem ipsum dolor sit amet, consectetur adipiscing elit. -->
               <div class="rightprice">
                Price :
                <span>$37</span>
                </div>
                <div class="add-to-cart-butt">
                   <a href="#" class="btn  watch mt-3">Buy Now</a> 
                   <a href="#" class="btn  btn-primary mt-3 ml-2">Add to Cart</a>
                </div>       
            </div>       
           </div>
        </div>
        <div class="col-md-3">
          <div class="cards product">
            <div class="book-details product-img"> 
              <a href="#"><img src="<?php echo base_url(); ?>assets/images/pd1.jpg" alt="product-images"></a> 
              <div class="quick-view-button">
                <a href="#" class="btn btn-info btn-sm">View Detail</a>
              </div>
            </div>
            <div class="card-body">
               <div class="books-details">
               <p><a href="#">Be One of Kind</a></p>
                <p class="wishlist"><a href="javascript:void(0);"> <i class="fas fa-heart"></i> Add to wishlist</a></p>
              </div>
              <!-- Lorem ipsum dolor sit amet, consectetur adipiscing elit. -->
               <div class="rightprice">
                Price :
                <span>$37</span>
                </div>
                <div class="add-to-cart-butt">
                   <a href="#" class="btn  watch mt-3">Buy Now</a> 
                   <a href="#" class="btn  btn-primary mt-3 ml-2">Add to Cart</a>
                </div>       
            </div>       
           </div>
        </div>
         </div>
      </div>
    </div>
  </section>
  <script type="text/javascript">
    $(document).ready(function(){

var quantitiy=0;
   $('.quantity-right-plus').click(function(e){
        
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt($('#quantity').val());
        
        // If is not undefined
            
            $('#quantity').val(quantity + 1);

          
            // Increment
        
    });

     $('.quantity-left-minus').click(function(e){
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt($('#quantity').val());
        
        // If is not undefined
      
            // Increment
            if(quantity>0){
            $('#quantity').val(quantity - 1);
            }
    });
    
});
  </script>

  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/modernizr.custom.17475.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.elastislide.js"></script>
  <script type="text/javascript">
      
      // example how to integrate with a previewer

      var current = 0,
        $preview = $( '#preview' ),
        $carouselEl = $( '#carousel' ),
        $carouselItems = $carouselEl.children(),
        carousel = $carouselEl.elastislide( {
          current : current,
          minItems : 4,
          onClick : function( el, pos, evt ) {

            changeImage( el, pos );
            evt.preventDefault();

          },
          onReady : function() {

            changeImage( $carouselItems.eq( current ), current );
            
          }
        } );

      function changeImage( el, pos ) {

        $preview.attr( 'src', el.data( 'preview' ) );
        $carouselItems.removeClass( 'current-img' );
        el.addClass( 'current-img' );
        carousel.setCurrent( pos );

      }

    </script>