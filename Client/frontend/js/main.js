var $yearSpan = $('.js_year');
var $year = $('#Year');

$year.on('input', function(){
    $yearSpan[0].textContent = $year.val();
});
$yearSpan[0].textContent = $year.val();

var $speedSpan = $('.js_maxspeed');
var $speed = $('#maxSpeed');
$speed.on('input', function(){
    $speedSpan[0].textContent = $speed.val() + " km/h";
});
$speedSpan[0].textContent = $speed.val() + " km/h";

var $priceSpan = $('.js_price');
var $price = $('#Price');
$price.on('input', function(){
    $priceSpan[0].textContent = $price.val() + "$";
});
$priceSpan[0].textContent = $price.val() + "$";

var $carList = $('#js-carsList');
var $carDetailed = $('#js-carsDetailed');
var $signUpForm = $('#js-registration');
var $btnFilter = $('#js-filter');
var $helloBar = $('#js-hello-bar');
var $userBar = $('#js-userbar');
var $statusBlock = $('#js-status');
var $loginBar = $('#js-loginbar');

//$helloBar.hide();

function userRegistration()
{
    $carDetailed.hide("fast");
    $carList.hide("fast");
    $signUpForm.show("fast");
}

$("#js-signup").click(function(){
    userRegistration();
});

function is_numeric( mixed_var ) {
	return !isNaN( mixed_var );
}


function carFilter(){
    var formData = {
        filter: {
            year: $('input[name=year]').val(),
            model: $('input[name=model]').val(),
            capacity: $('select[name=capacity]').val(),
            color: $('select[name=color]').val(),
            maxSpeed: $('input[name=maxSpeed]').val(),
            price: $('input[name=price]').val()
        }
    };
    if (formData.filter.year && is_numeric(formData.filter.year)){
        //console.log(formData);
        $carList.show();
        $carDetailed.hide("fast");
        $.ajax({
            type: "GET",
            url: "api/cars/",
            data: formData,
            dataType: "json",
            success: function(cars){
                $carList.html("");
                if (cars){
                    cars.forEach(car => {
                        $carList.append("<div class='col-lg-4 col-md-12 col-sm-12 col-xl-2 border border-light ml-1 mb-1 js-details' onclick='carDetails(" + car.id + ")' id='"+ car.id + "'><a href='#"+ car.id + "'>" + car.brand + " " + car.model + "</div>")
                    });
                } else {
                    $carList.html('<div class="col-12"><h2>Sorry, but we have no cars with this params!</h2></div>')
                }
            }
        });
    } else {
        $carList.html('<div class="col-12"><h2>Please, set year as numeric type. This field is required!</h2></div>');
    }
}

(function() {
    $carDetailed.hide();
    $signUpForm.hide();
    $statusBlock.hide();
    if(localStorage.getItem('nickname'))
    {
        $userBar.text("Hello, " + localStorage.getItem('nickname'))

        $helloBar.show();
        $loginBar.hide();
    } else {
        $helloBar.hide();
        $loginBar.show();
    }
    $.ajax({
        type: "GET",
        url: "api/cars/",
        success: function(result){
            var cars = ($.parseJSON(result));
            cars.forEach(car => {
                $carList.append("<div class='col-lg-4 col-md-12 col-sm-12 col-xl-2 border border-light ml-1 mb-1 js-details' onclick='carDetails(" + car.id + ")' id='"+ car.id + "'><a href='#"+ car.id + "'>" + car.brand + " " + car.model + "</div>")
            });
        }
    });
}());

function onMain() {
    $carDetailed.hide("fast");
    $carList.show("fast");
}

function carDetails(id){
    $carList.hide();
    $carDetailed.show("fast");
    $.ajax({
        type: "GET",
        url: "api/cars/" + id,
        success: function(result){
            if(result != "null"){
                var car = ($.parseJSON(result));
                $carDetailed.html(`
                <div class="col-9">
                            <table class="table">
                                <tbody>
                                    <tr>
                                    <th scope="row">Brand and model</th>
                                    <td>` + car.brand + ` ` + car.model + `</td>
                                    </tr>
                                    <tr>
                                    <th scope="row">Year</th>
                                    <td>` + car.year + `</td>
                                    </tr>
                                    <tr>
                                    <th scope="row">Engine capacity</th>
                                    <td>` + car.capacity + `</td>
                                    </tr>
                                    <tr>
                                    <th scope="row">Color</th>
                                    <td>` + car.color + `</td>
                                    </tr>
                                    <tr>
                                    <th scope="row">Max Speed</th>
                                    <td>` + car.max_speed + ` km/h</td>
                                    </tr>
                                    <tr>
                                    <th scope="row">Price</th>
                                    <td>$` + car.price + `</td>
                                    </tr>
                                </tbody>
                            </table>
                            <button onclick="onMain()" class="btn btn-primary">Back to list</button>
                        </div>
                `);
            } else {
                $carDetailed.html('<div class="col-9"><h2>Sorry, but we don\'t have car with this id!</h2></div>');
            }
        },
        error: function(){
            $carDetailed.html("<div class='col-9'><h2>Sorry, but we don't have car with this id!</h2></div>");
        }
    });
}

function signup(){
    var formData = $('#js-signup-form').serializeArray();
    console.log(formData);
    var status = true;
    formData.forEach(element => {
        if (!element.value)
        {
            $statusBlock.html("<h2>All fields are required!</h2>")
            $statusBlock.show("fast");
            status = false;
        }
    })
    if(status)
    {
        $.ajax({
            type: "post",
            url: "api/signup/",
            data: formData,
            success: function(result){
                console.log(result);
                switch (result) {
                    case '"success"':
                        $signUpForm.html('<div class="col-12"><h2>Thanks for registration! Now you can login</h2></div>');
                        break;
                    case '"failed"':
                        $signUpForm.html('<div class="col-12"><h2>Sorry, but your registration failed. Try again.</h2></div>');
                        break;
                    case '"password"':
                        $signUpForm.html('<div class="col-12"><h2>Please, try again. Passwords are not equal.</h2></div>');
                        break;
                    case '"exists"':
                            $signUpForm.html('<div class="col-12"><h2>Sorry, but user with this nickname or email already exists. Try again.</h2></div>');
                            break;
                    default:
                        $signUpForm.html('<div class="col-12"><h2>Sorry, but your registration not over. Try again.</h2></div>');
                        break;
                };
            },
            error: function(){
                $signUpForm.html('<div class="col-12"><h2>Sorry, but your registration not over. Try again.</h2></div>');
            }
        });
    } else {
        return false;
    }
}

$("#btn-signup").click(function(){
    signup();
});

function signin(){
    var formData = $('#js-signin-form').serializeArray();
    formData.push({name: "operation", value: "login"});
    console.log(formData);
    if (!formData[0].value || !formData[1].value)
    {
        $statusBlock.html("<h2>All fields are required!</h2>")
        $statusBlock.show("fast");
        return false;
    }
    $.ajax({
        type: "put",
        url: "api/signin/",
        data: formData,
        dataType: "json",
        success: function(result){
            console.log(result);
            switch (result.status) {
                case 'success':
                    localStorage.setItem('id', result.id);
                    localStorage.setItem('nickname', result.nickname);
                    localStorage.setItem('token', result.token);
                    $userBar.text("Hello, " + result.nickname);
                    $userBar.show("fast");
                    location.reload();
                    break;
                case 'no_user':
                    $statusBlock.html("<h2>No user with this email. Please, check fields and try again.</h2>")
                    $statusBlock.show("fast");
                    break;
                case 'password':
                    $signUpForm.html('<div class="col-12"><h2>Please, try again. Passwords are not equal.</h2></div>');
                    break;
                case 'err_password':
                    $statusBlock.html("<h2>Wrong password. Please, check fields and try again.</h2>");
                    $statusBlock.show("fast");
                    break;
                default:
                    $statusBlock.html('<h2>Error. Please, try again later.</h2>');
                    $statusBlock.show("fast");
                    break;
            };
        },
        error: function(){
            $statusBlock.html('<h2>Error. Please, try again later.</h2>');
            $statusBlock.show("fast");
        }
    });
}

function logout(){
    var formData = {
        id: localStorage.getItem('id'),
        token: localStorage.getItem('token'),
        operation: "logout"
    };
    $.ajax({
        type: "put",
        url: "api/signin/",
        data: formData,
        dataType: "json",
        success: function(result){
            console.log(result);
            switch (result.status) {
                case 'success':
                    localStorage.clear();
                    location.reload();
                    break;
                case 'err_token':
                    $statusBlock.html("<h2>Don't touch token, pls. >:(</h2>")
                    $statusBlock.show("fast");
                    break;
                case 'error':
                    $statusBlock.html("<h2>Lol. You already logout. How have you done that?</h2>");
                    $statusBlock.show("fast");
                    localStorage.clear();
                    break;
                default:
                    $signUpForm.html('<h2>Error. Please, try again later.</h2>');
                    $statusBlock.show("fast");
                    localStorage.clear();
                    break;
            };
        },
        error: function(){
            $signUpForm.html('<h2>Error. Please, try again later.</h2>');
            $statusBlock.show("fast");
        }
    });
}

$('#js-logout').click(function(){
    logout();
});

$("#btn-signin").click(function(){
    signin();
});