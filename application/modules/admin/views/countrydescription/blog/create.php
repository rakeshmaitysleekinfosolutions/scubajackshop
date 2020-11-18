<div class="content container-fluid">
    <form id="frm" action="<?php echo $saveBlogUrl;?>" method="post">
        <div class="row">
            <?php if(hasMessage('message')) { ?>
                <div class="alert alert-success alert-dismissible"><i class="fa fa-exclamation-circle"></i><?php echo getMessage('message');?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <h4 class="page-title">Add Field Trip Content</h4>
            </div>

            <div class="col-sm-4 text-right m-b-30">
                <button type="submit" class="btn btn-primary rounded"><i class="fa fa-save"></i> Save</button>
                <a href="<?php echo $backBlogUrl;?>" class="btn btn-primary rounded"><i class="fa fa-back"></i> Back</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                <h3 class="card-title">Blog Description</h3>
                <div class="experience-box">
                    <div class="form-group">
                        <label class="control-label">Title <span class="text-danger">*</span></label>
                        <input value="<?php echo $title;?>" id="input-title" name="title" type="text" class="form-control" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label>Small Description</label>
                        <textarea name="smallDescription" minlength="50" maxlength="200" rows="4" cols="5" class="form-control" placeholder="" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Full Description</label>
                        <textarea name="description" rows="4" cols="5" class="form-control summernote" placeholder="Enter your message here" required><?php echo $description;?></textarea>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <td class="text-left">Blog Primary Image</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="text-left">
                                    <a href="javascript:void(0);"  type="image" id="thumb-image" data-toggle="image" class="img-thumbnail">
                                        <img src="<?php echo $thumb;?>" alt="" title="" data-placeholder="<?php echo $placeholder;?>"/>
                                    </a>
                                    <input type="hidden" name="image" value="<?php echo $image;?>" id="input-image"/>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive">
                        <table id="images" class="table table-striped table-bordered table-hover">
                            <thead>
                                <th>
                                   Gallery Image & Videos
                                </th>
                                <tr>
                                    <td class="text-left">Image</td>
                                    <td>Video Url</td>
                                    <td>Sort Order</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $imageRow = 0;
                                    if($images) {
                                    foreach ($images as $image) {?>
                                        <tr id="image-row<?php echo $imageRow;?>">
                                            <td class="text-left">
                                                <a href="" type="image" id="thumb-image<?php echo $imageRow;?>" data-toggle="image" class="img-thumbnail">
                                                    <img src="<?php echo $image['thumb'];?>" alt="" title="" data-placeholder="<?php echo $placeholder;?>>"/>
                                                </a>
                                                <input type="hidden" name="images[<?php echo $imageRow;?>][image]" value="<?php echo $image['thumb'];?>" id="input-image<?php echo $imageRow;?>>"/>
                                            </td>
                                            <td>
                                                <input type="text" placeholder="Video Url" name="images[<?php echo $imageRow;?>][video]" data-placeholder="Video URL">
                                            </td>
                                            <td>
                                                <input type="text" name="images[<?php echo $imageRow;?>][sort_order]" data-placeholder="Sort Order">
                                            </td>
                                            <td class="text-left"><button type="button" onclick="$('#image-row<?php echo $imageRow;?>').remove();" data-toggle="tooltip" title="Delete" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                        </tr>
                                    <?php } ?>
                                    <?php $imageRow++; }
                                ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="3"></td>
                                <td class="text-left"><button type="button" data-toggle="tooltip" title="Add" class="btn btn-primary addImage"><i class="fa fa-plus-circle"></i></button></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            </div>
        </div>

    </form>
</div>

<script>
    var myLabel             = myLabel || {};
    myLabel.baseUrl         = '<?php echo base_url();?>';
    myLabel.filemanager     = '<?php echo admin_url('filemanager');?>';
    myLabel.imageRow        = '<?php echo $imageRow;?>';
    myLabel.placeholder     = '<?php echo $placeholder;?>';
</script>