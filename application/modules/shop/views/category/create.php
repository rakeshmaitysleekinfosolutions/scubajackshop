<div class="content container-fluid">
    <form id="<?php echo $form['id'];?>" action="<?php echo $route;?>" method="post">
        <div class="row">
            <?php if(hasMessage('message')) { ?>
                <div class="alert alert-info alert-dismissible"><i class="fa fa-exclamation-circle"></i>&nbsp;<?php echo getMessage('message');?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php } ?>
            <div class="col-sm-4 col-xs-3">
                <h4 class="page-title"><?php echo $heading;?></h4>
            </div>
            <div class="col-sm-8 text-right m-b-30">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                <a href="<?php echo $back;?>" class="btn btn-primary"><i class="fa fa-back"></i> Back</a>
            </div>
        </div>
        <div class="card-box">
            <h3 class="card-title"><?php echo $title;?></h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="profile-view">
                        <div class="profile-img-wrap">
                            <div class="profile-img">
                                <a href="javascript:void(0);" type="image" href="" id="thumb-image" data-toggle="image"><img src="<?php echo $thumb;?>" alt="" title="" data-placeholder="<?php echo $placeholder;?>"/></a>
                                <input type="hidden" name="image" value="<?php echo $image;?>" id="input-image"/>
                            </div>
                        </div>

                        <div class="profile-basic">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo $entryName;?> <span class="text-danger">*</span></label>
                                        <input value="<?php echo $name;?>" placeholder="<?php echo $entryName;?>" class="form-control" type="text" name="name" id="input-name" autocomplete="off" required>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo $entrySlug; ?> <span class="text-danger"></span></label>
                                        <input value="<?php echo $slug;?>" placeholder="<?php echo $entrySlug; ?>" class="form-control" type="text" name="slug" id="input-slug" autocomplete="off" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Status <span class="text-danger">*</span></label>
                                        <select name="status" class="form-control floating" id="input-payment-status" >
                                            <option value="0" <?php echo ($status == 0) ? 'selected' : '';?>>Inactive</option>
                                            <option value="1" <?php echo ($status == 1) ? 'selected' : '';?>>Active</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Sort Order <span class="text-danger">*</span></label>
                                        <input value="<?php echo $sort_order;?>" class="form-control" type="text" name="sort_order" id="input-ortOrder" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Parent Category <span class="text-danger"></span></label>
                                        <select name="parent_id" class="select floating" id="input-parent_id">
                                            <option value=""></option>
                                            <?php if(count($category) > 0) {?>
                                                <?php foreach ($category as $cat) {
                                                    if($cat->id != $id) {
                                                    ?>
                                                    <option value="<?php echo $cat->id;?>"><?php echo $cat->name;?></option>
                                                <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
        <div class="col-md-3">
            <div class="card-box m-b-0">
                <h3 class="card-title">Meta Data</h3>
                <div class="skills">
                    <div class="form-group">
                        <label class="control-label">Meta Title <span class="text-danger">*</span></label>
                        <input value="<?php echo $meta_title;?>" name="meta_title" type="text" class="form-control" placeholder="Enter your message here">
                    </div>
                    <div class="form-group">
                        <label>Meta keyword</label>
                        <textarea name="meta_keywords" rows="2" cols="5" class="form-control " placeholder="Enter your message here"><?php echo $meta_keywords;?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Meta Description</label>
                        <textarea name="meta_description" rows="2" cols="5" class="form-control " placeholder="Enter your message here"><?php echo $meta_description;?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card-box">
                <h3 class="card-title">Category Description</h3>
                <div class="experience-box">
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" rows="4" cols="5" class="form-control summernote" placeholder="Enter your message here"><?php echo $description;?></textarea>
                    </div>

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