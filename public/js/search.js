(function($) {

	$(document).ready(function(){

		var ap = window.ap;
		var pet_id = '', breed_id = '', gender = '', location = '', temp = '', sell_adopt = 'sell';

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
	$(document).on( 'click', '#pet_category ul li', function(){
		temp = '';
		breed_id = '';
		pet_id = $(this).val()

		if(pet_id != -1){
			$('#pet_category .select span').html($(this).html())
			$('#pet-breed .select span').html('Breed')
			$("#pet_category_id").val(pet_id)
		}
		
		$('#pet_breed .select span').text('BREED');
		console.trace($("#pet_category .select"))

		$("#pet_category .select").css({'background-color':'white'});

		breed = $('#pet_breed').find('.dropdown-menu')[0];
		$(breed).html(`<li value="-1">Please Select Pet</li>`);

		$('#pet_category_error').hide();
        $('#pet_category').css({'border': '1px solid #c9c8c8' ,'margin-bottom': '20px'})

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
			$("#pet_category .select").css({'background-color':'#FFCCCC'});
			return;
		}
		window.location.href = ap.site_url + '/pets/?cid='+pet_id+'&bid='+breed_id+'&city='+location+'&g='+gender+'&type='+sell_adopt;

		
	})

	})
})(jQuery);

