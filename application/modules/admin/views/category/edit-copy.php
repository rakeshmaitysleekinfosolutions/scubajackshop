
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
    <form id="frmSignUp" action="<?php echo admin_url('category/update');?>" method="post">
        <input type="hidden" name="categoryId" value="<?php echo $categoryId;?>">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <h3 class="page-title">Category Details</h3>
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Name <span class="text-danger">*</span></label>
                            <input value="<?php echo $name;?>" class="form-control" type="text" name="name" id="input-payment-firstname" autocomplete="off" >
                            <?php if($error_name) { ?>
                                <div class="text-danger"><?php  echo $error_name;?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Slug <span class="text-danger"></span></label>
                            <input value="<?php echo $slug;?>" class="form-control" type="text" name="slug" id="input-payment-lastname" autocomplete="off" >
                            <?php if($error_slug) { ?>
                                <div class="text-danger"><?php  echo $error_slug;?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Upload Image</label>

                            <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb;?>" alt="" title="" data-placeholder="<?php echo $placeholder;?>"/></a>
                            <input type="hidden" name="image" value="<?php echo $image;?>" id="input-image"/>
                            <?php if($error_image) { ?>
                                <div class="text-danger"><?php  echo $error_image;?></div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="select floating" id="input-payment-status" >
                                <option value="" selected>Select option</option>
                                <option value="0" <?php echo ($status == 0) ? 'selected' : '';?>>Inactive</option>
                                <option value="1" <?php echo ($status == 1) ? 'selected' : '';?>>Active</option>
                            </select>
                            <?php if($error_status) { ?>
                                <div class="text-danger"><?php echo $error_status;?></div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <h3 class="page-sub-title">Category Description</h3>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="4" cols="5" class="form-control summernote" placeholder="Enter your message here"><?php echo $description;?></textarea>
                </div>
                <div class="form-group">
                    <label class="control-label">Meta Title <span class="text-danger">*</span></label>
                    <input value="<?php echo $meta_title;?>" name="meta_title" type="text" class="form-control" placeholder="Enter your message here">
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
    myLabel.filemanager = '<?php echo admin_url('filemanager');?>';
</script>