<div class="content container-fluid">
    <div class="row">
        <div id="message"></div>
        <?php if(hasMessage('message')) { ?>
            <div class="alert alert-info alert-dismissible"><i class="fa fa-exclamation-circle"></i>&nbsp;<?php echo getMessage('message');?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php } ?>
        <?php if(getWarning('message')) { ?>
            <div class="alert alert-warning alert-dismissible"><i class="fa fa-exclamation-circle"></i>&nbsp;<?php echo getWarning('message');?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php } ?>
        <div class="col-sm-4 col-xs-3">
            <h4 class="page-title"><?php echo $heading;?></h4>
        </div>

        <div class="col-sm-8 text-right m-b-30">
            <button type="button" class="btn btn-primary" id="delete"><i class="fa fa-trash"></i> <?php echo $deleteBtn;?></button>
        </div>
    </div>
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $title;?></h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover datatable" id="datatable">
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
</div>
<script>
    var myLabel             = myLabel || {};
    myLabel.baseUrl         = '<?php echo base_url();?>';
    myLabel.fetch           = '<?php echo url('shop/order/onLoadDatatableEventHandler');?>';
    myLabel.status          = '<?php echo url('shop/order/onClickStatusEventHandler');?>';
    myLabel.delete          = '<?php echo url('shop/order/delete');?>';
</script>