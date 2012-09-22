/* 
	Clean Form Validation was written from scratch by Marc Grabanski
// http://marcgrabanski.com/code/clean-form-validation
/* Under the Creative Commons Licence http://creativecommons.org/licenses/by/3.0/
	Share or Remix it but please Attribute the authors. */

var cleanValidator = {
	init: function (settings) {
		this.settings = settings;
		this.form = document.getElementById(this.settings["formId"]);
		formInputs = this.form.getElementsByTagName("input");
		
		// change color of inputs on focus
		for(i=0;i<formInputs.length;i++)
		{
			if(formInputs[i].getAttribute("type") != "submit") {
				input = formInputs[i];
				input.style.background = settings["inputColors"][0];
				input.onblur = function () {
					this.style.background = settings["inputColors"][0];
				}
				input.onfocus = function () {
					this.style.background = settings["inputColors"][1];
				}
			}
		};
		this.form.onsubmit = function () {
			error = cleanValidator.validate();
			if(error.length < 1) {
				return true;
			} else {
				cleanValidator.printError(error);
				return false;
			}
		};
	},
	validate: function () {
		
		error = '';
		notEqArray = new Array();
		EqArray = new Array();
		
		validationTypes = new Array("isRequired", "isEmail", "isNumeric","isRequiredSelection","reqEqual","reqSelectNotEqual");
		for(n=0; n<validationTypes.length; n++) {
			var x = this.settings[validationTypes[n]];
			if(x != null ) {
				for(i=0; i<x.length; i++) 
				{
					inputField = document.getElementById(x[i]);
				
					switch (validationTypes[n]) {
						case "isRequired" :
							//if(!isRequired(inputField.value))
								//valid = 0;
						    valid = !isRequired(inputField.value);
						errorMsg = "is a required field.";
						break;
						case "isEmail" :
						valid = isEmail(inputField.value);
						errorMsg = "is an invalid email address.";
						break;
						case "isNumeric" :
						valid = isNumeric(inputField.value);
						errorMsg = "can only be a number.";
						break;
						case "isRequiredSelection" :
							var elementValue = document.getElementById(x[i]).selectedIndex;
							valid = !isRequired(elementValue);
							errorMsg = "is a required field.";
							break;
						case "reqEqual" :
							if(typeof(EqArray[0]) == "undefined") {
								EqArray[0] = inputField.value;
							}
							else {
								EqArray[1] = inputField.value;
								if(EqArray[0] != EqArray[1]) {
									valid = 0;
									errorMsg = "Passwords do not match!";
								}
							}
							break;
						case "reqSelectNotEqual" :
							var elementValue2 = document.getElementById(x[i]).selectedIndex;
							if(typeof(notEqArray[0]) == "undefined" && typeof(elementValue2) != "undefined") {
								notEqArray[0] = elementValue2;
							}
							else {
								notEqArray[1] = elementValue2;
								if(notEqArray[0] == notEqArray[1]) {
									valid = 0;
									errorMsg = "Please pick a different second security question";
								}
							}
							break;
						
					}
					
					if(!valid) {
						error += x[i]+" "+errorMsg+"\n";
						inputField.style.background = this.settings["errorColors"][0];
						inputField.style.border = "1px solid "+this.settings["errorColors"][1];
					} else {
						inputField.style.background = this.settings["inputColors"][0];
						inputField.style.border = '1px solid';
					}
				}
			}
		}
		return error;
	},
	printError: function (error) {
		alert(error);
		
	}
};

// returns true if the string is not empty
function isRequired(str){
	return (str == null) || (str.length == 0) || (str == "");
}
// returns true if the string is a valid email
function isEmail(str){
	if(isRequired(str)) return false;
	var re = /^[^\s()<>@,;:\/]+@\w[\w\.-]+\.[a-z]{2,}$/i
	return re.test(str);
}
// returns true if the string only contains characters 0-9 and is not null
function isNumeric(str){
	if(isRequired(str)) return false;
	/* /[\D]/g */
	var re = /[^\d/\./]/
		
	if (re.test(str)) return false;
	return true;
}