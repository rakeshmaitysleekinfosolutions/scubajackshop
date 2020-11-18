<div class="content container-fluid">
    <form id="frm" action="<?php echo admin_url('map/update/'.$primaryKey);?>" method="post">

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
                <h4 class="page-title">Edit Map</h4>
            </div>
            <div class="col-sm-4 text-right m-b-30">
                <button type="submit" class="btn btn-primary rounded"><i class="fa fa-save"></i> Save</button>
                <a href="<?php echo $back;?>" class="btn btn-primary rounded"><i class="fa fa-back"></i> Back</a>
            </div>
        </div>
        <div class="card-box">
            <h3 class="card-title">Manipulate world map data</h3>
            <div class="row">
                <div class="col-md-12">
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label">Country <span class="text-danger"></span></label>
                                    <select name="country_id" class="select floating" id="input-quiz" >
                                        <?php if(isset($countries)) {
                                            foreach ($countries as $country) {?>
                                                <option <?php echo ($country_id == $country->id) ? "selected" : "";?> value="<?php echo $country->id;?>"><?php echo $country->name;?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Data <span class="text-danger">*</span></label>
                                    <textarea rows="8" class="form-control" type="text" name="path_d" id="input-path_d" autocomplete="off" ><?php echo $path_d;?></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Status <span class="text-danger"></span></label>
                                    <select name="status" class="select floating" id="input-status" >
                                        <option value="0" <?php echo ($status == 0) ? 'selected' : '';?>>Inactive</option>
                                        <option value="1" <?php echo ($status == 1) ? 'selected' : '';?>>Active</option>
                                    </select>
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