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
                                        <label class="control-label"><?php echo $entryName;?> <span class="text-danger"></span></label>
                                        <input value="<?php echo $name;?>" class="form-control floating" type="text" name="name" id="input-payment-lastname" autocomplete="off" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo $entrySlug;?> <span class="text-danger"></span></label>
                                        <input value="<?php echo $slug;?>" class="form-control floating" type="text" name="slug" id="input-payment-lastname" autocomplete="off" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Status <span class="text-danger">*</span></label>
                                        <select name="status" class="select floating" id="input-payment-status" >
                                            <option value="0" <?php echo ($status == 0) ? 'selected' : '';?>>Inactive</option>
                                            <option value="1" <?php echo ($status == 1) ? 'selected' : '';?>>Active</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Sort Order <span class="text-danger">*</span></label>
                                        <input value="<?php echo $sort_order;?>" class="form-control floating" type="text" name="sort_order" id="input-ortOrder" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Quantity <span class="text-danger"></span></label>
                                        <input value="<?php echo $quantity;?>" placeholder="QTY" class="form-control floating" type="text" name="quantity" id="input-payment-lastname" autocomplete="off" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Price <span class="text-danger"></span></label>
                                        <input value="<?php echo $price;?>"  class="form-control floating" type="text" name="price" id="input-payment-lastname" autocomplete="off" >
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo $entryCategory;?><span class="text-danger">*</span></label>
                                        <select class="select form-control floating" name="categories_id[]" multiple>
                                            <?php if(count($categories)) {
                                                foreach ($categories as $category) {
                                                    $selected = '';
                                                    if($category_id == $category->id){
                                                        $selected = 'selected';
                                                    }?>
                                                    <option value="<?php echo $category->id;?>" <?php echo $selected;?>><?php echo $category->name;?></option>
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
            <div class="card-box">
                <h3 class="card-title">Description</h3>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label"><?php echo $entryDescription;?></label>
                            <textarea name="description" rows="5" class="form-control summernote" type="text" autocomplete="off"><?php echo $description;?></textarea>
                        </div>
                    </div>
                    <?php
                    /*

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label"><?php echo $entryModel;?> <span class="text-danger">*</span></label>
                            <input value="<?php echo $model;?>" placeholder="<?php echo $entryName;?>" class="form-control" type="text" name="model" id="input-payment-firstname" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">SKU <span class="text-danger"></span></label>
                            <input value="<?php echo $sku;?>" placeholder="SKU" class="form-control" type="text" name="sku" id="input-payment-lastname" autocomplete="off" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">UPC <span class="text-danger"></span></label>
                            <input value="<?php echo $upc;?>" placeholder="UPC" class="form-control" type="text" name="upc" id="input-payment-lastname" autocomplete="off" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">EAN <span class="text-danger"></span></label>
                            <input value="<?php echo $ean;?>" placeholder="EAN" class="form-control" type="text" name="ean" id="input-payment-lastname" autocomplete="off" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">JAN <span class="text-danger"></span></label>
                            <input value="<?php echo $jan;?>" placeholder="JAN" class="form-control" type="text" name="jan" id="input-payment-lastname" autocomplete="off" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">ISBN <span class="text-danger"></span></label>
                            <input value="<?php echo $isbn;?>" placeholder="ISBN" class="form-control" type="text" name="isbn" id="input-payment-lastname" autocomplete="off" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">MPN <span class="text-danger"></span></label>
                            <input value="<?php echo $mpn;?>" placeholder="MPN" class="form-control" type="text" name="mpn" id="input-payment-lastname" autocomplete="off" >
                        </div>
                    </div>
                    */
                    ?>
                </div>
            </div>
            <div class="card-box">
                <h3 class="card-title">Meta Data</h3>
                <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label"><?php echo $entryMetaTitle;?><span class="text-danger">*</span></label>
                                <input value="<?php echo $meta_title;?>" name="meta_title" class="form-control floating" type="text" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label"><?php echo $entryMetaDescription;?><span class="text-danger"></span></label>
                                <textarea name="meta_description" rows="5" class="form-control floating" type="text" autocomplete="off"><?php echo $meta_description;?></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label"><?php echo $entryMetaKeywords;?><span class="text-danger"></span></label>
                                <textarea name="meta_keywords" rows="5" class="form-control floating" type="text" autocomplete="off"><?php echo $meta_keywords;?></textarea>
                            </div>
                        </div>

                </div>
            </div>
            <div class="card-box">
                <h3 class="card-title">Additional Images</h3>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="images" class="table table-striped table-bordered table-hover">
                                <thead>
                                <th>
                                    Images
                                </th>
                                <tr>
                                    <td class="text-left">Image</td>
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
                                                <a href="" type="image" id="thumb-image<?php echo $imageRow;?>" data-toggle="image">
                                                    <img src="<?php echo $image['thumb'];?>" alt="" title="" data-placeholder="<?php echo $placeholder;?>>"/>
                                                </a>
                                                <input type="hidden" name="images[<?php echo $imageRow;?>][image]" value="<?php echo $image['image'];?>" id="input-image<?php echo $imageRow;?>"/>
                                            </td>
                                            <td>
                                                <div class="form-group select-focus">
                                                    <input value="<?php echo $image['sort_order'];?>" type="text" name="images[<?php echo $imageRow;?>][sort_order]" data-placeholder="Sort Order" class="form-control floating">
                                                </div>
                                            </td>
                                            <td class="text-left"><button type="button" onclick="$('#image-row<?php echo $imageRow;?>').remove();" data-toggle="tooltip" title="Delete" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                        </tr>
                                        <?php $imageRow++; } ?>
                                    <?php ; }
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
    var myLabel = myLabel || {};
    myLabel.baseUrl         = '<?php echo base_url();?>';
    myLabel.imageRow        = '<?php echo $imageRow;?>';
    myLabel.filemanager     = '<?php echo url('filemanager');?>';
    myLabel.placeholder     = '<?php echo $placeholder;?>';
</script>