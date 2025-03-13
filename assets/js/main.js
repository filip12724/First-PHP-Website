$(document).ready(function(){
    $(document).on("click", "#btn", function(event){
        event.preventDefault();

        let fname = $("#firstname");
        let lname = $("#lastname");
        let email = $("#email");
        let phone = $("#phone");
        let address = $("#address");
        let passwd=$("#password");
        let rpasswd=$("#rpassword");

        let isValid=true;
        let nameRegex = /^[A-Z][a-z]{1,24}$/;
        let emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        let phoneRegex = /^(\d){8,30}$/;
        let addressRegex = /^[A-Za-z0-9\s\.,#-]{1,35}$/;

        if (!checkValue(nameRegex, fname.val())) {
            $("#fname-error").text("First name should start with a capital letter and contain 2-25 characters (letters only)").show();
            isValid=false;
        } else {
            $("#fname-error").hide();
        }

        if (!checkValue(nameRegex, lname.val())) {
            $("#lname-error").text("Last name should start with a capital letter and contain 2-25 characters (letters only)").show();
            isValid=false;
        } else {
            $("#lname-error").hide();
        }

        if (!checkValue(emailRegex, email.val())) {
            $("#email-error").text("Email is not valid").show();
            isValid=false;
        } else {
            $("#email-error").hide();
        }

        if (!checkValue(phoneRegex, phone.val())) {
            $("#phone-error").text("Phone number should be 8-30 digits").show();
            isValid=false;
        } else {
            $("#phone-error").hide();
        }

        if (!checkValue(addressRegex, address.val())) {
            $("#address-error").text("Address should contain 1-35 characters (letters, digits, spaces, and special characters)").show();
            isValid=false;
        } else {
            $("#address-error").hide();
        }

        if (passwd.val()!=rpasswd.val()) {
            $("#passwd-error").text("Passwords do not match").show();
            isValid=false;
        } else {
            $("#passwd-error").hide();
        }
        if(isValid) {
            let formData = {
                fname: fname.val(),
                lname: lname.val(),
                email: email.val(),
                phone: phone.val(),
                address: address.val(),
                passwd: passwd.val(),
            };

                ajaxCallBack("../PHP-1-sajt/check-form.php","POST",formData,function(response) {


                    fname.val('');
                    lname.val('');
                    email.val('');
                    phone.val('');
                    address.val('');
                    passwd.val('');
                    rpasswd.val('');

                    window.location.href = "log-in.php";

                })

        }
    });
});


$(document).ready(function(){
    $(document).on("click", "#btnLog", function(eventLog){
        eventLog.preventDefault();

        let email = $("#emailLog");
        let passwd=$("#passwdLog");

        let isValid=true;
        let emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;


        if (!checkValue(emailRegex, email.val())) {
            console.log(isValid)
            $("#email-errorLog").text("Email is not valid").show();
            isValid=false;
        } else {
            $("#email-errorLog").hide();
        }
        console.log(isValid)
        if(isValid) {
            let dataForChecking={
                email:email.val(),
                passwd:passwd.val()
            }
            console.log(dataForChecking);
            ajaxCallBack("../PHP-1-sajt/check-log-in.php","POST",dataForChecking,function(response) {
                if (response && response.role) {
                    if (response.role === "admin") {
                        window.location.href = "admin-panel.php";
                    } else {
                        window.location.href = "shop.php";
                    }
                } else {
                    console.log("Invalid response format.");
                }
            })
        }
    });
});
function checkValue(regex, string){
    return regex.test(string);
}
    function ajaxCallBack(url,method,data,result){
        $.ajax({
            url: url,
            method:method,
            data:data,
            dataType: "json",
            success:result,
            error: function(xhr) {
                console.log(xhr);

                if (xhr.status === 404) {
                    console.log("The requested resource was not found.");
                } else if (xhr.status === 500) {
                    console.log("Internal Server Error. Please try again later.");
                }
                else if (xhr.status === 401) {
                    console.log("Login failed. Please check your credentials.");
                }
            }



        })
}

$(document).ready(function() {
    $('.close-button').click(function() {
        var index = $(this).data('index');
        ajaxCallBack("remove_product.php", "GET", {index: index}, function(response) {
            console.log(response);
            if(response.status === 'success') {
                window.location.href = 'cart.php';
            } else {

                alert(response.message);
            }
        });
    });
});
document.addEventListener('DOMContentLoaded', function() {
    var quantityInput = document.getElementById('quantityInput');
    if (quantityInput) {
        quantityInput.addEventListener('input', function() {
            var currentValue = parseInt(quantityInput.value);
            if (isNaN(currentValue) || currentValue < 1) {
                quantityInput.value = 1;
            } else if (currentValue > 5) {
                quantityInput.value = 5;
            }
        });
    }
});

$(document).ready(function(){

    $('table.zebra tbody tr:even').addClass('even-row');
});