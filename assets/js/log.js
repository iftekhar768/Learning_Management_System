let userId = document.getElementById("userId");
let idErr = document.getElementById("idErr");

let pass = document.getElementById("pass");
let passErr = document.getElementById("passErr");

let isValidated=false;

function validationForm()
{
    

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
        
        return true;
    }

    else
    {
        return false;
    }
    
}
