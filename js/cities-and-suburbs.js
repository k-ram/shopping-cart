$(document).ready(function(){

	// Listen for a change event in cities select element
	$('#cities').change(function() {

		// Get ID of the chosen city
		var cityID = $(this).val() ;

		//basic validation
		if ( cityID == '') {
			return;
		};

		// AJAX 
		$.ajax({

			type: 'get',
			url: 'api/cities-and-suburbs.php',
			data: {
				city: cityID
			},
			success: function( dataFromServer ) {

				console.log( dataFromServer );

				// Clear any old resuts from the suburbs select element
				$('#suburbs').html('');

				for (var i = 0; i < dataFromServer.length; i++) {

					$('#suburbs').append('<option value="'+dataFromServer[i].suburbID+'">'+dataFromServer[i].suburbName+'</option>');
				};


			},
			error: function() {
				alert('Something went wrong.');
			}
		});


	});
});