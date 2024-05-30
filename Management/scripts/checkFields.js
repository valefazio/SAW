function checkEmailFormat() {
    emailPattern = /\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,}\b/;
    if (!emailInput.value.match(emailPattern) || emailInput.value.length < 5 || emailInput.value.length > 254) {
        emailInput.setCustomValidity('Email not valid');
        emailInput.setAttribute('style', 'border-color: red; background-color: #fdd');
    } else {
        emailInput.setCustomValidity('');
        emailInput.setAttribute('style', 'border-color: #ccc');
    }
}

function checkPasswordFormat() {
    passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_-])[A-Za-z\d@$!%*?&_-]{8,}$/;
    if(!passwordInput.value.match(passwordPattern)) {
        passwordInput.setCustomValidity('La password deve contenere almeno 8 caratteri, di cui almeno una lettera maiuscola, una minuscola, un numero e un carattere speciale');
        passwordInput.setAttribute('style', 'border-color: red; background-color: #fdd');
    } else {
        passwordInput.setCustomValidity('');
        passwordInput.setAttribute('style', 'border-color: #ccc');
    }
}

function checkPasswordMatch() {
    if(passwordInput.value != confirmPasswordInput.value) {
        confirmPasswordInput.setCustomValidity('Le password non coincidono');
        confirmPasswordInput.setAttribute('style', 'border-color: red; background-color: #fdd');
    } else {
        confirmPasswordInput.setCustomValidity('');
        confirmPasswordInput.setAttribute('style', 'border-color: #ccc');
    }
}

function toggleButton(button) {
    //checkEmailFormat(); Non credo siano necessari
    //checkPasswordFormat();	
    if (emailInput.value !== "" && passwordInput.value !== "") {
        button.removeAttribute("disabled");
    } else {
        button.setAttribute("disabled", "disabled");
    }
}

function checkNameFormat() {
    var namePattern = /^[a-zA-ZÀ-ÿ\s']+$/;
    if (!firstnameInput.value.match(namePattern) || firstnameInput.value.length < 2 || firstnameInput.value.length > 50) {
        firstnameInput.setCustomValidity('Il nome può contenere solo lettere e spazi');
        firstnameInput.setAttribute('style', 'border-color: red; background-color: #fdd');
    } else {
        firstnameInput.setCustomValidity('');
        firstnameInput.setAttribute('style', 'border-color: #ccc');
    }

    if (!lastnameInput.value.match(namePattern) || lastnameInput.value.length < 2 || lastnameInput.value.length > 50) {
        lastnameInput.setCustomValidity('Il cognome può contenere solo lettere e spazi');
        lastnameInput.setAttribute('style', 'border-color: red; background-color: #fdd');
    } else {
        lastnameInput.setCustomValidity('');
        lastnameInput.setAttribute('style', 'border-color: #ccc');
    }
}
