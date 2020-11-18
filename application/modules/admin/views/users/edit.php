
<div class="content container-fluid">
    <div class="row">
        <div class="col-sm-4 col-xs-3">
            <h4 class="page-title"></h4>
        </div>
        <div class="col-sm-8 col-xs-9 text-right m-b-20">
            <a href="<?php echo $back;?>" class="btn btn-primary rounded pull-right"><i class="fa fa-back"></i> Back</a>
            <!-- <div class="view-icons">
                <a href="clients.html" class="grid-view btn btn-link"><i class="fa fa-th"></i></a>
                <a href="clients-list.html" class="list-view btn btn-link active"><i class="fa fa-bars"></i></a>
            </div> -->
        </div>
    </div>
    <form id="frmSignUp" action="<?php echo admin_url('users/update');?>" method="post">
        <input type="hidden" name="id" value="<?php echo $id;?>">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                    <h3 class="page-title">Personal Details</h3>
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
                <div class="row">
                    <div class="col-sm-3 col-lg-3">
                        <div class="form-group">

                            <a href="javascript:void(0);" id="thumb-image" data-toggle="image" class="" type="image"><img src="<?php echo $thumb;?>" alt="" title="" data-placeholder="<?php echo $placeholder;?>"/></a>
                            <input type="hidden" name="logo" value="<?php echo $logo;?>" id="input-image" />
                        </div>
                    </div>
                </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">First Name <span class="text-danger">*</span></label>
                                <input value="<?php echo $firstname;?>" class="form-control" type="text" name="firstname" id="input-payment-firstname" autocomplete="off" >
                                <?php if($error_firstname) { ?>
                                    <div class="text-danger"><?php  echo $error_firstname;?></div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Last Name <span class="text-danger">*</span></label>
                                <input value="<?php echo $lastname;?>" class="form-control" type="text" name="lastname" id="input-payment-lastname" autocomplete="off" >
                                <?php if($error_lastname) { ?>
                                    <div class="text-danger"><?php echo $error_lastname;?></div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Email <span class="text-danger">*</span></label>
                                <input value="<?php echo $email;?>" class="form-control floating" type="email" name="email" id="input-payment-email" autocomplete="off" >
                                <?php if($error_email) { ?>
                                    <div class="text-danger"><?php echo $error_email;?></div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Password <span class="text-danger">*</span></label>
                                    <input class="form-control floating" type="password" name="password" id="input-password" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Confirm Password <span class="text-danger">*</span></label>
                                    <input class="form-control floating" type="password" name="confirm" id="input-confirm" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Phone <span class="text-danger"></span></label>
                                <input class="form-control floating" type="text" name="phone" id="input-payment-phone" autocomplete="off" value="<?php echo $phone;?>" >

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Password <span class="text-danger">*</span></label>
                                <input value="<?php echo $password;?>" class="form-control floating" type="password" name="password" id="input-payment-password" autocomplete="off" >
                                <?php if($error_password) { ?>
                                    <div class="text-danger"><?php echo $error_password;?></div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Confirm Password <span class="text-danger">*</span></label>
                                <input value="<?php echo $confirm;?>" class="form-control floating" type="password" name="confirm" id="input-payment-confirm" autocomplete="off" >
                                <?php if($error_confirm) { ?>
                                    <div class="text-danger"><?php echo $error_confirm;?></div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="select floating" id="input-payment-status" >
                                    <option value="">Select option</option>
                                    <option value="0" <?php echo ($status == 0) ? 'selected' : '';?>>Inactive</option>
                                    <option value="1" <?php echo ($status == 1) ? 'selected' : '';?>>Active</option>
                                </select>
                                <?php if($error_status) { ?>
                                    <div class="text-danger"><?php echo $error_status;?></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <h3 class="page-sub-title">Address Details</h3>
                <input type="hidden" name="name="address[0][address_id]"" value="<?php echo $address_id;?>">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Contry <span class="text-danger"></span></label>
                                <select name="address[0][country_id]"  class="select floating" id="country_id" >
                                    <option value="">Select option</option>
                                    <?php if($countries) {
                                        foreach ($countries as $country) {?>
                                            <option <?php echo ($country['id'] == $country_id) ? "selected" : "";?> value="<?php echo $country->id;?>"><?php echo $country->name;?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">State <span class="text-danger"></span></label>
                                <select name="address[0][state_id]"   class="select floating" id="input-payment-state" >
                                    <option value="">Select option</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Address 1 <span class="text-danger"></span></label>
                                <input name="address[0][address_1]" value="<?php echo $address_1;?>" class="form-control floating" type="text" name="address_1" id="input-payment-address_1" autocomplete="off" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Address 2 <span class="text-danger"></span></label>
                                <input name="address[0][address_2]" value="<?php echo $address_2;?>" class="form-control floating" type="text" name="address_2" id="input-payment-address_2" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">City <span class="text-danger"></span></label>
                                <input name="address[0][city]" value="<?php echo $city;?>" class="form-control floating" type="text" name="city" id="input-payment-city" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">PostCode <span class="text-danger"></span></label>
                                <input name="address[0][postcode]" value="<?php echo $postcode;?>" class="form-control floating" type="text" name="postcode" id="input-payment-postcode" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-sm-12 m-t-20">
                                <button type="submit" name="submit" class="btn btn-primary">Save &amp; update</button>
                                <a href="<?php echo $back;?>" class="btn btn-primary">Cancel</a>
                            </div>
                        </div>


            </div>
        </div>
    </form>
</div>
<script>
    var myLabel = myLabel || {};
    myLabel.baseUrl = '<?php echo base_url();?>';
    myLabel.states  = '<?php echo admin_url('users/states');?>';
    myLabel.state_id  = '<?php echo $state_id;?>';
   // console.log(myLabel.state_id);
</script>