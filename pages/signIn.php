<?php
$dblocation = "localhost";
$dbuser = "ihorfelisieiev";
$dbpasswd = "";
$dbname = "Scamber";
$db_connect = mysqli_connect($dblocation, $dbuser, $dbpasswd, $dbname);
mysqli_set_charset($db_connect, "utf8");

function validateInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = validateInput($_POST['login']);
    $password = validateInput($_POST['password']);

    if (empty($login) || empty($password)) {
        $error = 'Будь-ласка введіть дані!';
    } else {
        $query = "SELECT * FROM Clients WHERE login = '$login' AND password = '$password'";
        $result = mysqli_query($db_connect, $query);

        if (mysqli_num_rows($result) > 0) {
            header("Location: clientPage.php?login=".($login)."&password=".($password)."");
        } else {
            $error = 'Incorrect login or password';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
    <link rel="stylesheet" href="../css/pages/signIn.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,regular,500,700,900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,regular,500,600,700,900&display=swap"
        rel="stylesheet" />
</head>

<body>
    <main class="page__block">
        <div class="page__content">
            <div class="form__block">
                <?php if ($error !== '') { ?>
                    <p style="color: red; text-align:center;margin:0 auto;">
                        <?php echo $error; ?>
                    </p>
                <?php } ?>
                <form method="POST" action="" class="form">
                    <input name ='login' class="sign-in__input" type="text" placeholder="Введіть свій логін">
                    <input name='password' class="sign-in__input" type="password" placeholder="Введіть свій пароль">
                    <button class="sign-in__button" type="submit">Sign In</button>
                </form>
                <button class='sign-up__button'>Sign Up</button>
            </div>
            <div class="text__block">
                <div class="logo">
                    <img src="../img/main/logo2.png" alt="">
                    <h2 class="logo__title">Scamber</h2>
                </div>
                <h1 class="sign-in__title">
                    Sell your<br>car for<br>the best<br>price!
                </h1>
            </div>
        </div>
    </main>
</body>

</html>

<?php mysqli_close($db_connect); ?>