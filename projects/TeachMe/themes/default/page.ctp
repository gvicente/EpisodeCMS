<!DOCTYPE html>
<html>
<head>
<?php echo $headers; ?>
<script>
Test = {
   currentQuestion:0,

   totalQuestions:30,

   currentAnswer:0,

   totalAnswers:5,

   enabled: false,

   open: function(blockName) {
	$('.centered').hide();
    $('.'+blockName).show();
   }, 

   init: function() {
	    Test.navigateTo(1);
	    Test.open('test');
	    $('body').live('keydown', function(e){
		    console.log('oops');
	        switch(e.which) {
	            case(122):
		            Test.enabled = !Test.enabled;
			        if(Test.enabled)
				        Test.open('test');
		            else 
		                Test.open('tip');
			        break
	            case(40): // down
	            	Test.activateAnswer('next');
	                break;
	            case(38): // up
	            	Test.activateAnswer('prev');
	                break;
	            case(13):
	            case(39): // right
	            	Test.navigateTo('next');
	                break;
	            case(37): // left
	            	Test.navigateTo('prev');
	                break;
	        }
	    });
	    $('#content').mousemove(function(){
		    if(Test.enabled) {
		    	$('#notify').html("Please don't move mouse.");
		    	$('#notify').show();
		    }
	    });
   },

   navigateTo: function(step) {
	   if(step == 'next') {
		   if(Test.currentQuestion < Test.totalQuestions-1)
			   Test.currentQuestion++;
	   } else if(step == 'prev') {
		   if(Test.currentQuestion > 1)
               Test.currentQuestion--;
		   else
			   Test.currentQuestion = 1;
	   } else {
		   Test.currentQuestion = step;
	   }
	   $('.question').removeClass('current');
	   $('#question-'+Test.currentQuestion).addClass('current');

	   // if saved
	   Test.activateAnswer(0);
   },

   activateAnswer: function(answer) {
	    if(answer == 'next') {
	    	if(Test.currentAnswer < Test.totalAnswers-1)
	            Test.currentAnswer++;
	    } else if(answer == 'prev') {
	    	if(Test.currentAnswer > 1)
                Test.currentAnswer--;
	    	else
	    		Test.currentAnswer = 1;
	    } else {
		    Test.currentAnswer = answer;
	    }
	    $('.answer').removeClass('current');
	    $('#answer-'+Test.currentAnswer).addClass('current');
   }
}

$(function(){
    Test.init();
});
</script>
</head>
<body>
<div id="header">
<h1><a href="#">TeachMe</a></h1>
</div>
<div id="content">
<div id="notify" style="display: none"></div>
<div class="centered tip">
<p>Click F11 to maximize browser.
<p>Use arrow keys to navigate between answers and questions.
<p>Don't use mouse. You have only 10 movements.

</div>
<div class="centered test">
<div class="test-navigation">
<ul>
<?php
$answers = array(1,2,3,4,5);
$current = 6;
?>
<?php for($i=1;$i<30;$i++):?>
	<li
		class="question <?php
                        if(in_array($i, $answers)) {
                            echo " class=complete ";
                        }
                        if($i==$current) {
                            echo " class=current ";
                        }
                    ?>"
		id="question-<?php echo $i?>"><a href="#<?php echo $i;?>"><?php echo $i;?></a></li>
		<?php endfor;?>
</ul>
</div>
<div class="test-question">
<p>Question</p>
</div>
<div class="test-answers">
<ul>
<?php for($i=1;$i<5;$i++):?>
	<li id="answer-<?php echo $i?>" class="answer"><a
		href="#<?php echo $i?>"><?php echo $i?></a></li>
		<?php endfor;?>
</ul>
</div>
</div>
</div>
		<?php echo $scripts_for_layout ?>
</body>
</html>
