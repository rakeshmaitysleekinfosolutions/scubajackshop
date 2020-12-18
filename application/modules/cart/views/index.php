<section class="book-list mb-4">
    <div class="container">
        <form id="<?php echo $form['name'];?>" name="<?php echo $form['name'];?>" action="<?php echo $form['action'];?>" method="post">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th></th>
                    <th>Image</th>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
                </thead>
                <tbody>
                <?php if(count($products) > 0) {
                    foreach ($products as $product) { ?>
                        <tr>
                            <td>
                                <button type="button" data-toggle="tooltip" title="Remove" class="btn btn-danger remove" id="<?php echo $product['cart_id'];?>"><i class="fa fa-times-circle "></i></button>
                            </td>
                            <td><?php if($product['thumb']) { ?> <a href="<?php echo $product['href'];?>"><img src="<?php echo $product['thumb'];?>" alt="<?php echo $product['name'];?>" title="<?php echo $product['name'];?>" class="img-thumbnail" /></a> <?php } ?></td>
                            <td class="text-left"><a href="<?php echo $product['href'];?>"><?php echo $product['name'];?></a><?php if(!$product['stock']) {?> <span class="text-danger">***</span> <?php } ?></td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button type="button" class="quantity-left-minus btn btn-number"  data-type="minus" data-field="" id="" data-cart_id="<?php echo $product['cart_id'];?>">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </span>
                                    <input type="text" name="quantity[<?php echo $product['cart_id'];?>]" id="quantity_<?php echo $product['cart_id'];?>" value="<?php echo $product['quantity'];?>" size="1" class="form-control input-number" min="1" max="100">
                                    <span class="input-group-btn">
                                    <button type="button" class="quantity-right-plus btn btn-number" data-type="plus" data-field="" id="" data-cart_id="<?php echo $product['cart_id'];?>">
                                        <i class="fas fa-plus"></i>
                                    </button>

                                </span>
                                </div>
                            </td>
                            <td class="text-right"><?php echo $product['price'];?></td>
                            <td class="text-right"><?php echo $product['total'];?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>

                <tr>
                    <td colspan="5">
                        <!--                    <div class="coupon">-->
                        <!--                        <label for="coupon_code">Coupon:</label>-->
                        <!--                        <input type="text" name="coupon_code" class="form-control" id="coupon_code" value="" placeholder="Coupon code">-->
                        <!--                        <button type="submit" class="btn btn-primary" name="apply_coupon" value="Apply coupon">-->
                        <!--                            Apply coupon-->
                        <!--                        </button>-->
                        <!--                    </div>-->
                    </td>
                    <td>
<!--                        <button type="submit" class="btn btn-primary update-cart">-->
<!--                            <i class="fas fa-sync"></i> Update Cart-->
<!--                        </button>-->
                        <div class="text-center">
                            <button type="submit" class="btn btn-info mt-4 continue_btn update-cart"><i class="fas fa-sync"></i> Update Cart</button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
        <div class="cart-totals">
            <h2>Cart totals</h2>
            <table class="table table-bordered">
                <tbody>
                <?php
                foreach ($totals as $key => $total) { ?>
                    <tr>
                        <td><strong><?php echo $total['title'];?></strong></td>
                        <td><?php echo $total['text'];?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <?php if($logged) { ?>
            <div class="text-center">
                <a href="<?php echo url('/checkout');?>" class="checkout-button btn btn-info mt-4 continue_btn">
                    Proceed to checkout
                </a>
            </div>
        <?php } else { ?>
            <div class="text-left">
                <a href="<?php echo url('/login');?>" class="checkout-button btn btn-info mt-4 continue_btn">
                    Proceed to checkout
                </a>
            </div>
        <?php } ?>

    </div>
</section>

<script>
    var myLabel = myLabel || {};
    myLabel.baseUrl          = '<?php echo url();?>';
    myLabel.remove           = '<?php echo url('cart/remove');?>';
    myLabel.coupon           = '<?php echo url('cart/coupon');?>';
</script>