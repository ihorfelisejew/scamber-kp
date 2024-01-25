<?php

$db_location = "localhost";
$db_user = "ihorfelisieiev";
$db_passwd = "";
$db_name = "Scamber";
$db_connect = mysqli_connect($db_location, $db_user, $db_passwd, $db_name);
mysqli_set_charset($db_connect, "utf8");

$login = urldecode($_GET['login']);
$password = urldecode($_GET['password']);

$adminQuery = "SELECT * FROM Workers WHERE login = '$login' AND password = '$password' LIMIT 1";
$admin = $db_connect->query($adminQuery)->fetch_assoc();

$addAdminError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_type = $_POST['form_type'];

    if ($form_type === 'change_password') {
        $form_login = $_POST['form_login'];
        $form_new_password = $_POST['form_new_password'];
        $form_password = $_POST['form_password'];
        echo $form_new_password;
        if ($admin["login"] == $form_login && $admin["password"] == $form_password) {
            $passwordChangeQuery = "UPDATE Workers SET password = '$form_new_password' WHERE worker_id = " . $admin["worker_id"] . "";
            $passwordChangeResult = $db_connect->query($passwordChangeQuery);
            header('Location: ../admin.php');
        }
    } elseif ($form_type === 'delete_account') {
        $deleteQuery = "DELETE FROM Workers WHERE worker_id = " . $admin["worker_id"] . "";
        $deleteResult = $db_connect->query($deleteQuery);
        header('Location: ../index.php');
        exit();
    } elseif ($form_type === 'orders-table') {
        if (isset($_POST['confirm_orders'])) {
            if (isset($_POST['confirmed_orders']) && is_array($_POST['confirmed_orders'])) {
                foreach ($_POST['confirmed_orders'] as $confirmedOrderID) {
                    $confirmedOrderID = (int) $confirmedOrderID; // Захист від SQL-ін'єкцій
                    $updateQuery = "UPDATE OrderProcessing SET acceptance_status = 1 WHERE order_id = $confirmedOrderID";
                    $db_connect->query($updateQuery);
                }
            }
        } elseif (isset($_POST['delete_orders'])) {
            if (isset($_POST['confirmed_orders']) && is_array($_POST['confirmed_orders'])) {
                foreach ($_POST['confirmed_orders'] as $confirmedOrderID) {
                    $confirmedOrderID = (int) $confirmedOrderID; // Захист від SQL-ін'єкцій
                    $deleteQuery = "DELETE FROM OrderProcessing WHERE order_id = $confirmedOrderID";
                    $db_connect->query($deleteQuery);
                }
            }
        }
    } elseif ($form_type === 'history-orders-table') {
        if (isset($_POST['confirm_done_orders'])) {
            if (isset($_POST['done_orders']) && is_array($_POST['done_orders'])) {
                foreach ($_POST['done_orders'] as $doneOrderID) {
                    $doneOrderID = (int) $doneOrderID; // Захист від SQL-ін'єкцій
                    $updateQuery = "UPDATE OrderProcessing SET execution_status = 1 WHERE order_id = $doneOrderID";
                    $db_connect->query($updateQuery);
                }
            }
        } elseif (isset($_POST['delete_orders'])) {
            if (isset($_POST['done_orders']) && is_array($_POST['done_orders'])) {
                foreach ($_POST['done_orders'] as $doneOrderID) {
                    $doneOrderID = (int) $doneOrderID; // Захист від SQL-ін'єкцій
                    $deleteQuery = "DELETE FROM OrderProcessing WHERE order_id = $doneOrderID";
                    $db_connect->query($deleteQuery);
                }
            }
        }
    } elseif ($form_type === 'cars-table') {
        if (isset($_POST['confirm_cars'])) {
            if (isset($_POST['confirmed_cars']) && is_array($_POST['confirmed_cars'])) {
                foreach ($_POST['confirmed_cars'] as $carID) {
                    $carID = (int) $carID; // Захист від SQL-ін'єкцій
                    $updateQuery = "UPDATE Cars SET offered_for_sale = 1 WHERE car_id = $carID";
                    $db_connect->query($updateQuery);
                }
            }
        } elseif (isset($_POST['delete_cars'])) {
            if (isset($_POST['confirmed_cars']) && is_array($_POST['confirmed_cars'])) {
                foreach ($_POST['confirmed_cars'] as $carID) {
                    $carID = (int) $carID; // Захист від SQL-ін'єкцій
                    $deleteQuery = "DELETE FROM Cars WHERE car_id = $carID";
                    $db_connect->query($deleteQuery);
                }
            }
        }
    } elseif ($form_type === 'contracts-table') {
        if (isset($_POST['delete_contract'])) {
            if (isset($_POST['checked_contracts']) && is_array($_POST['checked_contracts'])) {
                foreach ($_POST['checked_contracts'] as $contractID) {
                    $contractID = (int) $contractID; // Захист від SQL-ін'єкцій
                    $deleteQuery = "DELETE FROM HistoryOfBuyingAndSellingCars WHERE operation_id = $contractID";
                    $db_connect->query($deleteQuery);
                }
            }
        }
    } elseif ($form_type === 'clients-table') {
        if (isset($_POST['delete_clients'])) {
            if (isset($_POST['checked_clients']) && is_array($_POST['checked_clients'])) {
                foreach ($_POST['checked_clients'] as $clientID) {
                    $clientID = (int) $clientID; // Захист від SQL-ін'єкцій
                    $deleteQuery = "DELETE FROM Clients WHERE client_id = $clientID";
                    $db_connect->query($deleteQuery);
                }
            }
        }
    } elseif ($form_type === 'add-admin') {
        $addAdminLogin = $_POST['add-admin__login'];
        $addAdminPass = $_POST['add-admin__password'];
        $addAdminConfirmPass = $_POST['add-admin__confirm-password'];
        $workerID = (int) $_POST['worker'];
        if (empty($addAdminLogin) || empty($addAdminPass) || empty($addAdminConfirmPass)) {
            $addAdminError = 'Будь-ласка введіть дані!';
        } elseif ($addAdminPass !== $addAdminConfirmPass) {
            $addAdminError = 'Введіть одинакові паролі';
        } else {
            $updateQuery = "UPDATE Workers SET login = '$addAdminLogin', password = '$addAdminPass' WHERE worker_id = $workerID";
            $db_connect->query($updateQuery);
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
    <link rel="stylesheet" href="../css/pages/adminPage.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,regular,500,700,900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,regular,500,600,700,900&display=swap"
        rel="stylesheet" />
</head>

<body>
    <div class="admin__page">
        <header class="admin__header">
            <div class="header__container">
                <nav class="admin__menu">
                    <ul class="menu__list">
                        <li class="menu__item menu__active">
                            <a href="#content__profile" class="menu__link">Профіль</a>
                        </li>
                        <li class="menu__item">
                            <a href="#content__orders" class="menu__link">Обробка замовлень</a>
                        </li>
                        <li class="menu__item">
                            <a href="#content__contracts" class="menu__link">Архів договорів</a>
                        </li>
                        <li class="menu__item">
                            <a href="#content__clients" class="menu__link">Дані клієнтів</a>
                        </li>
                        <li class="menu__item">
                            <a href="#content__add-admin" class="menu__link">Додати адміністратора</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>
        <div class="content__block">
            <div class="content__container">
                <section id="content__profile" class="content__profile">
                    <div class="main__information">
                        <div class="main-inform__image-block">
                            <img src="../img/admin/profile_img.png" alt="Profile Image">
                        </div>
                        <h1 class="name__last-name">
                            <?php echo $admin["name_of_worker"] . " " . $admin["last_name"]; ?>
                        </h1>
                        <?php
                        $showroomQuery = "SELECT cs.name_of_showroom, cs.house_number, s.street_name, c.city, cs.showroom_phone_number
                            FROM Workers w
                            INNER JOIN CarShowrooms cs ON w.showroom_id = cs.showroom_id
                            INNER JOIN Streets s ON cs.street_id = s.street_id
                            INNER JOIN Cities c ON s.city_id = c.city_id
                            WHERE w.worker_id = " . ($admin["worker_id"]) . "
                            LIMIT 1";
                        $showroomInfo = $db_connect->query($showroomQuery)->fetch_assoc();
                        ?>
                        <div class="showroom-name__block main-info__item">
                            <div class="showroom-name circle"></div>
                            <p class="showroom-name__text">
                                <?php
                                echo "Працює в автосалоні <span>«" . $showroomInfo["name_of_showroom"] . "»</span>";
                                ?>
                            </p>
                        </div>
                        <div class="position__block main-info__item">
                            <div class="position__circle circle"></div>
                            <p class="position__text">
                                <?php
                                $positionQuery = "SELECT Positions.name_of_position
                                FROM Workers
                                INNER JOIN Positions ON Workers.position_id = Positions.position_id
                                WHERE Workers.worker_id = " . ($admin["worker_id"]) . "
                                LIMIT 1";

                                $position = $db_connect->query($positionQuery)->fetch_assoc()["name_of_position"];
                                echo "Посада: <span>" . $position . "</span>";
                                ?>
                            </p>
                        </div>
                        <div class="showroom-info__block">
                            <p class="showroom__contact-text">
                                <?php echo "м. " . $showroomInfo["city"] . ", вул. " . $showroomInfo["street_name"] . ", буд. " . $showroomInfo["house_number"]; ?>
                            </p>
                            <p class="showroom__contact-text">
                                <?php echo $showroomInfo["showroom_phone_number"] ?>
                            </p>
                        </div>
                    </div>
                    <div class="detail">
                        <div class="detail__main-info">
                            <h2 class="detail__title">Основна інформація</h2>
                            <div class="detail-info__item">
                                <h3 class="detail-info__title">E-mail</h3>
                                <p class="detail-info__text">
                                    <?php echo $admin["email"]; ?>
                                </p>
                            </div>
                            <div class="detail-info__item">
                                <h3 class="detail-info__title">Номер телефону</h3>
                                <p class="detail-info__text">
                                    <?php echo $admin["phone_number"]; ?>
                                </p>
                            </div>
                            <div class="detail-info__item">
                                <h3 class="detail-info__title">Дата народження</h3>
                                <p class="detail-info__text">
                                    <?php echo $admin["date_of_birth"]; ?>
                                </p>
                            </div>
                            <div class="detail-info__item">
                                <h3 class="detail-info__title">Дата прийняття на роботу</h3>
                                <p class="detail-info__text">
                                    <?php echo $admin["appointment_date"]; ?>
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
                                <input name="form_new_password"
                                    class="detail-auth-info__input detail-auth-new-password">
                                <h3 class="detail-info__title">Старий пароль</h3>
                                <input name="form_password" class="detail-auth-info__input detail-auth-password">
                                <button class="detail-auth-info__submit" type="submit">Оновити дані</button>
                            </form>
                        </div>
                    </div>
                </section>
                <section id="content__orders" class="content__orders non-active__content">
                    <?php
                    $unprocessedOrdersQuery = "SELECT * FROM OrderProcessing WHERE acceptance_status = 0";
                    $unprocessedOrders = $db_connect->query($unprocessedOrdersQuery);
                    if ($unprocessedOrders->num_rows !== 0) { ?>
                        <h2 class="order__title">Підтвердження замовлень</h2>
                        <form method="post" class="orders__table">
                            <input type="hidden" name="form_type" value="orders-table">
                            <div class="orders__titles">
                                <h4 class="orders__column-title">Ім'я клієнта</h4>
                                <h4 class="orders__column-title">Прізвище</h4>
                                <h4 class="orders__column-title">Контактні дані</h4>
                                <h4 class="orders__column-title">Деталі замовлення</h4>
                            </div>
                            <?php while ($order = $unprocessedOrders->fetch_assoc()) { ?>
                                <div class="orders__row">
                                    <div class="order__check-block">
                                        <input type="checkbox" name="confirmed_orders[]"
                                            value="<?php echo $order['order_id']; ?>" class="order__check-confirm">
                                    </div>
                                    <p class="order__column-item">
                                        <?php echo $order["client_name"] ?>
                                    </p>
                                    <p class="order__column-item">
                                        <?php echo $order["client_last_name"] ?>
                                    </p>
                                    <p class="order__column-item">
                                        <?php echo $order["client_contacts"] ?>
                                    </p>
                                    <p class="order__column-item details">
                                        <?php echo $order["order__detail"] ?>
                                    </p>
                                </div>

                            <?php } ?>
                            <div class="order-table__buttons">
                                <button type="submit" name="confirm_orders" class="orders__confirm">Підтвердити</button>
                                <button type="submit" name="delete_orders" class="orders__delete">Видалити</button>
                            </div>
                        </form>
                    <?php }
                    $unprocessedCarsQuery = "SELECT * FROM Cars WHERE offered_for_sale = 0";
                    $unprocessedCars = $db_connect->query($unprocessedCarsQuery);
                    if ($unprocessedCars->num_rows !== 0) { ?>
                        <hr class="form__separator">
                        <h2 class="order__title">Заявки на продаж авто</h2>
                        <form method="post" class="cars__table">
                            <input type="hidden" name="form_type" value="cars-table">
                            <div class="table__content overflow__x">
                                <div class="cars__titles">
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
                                <?php while ($car = $unprocessedCars->fetch_assoc()) {
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
                                <button type="submit" name="confirm_cars" class="orders__confirm">Підтвердити</button>
                                <button type="submit" name="delete_cars" class="orders__delete">Видалити</button>
                            </div>
                        </form>
                    <?php } ?>
                    <hr class="form__separator">
                    <h2 class="order__title">Історія замовлень</h2>
                    <?php
                    $confirmedOrdersQuery = "SELECT * FROM OrderProcessing WHERE acceptance_status = 1";
                    $confirmedOrders = $db_connect->query($confirmedOrdersQuery); ?>
                    <form method="post" class="orders__table">
                        <input type="hidden" name="form_type" value="history-orders-table">
                        <div class="orders__titles">
                            <h4 class="orders__column-title">Ім'я клієнта</h4>
                            <h4 class="orders__column-title">Прізвище</h4>
                            <h4 class="orders__column-title">Контактні дані</h4>
                            <h4 class="orders__column-title">Деталі замовлення</h4>
                            <h4 class="orders__column-title">Статус замовлення</h4>
                        </div>
                        <?php while ($order = $confirmedOrders->fetch_assoc()) { ?>
                            <div class="orders__row">
                                <div class="order__check-block">
                                    <input type="checkbox" name="done_orders[]" value="<?php echo $order['order_id']; ?>"
                                        class="order__check-confirm">
                                </div>
                                <p class="order__column-item">
                                    <?php echo $order["client_name"] ?>
                                </p>
                                <p class="order__column-item">
                                    <?php echo $order["client_last_name"] ?>
                                </p>
                                <p class="order__column-item overflow__x">
                                    <?php echo $order["client_contacts"] ?>
                                </p>
                                <p class="order__column-item details">
                                    <?php echo $order["order__detail"] ?>
                                </p>
                                <p class="order__column-item">
                                    <?php echo ($order["execution_status"] === '1') ? "Виконано" : "В пошуку авто"; ?>
                                </p>
                            </div>

                        <?php } ?>
                        <div class="order-table__buttons">
                            <button type="submit" name="confirm_done_orders" class="orders__confirm">Виконано</button>
                            <button type="submit" name="delete_orders" class="orders__delete">Видалити</button>
                        </div>
                    </form>
                </section>
                <section id="content__contracts" class="content__contracts non-active__content">
                    <h2 class="contracts__title">Історія договорів про купівлю-продаж автомобілів</h2>
                    <form method="get" class="dates__form">
                        <input type="hidden" name="form_type" value="get-contracts">
                        <input type="hidden" name="login" value="<?php echo $login ?>">
                        <input type="hidden" name="password" value="<?php echo $password ?>">
                        <div class="dates__block">
                            <input type="date" id="start_date" name="start_date" class="contracts-date__input"
                                value="<?php $startDateForContracts ?>" required>
                            <p> - </p>
                            <input type="date" name="end_date" class="contracts-date__input"
                                value="<?php $endDateForContracts ?>" required>
                        </div>
                        <button type="submit" class="contracts-date__search">Пошук договорів</button>
                    </form>
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                        $form_type = $_GET['form_type'];
                        if ($form_type === 'get-contracts') {
                            $startDateForContracts = $_GET["start_date"];
                            $endDateForContracts = $_GET["end_date"];
                            $contractsQuery = "SELECT * FROM HistoryOfBuyingAndSellingCars WHERE date_of_registration BETWEEN '$startDateForContracts' AND '$endDateForContracts'";
                            $contractsResult = $db_connect->query($contractsQuery);
                            if ($contractsResult->num_rows > 0) { ?>
                                <form method="post" class="contracts__form">
                                    <input type="hidden" name="form_type" value="contracts-table">
                                    <div class="contracts__table">
                                        <div class="contracts__row titles">
                                            <p>Дата реєстрації</p>
                                            <p>Авто</p>
                                            <p>Автосалон</p>
                                            <p>Клієнт</p>
                                            <p>Менеджер</p>
                                            <p>Сума контракту</p>
                                            <p>Тип контракту</p>
                                        </div>
                                        <?php while ($contract = $contractsResult->fetch_assoc()) { ?>
                                            <div class="contracts__row">
                                                <div class="contracts__check-block">
                                                    <input type="checkbox" name="checked_contracts[]"
                                                        value="<?php echo $contract['operation_id']; ?>"
                                                        class="contract__check-confirm">
                                                </div>
                                                <p>
                                                    <?php echo $contract['date_of_registration'] ?>
                                                </p>
                                                <p>
                                                    <?php
                                                    $carForContractQuery = "SELECT c.car_model, m.name_of_manufacture, c.year_of_manufacture, c.car_number
                                                    FROM Cars c
                                                    INNER JOIN Manufactures m ON c.manufacture_id = m.manufacture_id
                                                    WHERE c.car_id =" . $contract['car_id'] . "";

                                                    $carForContract = $db_connect->query($carForContractQuery)->fetch_assoc();
                                                    echo $carForContract["name_of_manufacture"] . " " . $carForContract["car_model"] . ", " . $carForContract["year_of_manufacture"] . ", " . $carForContract["car_number"]; ?>
                                                </p>
                                                <p>
                                                    <?php
                                                    $showroomForContractQuery = "SELECT cs.name_of_showroom, cs.house_number, s.street_name, c.city
                                                FROM CarShowrooms cs
                                                INNER JOIN Streets s ON cs.street_id = s.street_id
                                                INNER JOIN Cities c ON s.city_id = c.city_id
                                                WHERE cs.showroom_id = " . ($contract["showroom_id"]) . "
                                                LIMIT 1";
                                                    $showroomForContract = $db_connect->query($showroomForContractQuery)->fetch_assoc();

                                                    echo $showroomForContract["name_of_showroom"] . "\n" . $showroomForContract["city"] . ", вул. " . $showroomForContract["street_name"] . ", буд. " . $showroomForContract["house_number"]; ?>
                                                </p>
                                                <p>
                                                    <?php
                                                    $clientForContractQuery = "SELECT c.clients_name, c.last_name, c.phone_number
                                                 FROM Clients c
                                                 WHERE c.client_id = " . ($contract["client_id"]) . "
                                                 LIMIT 1";
                                                    $clientForContract = $db_connect->query($clientForContractQuery)->fetch_assoc();

                                                    echo $clientForContract["clients_name"] . " " . $clientForContract["last_name"] . ", " . $clientForContract["phone_number"]; ?>
                                                </p>
                                                <p>
                                                    <?php
                                                    $workerForContractQuery = "SELECT w.name_of_worker, w.last_name, p.name_of_position, w.phone_number
                                                FROM Workers w
                                                INNER JOIN Positions p ON w.position_id = p.position_id
                                                WHERE w.worker_id = " . ($contract["manager_id"]) . "
                                                LIMIT 1";
                                                    $workerForContract = $db_connect->query($workerForContractQuery)->fetch_assoc();

                                                    echo $workerForContract["name_of_worker"] . " " . $workerForContract["last_name"] . ", " . $workerForContract["name_of_position"] . ", " . $clientForContract["phone_number"]; ?>
                                                </p>
                                                <p>
                                                    <?php echo $contract['contract_amount'] ?>
                                                </p>
                                                <p>
                                                    <?php
                                                    $contractTypeForTableQuery = "SELECT ct.type_name
                                                FROM TypesOfContract ct
                                                WHERE ct.contract_type_id = " . ($contract["type_of_contract_id"]) . "
                                                LIMIT 1";
                                                    $contractTypeForTable = $db_connect->query($contractTypeForTableQuery)->fetch_assoc();
                                                    echo $contractTypeForTable['type_name'] ?>
                                                </p>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="contract-table__buttons">
                                        <button type="submit" name="change_contract" class="change__contract">Редагувати</button>
                                        <button type="submit" name="delete_contract" class="contract__delete">Видалити</button>
                                    </div>
                                </form>
                            <?php } else { ?>
                                <p class="contracts__not-found">За даними параметрами договорів купівлі-продажу не знайдено</p>
                            <?php }
                        }
                    }
                    ?>
                </section>
                <section id="content__clients" class="content__clients non-active__content">
                    <?php
                    $allClientsQuery = "SELECT * FROM Clients";
                    $allClients = $db_connect->query($allClientsQuery);
                    ?>
                    <h2 class="order__title">Клієнти</h2>
                    <form method="post" class="clients__table">
                        <input type="hidden" name="form_type" value="clients-table">
                        <div class="table__content overflow__x">
                            <div class="clients__titles">
                                <h4 class="clients__column-title">Ім'я</h4>
                                <h4 class="clients__column-title">Прізвище</h4>
                                <h4 class="clients__column-title">Номер телефону</h4>
                                <h4 class="clients__column-title">Пошта</h4>
                                <h4 class="clients__column-title">Дата народження</h4>
                                <h4 class="clients__column-title">Паспорт</h4>
                                <h4 class="clients__column-title">Ідентифікаційний код</h4>
                            </div>
                            <?php while ($client = $allClients->fetch_assoc()) {
                                ?>
                                <div class="client__row">
                                    <div class="client__check-block">
                                        <input type="checkbox" name="checked_clients[]" value="<?php echo $client['client_id']; ?>"
                                            class="client__check-confirm">
                                    </div>
                                    <div class="client__info-block">
                                        <p class="client__column-item">
                                            <?php echo $client["clients_name"]; ?>
                                        </p>
                                        <p class="client__column-item">
                                            <?php echo $client["last_name"] ?>
                                        </p>
                                        <p class="client__column-item">
                                            <?php echo $client["phone_number"] ?>
                                        </p>
                                        <p class="client__column-item">
                                            <?php echo $client["email"] ?>
                                        </p>
                                        <p class="client__column-item">
                                            <?php echo $client["date_of_birth"] ?>
                                        </p>
                                        <p class="client__column-item">
                                            <?php echo $client["series"]." ".$client["passport_number"].", ".$client["date_of_issue"] ?>
                                        </p>
                                        <p class="client__column-item">
                                            <?php echo $client["identification_code"] ?>
                                        </p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="order-table__buttons">
                            <button type="submit" name="change__clients" class="orders__confirm">Редагувати</button>
                            <button type="submit" name="delete_clients" class="orders__delete">Видалити</button>
                        </div>
                    </form>
                </section>
                <section id="content__add-admin" class="content__add-admin non-active__content">
                    <h2 class="order__title">Додати адміністратора</h2>
                    <form method="post" class="add-admin__form">
                        <input type="hidden" name="form_type" value="add-admin">
                        <?php if ($error !== '') { ?>
                            <p style="color: red;">
                                <?php echo $addAdminError; ?>
                            </p>
                        <?php } 
                        $workersQuery = "SELECT * FROM Workers WHERE login = '' AND password = ''";
                        $workers = $db_connect->query($workersQuery);
                        ?>
                        <select name="worker" class="select__worker">
                            <?php while ($worker = $workers->fetch_assoc()) {?>
                                <option value="<?php echo $worker["worker_id"]?>"><?php echo $worker["name_of_worker"]." ".$worker["last_name"] ?></option>
                            <?php }?>
                        </select>
                        <input type="text" name="add-admin__login" class="add-admin__input" placeholder="Введіть логін">
                        <input type="password" name="add-admin__password" class="add-admin__input" placeholder="Введіть пароль">
                        <input type="password" name="add-admin__confirm-password" class="add-admin__input" placeholder="Підтвердіть пароль">
                        <button class="add-admin__button">Оновити дані</button>
                    </form>
                </section>
            </div>
        </div>
    </div>
    <script src="../js/adminPage.js"></script>
</body>

</html>