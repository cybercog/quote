function clearText(thefield)
{
	if (thefield.defaultValue == thefield.value) {
		thefield.value = "";
	}
}

function restoreText(thefield)
{
	if (thefield.value == "")
	{
		thefield.value = thefield.defaultValue;
	}
}

function defaultChecks(form_name)
{
    var errors = [];
    var key = 0;

    var inputs = document.getElementsByTagName( "input" ), input, i = 0, elem;    
    while ( input = inputs[i++] )
    {
        // 1. current value != default value;
        // 2. current value isn't empty;
        // 3. type of current item isn't `hidden` and `submit`;
        if ( ( input.value == input.defaultValue || input.value == "" ) && input.type != "hidden" && input.type != "submit" ) {
            errors[key] = input.name;
            key++;
        }
    }
    
    var textareas = document.getElementsByTagName( "textarea" ), textarea, t = 0, elem;    
    while ( textarea = textareas[t++] )
    {
        textarea.value = trimString(textarea.value);
        
        if (textarea.value == textarea.defaultValue || textarea.value == "") {
            errors[key] = textarea.name;
            key++;
        }
    }
    
    if ( errors.length > 0 ) {
        // Marking elements with errors
        for ( var key in errors ) {
            elements = document.getElementsByName(errors[key]);
            for ( var i = 0; i < elements.length; i++ ) {
                
                // If we already have marked field as class += 'error'
                if ( elements.item(i).className.substr(-5,5) != "error" ) {
                    elements.item(i).className += ' error';
                }
            }
        }
        
        return false;
    }
    else {
        return true;
    }
}

function trimString(sInString) {
    sInString = sInString.replace(/ /g,' ');
    
    return sInString.replace(/(^\s+)|(\s+$)/g, "");
}