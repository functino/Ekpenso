$(document).ready(function(){
	$("#flashMessage").hide().fadeIn('slow').animate({opacity: 1.0}, 2000).animate({opacity: 0.4}, 2000).animate({opacity: 0.0, height: 15}, 1500, function(){
		$('#flashMessage').css('padding', '0');
		$('#flashMessage').css('background-image', 'none');
		$('#flashMessage').css('margin-top', '0px');
		$('#flashMessage').css('border', 'none');
		$('#flashMessage').css('font-weight', 'bold');
		$('#flashMessage').css('font-size', '10px');
		$('#flashMessage').css('height', '14px');
		$('#flashMessage').css('color', '#88AA00');
		$('#flashMessage').css('text-align', 'center');
		$('#flashMessage.error_message').css('color', '#8b0000');
		$('#flashMessage').css('background-color', 'white');
	}).animate({opacity: 0.8, height: 13}, 0);
});