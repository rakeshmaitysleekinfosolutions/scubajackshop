<section class="country">
    <div class="container">
        <div class="row">
           <div class="col-md-12">
               <div id="quiz">
                   <div id="quiz-header">
                       <h1><?php echo $quiz->name;?></h1>
<!--                       <p class="faded">A quiz about the plugin built by the plugin.</p>-->
                   </div>
                   <div id="quiz-start-screen">
                       <p><a href="#" id="quiz-start-btn" class="quiz-button">Start</a></p>
                   </div>
               </div>
           </div>
        </div>
    </div>
</section>

<script>
    var myLabel                 = myLabel || {};
    myLabel.baseUrl             = '<?php echo base_url();?>';
    myLabel.fetchQuizData       = '<?php echo site_url('api/fetch/quiz/'.$quiz->id);?>';
    myLabel.userGivenAnswer     = '<?php echo site_url('api/quiz/userGivenAnswer');?>';
    myLabel.finishCallback      = '<?php echo site_url('api/quiz/finishCallback');?>';
    myLabel.quizName            = '<?php echo $quiz->name;?>';
</script>