// returns the user to their position in the form upon submission
$(window).scroll(function() {
	sessionStorage.scrollTop = $(this).scrollTop();
});

$(document).ready(function() {
	if (sessionStorage.scrollTop != "undefined") {
		$(window).scrollTop(sessionStorage.scrollTop);
	}
});

// determines if player details should be shown or not based on the users selection
$(document).ready(function() {
	var target = $('#hidden');
	var select = $('#a3').val();
		
	if (select == '1'){
		target.show();
	}
	if (select == '0'){
		target.hide();
	}
	$('#a3').change(function(){
		var target = $('#hidden');
		var select = $('#a3').val();
		
		target.hide();
		
		if (select == '1'){
			target.show();
		}
		if (select == '0'){
			target.hide();
		}
	})
});
$(document).ready( function() {
	$('#a1').change(function() {
		$(this).closest('form').submit();
	});
	
	$('#l0').change(function() {
		$(this).closest('form').submit();
	});
});

// alows for pretty tooltips
$(document).ready(function() {
	$("[data-toggle='tooltip']").tooltip();
})(window.jQuery);