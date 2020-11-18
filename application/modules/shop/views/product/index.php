<div class="content container-fluid">
    <div class="row">
        <?php if(hasMessage('warning')) { ?>
            <div class="alert alert-success alert-dismissible"><i class="fa fa-exclamation-circle"></i><?php echo getMessage('warning');?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php } ?>
        <div class="col-sm-4 col-xs-3">
            <h4 class="page-title"><?php echo $title;?></h4>
        </div>

        <div class="col-sm-8 text-right m-b-30">
            <button type="submit" class="btn btn-primary"><i class="fa fa-trash"></i> Delete</button>
            <a href="<?php echo $add;?>" class="btn btn-primary"><i class="fa fa-plus"></i> Add</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped custom-table datatable">
                <thead>
                    <tr>
                    <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);"></td>
                    <?php if(count($columns)) {
                        foreach ($columns as $column) {?>
                            <th class="text-left"><?php echo $column;?></th>
                        <?php } ?>
                    <?php } ?>
                    <td class="text-right">Action</td>
                    </tr>
                </thead>
                
            </table>
        </div>
    </div>
</div>
</div>

<script>
    var myLabel             = myLabel || {};
    myLabel.baseUrl         = '<?php echo base_url();?>';
    myLabel.fetch        = '<?php echo url('shop/category/onLoadDatatableEventHandler');?>';
    myLabel.status    = '<?php echo url('shop/category/onClickStatusEventHandler');?>';
    myLabel.delete          = '<?php echo url('shop/category/delete');?>';
</script>