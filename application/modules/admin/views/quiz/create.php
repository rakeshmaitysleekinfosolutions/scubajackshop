<?php
//dd($_SESSION);
?>
<div class="content container-fluid" id="my-container">
    <form id="frm" action="<?php echo admin_url('quiz/store');?>" method="post">
        <input type="hidden" name="id" value="<?php echo $id;?>">
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
                <!--                <h4 class="page-title">Add Features Product</h4>-->
            </div>

            <div class="col-sm-4 text-right m-b-30">
                <button type="submit" class="btn btn-primary rounded"><i class="fa fa-save"></i> Save</button>
                <a href="<?php echo (isset($back)) ? $back : '';?>" class="btn btn-primary rounded"><i class="fa fa-back"></i> Back</a>
            </div>
        </div>
        <div class="row">

            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card-box">
                    <h3 class="card-title">Add Quiz</h3>
                    <div class="experience-box">
                        <div class="form-group">
                            <label class="control-label">Name <span class="text-danger">*</span></label>
                            <input value="<?php echo $name;?>" class="form-control" type="text" name="name" id="input-name" autocomplete="off" >
                            <?php if($error_name) { ?>
                                <div class="text-danger"><?php  echo $error_name;?></div>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Slug <span class="text-danger"></span></label>
                            <input value="<?php echo $slug;?>" class="form-control" type="text" name="slug" id="input-payment-lastname" autocomplete="off" >
                            <?php if($error_slug) { ?>
                                <div class="text-danger"><?php  echo $error_slug;?></div>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="select floating" id="input-status" >
                                <option value="0" <?php echo ($status == 0) ? 'selected' : '';?>>Inactive</option>
                                <option value="1" <?php echo ($status == 1) ? 'selected' : '';?>>Active</option>
                            </select>
                            <?php if($error_status) { ?>
                                <div class="text-danger"><?php echo $error_status;?></div>
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

</script>