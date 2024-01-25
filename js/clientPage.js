$(document).ready(function () {
    $('.order__form').submit(function (event) {
        console.log("fksjlaj");
        event.preventDefault();
        // Перевірка на ім'я
        var price = $('.car__price').val().trim();
        if (price === '') {
            showError("Введіть ціну авто");
            return;
        }else if(!validateNumber(price)){
            showError("Введіть ціну коректно");
            return;
        }

        var complete__set = $('.complete__set').val().trim();
        if (complete__set === '') {
            showError("Введіть назву комплектації");
            return;
        }

        var car__color = $('.car__color').val().trim();
        if (car__color === '') {
            showError("Введіть колір авто");
            return;
        }

        var engine__capacity = $('.engine__capacity').val().trim();
        if (engine__capacity === '') {
            showError("Введіть об'єм двигуна");
            return;
        }else if(!validateNumber(engine__capacity)){
            showError("Введіть об'єм двигуна коректно");
            return;
        }

        var fuel__consumption = $('.fuel__consumption').val().trim();
        if (fuel__consumption === '') {
            showError("Введіть середні витрати пального");
            return;
        }else if(!validateNumber(fuel__consumption)){
            showError("Введіть середні витрати пального коректно");
            return;
        }

        var car__mileage = $('.car__mileage').val().trim();
        if (car__mileage === '') {
            showError("Введіть пробіг авто");
            return;
        }else if(!validateNumber(car__mileage)){
            showError("Введіть пробіг авто коректно");
            return;
        }

        var car__number = $('.car__number').val().trim();
        if (car__number === '') {
            showError("Введіть номер авто");
            return;
        }
        
        var vin__code = $('.vin__code').val().trim();
        if (vin__code === '') {
            showError("Введіть VIN-код");
            return;
        }

        // AJAX-запит для відправки даних на сервер
        $.ajax({
            type: 'POST',
            url: '../pages/clientPage.php',
            data: {
                client_id: $('.client__id').val(),
                body_type: $('#body__type').val(),
                manufacture: $('#manufacture').val(),
                car_model: $('.car__model').val(),
                car_price: price,
                year_of_manufacture: $('.year__manufacture').val(),
                complete_set: complete__set,
                car_color: car__color,
                engine_type: $('#engine__type').val(),
                engine_capacity: engine__capacity,
                fuel_consumption: fuel__consumption,
                car_mileage: car__mileage,
                gearbox: $('#gearbox').val(),
                drive: $('#drive').val(),
                car_number: car__number,
                vin_code: vin__code,
                other_desc: $('.other__desc').val(),
            },
            success: function (response) {
                const labelForError = $('.order__label');
                $('.order__label').css('color', '#11158b');
                labelForError.text('Заявку відправлено, найближчим часом з вами зв\'яжеться наш менеджер!');
                $('.order__label').css('display', 'block');
                $('.order__form').trigger('reset');
                console.log(response);
            },
            error: function (error) {
                console.log('Помилка при відправці AJAX-запиту: ', error);
            }
        });
    });

    function showError(message) {
        const labelForError = $('.order__label');
        $('.order__label').css('color', 'red');
        labelForError.text(message);
        $('.order__label').css('display', 'block');
    }

    function validateNumber(inputValue) {
        var numberValue = parseFloat(inputValue);
        if (!isNaN(numberValue)) {
            return true;
        } else {
            return false;
        }
    }
});
