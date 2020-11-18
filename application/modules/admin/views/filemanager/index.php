
<div id="filemanager" class="modal-dialog product-options modal-lg modal-dialog-scrollable "  data-target="#exampleModalLong" >
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title">File Manager</h4>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="col-sm-5"><a href="<?php echo $parent;?>" data-toggle="tooltip" title="Parent" id="button-parent" class="btn btn-default"><i class="fa fa-level-up"></i></a> <a href="<?php echo $refresh;?>" data-toggle="tooltip" title="Refresh" id="button-refresh" class="btn btn-default"><i class="fa fa-refresh"></i></a>
          <button type="button" data-toggle="tooltip" title="Upload" id="button-upload" class="btn btn-primary"><i class="fa fa-upload"></i></button>
          <button type="button" data-toggle="tooltip" title="Folder" id="button-folder" class="btn btn-default"><i class="fa fa-folder"></i></button>
          <button type="button" data-toggle="tooltip" title="Delete" id="button-delete" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
        </div>
<!--        <div class="col-sm-7">-->
<!--          <div class="input-group">-->
<!--            <input type="text" name="search" value="--><?php //echo $filter_name;?><!--" placeholder="Search" class="form-control">-->
<!--            <span class="input-group-btn">-->
<!--            <button type="button" data-toggle="tooltip" title="Search" id="button-search" class="btn btn-primary"><i class="fa fa-search"></i></button>-->
<!--            </span></div>-->
<!--        </div>-->
      </div>
      <hr />
     

      <div class="row">
        <?php foreach($images as $img) { ?>
        <div class="col-md-4 text-center">
         
          <?php if($img['type'] == 'directory') { ?>
            <div class="text-center"><a type="<?php echo $img['type'];?>" href="<?php echo $img['href'];?>" class="directory" style="vertical-align: middle;" type="<?php echo $img['type'];?>"><i class="fa fa-folder fa-5x"></i></a></div>
            <label><input type="checkbox" name="path[]" value="<?php echo $img['path'];?>"/>&nbsp;<?php echo $img['name'];?></label>
          <?php } ?>
          
          <?php if($img['type'] == 'image' && $img['originalFileType'] == 'image') { ?>
            <a href="<?php echo $img['href'];?>" class="thumbnail" type="<?php echo $img['type'];?>"><img src="<?php echo $img['thumb'];?>" alt="<?php echo $img['name'];?>" title="<?php echo $img['name'];?>" /></a>
            <label><input type="checkbox" name="path[]" fname="<?php echo $img['name'];?>" value="<?php echo $img['path'];?>" /><?php echo $img['name'];?></label>
          <?php } ?>
            <?php if($img['type'] == 'craft') { ?>
                <a href="<?php echo $img['href'];?>" class="thumbnail" type="<?php echo $img['type'];?>"><img src="<?php echo $img['thumb'];?>" alt="<?php echo $img['name'];?>" title="<?php echo $img['name'];?>" /></a>
                <label><input type="checkbox" name="path[]" fname="<?php echo $img['name'];?>" value="<?php echo $img['path'];?>" /><?php echo $img['name'];?></label>
            <?php } ?>
        </div>
        <?php } ?>
      </div>
      <br />

    </div>
    <!-- <div class="modal-footer"><?php echo $pagination;?></div> -->
  </div>
</div>
<script type="text/javascript">
<?php if($target) { ?>
$('a.thumbnail').on('click', function(e) {

	e.preventDefault();

    var selectedFileType    = $(this).attr('type');
    var fileType            = '<?php echo $type;?>';
    if((selectedFileType == 'image' && fileType == 'craft') || (selectedFileType == 'craft' && fileType == 'craft')) {
        <?php if($thumb) {?>
            $('#<?php echo $thumb;?>').find('img').attr('src', $(this).find('img').attr('src'));
        <?php } ?>
            $("#pdf_text").text($(this).parent().find('input').attr('fname'));
    } else  {
        if(selectedFileType != fileType) {
            swal('Please select ' + fileType + ' only');
        } else {
            <?php if($thumb) {?>
                $('#<?php echo $thumb;?>').find('img').attr('src', $(this).find('img').attr('src'));
            <?php } ?>
        }
    }

    $('#<?php echo $target;?>').val($(this).parent().find('input').val());
    $('#modal-image').modal('hide');


});
<?php } ?>

$('a.directory').on('click', function(e) {
	e.preventDefault();

	$('#modal-image').load($(this).attr('href'));
});

$('.pagination a').on('click', function(e) {
	e.preventDefault();

	$('#modal-image').load($(this).attr('href'));
});

$('#button-parent').on('click', function(e) {
	e.preventDefault();

	$('#modal-image').load($(this).attr('href'));
});

$('#button-refresh').on('click', function(e) {
	e.preventDefault();

	$('#modal-image').load($(this).attr('href'));
});

$('input[name=\'search\']').on('keydown', function(e) {
	if (e.which == 13) {
		$('#button-search').trigger('click');
	}
});

$('#button-search').on('click', function(e) {
	var url = 'index.php?route=common/filemanager&user_token={{ user_token }}&directory={{ directory }}';

	var filter_name = $('input[name=\'search\']').val();

	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}

    
    <?php if($thumb) { ?>
	url += '&thumb=' + '<?php echo $thumb;?>';
    <?php } ?>

	<?php if($target) { ?>
	url += '&target=' + '<?php echo $target;?>';
    <?php } ?>

	$('#modal-image').load(url);
});
</script>
<script type="text/javascript">
$('#button-upload').on('click', function() {
	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file[]" value="" multiple="multiple" /></form>');

	$('#form-upload input[name=\'file[]\']').trigger('click');

	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file[]\']').val() != '') {
			clearInterval(timer);

			$.ajax({
				url: myLabel.filemanagerUpload + '?directory=<?php echo $directory;?>',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$('#button-upload i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
					$('#button-upload').prop('disabled', true);
				},
				complete: function() {
					$('#button-upload i').replaceWith('<i class="fa fa-upload"></i>');
					$('#button-upload').prop('disabled', false);
				},
				success: function(json) {

					if (json['error']) {
                        swal(json['error']);
					}

					if (json['success']) {
                        swal(json['success']);

						$('#button-refresh').trigger('click');
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					//alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});

$('#button-folder').popover({
	html: true,
	placement: 'bottom',
	trigger: 'click',
	title: 'Folder Name',
	content: function() {
		html  = '<div class="input-group">';
		html += '  <input type="text" name="folder" value="" placeholder="Folder Name" class="form-control">';
		html += '  <span class="input-group-btn"><button type="button" title="Folder" id="button-create" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></span>';
		html += '</div>';

		return html;
	}
});

$('#button-folder').on('shown.bs.popover', function() {
	$('#button-create').on('click', function() {
		$.ajax({
			url: myLabel.filemanagerFolder + '?directory=<?php echo $directory;?>',
			type: 'post',
			dataType: 'json',
			data: 'folder=' + encodeURIComponent($('input[name=\'folder\']').val()),
			beforeSend: function() {
				$('#button-create').prop('disabled', true);
			},
			complete: function() {
				$('#button-create').prop('disabled', false);
			},
			success: function(json) {
                if (json['error']) {
                    swal(json['error']);
                }

                if (json['success']) {
                    swal(json['success']);

                    $('#button-refresh').trigger('click');
                }
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	});
});

$('#modal-image #button-delete').on('click', function(e) {
    swal({
        title: "Confirm Delete",
        text: "Are you want to delete this record?(Yes/No)",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true
    }, function () {

        setTimeout(function () {
            $.ajax({
                url: myLabel.filemanagerDelete,
                type: 'post',
                dataType: 'json',
                data: $('input[name^=\'path\']:checked'),
                beforeSend: function() {
                    $('#button-delete').prop('disabled', true);
                },
                complete: function() {
                    $('#button-delete').prop('disabled', false);
                },
                success: function(json) {
                    if (json['error']) {
                        swal(json['error']);
                    }

                    if (json['success']) {
                        swal(json['success']);

                        $('#button-refresh').trigger('click');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }, 2000);

    });
});
</script>

<script>
    var myLabel = myLabel || {};
    myLabel.baseUrl = '<?php echo base_url();?>';
    myLabel.filemanagerUpload   = '<?php echo admin_url('filemanager/upload');?>';
    myLabel.filemanagerFolder   = '<?php echo admin_url('filemanager/folder');?>';
    myLabel.filemanagerDelete   = '<?php echo admin_url('filemanager/delete');?>';
</script>