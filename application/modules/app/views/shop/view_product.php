<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Bootstrap CSS -->
  <!-- font-awesome Css -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/all.min.css" rel="stylesheet" />
  <link type="text/css" rel="stylesheet" href="css/bootstrap.css">
  <link type="text/css" rel="stylesheet" href="css/style.css">
  <link type="text/css" rel="stylesheet" href="css/responsive.css">
  <link type="text/css" rel="stylesheet" href="font/font.css">

  <link rel="stylesheet" type="text/css" href="css/elastislide.css" />
  <title>Scuba Jack</title>
</head>

<body>
  <header class="menu-area sticky">
    <div class="container">
      <nav class="navbar navbar-expand-lg ">
        <a class="navbar-brand" href="index.html"> <img src="images/scuba-logo.png"> </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active"> <a class="nav-link" href="index.html">Home <span class="sr-only">(current)</span></a> </li>
            <li class="nav-item"> <a class="nav-link" href="#">About us</a> </li>
            <li class="nav-item"> <a class="nav-link ">
          Membership
        </a> </li>
            <li class="nav-item"> <a class="nav-link " href="#">Contact us</a> </li>
          </ul>
          <form class="form-inline searchs "> <i class="fas fa-search"></i> </form>
          <a href="log-in.html">
            <button class="btn my-account" type="submit"><i class="fas fa-user"></i>My account</button>
          </a>
        </div>
      </nav>
    </div>
  </header>
  <!--header end-->
  <section class="product-listing mb-4">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
             <div class="gallery">
                <div class="image-preview">
            <img id="preview" src="images/4.jpg" />
          </div>
          <!-- Elastislide Carousel -->
          <ul id="carousel" class="elastislide-list">
            <li data-preview="images/img1.jpg"><a href="#"><img src="images/img1.jpg" alt="" /></a></li>
            <li data-preview="images/img2.jpg"><a href="#"><img src="images/img2.jpg" alt="" /></a></li>
            <li data-preview="images/img3.jpg"><a href="#"><img src="images/img3.jpg" alt="" /></a></li>
            <li data-preview="images/img4.jpg"><a href="#"><img src="images/img4.jpg" alt="" /></a></li>
            <li data-preview="images/img5.jpg"><a href="#"><img src="images/img5.jpg" alt="" /></a></li>            
          </ul>
          <!-- End Elastislide Carousel -->          
        </div>            
        </div>
        <div class="col-md-6">
           <div class="card-body pt-0">
              <h5 class="text-left">The Brave Little Crab</h5> 
              <h4>in stock</h4>
              <p>Duis bibendum tincidunt urna eget luctus. Duis vestibulum porta erat, sed egestas neque congue sed. Curabitur auctor rutrum erat, sit amet convallis purus posuere sit amet. Nullam velit orci, tempor nec pulvinar et, tempus sed lacus. Nullam aliquet dictum nunc quis molestie. Proin dapibus massa quis tristique ultricies. Mauris tempor diam eget tellus accumsan fermentum.</p>
              <div class="single-product-price">
                           <h2>$50.66</h2>
                           <small>&nbsp;&nbsp;&nbsp;<s>40% off</s></small>
              </div>   
              <div class="form-group">
              <label>Color:</label>
              <select class="form-control">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
              </select>
            </div>
            <div class="form-group">
              <label>Size:</label>
              <select class="form-control">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
              </select>
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
              <a href="#"><img src="images/pd1.jpg" alt="product-images"></a> 
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
              <a href="#"><img src="images/pd1.jpg" alt="product-images"></a> 
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
              <a href="#"><img src="images/pd1.jpg" alt="product-images"></a> 
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
              <a href="#"><img src="images/pd1.jpg" alt="product-images"></a> 
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
  <!-- book-list part end -->
  <!-- footer start -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <div class="logo"> <img src="images/scuba-logo.png"> </div>
        </div>
        <div class="col-md-4">
          <div class="foot-two">
            <h4>Contact Us</h4>
            <h5>16 Gibbs Hill Drive, Gloucester, MA. 01930</h5>
            <h6>berhcostanzo@hotmail.com</h6>
            <p>Call us at <span>+978-491-0747</span></p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="foot-three">
            <h4>Links</h4>
            <h5>© 2020adventuresofscubajack.com All rights reserved</h5>
            <li> Terms & Privacy Policy |
              <li>
                <li> Warranty-Promise | </li>
                <li> My Account</li>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-------------------------footer end-------------------------->
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script type="text/javascript" src="js/jquiry.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>
    <script>
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

  <script src="js/modernizr.custom.17475.js"></script>
  <script type="text/javascript" src="js/jquery.elastislide.js"></script>
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
</body>

</html>