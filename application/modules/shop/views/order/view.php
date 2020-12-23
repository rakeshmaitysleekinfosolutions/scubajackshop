<div class="content container-fluid">
    <div class="row">
        <div id="message"></div>
        <div class="col-sm-4 col-xs-3">
            <h4 class="page-title">Order Details</h4>
        </div>
        <div class="col-sm-8 text-right m-b-30">
            <a href="<?php echo $back;?>" class="btn btn-primary"><i class="fa fa-back"></i> Back</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-shopping-cart"></i> Order Details</h3>
                </div>
                <table class="table">
                    <tbody>
                    <tr>
                        <td><button data-toggle="tooltip" title="Order ID" class="btn btn-info btn-xs"><i class="fa fa-first-order fa-fw"></i></button></td>
                        <td><?php echo $uuid;?></td>
                    </tr>
                    <tr>
                        <td><button data-toggle="tooltip" title="Order Status" class="btn btn-info btn-xs"><i class="fa fa-bars fa-fw"></i></button></td>
                        <td>
                            <?php if(count($order_statuses) > 0) { ?>
                                <select class="form-control" id="status" name="status" data-order_id="<?php echo $order_id;?>">
                                    <?php foreach ($order_statuses as $status) { ?>
                                        <option <?php echo ($order_status_id == $status['id']) ? "selected" : "";?> value="<?php echo $status['id'];?>"><?php echo $status['name'];?></option>
                                    <?php } ?>
                                </select>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td><button data-toggle="tooltip" title="Order Date" class="btn btn-info btn-xs"><i class="fa fa-calendar fa-fw"></i></button></td>
                        <td><?php echo $created_at;?></td>
                    </tr>
                    <tr>
                        <td><button data-toggle="tooltip" title="Payment Method" class="btn btn-info btn-xs"><i class="fa fa-credit-card fa-fw"></i></button></td>
                        <td><?php echo $payment_method;?></td>
                    </tr>
                    <?php if ($shipping_method) { ?>
                    <tr>
                        <td><button data-toggle="tooltip" title="Shipping Method" class="btn btn-info btn-xs"><i class="fa fa-truck fa-fw"></i></button></td>
                        <td><?php echo $shipping_method;?></td>
                    </tr>
                    <?php } ?>
                    </tbody>

                </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-user"></i> Customer Details</h3>
                </div>
                <table class="table">
                    <tr>
                        <td style="width: 1%;"><button data-toggle="tooltip" title="Customer" class="btn btn-info btn-xs"><i class="fa fa-user fa-fw"></i></button></td>
                        <td><?php if ($customer) { ?>
                            <a href="{{ customer }}" target="_blank"><?php echo $firstname;?> <?php echo $lastname;?></a> <?php } else {?>
                                <?php echo $firstname;?> <?php echo $lastname;?>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td><button data-toggle="tooltip" title="E-Mail" class="btn btn-info btn-xs"><i class="fa fa-envelope-o fa-fw"></i></button></td>
                        <td><a href="mailto:<?php echo $email;?>"><?php echo $email;?></a></td>
                    </tr>
                    <tr>
                        <td><button data-toggle="tooltip" title="Phone" class="btn btn-info btn-xs"><i class="fa fa-phone fa-fw"></i></button></td>
                        <td><?php echo $phone;?></td>
                    </tr>
                    <tr>
                        <td><button data-toggle="tooltip" title="Gender" class="btn btn-info btn-xs"><i class="fa fa-user fa-fw"></i></button></td>
                        <td><?php echo $gender;?></td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-info-circle"></i>  Order (#<?php echo $uuid;?>)</h3>
        </div>
        <div class="panel-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <td style="width: 50%;" class="text-left">Payment Address</td>
                    <?php if ($shipping_method) {?>
                    <td style="width: 50%;" class="text-left">Shipping Address</td>
                    <?php } ?>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="text-left"><?php echo $payment_address;?></td>
                    <?php if ($shipping_method) {?>
                    <td class="text-left"><?php echo $shipping_address;?></td>
                    <?php } ?>
                </tbody>
            </table>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <td class="text-left">Product</td>
                    <td class="text-right">Quantity</td>
                    <td class="text-right">Price</td>
                    <td class="text-right">Total</td>
                </tr>
                </thead>
                <tbody>
                <?php if(count($products) > 0) {
                    foreach ($products as $product) {?>
                <tr>
                    <td class="text-left"><?php echo $product['name'];?>
                    <td class="text-right"><?php echo $product['quantity'];?></td>
                    <td class="text-right"><?php echo $product['price'];?></td>
                    <td class="text-right"><?php echo $product['total'];?></td>
                </tr>
                <?php } ?>
                <?php } ?>
                <?php if(count($totals) > 0) { ?>
                    <?php foreach ($totals as $total) { ?>
                    <tr>
                        <td colspan="3" class="text-right"><?php echo $total['title'];?></td>
                        <td class="text-right"><?php echo $total['text'];?></td>
                    </tr>
                    <?php } ?>
                <?php } ?>
                </tbody>

            </table>
    </div>

</div>
    <script>
        var myLabel             = myLabel || {};
        myLabel.baseUrl         = '<?php echo base_url();?>';
        myLabel.status          = '<?php echo url('shop/order/onClickStatusEventHandler');?>';
    </script>