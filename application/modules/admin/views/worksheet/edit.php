<div class="content container-fluid">
    <form id="frm" action="<?php echo admin_url('worksheet/update/'.$id);?>" method="post">
        <div class="row">
            <?php if(hasMessage('message')) { ?>
                <div class="alert alert-success alert-dismissible"><i class="fa fa-exclamation-circle"></i><?php echo getMessage('message');?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <h4 class="page-title">Edit Worksheet</h4>
            </div>

            <div class="col-sm-4 text-right m-b-30">
                <button type="submit" class="btn btn-primary rounded"><i class="fa fa-save"></i> Save</button>
                <a href="<?php echo $back;?>" class="btn btn-primary rounded"><i class="fa fa-back"></i> Back</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                    <h3 class="card-title">Worksheet</h3>
                    <div class="experience-box">
                        <div class="form-group">
                            <label class="control-label">Title <span class="text-danger">*</span></label>
                            <input value="<?php echo $title;?>" id="input-title" name="title" type="text" class="form-control" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Sort Order <span class="text-danger">*</span></label>
                            <input value="<?php echo $sort_order;?>" id="input-sort_order" name="sort_order" type="text" class="form-control" placeholder="" required>
                        </div>
                        <div class="table-responsive">
                            <table id="worksheets" class="table table-striped table-bordered table-hover">
                                <thead>
                                <th>
                                    Worksheet Data
                                </th>
                                <tr>
                                    <td class="text-left">Worksheet</td>
                                    <td>Title</td>
                                    <td>Sort Order</td>
                                    <td></td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $counter = 0;
                                if($worksheets) {
                                    foreach ($worksheets as $worksheet) {?>
                                        <tr id="data-row<?php echo $counter;?>">
                                            <td class="text-left">
                                                <a href="javascript:void(0);" type="craft" id="thumb-data<?php echo $counter;?>" data-toggle="image" class="img-thumbnail">
                                                    <img src="<?php echo $worksheet['thumb'];?>" alt="" title="" data-placeholder="<?php echo $placeholder;?>"/>
                                                </a>
                                                <input type="hidden" name="worksheets[<?php echo $counter;?>][data]" value="<?php echo $worksheet['data'];?>" id="input-data<?php echo $counter;?>"/>
                                            </td>
                                            <td>
                                                <input value="<?php echo $worksheet['title'];?>" class="form-control" type="text" placeholder="Title" name="worksheets[<?php echo $counter;?>][title]" data-placeholder="Title">
                                            </td>
                                            <td>
                                                <input value="<?php echo $worksheet['sort_order'];?>" class="form-control" type="text" name="worksheets[<?php echo $counter;?>][sort_order]" data-placeholder="Sort Order">
                                            </td>
                                            <td class="text-left"><button type="button" onclick="$('#data-row<?php echo $counter;?>').remove();" data-toggle="tooltip" title="Delete" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                        </tr>
                                    <?php $counter++; } ?>
                                    <?php  }
                                ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="3"></td>
                                    <td class="text-left"><button type="button" data-toggle="tooltip" title="Add" class="btn btn-primary addData"><i class="fa fa-plus-circle"></i></button></td>
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
    myLabel.counter         = '<?php echo $counter;?>';
    myLabel.placeholder     = '<?php echo $placeholder;?>';
</script>