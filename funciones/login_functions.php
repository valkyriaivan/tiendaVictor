<?php
  session_start();
    // variable declaration
    $username = "";
    $email    = "";
    $errors = array();
    $error = false;
    $_SESSION['success'] = "";

    // connect to database
    $db = mysqli_connect('localhost', 'root', 'sa', 'mi_primera_web');

    // REGISTER USER
    if (isset($_POST['reg_user'])) {
        // receive all input values from the form
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
        $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

        // form validation: ensure that the form is correctly filled
        if (empty($username)) { array_push($errors, "El nombre de usuario es obligatorio."); $nombreErr = true;}
        if (empty($email)) { array_push($errors, "El correo electrónico es obligatorio."); $emailErr = true;}
        if (empty($password_1)) { array_push($errors, "Se requiere una contraseña."); $passErr = true;}

        if ($password_1 != $password_2) {
            $passErr = true;
            array_push($errors, "No coinciden las dos contraseñas.");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          array_push($errors, "Formato inválido de correo");
          $emailErr = true;
        }

        // register user if there are no errors in the form
        if (count($errors) == 0) {
            $password = md5($password_1);//encrypt the password before saving in the database
            $query = "INSERT INTO users (username, email, password)
                      VALUES('$username', '$email', '$password')";
            mysqli_query($db, $query);

            $_SESSION['username'] = $username;
            $_SESSION['success'] = "Ahora estás logeado";
            unset($_SESSION['msg']);
            if (isset($_GET["redirect"])){
                header('location: ' . $_GET["redirect"]);
            }else
                header('location: /login/index.php');
        }
    }
    // ...

    // LOGIN USER
    if (isset($_POST['login_user'])) {
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $password = mysqli_real_escape_string($db, $_POST['password']);

        if (empty($username)) {
          $nombreErr = true;
          array_push($errors, "Username is required");
        }
        if (empty($password)) {
          $passErr = true;
          array_push($errors, "Password is required");
        }

        if (count($errors) == 0) {
            $password = md5($password);
            $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
            $results = mysqli_query($db, $query);

            if (mysqli_num_rows($results) == 1) {
                $_SESSION["username"] = $username;
                $_SESSION["success"] = "Ahora estás logeado.";
                unset($_SESSION['msg']);
                if (isset($_GET["redirect"])){
                    header('location: ' . $_GET["redirect"]);
                }else
                    header('location: /login/index.php');
                }
            else {
              array_push($errors, "Combinación errónea de usuario y contraseña");
            }
        }
    }
?>
