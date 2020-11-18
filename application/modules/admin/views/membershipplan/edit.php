<div class="content container-fluid">
    <form id="frm" action="<?php echo admin_url('membershipplan/update/'.$primaryKey);?>" method="post">
        <input type="hidden" name="duration" id="input-duration" value="<?php echo $duration;?>">
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
            <div class="col-sm-8">
                <h4 class="page-title">Edit Membership Plan</h4>
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
                                    <input  class="form-control" type="text" name="name" id="input-name" autocomplete="off" value="<?php echo $name;?>" required></input>
                                    <?php if($error_name) { ?>
                                        <div class="text-danger"><?php  echo $error_name;?></div>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Description <span class="text-danger"></span></label>
                                    <textarea class="form-control" type="text" name="description" id="input-description" autocomplete="off" ><?php echo $description;?></textarea>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Type <span class="text-danger"></span></label>
                                    <select name="type" class="select floating" id="input-type" >
                                        <option value="REGULAR" <?php echo ($type == 'REGULAR') ? "selected" : "";?>>REGULAR</option>
                                        <option value="TRIAL" <?php echo ($type == 'TRIAL') ? "selected" : "";?>>TRIAL</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Frequency <span class="text-danger"></span></label>
                                    <select name="frequency" class="select floating" id="input-frequency" >
                                        <!--                                        <option value="WEEK">WEEK</option>-->
                                        <!--                                        <option value="DAY">DAY</option>-->
<!--                                        <option value="YEAR" --><?php //echo ($type == 'YEAR') ? "selected" : "";?><!-->YEAR</option>-->
                                        <option value="MONTH" <?php echo ($type == 'MONTH') ? "selected" : "";?>>MONTH</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Frequency Interval <span class="text-danger"></span></label>
                                    <select name="frequency_interval" class="select floating" id="input-frequency_interval" >
                                        <?php
                                        for ($i = 1; $i <= 12; $i++) {?>
                                            <option value="<?php echo $i;?>" <?php echo ($frequency_interval == $i) ? "selected" : "";?>><?php echo $i;?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Cycles <span class="text-danger"></span></label>
                                    <select name="cycles" class="select floating" id="input-cycles" >
                                        <?php
                                        for ($i = 1; $i <= 3; $i++) {?>
                                            <option value="<?php echo $i;?>" <?php echo ($cycles == $i) ? "selected" : "";?>><?php echo $i;?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">State <span class="text-danger"></span></label>
                                    <select name="state" class="select floating" id="input-state" >
                                        <option value="ACTIVE" <?php echo ($state == 'ACTIVE') ? "selected" : "";?>>ACTIVE</option>
                                        <option value="INACTIVE" <?php echo ($state == 'INACTIVE') ? "selected" : "";?>>INACTIVE</option>
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