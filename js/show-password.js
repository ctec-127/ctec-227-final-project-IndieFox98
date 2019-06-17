function togglePassword(pwd_id) {
    var pwd_field = document.getElementById(pwd_id);
    var btn = document.getElementById("tgl-" + pwd_id);

    if (pwd_field.type === "password") {
        pwd_field.type = "text";
        btn.innerHTML = '<i class="fa fa-eye-slash"></i>';
    } else {
        pwd_field.type = "password";
        btn.innerHTML = '<i class="fa fa-eye"></i>';
    }
}