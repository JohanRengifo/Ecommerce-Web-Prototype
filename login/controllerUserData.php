<?php
session_start();
require "connection.php";
$email = "";
$user = "";
$errors = array();

// if user signup button
if (isset($_POST['signup'])) {
    $user = mysqli_real_escape_string($con, $_POST['user']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);

    if ($password !== $cpassword) {
        $errors['password'] = "Las Contraseñas No Coinciden!";
    }

    $email_check = "SELECT * FROM user WHERE email = '$email'";
    $res = mysqli_query($con, $email_check);

    if (mysqli_num_rows($res) > 0) {
        $errors['email'] = "Este correo Electronico Ya existe!";
    }

    if (count($errors) === 0) {
        $encpass = password_hash($password, PASSWORD_BCRYPT);
        $code = rand(999999, 111111);
        $status = "notverified";

        $insert_data = "INSERT INTO user (user, email, pass, code, status)
                        VALUES ('$user', '$email', '$encpass', '$code', '$status')";
        $data_check = mysqli_query($con, $insert_data);

        if ($data_check) {
            $subject = "Email Verification Code | Student Analytics Col";
            $message = '
            <html>
            <head>
              <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
              <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
              <style>
                a,
                a:link,
                a:visited {
                  text-decoration: none;
                  color: #00788a;
                }

                a:hover {
                  text-decoration: underline;
                }

                h2,
                h2 a,
                h2 a:visited,
                h3,
                h3 a,
                h3 a:visited,
                h4,
                h5,
                h6,
                .t_cht {
                  color: #000 !important;
                }

                .ExternalClass p,
                .ExternalClass span,
                .ExternalClass font,
                .ExternalClass td {
                  line-height: 100%;
                }

                .ExternalClass {
                  width: 100%;
                }
              </style>
            </head>

            <body style="font-size: 1.25rem; font-family: \'Roboto\', sans-serif; padding-left: 20px; padding-right: 20px; padding-top: 20px; padding-bottom: 20px; background-color: #FAFAFA; width: 75%; max-width: 1280px; min-width: 600px; margin-right: auto; margin-left: auto;">
              <table cellpadding="12" cellspacing="0" width="100%" bgcolor="#FAFAFA" style="border-collapse: collapse; margin: auto;">
                <thead>
                  <tr>
                    <td style="padding-left: 0; padding-right: 0;">
                      <img src="https://uploads-ssl.webflow.com/5e96c040bda7162df0a5646d/5f91d2a4d4d57838829dcef4_image-blue%20waves%402x.png" style="width: 80%; max-width: 750px;" />
                    </td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td style="padding: 50px; background-color: #fff; max-width: 660px;">
                      <table width="100%" style="">
                        <tr>
                          <td style="text-align:center;">
                            <h1 style="font-size: 30px; color: #202225; margin-top: 0;">¡Hola!</h1>
                            <p style="font-size: 18px; margin-bottom: 30px; color: #202225; max-width: 60ch; margin-left: auto; margin-right: auto;">Este es tu código de verificación:</p>
                            <p style="font-size: 24px; font-weight: bold; margin-bottom: 30px; color: #202225; max-width: 60ch; margin-left: auto; margin-right: auto;">' . $code . '</p>
                            <p style="font-size: 18px; margin-bottom: 30px; color: #202225; max-width: 60ch; margin-left: auto; margin-right: auto;">Ingresa este código para validar que eres tú.</p>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <td style="text-align: center; padding-top: 30px;">
                      <table>
                        <tr>
                          <td><img src="https://uploads-ssl.webflow.com/5e96c040bda7162df0a5646d/5f91d2a4d80f5ebbf2ec0119_image-hand%20with%20wrench%402x.png" style="width: 100px;" /></td>
                          <td style="text-align: left; color:#B6B6B6; font-size: 18px; padding-left: 12px;">Si no has solicitado esto, puedes ignorar este correo o notificárnoslo.</td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </tfoot>
              </table>
            </body>
            </html>';
            $headers = "From: accountsecurityservice@student-analytics-col.com\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=utf-8\r\n";

            if (mail($email, $subject, $message, $headers)) {
                $info = "Hemos enviado un código de verificación a tu correo electrónico - $email";
                $_SESSION['info'] = $info;
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                header('location: user-otp.php');
                exit();
            } else {
                $errors['otp-error'] = "¡Error al enviar el código!";
            }
        } else {
            $errors['db-error'] = "¡Error al insertar datos en la base de datos!";
        }
    }
}

//if user click verification code submit button
if (isset($_POST['check'])) {
    $_SESSION['info'] = "";
    $otp_code = mysqli_real_escape_string($con, $_POST['otp']);
    $check_code = "SELECT * FROM user WHERE code = $otp_code";
    $code_res = mysqli_query($con, $check_code);
    if (mysqli_num_rows($code_res) > 0) {
        $fetch_data = mysqli_fetch_assoc($code_res);
        $fetch_code = $fetch_data['code'];
        $email = $fetch_data['email'];
        $code = 0;
        $status = 'verified';
        $update_otp = "UPDATE user SET code = $code, status = '$status' WHERE code = $fetch_code";
        $update_res = mysqli_query($con, $update_otp);
        if ($update_res) {
            $_SESSION['user'] = $user;
            $_SESSION['email'] = $email;
            header('location: home.php');
            exit();
        } else {
            $errors['otp-error'] = "Error al actualizar el código!";
        }
    } else {
        $errors['otp-error'] = "Has introducido un código incorrecto!";
    }
}

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $check_email = "SELECT * FROM user WHERE email = '$email'";
    $res = mysqli_query($con, $check_email);
    if (mysqli_num_rows($res) > 0) {
        $fetch = mysqli_fetch_assoc($res);
        $fetch_pass = $fetch['pass'];
        if (password_verify($password, $fetch_pass)) {
            $_SESSION['email'] = $email;
            $status = $fetch['status'];
            if ($status == 'verified') {
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                header('location: home.php');
            } else {
                $info = "Parece que aún no has verificado tu correo electrónico - $email";
                $_SESSION['info'] = $info;
                header('location: user-otp.php');
            }
        } else {
            $errors['email'] = "¡Correo electrónico o contraseña incorrectos!";
        }
    } else {
        $errors['email'] = "¡Parece que aún no eres miembro! Haz clic en el enlace inferior para registrarte.";
    }
}

//if user click continue button in forgot password form
if (isset($_POST['check-email'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $check_email = "SELECT * FROM user WHERE email='$email'";
    $run_sql = mysqli_query($con, $check_email);
    if (mysqli_num_rows($run_sql) > 0) {
        $code = rand(999999, 111111);
        $insert_code = "UPDATE user SET code = $code WHERE email = '$email'";
        $run_query =  mysqli_query($con, $insert_code);
        if ($run_query) {
            $subject = "Código de restablecimiento de contraseña | Student Analytics Col";
            $message = '
            <html>
            <head>
              <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
              <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
              <style>
                a,
                a:link,
                a:visited {
                  text-decoration: none;
                  color: #00788a;
                }

                a:hover {
                  text-decoration: underline;
                }

                h2,
                h2 a,
                h2 a:visited,
                h3,
                h3 a,
                h3 a:visited,
                h4,
                h5,
                h6,
                .t_cht {
                  color: #000 !important;
                }

                .ExternalClass p,
                .ExternalClass span,
                .ExternalClass font,
                .ExternalClass td {
                  line-height: 100%;
                }

                .ExternalClass {
                  width: 100%;
                }
              </style>
            </head>

            <body style="font-size: 1.25rem; font-family: \'Roboto\', sans-serif; padding-left: 20px; padding-right: 20px; padding-top: 20px; padding-bottom: 20px; background-color: #FAFAFA; width: 75%; max-width: 1280px; min-width: 600px; margin-right: auto; margin-left: auto;">
              <table cellpadding="12" cellspacing="0" width="100%" bgcolor="#FAFAFA" style="border-collapse: collapse; margin: auto;">
                <thead>
                  <tr>
                    <td style="padding-left: 0; padding-right: 0;">
                      <img src="https://uploads-ssl.webflow.com/5e96c040bda7162df0a5646d/5f91d2a4d4d57838829dcef4_image-blue%20waves%402x.png" style="width: 80%; max-width: 750px;" />
                    </td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td style="padding: 50px; background-color: #fff; max-width: 660px;">
                      <table width="100%" style="">
                        <tr>
                          <td style="text-align:center;">
                            <h1 style="font-size: 30px; color: #202225; margin-top: 0;">¡Hola!</h1>
                            <p style="font-size: 18px; margin-bottom: 30px; color: #202225; max-width: 60ch; margin-left: auto; margin-right: auto;">Este es tu código de verificación:</p>
                            <p style="font-size: 24px; font-weight: bold; margin-bottom: 30px; color: #202225; max-width: 60ch; margin-left: auto; margin-right: auto;">' . $code . '</p>
                            <p style="font-size: 18px; margin-bottom: 30px; color: #202225; max-width: 60ch; margin-left: auto; margin-right: auto;">Ingresa este código para validar que eres tú.</p>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <td style="text-align: center; padding-top: 30px;">
                      <table>
                        <tr>
                          <td><img src="https://uploads-ssl.webflow.com/5e96c040bda7162df0a5646d/5f91d2a4d80f5ebbf2ec0119_image-hand%20with%20wrench%402x.png" style="width: 100px;" /></td>
                          <td style="text-align: left; color:#B6B6B6; font-size: 18px; padding-left: 12px;">Si no has solicitado esto, puedes ignorar este correo o notificárnoslo.</td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </tfoot>
              </table>
            </body>
            </html>
            ';
            $headers = "From: accountsecurityservice@student-analytics-col.com\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=utf-8\r\n";

            if (mail($email, $subject, $message, $headers)) {
                $info = "Hemos enviado un código de restablecimiento de contraseña a tu correo electrónico - $email";
                $_SESSION['info'] = $info;
                $_SESSION['email'] = $email;
                header('location: reset-code.php');
                exit();
            } else {
                $errors['otp-error'] = "¡Error al enviar el código!";
            }
        } else {
            $errors['db-error'] = "¡Algo salió mal!";
        }
    } else {
        $errors['email'] = "¡Esta dirección de correo electrónico no existe!";
    }
}


//if user click check reset otp button
if (isset($_POST['check-reset-otp'])) {
    $_SESSION['info'] = "";
    $otp_code = mysqli_real_escape_string($con, $_POST['otp']);
    $check_code = "SELECT * FROM user WHERE code = $otp_code";
    $code_res = mysqli_query($con, $check_code);
    if (mysqli_num_rows($code_res) > 0) {
        $fetch_data = mysqli_fetch_assoc($code_res);
        $email = $fetch_data['email'];
        $_SESSION['email'] = $email;
        $info = "Crea una contraseña nueva que no utilices en ningún otro sitio!";
        $_SESSION['info'] = $info;
        header('location: new-password.php');
        exit();
    } else {
        $errors['otp-error'] = "Has introducido un código incorrecto!";
    }
}

//if user click change password button
if (isset($_POST['change-password'])) {
    $_SESSION['info'] = "";
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
    if ($password !== $cpassword) {
        $errors['password'] = "¡Confirmar contraseña, no coinciden!";
    } else {
        $code = 0;
        $email = $_SESSION['email']; //getting this email using session
        $encpass = password_hash($password, PASSWORD_BCRYPT);
        $update_pass = "UPDATE user SET code = $code, pass = '$encpass' WHERE email = '$email'";
        $run_query = mysqli_query($con, $update_pass);
        if ($run_query) {
            $info = "Su contraseña ha cambiado. Ahora puede iniciar sesión con su nueva contraseña.";
            $_SESSION['info'] = $info;
            header('Location: password-changed.php');
        } else {
            $errors['db-error'] = "No se ha podido cambiar la contraseña.";
        }
    }
}

//if login now button click
if (isset($_POST['login-now'])) {
    header('Location: login-user.php');
}
