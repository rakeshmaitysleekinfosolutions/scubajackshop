<section class="book-list mb-4">
    <div class="container">
        <?php if(count($breadcrumbs) > 0) {?>
            <?php foreach ($breadcrumbs as $breadcrumb) {?>
                <li><a href="<?php echo $breadcrumb['href'];?>"><?php echo $breadcrumb['text'];?></a></li>
            <?php } ?>
        <?php } ?>
        <div class="row">
                <div class="col-md-8">
                    <form id="billing-address" action="<?php echo url('checkout/save-payment-address');?>" method="post">
                    <div class="billing-details">
                        <h2>Billing Details</h2>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input name="payment_address[firstname]" value="<?php echo (isset($payment_address['firstname'])) ? $payment_address['firstname'] : '';?>" type="text" class="form-control" placeholder="First Name" autocomplete="off" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input name="payment_address[lastname]" value="<?php echo (isset($payment_address['lastname'])) ? $payment_address['lastname'] : '';?>" type="text" class="form-control" placeholder="Last Name" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input name="payment_address[address_1]" value="<?php echo (isset($payment_address['address_1'])) ? $payment_address['address_1'] : '';?>" type="text" class="form-control" placeholder="Address 1" autocomplete="off" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input name="payment_address[address_2]" value="<?php echo (isset($payment_address['address_2'])) ? $payment_address['address_2'] : '';?>" type="text" class="form-control" placeholder="Address 2(optional)" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select class="select form-control" name="payment_address[country_id]" autocomplete="off" required>
                                                <option value="">select country</option>
                                                <?php if(count($countries)) {
                                                    foreach ($countries as $country) {
                                                        $selected = '';
                                                        if($payment_address['country_id'] == $country->id){
                                                            $selected = 'selected';
                                                        }
                                                        ?>
                                                        <option value="<?php echo $country->id;?>" <?php echo $selected;?>><?php echo $country->name;?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <select class="select form-control" name="payment_address[state_id]" autocomplete="off" required>
                                            <option value="">select state</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input name="payment_address[city]" value="<?php echo (isset($payment_address['city'])) ? $payment_address['city'] : '';?>" type="text" class="form-control" placeholder="City" autocomplete="off" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input name="payment_address[postcode]" value="<?php echo (isset($payment_address['postcode'])) ? $payment_address['postcode'] : '';?>" type="text" class="form-control" placeholder="Post Code" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>

                        <div class="form-check mb-5">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" id="ship-different-address-chkbox" <?php echo ($shipping) ? 'checked' : '';?>><p>Ship to different address?</p>
                            </label>
                        </div>
                    </div>
                    <div class="cart-totals mt-4" id="shiiping-address" style="<?php echo ($shipping) ? 'display:block' : 'display:none';?>">
                        <h2>Shipping Details</h2>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <input name="shipping_address[firstname]" value="<?php echo (isset($shipping_address['firstname'])) ? $shipping_address['firstname'] : '';?>" id="shipping_address[firstname]" type="text" class="form-control" placeholder="First Name">
                                </div>
                                <div class="col-md-6">
                                    <input name="shipping_address[lastname]" value="<?php echo (isset($shipping_address['lastname'])) ? $shipping_address['lastname'] : '';?>" type="text" class="form-control" placeholder="Last Name">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <input name="shipping_address[address_1]" value="<?php echo (isset($shipping_address['address_1'])) ? $shipping_address['address_1'] : '';?>" type="text" class="form-control" placeholder="Address 1">
                                </div>
                                <div class="col-md-6">
                                    <input name="shipping_address[address_2]" value="<?php echo (isset($shipping_address['address_2'])) ? $shipping_address['address_2'] : '';?>" type="text" class="form-control" placeholder="Address 2(optional)">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="select form-control" name="shipping_address[country_id]">
                                            <option value="">select country</option>
                                            <?php if(count($countries)) {
                                                foreach ($countries as $country) {
                                                    $selected = '';
                                                        if($shipping_address['country_id'] == $country->id){
                                                            $selected = 'selected';
                                                        }
                                                    ?>
                                                    <option value="<?php echo $country->id;?>" <?php echo $selected;?>><?php echo $country->name;?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <select class="select form-control" name="shipping_address[state_id]">
                                        <option value="">select state</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input name="shipping_address[city]" value="<?php echo (isset($shipping_address['city'])) ? $shipping_address['city'] : '';?>" type="text" class="form-control" placeholder="City">
                                    </div>
                                    <div class="col-md-6">
                                        <input name="shipping_address[postcode]" value="<?php echo (isset($shipping_address['postcode'])) ? $shipping_address['postcode'] : '';?>" type="text" class="form-control" placeholder="Post Code">
                                    </div>
                                </div>
                            </div>
                    </div>
                    <button type="submit" class="btn btn-info mt-4 w-100" id="submit-payment-address-btn">Continue</button>
                    </form>
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
</section>
<script>
    var myLabel = myLabel || {};
    myLabel.baseUrl          = '<?php echo url();?>';
    myLabel.states           = '<?php echo url('states');?>';
</script>