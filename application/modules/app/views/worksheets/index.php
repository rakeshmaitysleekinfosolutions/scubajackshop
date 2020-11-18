<section class="country">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Worksheet Page</h2>
                <?php if(isset($worksheets)) {
                    $c = 0;
                    foreach  ($worksheets as $key => $worksheet) { $c++;?>
                        <div class="panel-group" id="accordion">
                          <div class="panel panel-default">
                            <div class="work_sht_wrap">
                                <div class="panel-heading">
                              <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" aria-expanded="<?php if($c==1){ echo "true"; }else{ echo "false"; } ?>" href="#collapse<?php echo $c;?>">
                                    <h3><?php echo $worksheet['title'];?></h3>
                                </a>
                              </h4>
                            </div>
                                <?php if($worksheet['sheets']) { ?>
                            <div id="collapse<?php echo $c;?>" aria-expanded="<?php if($c==1){ echo "true"; }else{ echo "false"; } ?>" style="<?php if($c==1){ echo "true"; }else{ echo "height: 0px;"; } ?>" class="panel-collapse collapse <?php if($c==1){ echo "in show"; }else{ echo ""; } ?>">
                              <div class="panel-body">
                                <div class="accor-cont">
                                    <ul>
                                        <?php foreach ($worksheet['sheets'] as $sheet) {?>
                                            <li>
                                                <a href="<?php echo site_url('image/'.$sheet['data']);?>" target="_blank"><i class="far fa-file-pdf"></i>
                                                    <?php echo $sheet['title'];?></a>
                                           </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                              </div>
                            </div>
                                <?php } ?>
                            </div>
                          </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="404-logo pb-5">
                        <img src="<?php echo resize(getSession('settings')['logo'],200,200);?>" alt="<?php echo getSession('settings')['company_name'];?>" style="width:100px">
                    </div>
                    <h2>Sorry! This content is not available.</h2>
                <?php } ?>
            </div>
        </div>
    </div>
</section>