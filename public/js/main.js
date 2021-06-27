(function($) {

	$(document).ready(function(){

		var ap = window.ap;
		var pet_id = '', breed_id = '', gender = '', location = '', temp = '', sell_adopt = 'sell';

    /*Dropdown Menu*/
	$('.custom-dropdown').click(function () {
	        $(this).attr('tabindex', 1).focus();
	        $(this).toggleClass('active');
	        $(this).find('.dropdown-menu').slideToggle(300);
	    });
	    $('.custom-dropdown').focusout(function () {
	        $(this).removeClass('active');
	        $(this).find('.dropdown-menu').slideUp(300);
	    });
	    // $('.dropdown .dropdown-menu li').click(function () {
	    //     $(this).parents('.dropdown').find('span').text($(this).text());
	    //     $(this).parents('.dropdown').find('input').attr('value', $(this).attr('id'));
	    // });
	/*End Dropdown Menu*/

	// when pet , breed and gender dropdown value selected 

	// When Make value selected
	$(document).on( 'change', '#pet_category_id', function(){
		temp = '';
		breed_id = '';
		pet_id = $(this).val();
		$('#pet_category_error').hide();
        $('.response_alerts .alert-warning').fadeOut();
		$.ajax({
		url:ap.ajax_url, 
		type:'post', 
		data:{action:'pet_child_cat',id:pet_id},
		async:false
	}).done(function(d){

		d = d.data;
		temp = `<option value="">Please Select Breed</option>`;

		$.each(d, function(k, v){

			temp += `<option value="`+v.term_id+`">`+v.name+`</option>`
		})
			
		$("#pet_breed_id").html(temp);

	}).fail(function(d){
		alert('No Child Category Found, Select another option!');
	});

	});
    // when loaction selected from list
	$(document).on( 'change', '#country', function(){
		var location = $(this).val();
		var countryId = $(this).find('option:selected').attr('data-countryid');

		$('#location_error').hide();
		$('.response_alerts .alert-warning').fadeOut();
		temp = `<option value="">Select City</option>`;

		$.get(`${ap.ajax_url}/?id=${countryId}&action=ap_city_list`,function(_data){
			$.each(_data.data, function(k, v){
				temp += `<option data-cityid="`+v.id+`" value="`+v.name+`">`+v.name+`</option>`
			})
				
			$("#city").html(temp);
		});
	})

	// when city selected from list
	$(document).on( 'change', '#city', function(){
		var cityId = $(this).find('option:selected').attr('data-cityid');
	})
	// when current location is clicked

	$("#location_current").click(function(){
		var currentLocation = 'Islamabad'
		$('#location_input').val(currentLocation);
	})
    // form validation

    $("input[name='post_title']").on('input', function(e) {
	    var post_title = $(this);
	    var post_title=post_title.val();

	    if(post_title != ''){$(this).removeClass("invalid").addClass("valid"); $('#title_required').hide(); $('.response_alerts .alert-warning').fadeOut();}
	    else{ $(this).removeClass("valid").addClass("invalid"); $('#title_required').show(); }
      });

    $("textarea[name='description']").on('input', function(e) {
	    var description = $(this);
	    var description=description.val();

	    if(description != ''){$(this).removeClass("invalid").addClass("valid"); $('#description_error').hide(); $('.response_alerts .alert-warning').fadeOut();}
	    else{ $(this).removeClass("valid").addClass("invalid"); $('#description_error').show(); }
      });

    $("input[name='price']").on('input', function(e) {
	    var price = $(this);
	    var price=price.val();

	    if(price != ''){$(this).removeClass("invalid").addClass("valid"); $('#price_error_required').hide(); $('.response_alerts .alert-warning').fadeOut();}
	    else{ $(this).removeClass("valid").addClass("invalid"); $('#price_error_required').show(); }
      });

    // $("input[name='phoneNumber']").on('input', function(e) {
	   //  var phoneNumber = $(this);
	   //  var phoneNumber=phoneNumber.val();

	   //  if(phoneNumber != ''){$(this).removeClass("invalid").addClass("valid"); $('#phoneNumber_error').hide(); $('.response_alerts .alert-warning').fadeOut();}
	   //  else{ $(this).removeClass("valid").addClass("invalid"); $('#phoneNumber_error').show(); }
    //   });

    $("input[name='agree_term']").click(function(){
            if($(this).prop("checked") == true){
                $('#agree_term_error').hide();
                $('.response_alerts .alert-warning').fadeOut();
            }
            else if($(this).prop("checked") == false){
                $('#agree_term_error').show();
            }
        });

    // image validation code
        var a=0;
        //binds to onchange event of your input field
        $("input[name='image_gallary[]']").bind('change', function(e) {
            let all_files = $('#image_gallary')[0].files;
            temp = '';

            $.each(all_files, function(k, v){
            	let ext = v.name.split('.').pop().toLowerCase();

            	if ($.inArray(ext, ['jpg','png','jpeg']) == -1 && all_files.length!= 0){

                 $('#image_gallary_error1').slideDown("slow");
                 $('#image_gallary_error2').slideUp("slow");
                 a=0;

             }
             else{
                
                 let picsize = (v.size);
                 if (picsize > 5000000){
                 $('#image_gallary_error2').slideDown("slow");
                 a=0;
                 }else{
                 a=1;
                 	$('#image_gallary_error2').slideUp("slow");

                 	temp += `<img src="`+URL.createObjectURL(v)+`" class="img-thumbnail" /> `
					console.log(temp)
                 }
                 $('#image_gallary_error1').slideUp("slow");
                 if (a==1){
                 $('input:submit').attr('disabled',false);
             }
            }

         })

          if(all_files.length!= 0){
          	$('#gallary_image_output').html(temp)
          }
        });

        $("input[name='featured_image']").bind('change', function(e) {
            
            let ext = $("input[name='featured_image']").val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['jpg','png','jpeg']) == -1 && e.target.files.length!= 0){

                 $('#featured_image_error1').slideDown("slow");
                 $('#featured_image_error2').slideUp("slow");
                 a=0;
             }
             else{
                
                 let picsize = (this.files[0].size);
                 if (picsize > 5000000){
                 $('#featured_image_error2').slideDown("slow");
                 a=0;
                 }else{
	                 a=1;
	                 $('#featured_image_error2').slideUp("slow");
	                 $('.f_img_u_btn').css({'background-color': '#cfcfbe'})
	                 $('#featured_image_error3').slideUp("slow");

	                 $('.response_alerts .alert-warning').fadeOut();

	                var image = document.getElementById('featured_image_output');

					image.src = URL.createObjectURL(e.target.files[0]);
					$('#featured_image_output_div').fadeIn();
					$('#featured_image_output').fadeIn();

                 }
                 $('#featured_image_error1').slideUp("slow");
                 if (a==1){
                 $('input:submit').attr('disabled',false);
             }
            }
        });


        //  when radio button option selected 

        $("input[name='sell_adopt']").on('change', function(e) {
		    var sell_adopt_input = $(this);
		    var sell_adopt=sell_adopt_input.val();

		    if(sell_adopt == 'sell'){ 

		    	$('.price-div').slideDown("fast");
		    	$('.pet-sitting-div').slideUp("fast");

			}
		    else if(sell_adopt == 'adopt'){ 

		    	$('.price-div').slideUp("fast");
		    	$('.pet-sitting-div').slideUp("fast");

			}
		    else if(sell_adopt == 'pet-sitting'){ 

		    	$('.price-div').slideUp("fast");
		    	$('.pet-sitting-div').slideDown("fast");

			}
	     });

        // when from and to date changed

        $("input[name='startDate']").on('change', function(e) {

        	$("#select_startDate").slideUp("fast");

        	var startDate = new Date($('#startDate').val());
			var currentDate = new Date();

			var d1 = Date.parse(startDate);
			var d2 = Date.parse(currentDate);

			if (d1 < d2) {
			    $('#valid_startDate').slideDown("fast");
			    return;
			}
			else{
				$('#valid_startDate').slideUp("fast");
				$('.response_alerts .alert-warning').fadeOut();
				return;
			}
			
        });
	
        $("input[name='endDate']").on('change', function(e) {
        	var endDate = new Date($('#endDate').val());
        	var startDate = new Date($('#startDate').val());

        	if(isNaN(startDate.getTime())){
        		$("#select_startDate").slideDown("fast");
        		return;
        	}

        	$("#select_startDate").slideUp("fast");

			var currentDate = new Date();

			var d1 = Date.parse(endDate);
			var d2 = Date.parse(currentDate);
			var d3 = Date.parse(startDate);

			if (d1 <= d2) {
			    $('#valid_endDate').slideDown("fast");
			    $('#startDate_endDate').slideUp("fast");
			    return;
			}

			if(d1 < d3){
				
				$('#valid_endDate').slideUp("fast");
				$('#startDate_endDate').slideDown("fast");
				return
			}
			else{
				$('#valid_endDate').slideUp("fast");
				$('#startDate_endDate').slideUp("fast");
				$('.response_alerts .alert-warning').fadeOut();
				return;
			}
        });


        // when current and location list button clicked

        $("body a.location").on('click', function(e) {

		    var location_btn = $(this);
		    var location=location_btn.attr('value');

		    $(this).parent().find('.selected_location').removeClass('selected_location');

		    if(location == 'location_list'){
		    	$('#location_current').fadeOut('fast', function(){
		    		$('#location_list').fadeIn('fast');
			    });

			    $(this).addClass('selected_location');
			}
		    else if(location == 'location_current'){
		    	$('#location_list').fadeOut('fast', function(){
		    		$('#location_current').fadeIn('fast');
			    });

			    $('#location_input').val(ap.user_location);

			    $(this).addClass('selected_location');
		    }
	    });

    // phone input with country code
    $('.input-phone').intlInputPhone();
    $("#btn-country").click(function(){
    	$('.input-phone .dropdown-menu').css({'display':'block'})
    })
    $('.input-phone .f16 li').click(function(){
    	$('.input-phone .dropdown-menu').css({'display':'none'})
    })
    $(document).click(function(){
    	$('.input-phone .dropdown-menu').css({'display':'none'})
    })

    // place phone number in input field on edit form
	if(ap._phone != '' && ap._phone != undefined){

		var phone = ap._phone.split(" "), flagClass = '';

		$.each($(".input-phone ul.f16").children(), function(k, v){
			if($(v).find('i.callingCode').length != 0){

					var callingCode = $(v).find('i.callingCode').text();

					callingCode = callingCode.trim()

				if(callingCode === phone[0]){

					flagClass = $(v).find('i.flag').attr('class');
					$(v).trigger('click');

				}
			}
		})

		var spanFlag = $("#btn-country").find('span.flag');
		$("#btn-country").find('span.btn-cc').html('&nbsp;&nbsp '+ phone[0]);

		spanFlag.removeAttr('class');
		spanFlag.attr('class', flagClass);

		flagClass = flagClass.replace("flag ", "");
		phone[0] = phone[0].replace("+", "");


		$("#phoneNumber").val(phone[1])
		$("#defaultCountry").val(flagClass)
		$("#carrierCode").val( phone[0])
	}


	$("#edit_ap_post").submit(function(e){
		e.preventDefault();

		var description_input = $("textarea[name='description']");
	    var description=description_input.val();

	    var post_title_input = $("input[name='post_title']");
	    var post_title=post_title_input.val();

	    var sell_adopt_input = $("input[name='sell_adopt']");
		var sell_adopt= sell_adopt_input.val();
		
		var countryID=$("select[name='country']").find('option:selected').attr('data-countryid');
		var cityID=$("select[name='city']").find('option:selected').attr('data-cityid');

	    var price_input = $("input[name='price']");
	    var price=price_input.val();

	    var startDate_input = $("input[name='startDate']");
	    var startDate=startDate_input.val();

	    var endDate_input = $("input[name='endDate']");
	    var endDate=endDate_input.val();

	    var pet_category_id = $("input[name='pet_category_id']");
	    var pet_id=pet_category_id.val();

	    var pet_breed_id = $("input[name='pet_breed_id']");
	    var breed_id=pet_breed_id.val();

	    var pet_gender_input = $("input[name='pet_gender_input']");
	    var gender=pet_gender_input.val();

	    var location_contry_field = $("select[name='country']");
		var location_country=location_contry_field.val();
		var location_city= $("select[name='city']");

	    var phoneNumber_input = $("input[name='phoneNumber']");
	    var phoneNumber=phoneNumber_input.val();
	    var carrierCode = $("#btn-country .btn-cc").text();
	   		carrierCode = carrierCode.trim()

	    if(post_title != ''){post_title_input.removeClass("invalid").addClass("valid"); $('#title_required').hide();}
	    else{ post_title_input.removeClass("valid").addClass("invalid"); $('#title_required').show();$('.response_alerts .alert-warning').fadeIn();  return false;}

	    if(description != ''){description_input.removeClass("invalid").addClass("valid"); $('#description_error').hide();}
	    else{ description_input.removeClass("valid").addClass("invalid"); $('#description_error').show();$('.response_alerts .alert-warning').fadeIn(); return false;}

	    if(sell_adopt == 'sell'){ 

	    	if(price != ''){price_input.removeClass("invalid").addClass("valid"); $('#price_error_required').hide();}
	    	else{ price_input.removeClass("valid").addClass("invalid"); $('#price_error_required').show(); $('.response_alerts .alert-warning').fadeIn(); return false;}

		}
		else if(sell_adopt == 'pet-sitting'){ 

		   	if(startDate == '' || endDate == ''){
	        	$('#start_end_date_required').show();
	        	$('.response_alerts .alert-warning').fadeIn();
	            return false;
	        }

		}

        // if($("input[name='agree_term']").prop("checked") == false){
        // 	$('#agree_term_error').show();
        // 	$('.response_alerts .alert-warning').fadeIn();
        //     return false;
        // }

        if(pet_id == ''){
        	$('#pet_category_error').show();
        	$('#pet_category').css({'border': '1px solid rgb(184, 17, 17)','margin-bottom': '10px'});
        	$('.response_alerts .alert-warning').fadeIn();
            return false;
        }

        if(breed_id == ''){
        	$('#pet_breed_error').show();
        	$('#pet_breed').css({'border': '1px solid rgb(184, 17, 17)' ,'margin-bottom': '10px'});
        	$('.response_alerts .alert-warning').fadeIn();
            return false;
        }

        if(gender == ''){
        	$('#pet_gender_error').show();
        	$('#pet_gender').css({'border': '1px solid rgb(184, 17, 17)' ,'margin-bottom': '10px'});
        	$('.response_alerts .alert-warning').fadeIn();
            return false;
        }

        // if(location_country == '' || location_city==''){
        // 	$('#location_error').show();
        // 	$('#location_list').css({'border': '1px solid rgb(184, 17, 17)'});
        // 	$('.response_alerts .alert-warning').fadeIn();
        //     return false;
        // }

        // if($('#featured_image')[0].files.length == 0){
        // 	$('#featured_image_error3').show();
        // 	$('.f_img_u_btn').css({'background-color': 'rgb(255 202 202)'});
        // 	$('.response_alerts .alert-warning').fadeIn();
        //     return false;
        // }
        // if(phoneNumber == ''){
        // 	$('#phoneNumber_error').show();
        // 	$('#phoneNumber').css({'border': '1px solid rgb(184, 17, 17)'});
        // 	$('.response_alerts .alert-warning').fadeIn();
        // 	$('div.popover .popover-content').css({'display': 'none'})
        // 	$('div.popover .arrow').css({'display': 'none'})
        //     return false;
        // }

        console.log($('.submit-div input[type="submit"]'))
        $("input[type='submit']").val(' ');
        $("input[type='submit']").addClass('request_sent');
        // $("#btn-update-form").css({
        // 	'background':'#000 !important',
        // 	'border-color':'#000 !important',
        // 	'color':'#fff !important'
        // });
        
        $("input[type='submit']").attr('disabled','disabled');
        $(".submit-div .fa-spinner").fadeIn();

	    var fd = new FormData(document.forms["edit_ap_post"]);
		fd.append('action', 'update_ap_post');
		fd.append("post_id", ap.post_id);

		fd.append("country_id", countryID);
		fd.append("city_id", cityID);
		fd.append("carrierCode", carrierCode);
		// fd.append( "gender", $("#pet_gender_input").val());	

		$.ajax({
	        type: "POST",
	        url: ap.ajax_url,
	        data: fd,
	        processData: false,
	        contentType: false,
	        dataType: "json",
	        success: function(data, textStatus, jqXHR) {

	        	console.log(data)
	        	if(data.status == 'success'){

	        		$('.response_alerts .response_message').removeClass('alert-danger');
	        		$('.response_alerts .response_message').addClass('alert-success');
	        		$('.response_alerts .response_message').text('Your pet successfully updated!')

	        	}
	        	else{
	        		$('.response_alerts .response_message').removeClass('alert-success');
	        		$('.response_alerts .response_message').addClass('alert-danger');
	        		$('.response_alerts .response_message').text('Please try later, something went wrong!')
	        	}

	        	$('.response_alerts .response_message').fadeIn();
		        $("input[type='submit']").css({'background-color':'#000 !important','border-color':'#000 !important','color':'color: #fff !important'});
		        $("input[type='submit']").removeAttr('disabled');
		        $(".submit-div .fa-spinner").fadeOut();
		        $("input[type='submit']").val('Update Pet');

	        },
	        error: function(data, textStatus, jqXHR) {

	        	$('.response_alerts .response_message').removeClass('alert-success');
	        	$('.response_alerts .response_message').addClass('alert-danger');
	        	$('.response_alerts .response_message').text('Please try later, something went wrong!')

	        	$('.response_alerts .response_message').fadeIn();
		        $("input[type='submit']").css({'background-color':'#000 !important','border-color':'#000 !important','color':'color: #fff !important'});
		        $("input[type='submit']").removeAttr('disabled');
		        $(".submit-div .fa-spinner").fadeOut();
		        $("input[type='submit']").val('Update Pet');

	        },
		});
	});
        // when add pet form submitted
    $('#save_ap_post').submit(function(e) {
		e.preventDefault();
		
	    var description_input = $("textarea[name='description']");
	    var description=description_input.val();

	    var post_title_input = $("input[name='post_title']");
	    var post_title=post_title_input.val();

	    var sell_adopt_input = $("input[name='sell_adopt']");
		var sell_adopt= sell_adopt_input.val();
		
		var countryID=$("select[name='country']").find('option:selected').attr('data-countryid');

	    var price_input = $("input[name='price']");
	    var price=price_input.val();

	    var startDate_input = $("input[name='startDate']");
	    var startDate=startDate_input.val();

	    var endDate_input = $("input[name='endDate']");
	    var endDate=endDate_input.val();

	    var pet_category_id = $("input[name='pet_category_id']");
	    var pet_id=pet_category_id.val();

	    var pet_breed_id = $("input[name='pet_breed_id']");
	    var breed_id=pet_breed_id.val();

	    var pet_gender_input = $("input[name='pet_gender_input']");
	    var gender=pet_gender_input.val();

	    var location_contry_field = $("select[name='country']");
		var location_country=location_contry_field.val();
		var location_city= $("select[name='city']");

	    var phoneNumber_input = $("input[name='phoneNumber']");
	    var phoneNumber=phoneNumber_input.val();
	    var carrierCode = $("#btn-country .btn-cc").text();
	   		carrierCode = carrierCode.trim()

	   	var countryID=$("select[name='country']").find('option:selected').attr('data-countryid');
		var cityID=$("select[name='city']").find('option:selected').attr('data-cityid');

	    if(post_title != ''){post_title_input.removeClass("invalid").addClass("valid"); $('#title_required').hide();}
	    else{ post_title_input.removeClass("valid").addClass("invalid"); $('#title_required').show();$('.response_alerts .alert-warning').fadeIn();  return false;}

	    if(description != ''){description_input.removeClass("invalid").addClass("valid"); $('#description_error').hide();}
	    else{ description_input.removeClass("valid").addClass("invalid"); $('#description_error').show();$('.response_alerts .alert-warning').fadeIn(); return false;}

	    if(sell_adopt == 'sell'){ 

	    	if(price != ''){price_input.removeClass("invalid").addClass("valid"); $('#price_error_required').hide();}
	    	else{ price_input.removeClass("valid").addClass("invalid"); $('#price_error_required').show(); $('.response_alerts .alert-warning').fadeIn(); return false;}

		}
		else if(sell_adopt == 'pet-sitting'){ 

		   	if(startDate == '' || endDate == ''){
	        	$('#start_end_date_required').show();
	        	$('.response_alerts .alert-warning').fadeIn();
	            return false;
	        }

		}

        if($("input[name='agree_term']").prop("checked") == false){
        	$('#agree_term_error').show();
        	$('.response_alerts .alert-warning').fadeIn();
            return false;
        }

        if(pet_id == ''){
        	$('#pet_category_error').show();
        	$('#pet_category').css({'border': '1px solid rgb(184, 17, 17)','margin-bottom': '10px'});
        	$('.response_alerts .alert-warning').fadeIn();
            return false;
        }

        if(breed_id == ''){
        	$('#pet_breed_error').show();
        	$('#pet_breed').css({'border': '1px solid rgb(184, 17, 17)' ,'margin-bottom': '10px'});
        	$('.response_alerts .alert-warning').fadeIn();
            return false;
        }

        if(gender == ''){
        	$('#pet_gender_error').show();
        	$('#pet_gender').css({'border': '1px solid rgb(184, 17, 17)' ,'margin-bottom': '10px'});
        	$('.response_alerts .alert-warning').fadeIn();
            return false;
        }

        if(location_country == '' || location_city==''){
        	$('#location_error').show();
        	$('#location_list').css({'border': '1px solid rgb(184, 17, 17)'});
        	$('.response_alerts .alert-warning').fadeIn();
            return false;
        }

        if($('#featured_image')[0].files.length == 0){
        	$('#featured_image_error3').show();
        	$('.f_img_u_btn').css({'background-color': 'rgb(255 202 202)'});
        	$('.response_alerts .alert-warning').fadeIn();
            return false;
        }
        if(phoneNumber == ''){
        	$('#phoneNumber_error').show();
        	$('#phoneNumber').css({'border': '1px solid rgb(184, 17, 17)'});
        	$('.response_alerts .alert-warning').fadeIn();
        	$('div.popover .popover-content').css({'display': 'none'})
        	$('div.popover .arrow').css({'display': 'none'})
            return false;
        }


        $("input[type='submit']").val(' ');
        $("input[type='submit']").addClass('request_sent');
        $("input[type='submit']").attr('disabled','disabled');
        $(".submit-div .fa-spinner").fadeIn();

	    var fd = new FormData(document.forms["save_ap_post"]);
		fd.append('action', 'save_ap_post');
		// fd.append( "featured_image", $('#featured_image')[0].files[0]);
		// fd.append( "image_gallary", $('#image_gallary')[0].files);
		fd.append("country_id", countryID);
		fd.append("city_id", cityID);
		fd.append("carrierCode", carrierCode);
		// fd.append( "gender", $("#pet_gender_input").val());	

		$.ajax({
	        type: "POST",
	        url: ap.ajax_url,
	        data: fd,
	        processData: false,
	        contentType: false,
	        dataType: "json",
	        success: function(data, textStatus, jqXHR) {

	        	if(data.status == 'success'){
	        		$('.response_alerts .response_message').removeClass('alert-danger');
	        		$('.response_alerts .response_message').addClass('alert-success');
	        		$('.response_alerts .response_message').text('Your pet successfully added!')

	        	}
	        	else{
	        		$('.response_alerts .response_message').removeClass('alert-success');
	        		$('.response_alerts .response_message').addClass('alert-danger');
	        		$('.response_alerts .response_message').text('Please try later, something went wrong!')
	        	}

	        	$('.response_alerts .response_message').fadeIn();
		        $("input[type='submit']").removeClass('request_sent');
		        $("input[type='submit']").removeAttr('disabled');
		        $(".submit-div .fa-spinner").fadeOut();
		        $("input[type='submit']").val('Add Pet');


	        },
	        error: function(data, textStatus, jqXHR) {

	        	$('.response_alerts .response_message').removeClass('alert-success');
	        	$('.response_alerts .response_message').addClass('alert-danger');
	        	$('.response_alerts .response_message').text('Please try later, something went wrong!')

	        	$('.response_alerts .response_message').fadeIn();
		        $("input[type='submit']").removeClass('request_sent');
		        $("input[type='submit']").removeAttr('disabled');
		        $(".submit-div .fa-spinner").fadeOut();
		        $("input[type='submit']").val('Add Pet');

	        },
		});
	    
    });
    
	$("#my_pets .btn-delete").click(function(e){
		e.preventDefault();
		var pet_id = $(this).data('id');
		var x = confirm("Are you sure you want to delete?");
		if (x){

			$.ajax({
				url:ap.ajax_url, 
				type:'post', 
				data:{action:'delete_pet_by_id',pet_id:pet_id},
				async:false
			}).done(function(d){
				d= JSON.parse(d)
				console.log(d)
				location.reload();

			}).fail(function(d){
				alert('Something went wrong. Please try again later!');
			});

		}
		else{
			return false;
		}

	})


	//  FILTER JS

	/*Dropdown Menu*/
	$('.dropdown').click(function () {
	        $(this).attr('tabindex', 1).focus();
	        $(this).toggleClass('active');
	        $(this).find('.dropdown-menu').slideToggle(300);
	    });
	    $('.dropdown').focusout(function () {
	        $(this).removeClass('active');
	        $(this).find('.dropdown-menu').slideUp(300);
	    });
	/*End Dropdown Menu*/

	// when location , pet , breed and gender dropdown value selected 

	// When Make value selected
	$(document).on( 'click', '#pet_cat ul li', function(){
		temp = '';
		breed_id = '';
		pet_id = $(this).val()

		if(pet_id != -1){
			$('#pet_cat .select span').html($(this).html())
			$('#pet-breed .select span').html('Breed')
			$("#pet_category_id").val(pet_id)
		}
		
		$('#pet_breed .select span').text('BREED');
		console.trace($("#pet_cat .select"))

		$("#pet_cat .select").css({'background-color':'white'});

		breed = $('#pet_breed').find('.dropdown-menu')[0];
		$(breed).html(`<li value="-1">Please Select Pet</li>`);

		$('#pet_category_error').hide();
        $('#pet_cat').css({'border': '1px solid #c9c8c8' ,'margin-bottom': '20px'})

        $('.response_alerts .alert-warning').fadeOut();

		$.ajax({
			url:ap.ajax_url, 
			type:'post', 
			data:{action:'pet_child_cat',id:pet_id},
			async:false
		}).done(function(d){

			d = d.data;
			temp = '';

			$.each(d, function(k, v){

				temp += `<li value="`+v.term_id+`">`+v.name+`</li>`
			})
				
			$("#pet_breed ul.dropdown-menu").html(temp);

			setTimeout(function() {
		        $("#pet_category_req").slideUp(500); 
		    }, 100);

			

		}).fail(function(d){
			alert('No Child Category Found, Select another option!');
		});

	});

	// when pet Breed  selected
	$(document).on( 'click', '#pet_breed ul li', function(){

		breed_id = $(this).attr('value')

		$('#pet_breed .select span').html($(this).html())
		$('#pet_breed_id').val(breed_id);

		$('#pet_breed_error').hide();
        $('#pet_breed').css({'border': '1px solid #c9c8c8'  ,'margin-bottom': '20px'});

        $('.response_alerts .alert-warning').fadeOut();
	})

	// when pet gender selected
	$(document).on( 'click', '#pet_gender ul li', function(){

		gender = $(this).attr('value')

		$('#pet_gender .select span').html($(this).html())
		$('#pet_gender_input').val(gender);

		$('#pet_gender_error').hide();
        $('#pet_gender').css({'border': '1px solid #c9c8c8'  ,'margin-bottom': '20px'});

        $('.response_alerts .alert-warning').fadeOut();
	})
    
     // when loaction selected from list
	$(document).on( 'click', '#location_list ul li', function(){
		temp = '';
		location = $(this).attr('value')

		$('#location_list .select span').html($(this).html())
		$('#location_input').val(location);

		$('#location_error').hide();
        $('#location_list').css({'border': '1px solid #c9c8c8'});

        $('.response_alerts .alert-warning').fadeOut();
	})

	//  when radio button option selected 
        $("input[name='sell_adopt']").on('change', function(e) {
		    var sell_adopt_input = $(this);
		    sell_adopt=sell_adopt_input.val();
	     });

		$("#search_pet").click(function(e){
		e.preventDefault();

		if(pet_id == ''){
			$("#pet_category_req").slideDown(500);
			$("#pet_cat .select").css({'background-color':'#FFCCCC'});
			return;
		}
		window.location.href = ap.site_url + '/pets/?cid='+pet_id+'&bid='+breed_id+'&city='+location+'&g='+gender+'&type='+sell_adopt;

		
	})

	})
})(jQuery);

