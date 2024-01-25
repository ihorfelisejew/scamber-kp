<?php

$db_location = "localhost";
$db_user = "ihorfelisieiev";
$db_passwd = "";
$db_name = "Scamber";
$db_connect = mysqli_connect($db_location, $db_user, $db_passwd, $db_name);
mysqli_set_charset($db_connect, "utf8");

$login = urldecode($_GET['login']);
$password = urldecode($_GET['password']);

$clientQuery = "SELECT * FROM Clients WHERE login = '$login' AND password = '$password' LIMIT 1";
$client = $db_connect->query($clientQuery)->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_type = $_POST['form_type'];

    if ($form_type === 'change_password') {
        $form_login = $_POST['form_login'];
        $form_new_password = $_POST['form_new_password'];
        $form_password = $_POST['form_password'];
        echo $form_new_password;
        if ($admin["login"] == $form_login && $admin["password"] == $form_password) {
            $passwordChangeQuery = "UPDATE Clients SET password = '$form_new_password' WHERE client_id = " . $client["client_id"] . "";
            $passwordChangeResult = $db_connect->query($passwordChangeQuery);
            header('Location: signIn.php');
        }
    } elseif ($form_type === 'delete_account') {
        $deleteQuery = "DELETE FROM Clients WHERE client_id = " . $client["client_id"] . "";
        $deleteResult = $db_connect->query($deleteQuery);
        header('Location: ../index.php');
        exit();
    }  elseif ($form_type === 'cars-table') {
        if (isset($_POST['delete_cars'])) {
            if (isset($_POST['confirmed_cars']) && is_array($_POST['confirmed_cars'])) {
                foreach ($_POST['confirmed_cars'] as $carID) {
                    $carID = (int) $carID; // Захист від SQL-ін'єкцій
                    $deleteQuery = "DELETE FROM Cars WHERE car_id = $carID";
                    $db_connect->query($deleteQuery);
                }
            }
        }
    }else {
        // Отримання даних з форми
        $client_id = $_POST["client_id"];
        $body_type = $_POST["body_type"];
        $manufacture = $_POST["manufacture"];
        $car_model = $_POST["car_model"];
        $car_price = $_POST["car_price"];
        $year_of_manufacture = $_POST["year_of_manufacture"];
        $complete_set = $_POST["complete_set"];
        $car_color = $_POST["car_color"];
        $engine_type = $_POST["engine_type"];
        $engine_capacity = $_POST["engine_capacity"];
        $fuel_consumption = $_POST["fuel_consumption"];
        $car_mileage = $_POST["car_mileage"];
        $gearbox = $_POST["gearbox"];
        $drive = $_POST["drive"];
        $car_number = $_POST["car_number"];
        $vin_code = $_POST["vin_code"];
        $other_desc = $_POST["other_desc"];

        // SQL-запит для вставки даних в базу даних
        $sql = "INSERT INTO Cars (client_id, body_type_id, manufacture_id, car_model, price, year_of_manufacture, complete_set, color, engine_type_id, engine_capacity, fuel_consumption, car_mileage, gearbox_id, drive_id, car_number, VIN_code, other_desc)
            VALUES ('$client_id', '$body_type', '$manufacture', '$car_model', '$car_price', '$year_of_manufacture', '$complete_set', '$car_color', '$engine_type', '$engine_capacity', '$fuel_consumption', '$car_mileage', '$gearbox', '$drive', '$car_number', '$vin_code', '$other_desc')";

        // Виконання SQL-запиту
        if ($db_connect->query($sql) === TRUE) {
            echo "Дані успішно вставлені в таблицю Cars";
        } else {
            echo "Помилка: " . $sql . "<br>" . $db_connect->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $admin["name_of_worker"] . " " . $admin["last_name"]; ?>
    </title>
    <link rel="stylesheet" href="../css/pages/clientPage.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,regular,500,700,900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,regular,500,600,700,900&display=swap"
        rel="stylesheet" />
</head>

<body>
    <header class="header">
        <div class="header__container">
            <div class="header__menu">
                <div class="header__logo">
                    <img src="../img/main/logo.png" alt="logo">
                    <h3 class="main__logo-text">Scamber</h3>
                </div>
                <nav class="header__menu-block menu">
                    <ul class="menu__list">
                        <li class="menu__item ">
                            <a href="../index.php" class="menu__link menu__active">Головна</a>
                        </li>
                        <li class="menu__item">
                            <a href="#content__profile" class="menu__link">Профіль</a>
                        </li>
                        <li class="menu__item">
                            <a href="#order__block" class="menu__link">Продати авто</a>
                        </li>
                        <li class="menu__item">
                            <a href="#order-status__block" class="menu__link">Статус продажів</a>
                        </li>
                        <li class="menu__item">
                            <a href="#" class="menu__link">Контакти</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <section id="content__profile" class="content__profile">
        <div class="profile__container">
            <div class="main__information">
                <div class="main-inform__image-block">
                    <img src="../img/admin/profile_img.png" alt="Profile Image">
                </div>
                <h1 class="name__last-name">
                    <?php echo $client["clients_name"] . " " . $client["last_name"]; ?>
                </h1>
            </div>
            <div class="detail">
                <div class="detail__main-info">
                    <h2 class="detail__title">Основна інформація</h2>
                    <div class="detail-info__item">
                        <h3 class="detail-info__title">E-mail</h3>
                        <p class="detail-info__text">
                            <?php echo $client["email"]; ?>
                        </p>
                    </div>
                    <div class="detail-info__item">
                        <h3 class="detail-info__title">Номер телефону</h3>
                        <p class="detail-info__text">
                            <?php echo $client["phone_number"]; ?>
                        </p>
                    </div>
                    <div class="detail-info__item">
                        <h3 class="detail-info__title">Дата народження</h3>
                        <p class="detail-info__text">
                            <?php echo $client["date_of_birth"]; ?>
                        </p>
                    </div>
                    <form method="POST">
                        <input type="hidden" name="form_type" value="delete_account">
                        <button type="submit" class="delete__button">Видалити акаунт</button>
                    </form>
                </div>
                <div class="detail__auth-info">
                    <h2 class="detail__title">Дані для аутентифікації</h2>
                    <form method="POST" class="detail-info__item">
                        <input type="hidden" name="form_type" value="change_password">
                        <h3 class="detail-info__title">Логін</h3>
                        <input name="form_login" class="detail-auth-info__input detail-auth-login"
                            value="<?php echo $login; ?>">
                        <h3 class="detail-info__title">Новий пароль</h3>
                        <input name="form_new_password" class="detail-auth-info__input detail-auth-new-password">
                        <h3 class="detail-info__title">Старий пароль</h3>
                        <input name="form_password" class="detail-auth-info__input detail-auth-password">
                        <button class="detail-auth-info__submit" type="submit">Оновити дані</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section id="order__block" class="order__block">
        <div class="order__container">
            <div class="order__form-block">
                <h3 class="form__title title">Заявка на продаж автомобіля</h3>
                <form class="order__form" method="post">
                    <input type="hidden" id="form-type" name="form_type" value="sale_car">
                    <input name="client_id" class="client__id" type="hidden" value="<?php echo $client["client_id"] ?>">
                    <label name="label" class="order__label">
                        <?php echo $orderError; ?>
                    </label>
                    <div class="order__form-content">
                        <div class="order__select-block body__type">
                            <select name="body_type" id="body__type" class="order__select">
                                <?php
                                $bodyTypesQuery = "SELECT * FROM BodyTypes";
                                $bodyTypes = $db_connect->query($bodyTypesQuery);
                                while ($bodyType = $bodyTypes->fetch_assoc()) { ?>
                                    <option value="<?php echo $bodyType["type_id"] ?>">
                                        <?php echo $bodyType["name_of_type"] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="order__select-block manufacture">
                            <select name="manufacture" id="manufacture" class="order__select">
                                <?php
                                $manufacturesQuery = "SELECT * FROM Manufactures";
                                $manufactures = $db_connect->query($manufacturesQuery);
                                while ($manufacture = $manufactures->fetch_assoc()) { ?>
                                    <option value="<?php echo $manufacture["manufacture_id"] ?>">
                                        <?php echo $manufacture["name_of_manufacture"] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <input name="car_price" class="order__input car__price" type="text"
                            placeholder="Ціна машини (в $)">
                        <input name="car_model" class="order__input car__model" type="text" placeholder="Модель машини">
                        <input type="number" id="year_of_manufacture" class="order__input year__manufacture"
                            name="year_of_manufacture" min="1900" max="<?php echo date('Y'); ?>" step="1" value="2010">
                        <input name="complete_set" class="order__input complete__set" type="text"
                            placeholder="Комплектація">
                        <input name="car_color" class="order__input car__color" type="text" placeholder="Колір">
                        <div class="order__select-block engine__type">
                            <select name="engine_type" id="engine__type" class="order__select">
                                <?php
                                $engineTypesQuery = "SELECT * FROM EngineType";
                                $engineTypes = $db_connect->query($engineTypesQuery);
                                while ($engineType = $engineTypes->fetch_assoc()) { ?>
                                    <option value="<?php echo $engineType["engine_id"] ?>">
                                        <?php echo $engineType["type_of_engine"] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <input name="engine_capacity" class="order__input engine__capacity" type="text"
                            placeholder="Об'єм двигуна">
                        <input name="fuel_consumption" class="order__input fuel__consumption" type="text"
                            placeholder="Розхід палива">
                        <input name="car_mileage" class="order__input car__mileage" type="text"
                            placeholder="Пробіг автомобіля (в км.)">
                        <div class="order__select-block gearbox">
                            <select name="gearbox" id="gearbox" class="order__select">
                                <?php
                                $gearboxesQuery = "SELECT * FROM Gearboxes";
                                $gearboxes = $db_connect->query($gearboxesQuery);
                                while ($gearbox = $gearboxes->fetch_assoc()) { ?>
                                    <option value="<?php echo $gearbox["gearbox_id"] ?>">
                                        <?php echo $gearbox["name_of_gearbox"] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="order__select-block drive">
                            <select name="drive" id="drive" class="order__select">
                                <?php
                                $drivesQuery = "SELECT * FROM Drives";
                                $drives = $db_connect->query($drivesQuery);
                                while ($drive = $drives->fetch_assoc()) { ?>
                                    <option value="<?php echo $drive["drive_id"] ?>">
                                        <?php echo $drive["name_of_drive"] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <input name="car_number" class="order__input car__number" type="text" placeholder="Номер авто">
                        <input name="vin_code" class="order__input vin__code" type="text" placeholder="VIN-код">
                        <textarea name="other_desc" placeholder="Детальний опис автомобіля"
                            class="order__input other__desc"></textarea>
                        <button type="submit" class="order__button">Продати</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <section id="order-status__block" class="order-status__block">
        <div class="order-status__container">
            <div class="order-status__content">
                <div class="order-status__table">
                    <?php
                    $statusOrdersQuery = "SELECT * FROM Cars WHERE client_id = " . $client["client_id"];
                    $statusOrders = $db_connect->query($statusOrdersQuery);
                    if ($statusOrders->num_rows !== 0) { ?>
                        <h2 class="order__title">Статус продажу автомобілів</h2>
                        <form method="post" class="orders__table">
                            <input type="hidden" name="form_type" value="orders-table">
                            <div class="table__content overflow__x">
                                <div class="cars__titles">
                                    <h4 class="cars__column-title">Статус підтвердження</h4>
                                    <h4 class="cars__column-title">Назва авто</h4>
                                    <h4 class="cars__column-title">Комплектація</h4>
                                    <h4 class="cars__column-title">Пробіг</h4>
                                    <h4 class="cars__column-title">Ціна</h4>
                                    <h4 class="cars__column-title">Тип кузову</h4>
                                    <h4 class="cars__column-title">Номер ато</h4>
                                    <h4 class="cars__column-title">VIN-код</h4>
                                    <h4 class="cars__column-title">Колір</h4>
                                    <h4 class="cars__column-title">Двигун</h4>
                                    <h4 class="cars__column-title">Тип коробки передач</h4>
                                    <h4 class="cars__column-title">Тип приводу</h4>
                                    <h4 class="cars__column-title">Розхід палива</h4>
                                    <h4 class="cars__column-title">Опис</h4>
                                </div>
                                <?php while ($car = $statusOrders->fetch_assoc()) {
                                    $carInfoQuery = "SELECT bt.name_of_type, mft.name_of_manufacture,  et.type_of_engine, g.name_of_gearbox, d.name_of_drive
                            FROM Cars c
                            INNER JOIN BodyTypes bt ON c.body_type_id = bt.type_id
                            INNER JOIN Manufactures mft ON c.manufacture_id = mft.manufacture_id
                            INNER JOIN EngineType et ON c.engine_type_id = et.engine_id
                            INNER JOIN Gearboxes g ON c.gearbox_id = g.gearbox_id
                            INNER JOIN Drives d ON c.drive_id = d.drive_id
                            WHERE c.car_id = " . ($car["car_id"]) . "
                            LIMIT 1";
                                    $carInfoResult = $db_connect->query($carInfoQuery);
                                    $carInfo = $carInfoResult->fetch_assoc();
                                    ?>
                                    <div class="car__row">
                                        <div class="car__check-block">
                                            <input type="checkbox" name="confirmed_cars[]" value="<?php echo $car['car_id']; ?>"
                                                class="car__check-confirm">
                                        </div>
                                        <div class="car__info-block">
                                            <p class="car__column-item">
                                                <?php echo ($car["offered_for_sale"] === '1') ? "Підтверджено" : "На розгляді" ?>
                                            </p>
                                            <p class="car__column-item">
                                                <?php echo $carInfo["name_of_manufacture"] . " " . $car["car_model"] . ", " . $car["year_of_manufacture"]; ?>
                                            </p>
                                            <p class="car__column-item">
                                                <?php echo $car["complete_set"] ?>
                                            </p>
                                            <p class="car__column-item">
                                                <?php echo $car["car_mileage"] ?>
                                            </p>
                                            <p class="car__column-item">
                                                <?php echo $car["price"] ?>
                                            </p>
                                            <p class="car__column-item">
                                                <?php echo $carInfo["name_of_type"] ?>
                                            </p>
                                            <p class="car__column-item">
                                                <?php echo $car["complete_set"] ?>
                                            </p>
                                            <p class="car__column-item overflow__x">
                                                <?php echo $car["VIN_code"] ?>
                                            </p>
                                            <p class="car__column-item">
                                                <?php echo $car["color"] ?>
                                            </p>
                                            <p class="car__column-item">
                                                <?php echo $carInfo["type_of_engine"] . ", " . $car["engine_capacity"] ?>
                                            </p>
                                            <p class="car__column-item">
                                                <?php echo $carInfo["name_of_gearbox"] ?>
                                            </p>
                                            <p class="car__column-item">
                                                <?php echo $carInfo["name_of_drive"] ?>
                                            </p>
                                            <p class="car__column-item">
                                                <?php echo $car["fuel_consumption"] ?>
                                            </p>
                                            <p class="car__column-item details">
                                                <?php echo $car["other_desc"] ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="order-table__buttons">
                                <button type="submit" name="confirm_orders" class="orders__confirm">Редагувати</button>
                                <button type="submit" name="delete_orders" class="orders__delete">Видалити</button>
                            </div>
                        </form>
                    <?php } else { ?>
                        <p>Ви ще не подали заявки на продаж авто</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../js/clientPage.js"></script>
</body>

</html>