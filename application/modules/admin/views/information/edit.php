<div class="content container-fluid">
    <form id="frm" action="<?php echo admin_url('information/update/'.$primaryKey);?>" method="post">

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
                <h4 class="page-title">Edit Information</h4>
            </div>
            <div class="col-sm-4 text-right m-b-30">
                <button type="submit" class="btn btn-primary rounded"><i class="fa fa-save"></i> Save</button>
                <a href="<?php echo $back;?>" class="btn btn-primary rounded"><i class="fa fa-back"></i> Back</a>
            </div>
        </div>
        <div class="row">


            <div class="col-md-8">
                <div class="card-box">
                    <h3 class="card-title">Information</h3>
                    <div class="experience-box">
                        <div class="form-group">
                            <label class="control-label">Title <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="title" id="input-title" autocomplete="off" value="<?php echo $title;?>" required>
                            <?php if($error_title) { ?>
                                <div class="text-danger"><?php  echo $error_title;?></div>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Heading <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="heading" id="input-heading" autocomplete="off" value="<?php echo $heading;?>" required>
                            <?php if($error_heading) { ?>
                                <div class="text-danger"><?php  echo $error_heading;?></div>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Slug <span class="text-danger"></span></label>
                            <input value="<?php echo $slug;?>" class="form-control" type="text" name="slug" id="input-payment-lastname" autocomplete="off" >
                        </div>


                        <div class="form-group">
                            <label class="control-label">Body <span class="text-danger"></span></label>
                            <textarea class="form-control summernote" type="text" name="body" id="input-body" autocomplete="off" ><?php echo $body;?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="select floating" id="input-status" >
                                <option value="0" <?php echo ($status == 0) ? 'selected' : '';?>>Inactive</option>
                                <option value="1" <?php echo ($status == 1) ? 'selected' : '';?>>Active</option>
                            </select>

                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-4">
                <div class="card-box pdf">
                    <h3 class="card-title">Meta Data</h3>
                    <div class="skills">
                        <div class="form-group">
                            <label class="control-label">Meta Title <span class="text-danger">*</span></label>
                            <input value="<?php echo $meta_title;?>" id="input-metaTitle" name="meta_title" type="text" class="form-control" placeholder="Enter your message here" >
                            <?php if($error_meta_title) { ?>
                                <div class="text-danger"><?php echo $error_meta_title;?></div>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label>Meta keyword</label>
                            <textarea name="meta_keyword" rows="2" cols="5" class="form-control " placeholder="Enter your message here"><?php echo $meta_keyword;?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Meta Description</label>
                            <textarea name="meta_description" rows="2" cols="5" class="form-control " placeholder="Enter your message here"><?php echo $meta_description;?></textarea>
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