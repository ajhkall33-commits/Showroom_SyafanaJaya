<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Ayo Ngoding - Membuat Form Wizard Bootstrap</title>
        <!-- CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
       
<style>
 .f1-steps { overflow: hidden; position: relative; margin-top: 20px; }

.f1-progress { position: absolute; top: 24px; left: 0; width: 100%; height: 1px; background: #ddd; }
.f1-progress-line { position: absolute; top: 0; left: 0; height: 1px; background: #338056; }

.f1-step { position: relative; float: left; width: 25%; padding: 0 5px; }

.f1-step-icon {
	display: inline-block; width: 40px; height: 40px; margin-top: 4px; background: #ddd;
	font-size: 16px; color: #fff; line-height: 40px;
	-moz-border-radius: 50%; -webkit-border-radius: 50%; border-radius: 50%;
}
.f1-step.activated .f1-step-icon {
	background: #fff; border: 1px solid #338056; color: #338056; line-height: 38px;
}
.f1-step.active .f1-step-icon {
	width: 48px; height: 48px; margin-top: 0; background: #338056; font-size: 22px; line-height: 48px;
}

.f1-step p { color: #ccc; }
.f1-step.activated p { color: #338056; }
.f1-step.active p { color: #338056; }

.f1 fieldset { display: none; text-align: left; }

.f1-buttons { text-align: right; }

.f1 .input-error { border-color: #f35b3f; }
</style>
    </head>
    <body style="text-align: center;">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                	<div id="form-wizard"></div>
                </div>
            </div>
        </div>
        <!-- Javascript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
       <script>
        function scroll_to_class(element_class, removed_height) {
	var scroll_to = $(element_class).offset().top - removed_height;
	if($(window).scrollTop() != scroll_to) {
		$('html, body').stop().animate({scrollTop: scroll_to}, 0);
	}
}

function bar_progress(progress_line_object, direction) {
	var number_of_steps = progress_line_object.data('number-of-steps');
	var now_value = progress_line_object.data('now-value');
	var new_value = 0;
	if(direction == 'right') {
		new_value = now_value + ( 100 / number_of_steps );
	}
	else if(direction == 'left') {
		new_value = now_value - ( 100 / number_of_steps );
	}
	progress_line_object.attr('style', 'width: ' + new_value + '%;').data('now-value', new_value);
}

$(document).ready(function() {
    // Form
  
    
    $('.f1 input[type="text"], .f1 input[type="password"], .f1 textarea').on('focus', function() {
    	$(this).removeClass('input-error');
    });
    
    // step selanjutnya (ketika klik tombol selanjutnya)
    
    
    // step sbelumnya (ketika klik tombol sebelumnya)
    $('.f1 .btn-previous').on('click', function() {
    	// navigation steps / progress steps
    	var current_active_step = $(this).parents('.f1').find('.f1-step.active');
    	var progress_line = $(this).parents('.f1').find('.f1-progress-line');
    	
    	$(this).parents('fieldset').fadeOut(400, function() {
    		// change icons
    		current_active_step.removeClass('active').prev().removeClass('activated').addClass('active');
    		// progress bar
    		bar_progress(progress_line, 'left');
    		// show previous step
    		$(this).prev().fadeIn();
    		// scroll window to beginning of the form
			scroll_to_class( $('.f1'), 20 );
    	});
    });
    
    // submit (ketika klik tombol submit diakhir wizard)
    $('.f1').on('submit', function(e) {
    	// validasi form
    	$(this).find('input[type="text"], input[type="password"], textarea').each(function() {
    		if( $(this).val() == "" ) {
    			e.preventDefault();
    			$(this).addClass('input-error');
    		}
    		else {
    			$(this).removeClass('input-error');
    		}
    	});
    });
});

ListJob(<?=$id?>);
function ListJob(id){
      $.ajax({
         url: "<?=base_url()?>PM/ListJob/"+id,
         type: 'post',
         // data: formData,
         contentType: false,
         processData: false,
         success: function(r){
            var json = JSON.parse(r);
            var row ='';
            row+=`<form action="" method="post" class="f1">
                		<h3>www.ayongoding.com</h3>
                	
                		<div class="f1-steps">
                			<div class="f1-progress">
                			    <div class="f1-progress-line" data-now-value="25" data-number-of-steps="4" style="width: 25%;"></div>
                			</div>
                            <div class="f1-step active">
                                <div class="f1-step-icon"><i class="fa fa-user"></i></div>
                                <p>Biodata</p>
                            </div>
                			<div class="f1-step">
                				<div class="f1-step-icon"><i class="fa fa-home"></i></div>
                				<p>Alamat</p>
                			</div>
                			<div class="f1-step">
                				<div class="f1-step-icon"><i class="fa fa-key"></i></div>
                				<p>Akun</p>
                			</div>
                		    <div class="f1-step">
                				<div class="f1-step-icon"><i class="fa fa-address-book"></i></div>
                				<p>Sosial</p>
                			</div>
                		</div>
                		
                	`;
            jQuery.each(json['data']['list_job'], function( i, val ) {
                 row += `<fieldset>
                		    <h4>Identitas Pribadi</h4>
                			<div class="form-group">
                			    <label>Nama Awal</label>
                                <input type="text" name="nama_awal" placeholder="Nama Awal" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Nama Akhir</label>
                                <input type="text" name="nama_akhir" placeholder="Nama Akhir" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Tentang Kamu</label>
                                <textarea name="tentang_kamu" placeholder="Tentang Kamu" class="form-control"></textarea>
                            </div>
                            <div class="f1-buttons">
                                <button type="button" class="btn btn-primary btn-next" onclick="NextStep()">Selanjutnya <i class="fa fa-arrow-right"></i></button>
                            </div>
                        </fieldset>`;

              
            });
            row+=`</form>`;
          
            $('#form-wizard').html(row);
            $('.f1 fieldset:first').fadeIn('slow');
         }, error: function(){
            hide ();
         }
      });   
      return false;
   }
  

   function NextStep(){
    $('.f1 .btn-next').on('click', function() {
    	
    
    var parent_fieldset = $(this).parents('fieldset');
    console.log(parent_fieldset);
    	var next_step = true;
    	// navigation steps / progress steps
    	var current_active_step = $(this).parents('.f1').find('.f1-step.active');
    	var progress_line = $(this).parents('.f1').find('.f1-progress-line');
    	
    	// validasi form
    	
    	if( next_step ) {
    		parent_fieldset.fadeOut(400, function() {
    			// change icons
    			current_active_step.removeClass('active').addClass('activated').next().addClass('active');
    			// progress bar
    			bar_progress(progress_line, 'right');
    			// show next step
	    		$(this).next().fadeIn();
	    		// scroll window to beginning of the form
    			scroll_to_class( $('.f1'), 20 );
	    	});
    	}
    });
   }
       </script>
    </body>
</html>