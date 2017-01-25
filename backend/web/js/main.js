// $(document).ajaxSuccess(function( event, request, settings ) {
//   alert( "Starting request at " + settings.url  );
// });

		
$(function(){
	// event click button dengan id modalButton
	$('#modalButton').click(function(event) {
		//ajax('/yii2_bbt/backend/web/index.php?r=virtual/create');
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
	});

	
});
function create(url)
{
	$('#modal').modal('show')
			.find('#modalContent')
			.load(url);
}
function status(){
	
}

