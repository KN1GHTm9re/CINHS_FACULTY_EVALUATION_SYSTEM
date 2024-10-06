// for registration toggle password
function showPasswordFromRegistration() {
    let btnShowPassword = document.getElementById("reg-show-password");
    let txtPassword = document.getElementById("reg-password-txt");

    // Remove any existing event listeners
    document.removeEventListener("click", togglePasswordVisibilityForRegistration);

    // Add a new event listener
    document.addEventListener("click", togglePasswordVisibilityForRegistration);
}

// for registration toggle confirm password
function showConfirmPasswordFromRegistration() {
    let btnShowPassword = document.getElementById("reg-show-confirmpassword");
    let txtPassword = document.getElementById("reg-confirmpassword-txt");

    // Remove any existing event listeners
    document.removeEventListener("click", toggleConfirmPasswordVisibilityForRegistration);

    // Add a new event listener
    document.addEventListener("click", toggleConfirmPasswordVisibilityForRegistration);
}

// for login toggle password
function showPasswordForLogin() {
    // Remove any existing event listeners
    document.removeEventListener("click", togglePasswordVisibilityForLogin);

    // Add a new event listener
    document.addEventListener("click", togglePasswordVisibilityForLogin);
}

// for callback function
function togglePasswordVisibilityForLogin(event) {
    let btnShowPasswordLogin = document.getElementById("btnShowPasswordLogin");
    let txtPasswordLogin = document.getElementById("txtPasswordLogin");

    if (event.target && event.target.id == "btnShowPasswordLogin") {
        if (btnShowPasswordLogin.textContent == "SHOW") {
            txtPasswordLogin.type = "text";
            btnShowPasswordLogin.textContent = "HIDE";
           
        } else {
            txtPasswordLogin.type = "password";
            btnShowPasswordLogin.textContent = "SHOW";  
        }
    }
}

// for login toggle password
function showPasswordForAddingUser() {
    // Remove any existing event listeners
    document.removeEventListener("click", togglePasswordVisibilityForAddingUser);

    // Add a new event listener
    document.addEventListener("click", togglePasswordVisibilityForAddingUser);
}

// for callback function
function togglePasswordVisibilityForAddingUser(event) {
    let btnShowPasswordAddUser = document.getElementById("btnShowPasswordAddUser");
    let txtPasswordAddUser = document.getElementById("txtPasswordAddUser");

    if (event.target && event.target.id == "btnShowPasswordAddUser") {
        if (btnShowPasswordAddUser.textContent == "SHOW") {
            txtPasswordAddUser.type = "text";
            btnShowPasswordAddUser.textContent = "HIDE";
           
        } else {
            txtPasswordAddUser.type = "password";
            btnShowPasswordAddUser.textContent = "SHOW";  
        }
    }
}

// for login toggle password
function showPasswordForUpdatingUser() {
    // Remove any existing event listeners
    document.removeEventListener("click", togglePasswordVisibilityForUpdatingUser);

    // Add a new event listener
    document.addEventListener("click", togglePasswordVisibilityForUpdatingUser);
}

// for callback function
function togglePasswordVisibilityForUpdatingUser(event) {
    let btnShowPasswordUpdateUser = document.getElementById("btnShowPasswordUpdateUser");
    let txtPasswordUpdateUser = document.getElementById("txtPasswordUpdateUser");

    if (event.target && event.target.id == "btnShowPasswordUpdateUser") {
        if (btnShowPasswordUpdateUser.textContent == "SHOW") {
            txtPasswordUpdateUser.type = "text";
            btnShowPasswordUpdateUser.textContent = "HIDE";
           
        } else {
            txtPasswordUpdateUser.type = "password";
            btnShowPasswordUpdateUser.textContent = "SHOW";  
        }
    }
}

// for login toggle password
function showPasswordForEditProfile() {
    // Remove any existing event listeners
    document.removeEventListener("click", togglePasswordVisibilityForEditProfile);

    // Add a new event listener
    document.addEventListener("click", togglePasswordVisibilityForEditProfile);
}

// for callback function
function togglePasswordVisibilityForEditProfile(event) {
    let btnShowPasswordEditProfile = document.getElementById("btnShowPasswordEditProfile");
    let txtPasswordEditProfile = document.getElementById("txtPasswordEditProfile");

    if (event.target && event.target.id == "btnShowPasswordEditProfile") {
        if (btnShowPasswordEditProfile.textContent == "SHOW") {
            txtPasswordEditProfile.type = "text";
            btnShowPasswordEditProfile.textContent = "HIDE";
           
        } else {
            txtPasswordEditProfile.type = "password";
            btnShowPasswordEditProfile.textContent = "SHOW";  
        }
    }
}



// for reg confirm password
function togglePasswordVisibilityForRegistration(event) {
    let btnShowPassword = document.getElementById("reg-show-password");
    let txtPassword = document.getElementById("reg-password-txt");

    if (event.target && event.target.id === "reg-show-password") {
        if (btnShowPassword.src.includes("show-password.png")) {
            btnShowPassword.src = "hide-password.png";
            txtPassword.type = "text";
            btnShowPassword.style.left = "57.8%";
        } else {
            btnShowPassword.src = "show-password.png";
            txtPassword.type = "password";
            btnShowPassword.style.left = "57.5%";
        }
    }
}

// for login password
function toggleConfirmPasswordVisibilityForRegistration(event) {
    let btnShowPassword = document.getElementById("reg-show-confirmpassword");
    let txtPassword = document.getElementById("reg-confirmpassword-txt");

    if (event.target && event.target.id === "reg-show-confirmpassword") {
        if (btnShowPassword.src.includes("show-password.png")) {
            btnShowPassword.src = "hide-password.png";
            txtPassword.type = "text";
            btnShowPassword.style.left = "57.8%";
        } else {
            btnShowPassword.src = "show-password.png";
            txtPassword.type = "password";
            btnShowPassword.style.left = "57.5%";
        }
    }
}

