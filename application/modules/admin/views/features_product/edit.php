<div class="content container-fluid">
    <form id="frm" action="<?php echo admin_url('features_product/update');?>" method="post">
        <input type="hidden" name="featuresProductId" value="<?php echo $featuresProductId;?>">
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
                    <h3 class="card-title">Features Product</h3>
                    <div class="experience-box">
                        <div class="form-group">
                            <label class="control-label">Product <span class="text-danger">*</span></label>
                            <select name="featuresProduct[]" class="select floating" id="input-product" multiple >

                                <?php if(!empty($products)) {
                                    foreach ($products as $product) {?>
                                        <option value="<?php echo $product->id;?>" <?php echo  ($product->id == $featuresProduct) ? "selected" : ""?>><?php echo $product->name;?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <?php if($error_product) { ?>
                                <div class="text-danger"><?php echo $error_product;?></div>
                            <?php } ?>
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