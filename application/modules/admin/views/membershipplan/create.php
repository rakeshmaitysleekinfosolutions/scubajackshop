<div class="content container-fluid">
    <form id="frm" action="<?php echo admin_url('membershipplan/store');?>" method="post">
        <input type="hidden" name="duration" id="input-duration">
        <div class="row">
            <?php if($error_warning) { ?>
                <div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i><?php echo $error_warning;?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php } ?>
            <?php if(hasMessage('message')) { ?>
                <div class="alert alert-success alert-dismissible"><i class="fa fa-exclamation-circle"></i><?php echo getMessage('message');?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php } ?>
        </div>
        <div class="row">
            <p>(A) frequency=MONTH + frequency_interval=2 + cycles=3 + amount={10 USD} -> subscriber will be charged 3 times every second month for 10 USD each time (3x10usd payments within 6 months)</p>
            <span> If your customers signup on JAN means, according to your value set, first payment will done on JAN, second on MAR, third on JUN for 10 USD per month</span>

            <p>(B) frequency=YEAR + frequency_interval=1 + cycles=1 + amount={100 USD} -> subscriber will be charged 1 time for 100 USD in the moment of subscription creation (100usd payment for 1 year)</p>
            <span> If your customer signup on JAN, first payment will done on JAN and for the whole year it will be 100 USD.</span>
            <div class="col-sm-8">
                <h4 class="page-title">Add Membership Plan</h4>
            </div>
            <div class="col-sm-4 text-right m-b-30">
                <button type="submit" class="btn btn-primary rounded"><i class="fa fa-save"></i> Save</button>
                <a href="<?php echo $back;?>" class="btn btn-primary rounded"><i class="fa fa-back"></i> Back</a>
            </div>
        </div>
        <div class="card-box">
            <h3 class="card-title">Membership Plan</h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="profile-view">
                        <div class="">
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label">Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="name" id="input-name" autocomplete="off" value="<?php echo $name;?>" required>
                                    <?php if($error_name) { ?>
                                        <div class="text-danger"><?php  echo $error_name;?></div>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control" type="text" name="description" id="input-description" autocomplete="off" required><?php echo $description;?></textarea>
                                </div>
<!--                                frequency-->
<!--                                frequency_interval-->
<!--                                cycles-->


                                <div class="form-group">
                                    <label class="control-label">Type <span class="text-danger"></span></label>
                                    <select name="type" class="select floating" id="input-type" >
                                        <option value="REGULAR" selected>REGULAR</option>
                                        <option value="TRIAL" >TRIAL</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Frequency <span class="text-danger"></span></label>
                                    <select name="frequency" class="select floating" id="input-frequency" >
<!--                                        <option value="WEEK">WEEK</option>-->
<!--                                        <option value="DAY">DAY</option>-->
<!--                                        <option value="YEAR">YEAR</option>-->
                                        <option value="MONTH" selected>MONTH</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Frequency Interval <span class="text-danger"></span></label>
                                    <select name="frequency_interval" class="select floating" id="input-frequency_interval" >
                                        <?php
                                        for ($i = 1; $i <= 12; $i++) {?>
                                            <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Cycles <span class="text-danger"></span></label>
                                    <select name="cycles" class="select floating" id="input-cycles" >
                                        <?php
                                        for ($i = 1; $i <= 3; $i++) {?>
                                            <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">State <span class="text-danger"></span></label>
                                    <select name="state" class="select floating" id="input-state" >
                                       <option value="ACTIVE">ACTIVE</option>
                                        <option value="INACTIVE">INACTIVE</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Price <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="price" id="input-price" autocomplete="off" value="<?php echo $price;?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    var myLabel = myLabel || {};
    myLabel.baseUrl = '<?php echo base_url();?>';
</script>