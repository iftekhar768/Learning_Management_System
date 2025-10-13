let userId = document.getElementById("userId");
let idErr = document.getElementById("idErr");

let username = document.getElementById("username");
let nameErr = document.getElementById("nameErr");

let roleSelect = document.getElementById("roleSelect");
let roleErr = document.getElementById("roleErr");

let email = document.getElementById("email");
let emailErr = document.getElementById("emailErr");

let pass = document.getElementById("pass");
let passErr = document.getElementById("passErr");

let isValidated = false;

function validationForm()
{
    if(username.value)
    {
        isValidated=true;
    }

    else
    {
        isValidated=false;
        nameErr.innerHTML="Please provide an userName";
        nameErr.style.color="red";
    }

    if(userId.value)
    {
        isValidated=true;
    }

    else
    {
        isValidated=false;
        idErr.innerHTML="Please Provide a userId";
        idErr.style.color="Red";

    }


    if(email.value)
    {
        isValidated=true;
    }

    else
    {
        isValidated=false;
        emailErr.innerHTML="Plase enter your email";
        emailErr.style.color="red";
    }
    if(pass.value)
    {
        isValidated=true;
    }

    else
    {
        isValidated=false;
        passErr.innerHTML="Please provide your password";
        passErr.style.color="red";
    }

    if(isValidated)
    {
        alert("user ID: "+userId.value+", user name: "+username.value+", email: "+email.value);
        return true;
    }

    else
    {
        return false;
    }
}
