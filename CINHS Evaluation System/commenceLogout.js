function commenceLogout()
{
    let confirmLogout = confirm("Are you sure you want to logout?");

    if(confirmLogout)
    {   
        alert("Logout successful.");
        window.location.href="login-form.php";
    }
}