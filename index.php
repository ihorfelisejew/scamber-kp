<?
$db_location = "localhost";
$db_user = "ihorfelisieiev";
$db_passwd = "";
$db_name = "Scamber";
$db_connect = mysqli_connect($db_location, $db_user, $db_passwd, $db_name);
mysqli_set_charset($db_connect, "utf8");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Отримання даних з форми
    $clientName = $_POST["client_name"];
    $clientLastName = $_POST["client_last_name"];
    $clientContacts = $_POST["client_contacts"];
    $orderDetails = $_POST["order_details"];

    // SQL-запит для вставки даних в базу даних
    $sql = "INSERT INTO OrderProcessing (client_name, client_last_name, client_contacts, order__detail)
            VALUES ('$clientName', '$clientLastName', '$clientContacts', '$orderDetails')";

    if ($db_connect->query($sql) === TRUE) {
        echo "Запис в базу даних успішно виконано";
    } else {
        echo "Помилка: " . $db_connect->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,regular,500,600,700,900&display=swap"
        rel="stylesheet" />
    <title>Scamber</title>
</head>

<body>
    <div class="wrapper">
        <header id="header" class="header">
            <div class="header__container">
                <div class="header__content">
                    <div class="header__menu">
                        <div class="header__logo">
                            <img src="img/main/logo.png" alt="logo">
                            <h3 class="main__logo-text">Scamber</h3>
                        </div>
                        <nav class="header__menu-block menu">
                            <ul class="menu__list">
                                <li class="menu__item ">
                                    <a href="#header" class="menu__link menu__active">Головна</a>
                                </li>
                                <li class="menu__item">
                                    <a href="#about__title" class="menu__link">Про нас</a>
                                </li>
                                <li class="menu__item">
                                    <a href="#catalog__title" class="menu__link">Каталог</a>
                                </li>
                                <li class="menu__item">
                                    <a href="#contacts__title" class="menu__link">Контакти</a>
                                </li>
                                <li class="menu__item">
                                    <a href="#order__title" class="menu__link">Купити авто</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="header__contacts">
                        <div class="header__contacts-item">
                            <img src="img/main/main_phone.png" alt="" class="header__contact-icon">
                            <a href="tel:+380681543521" class="header__contact-text">+380 68 154 35 21</a>
                        </div>
                        <div class="header__contacts-item">
                            <img src="img/main/main_location.png" alt="" class="header__contact-icon">
                            <button class="header__contact-more">
                                <p class="header__contact-text">Івано-Франківськ</p>
                                <img src="img/main/main_location-arrow.png" alt="more">
                            </button>
                        </div>
                        <div class="header__contacts-item">
                            <a href="pages/signIn.php" class="header__contact-sign-in">
                                Sign in
                            </a>
                        </div>
                        <!-- <button class="icon-menu" type="button">
                            <span></span>
                        </button> -->
                    </div>
                </div>
            </div>
        </header>
        <main class="page__main main">
            <div class="main__container">
                <div class="main__content">
                    <div class="main__info">
                        <h1 class="main__title">
                            Твій новий автомобіль за доступною ціною
                        </h1>
                        <p class="main__text">
                            Автосалон, де ти можеш знайти будь-який
                            автомобіль та купити його всього за
                            декілька кліків. Вперед!
                        </p>
                        <button class="main__button">
                            Обрати автомобіль
                        </button>
                    </div>
                    <div class="main__image">
                        <img src="img/main/main_car.png" alt="Car">
                    </div>
                </div>
            </div>
            <div class="main__bg">
                <div class="main__bg-content"></div>
            </div>
        </main>
        <section id="about" class="page__about about">
            <div class="about__container">
                <h2 id="about__title" class="about__title title">Про автосалон Scamber</h2>
                <p class="about__description">
                    Автосалон <span>Scamber</span> спеціалізується на продажу б/у та нових машин, викупом ваших
                    автомобілів та
                    trade-in. Наша команда допоможе Вам підібрати необхідний автомобіль та надасть відповідь на всі
                    виникші питання.
                </p>
                <div class="about__statistics">
                    <div class="statistic__item">
                        <p class="statistic__title">2</p>
                        <div class="statistic__text">РОКИ НА РИНКУ</div>
                    </div>
                    <div class="statistic__item">
                        <p class="statistic__title">250+</p>
                        <div class="statistic__text">ПРОДАНИХ АВТОМОБІЛІВ</div>
                    </div>
                </div>
                <p class="about__description">
                    Наш досвід у перевірці та продажу авто дає змогу зробити процес підбору безпечним та ефективним.
                    Перед тим як автомобіль попадає в наш автосалон, він проходить перевірку на дефекти та проблеми, щоб
                    ви могли бути впевнені в його надійності. Наші фахівці проведуть детальний технічний огляд авто та
                    нададуть повний звіт про його стан, пробіг та дефекти.
                </p>
                <div class="about__why-we">
                    <div class="why-we__item">
                        <div class="why-we__image">
                            <img src="img/main/about/about_1.png" alt="">
                        </div>
                        <p class="why-we__text">Економимо Ваш час попередніми перевірками авто</p>
                    </div>
                    <div class="why-we__item">
                        <div class="why-we__image">
                            <img src="img/main/about/about_2.png" alt="">
                        </div>
                        <p class="why-we__text">Велика кількість задоволених клієнтів</p>
                    </div>
                    <div class="why-we__item">
                        <div class="why-we__image">
                            <img src="img/main/about/about_3.png" alt="">
                        </div>
                        <p class="why-we__text">Надійні умови договору та оформлення гарантії</p>
                    </div>
                    <div class="why-we__item">
                        <div class="why-we__image">
                            <img src="img/main/about/about_4.png" alt="">
                        </div>
                        <p class="why-we__text">Продаж автомобілів, які успішно пройшли перевірку</p>
                    </div>
                </div>
            </div>
        </section>
        <section id="catalog" class="page__catalog catalog">
            <div class="catalog__container">
                <div class="catalog__head-block">
                    <h2 id="catalog__title" class="catalog__title title">Каталог</h2>
                    <button class="catalog__more-cars">
                        <p class="more-cars__text">Всі авто</p>
                        <img src="img/main/catalog/catalog__arrow.png" alt="">
                    </button>
                </div>
                <div class="catalog__content">
                    <?php include "php/main-catalog.php"; ?>
                </div>
            </div>
        </section>
        <section id="contacts" class="page__contacts contacts">
            <div class="contacts__container">
                <h2 id="contacts__title" class="contacts__title title">Контакти</h2>
                <p class="contacts__text">Якщо у Вас виникнуть якісь запитання, то Ви можете зв’язатися з нашими
                    працівниками, які обов’язково допоможуть Вам, або навідатися у наш автосалон.</p>
                <div class="contacts__content">
                    <div class="contacts__social">
                        <ul class="social-list">
                            <li class="socials-item">
                                <img src="img/main/contacts/social-icon_1.png" alt="" class="social-image">
                                <a href="tel: +380688888888" class="social-link">+(380)68-888-88-88</a>
                            </li>
                            <li class="socials-item">
                                <img src="img/main/contacts/social-icon_2.png" alt="" class="social-image">
                                <a href="https://web.telegram.org/k/" class="social-link">t.me/scamber_tg</a>
                            </li>
                            <li class="socials-item">
                                <img src="img/main/contacts/social-icon_3.png" alt="" class="social-image">
                                <a href="https://www.instagram.com/" class="social-link">@scamber_avto</a>
                            </li>
                            <li class="socials-item">
                                <img src="img/main/contacts/social-icon_4.png" alt="" class="social-image">
                                <a href="https://www.google.com/maps/place/Audi+%D0%A6%D0%B5%D0%BD%D1%82%D1%80+%D0%A5%D0%BC%D0%B5%D0%BB%D1%8C%D0%BD%D0%B8%D1%86%D1%8C%D0%BA%D0%B8%D0%B9/@49.4352947,27.014443,17z/data=!4m15!1m8!3m7!1s0x4732070ffe4354e9:0xf12413fb091cdcb!2z0L_RgNC-0YHQv9C10LrRgiDQnNC40YDRgywgNTYsINCl0LzQtdC70YzQvdC40YbRjNC60LjQuSwg0KXQvNC10LvRjNC90LjRhtGM0LrQsCDQvtCx0LvQsNGB0YLRjCwgMjkwMDA!3b1!8m2!3d49.4431073!4d26.9888937!16s%2Fg%2F11c3q43s4q!3m5!1s0x473207b01eb83ed3:0xfa17ef6dae6da7e0!8m2!3d49.4351128!4d27.0165174!16s%2Fg%2F113fvk_dx?entry=ttu"
                                    class="social-link">м. Хмельницький, проспект Миру, 101/2</a>
                            </li>
                        </ul>
                        <h3 class="contacts__social-text">Підписуйтесь на наші новини</h3>
                    </div>
                    <div class="contacts__map">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5189.176472066097!2d27.012576177247162!3d49.43559823472791!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x473207b01eb83ed3%3A0xfa17ef6dae6da7e0!2zQXVkaSDQptC10L3RgtGAINCl0LzQtdC70YzQvdC40YbRjNC60LjQuQ!5e0!3m2!1suk!2sua!4v1701946240443!5m2!1suk!2sua"
                            width="625px" height="340px" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                <p class="contacts__text contacts__bottom-text">
                    Дізнавайтесь про наші новинки першими і завжди будьте в курсі наших знижок та новинок!
                </p>
                <form class="contacts__callback">
                    <input type="email" class="contacts__email" placeholder="Введіть Ваш e-mail">
                    <button class="contacts__button">Підписатися</button>
                </form>
            </div>
        </section>
        <section id="order" class="page__order order">
            <div class="order__container">
                <h2 id="order__title" class="order__title title">Замовити авто</h2>
                <p class="order__text">
                    У нашому автосалоні діє функція «Авто під замовлення». Залиште заявку у формі нижче і наші менеджери
                    обов'язково зв'яжуться з вами для уточнення деталей та підбору ідеального авто для вас!
                </p>
                <div class="order__form-block">
                    <h3 class="form__title title">Замовлення авто</h3>
                    <form class="order__form" method="post">
                        <label name="label" class="order__label">
                            <?php echo $orderError; ?>
                        </label>
                        <div class="order__form-content">
                            <input name="client_name" class="order__name-input" type="text" placeholder="Ваше ім'я">
                            <input name="client_last_name" class="order__last-name-input" type="text" placeholder="Ваше прізвище">
                            <div class="order__contact-type-block">
                                <p class="order__contact-type-text">Оберіть тип зв'язку</p>
                                <select name="type-of-contact" id="type-of-contact" class="type-of-contact"
                                    onchange="ShowType()">
                                    <option value="Phone" selected>Номер телефону</option>
                                    <option value="E-mail">E-mail</option>
                                    <option value="Telegram">Telegram</option>
                                </select>
                            </div>
                            <input name="client_contacts" class="order__contact-data" id="order__contact-link" type="text"
                                placeholder="Введіть свій номер телефону" class="contact-type-input">
                            <textarea name="order_details" placeholder="Введіть деталі замовлення" class="order__message"></textarea>
                            <button type="submit" class="order__button">Замовити авто</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <footer class="footer">
            <div class="footer__container">
                <div class="footer__content">
                    <div class="footer__contacts">
                        <div class="work-schedule__block">
                            <div class="footer__logo-block">
                                <img src="img/main/logo.png" alt="" class="footer__logo">
                                <p class="logo__text">Scamber</p>
                            </div>
                            <div class="work-schedule">
                                <h3 class="footer__title">
                                    Час роботи
                                </h3>
                                <p class="work-schedule__item">
                                    Понеділок – Субота:
                                    <span>09:00 – 20:00</span>
                                </p>
                                <p class="work-schedule__item">
                                    Неділя:
                                    <span>09:00 – 19:00</span>
                                </p>
                            </div>
                            <p class="footer__address">
                                м. Хмельницький, проспект Миру, 101/2
                            </p>
                        </div>
                        <div class="footer__social-block">
                            <h3 class="footer__title">
                                Контакти
                            </h3>
                            <ul class="social-list footer-list">
                                <li class="socials-item footer-list-item">
                                    <img src="img/main/contacts/social-icon_1.png" alt=""
                                        class="social-image footer-list-image">
                                    <a href="tel: +380688888888"
                                        class="social-link footer-list-link">+(380)68-888-88-88</a>
                                </li>
                                <li class="socials-item footer-list-item">
                                    <img src="img/main/contacts/social-icon_2.png" alt=""
                                        class="social-image footer-list-image">
                                    <a href="https://web.telegram.org/k/"
                                        class="social-link footer-list-link">t.me/scamber_tg</a>
                                </li>
                                <li class="socials-item footer-list-item">
                                    <img src="img/main/contacts/social-icon_3.png" alt=""
                                        class="social-image footer-list-image">
                                    <a href="https://www.instagram.com/"
                                        class="social-link footer-list-link">@scamber_avto</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="footer__news-subscribe">
                        <h3 class="footer__title">
                            Підписуйтесь на наші новини
                        </h3>
                        <p class="footer__subscribe-text">
                            Дізнавайтесь про наші новинки першими і завжди будьте в курсі наших знижок та новинок!
                        </p>
                        <form class="footer__callback">
                            <input type="email" class="footer__callback-email" placeholder="Введіть Ваш e-mail">
                            <button class="footer__callback-button">Підписатися</button>
                        </form>
                    </div>
                </div>
                <div class="footer__copy">
                    <p class="copy__text">
                        ©All rights reserved by «Scamber» 2023
                    </p>
                </div>
            </div>
        </footer>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="js/mine.js"></script>
</body>

</html>