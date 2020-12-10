<section class="book-list mb-4">
    <div class="container">
        <?php if(count($breadcrumbs) > 0) {?>
            <?php foreach ($breadcrumbs as $breadcrumb) {?>
                <li><a href="<?php echo $breadcrumb['href'];?>"><?php echo $breadcrumb['text'];?></a></li>
            <?php } ?>
        <?php } ?>
        <div class="row">
            <div class="col-md-8">
                <div class="payment-method">
                    <h4>Payment Method</h4>
                    <form id="frm-payment" action="" method="post">
                        <div class="gray-bg">
                            <div class="mb-3"><img src="<?php echo url('assets/images/card.png');?>" alt="" /></div>
                            <div class="form-group">
                                <label>Card Number</label>
                                <input name="card_number" type="text" class="form-control" placeholder="xxxx-xxxx-xxxx-xxxx" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label>Expiration Date</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <select name="exp_month" class="form-control" autocomplete="off" required>
                                            <option value="">--Month--</option>
                                            <?php for($i = 1; $i <= 12; $i++) { ?>
                                                <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <select name="exp_year" class="form-control" autocomplete="off" required>
                                            <?php for($i = 0; $i <= $years; $i++) { ?>
                                                <option value="<?php echo $years[$i];?>"><?php echo $years[$i];?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>CVC*</label>
                                <input name="cvv" type="text" class="form-control col-md-6" autocomplete="off" required>
                                <span class="question"><i class="far fa-question-circle"></i></span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-info mt-4 w-100">Confirm Order</button>
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