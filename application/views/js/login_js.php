jQuery(document).ready(function ()
{
	jQuery('#loginButton').click(function (e)
								 {
		e.preventDefault();
		var email = jQuery('#email').val();
		var pw = jQuery('#password').val();

		//all the required fields to validate
		var allFields = jQuery([]).add("#email").add("#password");
		var tips = jQuery('.tips');
		//clear errors before validation
		allFields.removeClass("ui-state-error");
		clearTips(tips);
		//validate
		var valid = validEmail(jQuery('#email'), tips);
		//password check
		if (valid && jQuery.trim(pw) == "")
		{
			valid = false;
			jQuery("#password").addClass("ui-state-error");
			updateTips("You must enter a Password", tips);
		}

		if (valid)
		{
			jQuery.ajax({
				type:"POST",
				url:base_url + "login/log_in",
				data:"email=" + email + "&password=" + pw,
				cache:false,
				success:function (data)
				{
					//data could return invalid email
					if (data == false)
					{
						jQuery("#email").addClass("ui-state-error");
						jQuery("#password").addClass("ui-state-error");
						updateTips("Invalid user name and password combination", tips);
					}
					else
					{
						updateTips("Entering", tips);
						setTimeout(function() {
							window.location = base_url;
						}, 800);
					}
				},
				error:function (data)
				{
                    $('body').html(data.responseText);
				}
			});
		}
		return false;
	});
    
    $(".nav-tabs a").click(function() {
        $(this).tab('show');
    });
    
    if( <?=$admin?> == 1 ) {
        $('.nav-tabs a[href="#login"]').tab('show')
    }


});
