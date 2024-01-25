document.addEventListener('click', documentClick);

function documentClick(e) {
    const targetItem = e.target;
    if (targetItem.closest('.icon-menu')) {
        document.documentElement.classList.toggle('menu-open');
    }
}

function fixedMenuOnPageLoad() {
    const header = document.querySelector('.header__menu');

    if (window.scrollY > 70) {
        header.classList.add('menu__fixed');
    } else {
        header.classList.remove('menu__fixed');
    }
}

// Викликаємо функцію при завантаженні сторінки
window.addEventListener('load', fixedMenuOnPageLoad);

var lastScrollTop = 0;
function scrollToBlock() {
    var st = window.scrollY || document.documentElement.scrollTop;
    var blocks = document.querySelectorAll('section');

    for (var i = 0; i < blocks.length; i++) {
        var block = blocks[i];
        var rect = block.getBoundingClientRect();

        if ((st > lastScrollTop && rect.top <= 70) || (rect.top >= -400 && rect.top <= 0)) {
            var menuItems = document.querySelectorAll('.menu__link');
            menuItems.forEach(function (item) {
                item.classList.remove('menu__active');
                if (item.getAttribute('href') == "#" + block.id + "__title") {
                    item.classList.add('menu__active');
                }
            });
        }
    }

    lastScrollTop = st <= 0 ? 0 : st;
}

var enableScroll = true;
window.addEventListener('scroll', function () {
    const header = document.querySelector('.header__menu');

    if (enableScroll) scrollToBlock();

    if (window.scrollY > 70) {
        header.classList.add('menu__fixed');
    } else {
        document.querySelectorAll('.menu__link').forEach(includeItem => {
            includeItem.classList.remove('menu__active');
        });
        document.querySelector('.menu__link').classList.add('menu__active');
        header.classList.remove('menu__fixed');
    }
});

let scrolling = false;

function smoothScroll(target) {
    if (scrolling) return;
    scrolling = true;

    const offset = 100; // Відступ від верху секції (за потреби)
    const targetElement = document.querySelector(target);
    const targetPosition = targetElement.offsetTop - offset;
    const startPosition = window.scrollY;
    const distance = targetPosition - startPosition;
    const duration = 1000; // Тривалість анімації

    let startTimestamp;

    function animation(timestamp) {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = timestamp - startTimestamp;

        window.scrollTo(0, easeInOutCubic(progress, startPosition, distance, duration));

        if (progress < duration) {
            requestAnimationFrame(animation);
        } else {
            scrolling = false;
        }
    }

    requestAnimationFrame(animation);
}

function easeInOutCubic(t, b, c, d) {
    t /= d / 2;
    if (t < 1) return c / 2 * t * t * t + b;
    t -= 2;
    return c / 2 * (t * t * t + 2) + b;
}

document.querySelectorAll('.menu__link').forEach(item => {
    item.addEventListener('click', function (e) {
        e.preventDefault();
        enableScroll = false;

        const target = this.getAttribute('href');
        smoothScroll(target);
        setTimeout(function () {
            if (window.scrollY > 70) {
                document.querySelectorAll('.menu__link').forEach(includeItem => {
                    includeItem.classList.remove('menu__active');
                });
                item.classList.add('menu__active');
            }
        }, 300);
        setTimeout(function () {
            // Включаємо функцію скролу знову після затримки (наприклад, після завершення анімації або дій)
            enableScroll = true;
        }, 1000);
    });
});


/*-----------order-form-----------*/

function ShowType() {
    const typeOfContact = $('.type-of-contact');
    const valueType = typeOfContact.val();
    const inputsForContact = $('#order__contact-link');
    if (valueType == "Phone") inputsForContact.attr('placeholder', "Введіть свій номер телефону");
    else if (valueType == "E-mail") inputsForContact.attr('placeholder', "Введіть свій e-mail");
    else inputsForContact.attr('placeholder', "Введіть свій telegram тут");
}

$(document).ready(function () {
    $('.order__form').submit(function (event) {
        event.preventDefault();
        const labelForError = $('.order__label');

        // Перевірка на ім'я
        var name = $('.order__name-input').val().trim();
        if (name === '') {
            showError("Введіть своє ім'я");
            return;
        }

        // Перевірка на прізвище
        var last_name = $('.order__last-name-input').val().trim();
        if (last_name === '') {
            showError("Введіть своє прізвище");
            return;
        }

        // Перевірка на тип контакту
        var contactType = $('#type-of-contact').val();
        var inputContactValue = $('#order__contact-link').val().trim();

        var checkContact = validateContact(contactType, inputContactValue);
        if (checkContact !== '') {
            showError(checkContact);
            return;
        }

        // AJAX-запит для відправки даних на сервер
        $.ajax({
            type: 'POST',
            url: 'index.php',
            data: {
                client_name: name,
                client_last_name: last_name,
                client_contacts: inputContactValue,
                order_details: $('.order__message').val()
            },
            success: function (response) {
                const labelForError = $('.order__label');
                $('.order__label').css('color', '#11158b');
                labelForError.text('Заявку відправлено, найближчим часом з вами зв\'яжеться наш менеджер!');
                $('.order__label').css('display', 'block');
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

    function validateContact(type, value) {
        switch (type) {
            case 'Phone':
                return /^(?:\+380|0)\d{9}$/.test(value) ? '' : "Введіть свій номер телефону (починається з '+380' або '0')";
            case 'E-mail':
                var lambda = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
                return lambda.test(value) ? '' : "Будь ласка, введіть коректний e-mail!";
            case 'Telegram':
                var lambda = /^@+[a-zA-Z0-9_]{5,32}$/;
                return lambda.test(value) ? '' : "Будь ласка, введіть нікнейм коректно!";
            default:
                return '';
        }
    }
});
