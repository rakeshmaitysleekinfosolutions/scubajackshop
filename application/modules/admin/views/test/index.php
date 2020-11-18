<div class="content container-fluid">
	<div class="row">
        <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-heading bg-orange">Category Details</div>
            <div class="panel-body">
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
          </div>
        </div>
        <!-- Category Description -->
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading bg-orange">Category Details</div>
                <div class="panel-body">
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
                </div>
            </div>
        </div>
    </div>
</div>