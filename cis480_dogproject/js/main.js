
function checkPasswordStrength() {
	var number = /([0-9])/;
	var alphabets = /([a-zA-Z])/;
	var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;

	if($('#password').val().length<6) {
		$('#password-strength-status').removeClass();
		$('#password-strength-status').addClass('weak');
		$('#password-strength-status').html("Weak (should be atleast 6 characters.)");
	} else {  	
		if($('#password').val().match(number) && $('#password').val().match(alphabets) && $('#password').val().match(special_characters)) {            
			$('#password-strength-status').removeClass();
			$('#password-strength-status').addClass('strong');
			$('#password-strength-status').html("Strong Password");
		} else {
			$('#password-strength-status').removeClass();
			$('#password-strength-status').addClass('medium');
			$('#password-strength-status').html("Needs to Contain at least 1 number, Special Character, Capital, and LowerCase Letter.");
		} 
	}
}