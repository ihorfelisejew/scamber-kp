<?php
$dblocation = "localhost";
$dbuser = "ihorfelisieiev";
$dbpasswd = "";
$dbname = "Scamber";
$db_connect = mysqli_connect($dblocation, $dbuser, $dbpasswd, $dbname);
mysqli_set_charset($db_connect, "utf8");

$sqlQuery = "SELECT Cars.*
FROM Cars
INNER JOIN CarsInShowroom ON CarsInShowroom.car_id = Cars.car_id
WHERE CarsInShowroom.showroom_id = 1";

$cars = $db_connect->query($sqlQuery);

$n = 1;
while ($car = $cars->fetch_assoc()) {
        $price = number_format($car['price'], 0, '.', ' ');
        echo '<div class="catalog__item">';

        echo '<div class="catalog__item-head">
            <div class="catalog__head-info">';

        $manufactureQuery = "SELECT Manufactures.name_of_manufacture
  FROM Cars
  INNER JOIN Manufactures ON Cars.manufacture_id = Manufactures.manufacture_id
  WHERE Cars.car_id = " . ($car["car_id"]) . "
  LIMIT 1";

        $manufacture = $db_connect->query($manufactureQuery)->fetch_assoc()["name_of_manufacture"];
        // Вивід виробника і типу кузова
        echo '<div class="catalog__head-item">
            <div class="catalog__head-circle"></div>
            <p class="catalog__head-text">' . $manufacture . '</p>
          </div>';

        $body_typeQuery = "SELECT BodyTypes.name_of_type
          FROM Cars
          INNER JOIN BodyTypes ON Cars.body_type_id = BodyTypes.type_id
          WHERE Cars.car_id = " . ($car["car_id"]) . "
          LIMIT 1";

        $body_type = $db_connect->query($body_typeQuery)->fetch_assoc()["name_of_type"];
        echo '<div class="catalog__head-item">
            <div class="catalog__head-circle"></div>
            <p class="catalog__head-text">' . $body_type . '</p>
          </div>';

        echo '</div>
          <div class="catalog__head-image"><img src="img/main/catalog/new_image.png" alt="NEW"></div>
          </div>';

        // Вивід інформації про автомобіль
        echo '<div class="catalog__item-content">
            <div class="catalog__item-image">
                <img src="img/main/catalog/car_' . ($n) . '.png" alt="car">
            </div>
            <h3 class="catalog__item-name">' . $manufacture . ' ' . $car["car_model"] . ' ' . $car["year_of_manufacture"] . '</h3>
            <div class="catalog__item-info">
                <div class="catalog__item-info-column">';

        // Вивід показників пробігу і типу кузова
        echo '<div class="catalog__item-info-element">
            <img src="img/main/catalog/icon_mileage.png" class="catalog__item-info-image">
            <p class="catalog__item-info-text">' . $car["car_mileage"] . ' тис. км.</p>
          </div>';
        $engine_typeQuery = "SELECT EngineType.type_of_engine
          FROM Cars
          INNER JOIN EngineType ON Cars.engine_type_id = EngineType.engine_id
          WHERE Cars.car_id = " . ($car["car_id"]) . "
          LIMIT 1";

        $engine_type = $db_connect->query($engine_typeQuery)->fetch_assoc()["type_of_engine"];
        echo '<div class="catalog__item-info-element">
            <img src="img/main/catalog/icon_engine.png" class="catalog__item-info-image">
            <p class="catalog__item-info-text">' . $engine_type . ', '. $car['engine_capacity'].' л</p>
          </div>';

        echo '</div>
          <div class="catalog__item-info-column">';
        $gearboxQuery = "SELECT Gearboxes.name_of_gearbox
          FROM Cars
          INNER JOIN Gearboxes ON Cars.body_type_id = Gearboxes.gearbox_id
          WHERE Cars.car_id = " . ($car["car_id"]) . "
          LIMIT 1";

        $gearbox = $db_connect->query($gearboxQuery)->fetch_assoc()["name_of_gearbox"];
        // Вивід показників коробки передач та інформації про ДТП
        echo '<div class="catalog__item-info-element">
            <img src="img\main\catalog\icon_gearbox.png" class="catalog__item-info-image">
            <p class="catalog__item-info-text">' . $gearbox . '</p>
          </div>';

        echo '<div class="catalog__item-info-element">
            <img src="img\main\catalog\icon_accident.png" class="catalog__item-info-image">
            <p class="catalog__item-info-text">Не був в дтп</p>
          </div>';

        echo '</div>
          </div>
          <div class="catalog__item-bottom-info">
            <p class="catalog__item-price">' . number_format($car['price'], 0, '.', ' ') . ' $</p>
            <button class="catalog__item-more">Детальніше</button>
          </div>
          </div>';

        echo '</div>';
        $n++;
}
mysqli_close($db_connect);
?>