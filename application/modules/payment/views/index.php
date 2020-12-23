<section class="book-list mb-4">
    <div class="container">
        <div class="breadcrumb">
            <?php if(count($breadcrumbs) > 0) {?>
                <?php foreach ($breadcrumbs as $breadcrumb) {?>
                    <li><a href="<?php echo $breadcrumb['href'];?>"><?php echo $breadcrumb['text'];?></a></li>
                <?php } ?>
            <?php } ?>
        </div>
        <div class="row">
        <div class='card-wrapper'></div>
            <div class="col-md-8">
                <div class="payment-method">
                    <h4>Payment Method</h4>
                    <div class="card-errors"></div>
                    <form id="paymentFrm" action="<?php echo url('/checkout/payment');?>" method="post">
                        <div class="gray-bg">
                            <div class="mb-3"><img src="<?php echo url('assets/images/card.png');?>" alt="" /></div>
                            <div class="form-group">
                                <label>Full Name</label>
                                <input name="name" id="cc-name" type="text" class="form-control" placeholder="Card Holder Name" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label>Card Number</label>
                                <input name="number" id="cc-number" type="text" class="form-control" placeholder="xxxx-xxxx-xxxx-xxxx" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label>Expiration Date</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" name="exp" id="cc-exp" placeholder="MM/YYYY" autocomplete="off" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" name="cvc" id="cc-cvc" placeholder="XXXX" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" id="payBtn" class="btn btn-info mt-4 w-100 payment-button">Pay Now</button>
                    </form>

                </div>
            </div>
             <div class="col-md-4">
                <div class="billing-details">
                    <h3>Order Summary</h3>
                    <table class="table table-bordered">
                        <tbody>
                        <?php if(count($products) > 0) {
                            foreach ($products as $product) { ?>
                                <tr>
                                    <td>
                                        <?php if($product['thumb']) { ?> <a href="<?php echo $product['href'];?>"><img src="<?php echo $product['thumb'];?>" alt="<?php echo $product['name'];?>" title="<?php echo $product['name'];?>"/></a> <?php } ?>
                                    </td>
                                    <td><?php echo $product['name'];?></td>
                                    <td>x&nbsp;<?php echo $product['quantity'];?></td>
                                    <td><?php echo $product['price'];?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                        <?php foreach ($totals as $key => $total) { ?>
                        <tr class="add-border">
                            <td></td>
                            <td colspan="2"><strong><?php echo $total['title'];?></strong></td>
                            <td><strong><?php echo $total['text'];?></strong></td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<script>
    var myLabel = {};
    myLabel.stripe_publishable_key = '<?php echo $this->config->item('stripe_publishable_key'); ?>';

</script>