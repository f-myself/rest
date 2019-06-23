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
var $btnFilter = $('#js-filter');


// $btnFilter.click(function(){
//     console.log(this);
// })

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
        console.log(formData);
        $.ajax({
            type: "GET",
            url: "api/cars/",
            data: formData,
            dataType: "json",
            success: function(cars){
                console.log('success');
                console.log(cars);
                $carList.html("");
                cars.forEach(car => {
                    $carList.append("<div class='col-lg-4 col-md-12 col-sm-12 col-xl-2 border border-light ml-1 mb-1 js-details' onclick='carDetails(" + car.id + ")' id='"+ car.id + "'><a href='#"+ car.id + "'>" + car.brand + " " + car.model + "</div>")
                });
            }
        });
    } else {
        $carList.html('<div class="col-9"><h2>Please, set year as numeric type. This field is required!</h2></div>');
    }
}

(function() {
    $carDetailed.hide();
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