<section class="book-list">
    <h3><span>Worksheets</span></h3>
    <p>The Adventures of Scuba Jack has over 1000 of the best printables, themes, activities and preschool lesson plans on the planet.
        Our activities support curriculum for every learner through Reading, Writing, Numbers, Math, Coloring and Stories. Our Virtual Field Trips are for Preschool and Elementary School students
    </p>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- <h2>Worksheet Page</h2> -->
                 <?php if(isset($worksheets)) {?>
                  <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
                    <?php $c = 0; foreach  ($worksheets as $key => $worksheet) { $c++;?>
                      <!-- Accordion card -->
                      <div class="card">
                        <!-- Card header -->
                          <div class="card-header" role="tab" id="headingOne1">
                            <a data-toggle="collapse" data-parent="#accordionEx" aria-expanded="<?php if($c==1){ echo "true"; }else{ echo "false"; } ?>" href="#collapseOne<?php echo $c;?>"
                              aria-controls="collapseOne<?php echo $c;?>">
                              <h5 class="mb-0"><?php echo $worksheet['title'];?> <i class="fas fa-angle-down rotate-icon"></i></h5>
                            </a>
                          </div>
                          <!-- Card body -->
                          <?php if($worksheet['sheets']) { ?>
                            <div id="collapseOne<?php echo $c;?>" class="collapse <?php if($c==1){ echo "show"; }else{ echo ""; } ?>" role="tabpanel" aria-labelledby="headingOne<?php echo $c;?>" data-parent="#accordionEx" aria-expanded="<?php if($c==1){ echo "true"; }else{ echo "false"; } ?>">
                              <div class="card-body">
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
                      <!-- Accordion card -->
                    <?php } ?>
                  </div>
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