<div class="content container-fluid">
    <form id="frm" action="<?php echo admin_url('continent/update/'.$primaryKey);?>" method="post">

        <div class="row">
            <?php if(hasMessage('message')) { ?>
                <div class="alert alert-success alert-dismissible"><i class="fa fa-exclamation-circle"></i><?php echo getMessage('message');?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <h4 class="page-title">Edit Features Product</h4>
            </div>
            <div class="col-sm-4 text-right m-b-30">
                <button type="submit" class="btn btn-primary rounded"><i class="fa fa-save"></i> Save</button>
                <a href="<?php echo $back;?>" class="btn btn-primary rounded"><i class="fa fa-back"></i> Back</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card-box">
                    <h3 class="card-title">Country</h3>
                    <div class="experience-box">
                        <div class="form-group">
                            <label class="control-label">Country <span class="text-danger">*</span></label>
                            <select name="continents[]" class="select floating" id="input-continents" multiple >

                                <?php if(!empty($countries)) {
                                    foreach ($countries as $country) {?>
                                        <option value="<?php echo $country->id;?>" <?php echo  ($country->id == $continents) ? "selected" : ""?>><?php echo $country->name;?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </form>
</div>

<script>
    var myLabel = myLabel || {};
    myLabel.baseUrl = '<?php echo base_url();?>';
    myLabel.filemanager = '<?php echo admin_url('filemanager');?>';
</script>