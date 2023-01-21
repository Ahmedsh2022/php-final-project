<?php
include_once "partial/DB_CONNECTION.php";
$errors = [];
$success = false;
function validat_input($input)
{
    $input = htmlspecialchars($input);
    $input = trim($input);
    $input = stripslashes($input);
    return $input;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_Con = $_POST['password_Con'];
    $country = $_POST['country'];

    if (strcmp($country, "empty") == 0) {
        $errors['country_error'] = "*Please Choose your country.";
    }

    if (isset($_POST['gender'])) {
        $gender = $_POST['gender'];
    } else {
        $errors['gender_error'] = "*Please Choose your gender.";
    }


    if (empty($name)) {
        $errors["name_error"] = " *Please Enter your name ";
    }

    if (empty($username)) {
        $errors['username_error'] = " *Please Enter username ";
    } else {
        if (strlen($username) >= 6) {
            if (!preg_match("/^[a-zA-Z@#$& ]*$/",  $username)) {
                $errors['username_error'] = "*Please Enter Just a-z @#$&";
            } else {
                $username = validat_input($_POST['username']);
            }
        } else {
            $errors['username_error'] = "*Please Enter Mor Than 6 Char";
        }
    }
    if (empty($email)) {
        $errors['email_error'] = "*email is required, please fill it";
    } else {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email_error'] = "*please enter valid email ";
        } else {
            $email = validat_input($_POST['email']);
        }
    }
    if (empty($password)) {
        $errors['password_error'] = "*password is required, please fill it";
    } else {

        if (strlen($password) >= 12) {

            if (!preg_match("/^[a-zA-Z0-9@#$& ]*$/", $password)) {
                $errors['password_error'] = "*Please Enter Just a-z 0-9 @#$&";
            }
        } else {
            $errors['password_error'] = "*Please Enter Mor Than 12 Char";
        }
    }
    if (empty($password_Con)) {
        $errors['password_Con_error'] = "*password comfimation is required, please fill it";
    } elseif (strcmp($password_Con, $password) != 0) {
        $errors['password_Con_error'] = "*passwords do not match";
        $errors['password_error'] = "*passwords do not match";
    }


    if (count($errors) > 0) {
        $errors['general_error'] = "*Please Fix All Errors";
    } else {

        $query = "INSERT INTO admins (name,email,username,password,country,gender)
    VALUES('$name','$email','$username','$password','$country','$gender')";
        $result = mysqli_query($connection, $query);
        if ($result) {
            $errors = [];
            $success = true;
        } else {
            $errors['general_error'] = "please fix all errors";
        }

        if ($success) {
            header('Location:login.php');
        } else {
            $errors['general_error'] = "*Error! be careful of the inputs!";
        }
    }
}
?>









<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<?php
include "partial/header.php";

?>

<body class="vertical-layout vertical-menu-modern 1-column   menu-expanded blank-page blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column">

    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="flexbox-container">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-md-4 col-10 box-shadow-2 p-0">
                            <div class="card border-grey border-lighten-3 m-0">
                                <div class="card-header border-0">
                                    <div class="card-title text-center">
                                        <div class="p-1">
                                            <img src="app-assets/images/logo/logo-dark.png" alt="branding logo">
                                        </div>
                                    </div>
                                    <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                                        <span>Sign Up</span>
                                    </h6>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <?php
                                        if (!empty($errors['general_error'])) {
                                            echo "<div class='alert alert-danger'>" . $errors["general_error"] . "</div>";
                                        } elseif ($success) {
                                            echo "<div class='alert alert-success'>Admin Added Succesfully</div>";
                                        }

                                        ?>
                                        <form method="POST" class="form-horizontal form-simple" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                                            <fieldset class="form-group position-relative has-icon-left mb-0">
                                                <input type="text" class="form-control form-control-lg input-lg" name='name' id="name" placeholder="Your Name" <?php
                                                                                                                                                                if (isset($name)) {
                                                                                                                                                                    echo "value='" . $name . "'";
                                                                                                                                                                }

                                                                                                                                                                ?>>
                                                <?php
                                                if (!empty($errors['name_error'])) {
                                                    echo "<span class='text-danger'>" . $errors["name_error"] . "</span>";
                                                }

                                                ?>
                                                <div class="form-control-position">
                                                    <i class="ft-user"></i>
                                                </div>
                                            </fieldset>
                                            <br>
                                            <fieldset class="form-group position-relative has-icon-left mb-0">
                                                <input type="email" class="form-control form-control-lg input-lg" name='email' id="user-name" placeholder="Your Email" <?php
                                                                                                                                                                        if (isset($email)) {
                                                                                                                                                                            echo "value='" . $email . "'";
                                                                                                                                                                        }

                                                                                                                                                                        ?>>
                                                <?php
                                                if (!empty($errors['email_error'])) {
                                                    echo "<span class='text-danger'>" . $errors["email_error"] . "</span>";
                                                }

                                                ?>
                                                <div class="form-control-position">
                                                    <i class="ft-mail"></i>
                                                </div>
                                            </fieldset>
                                            <br>
                                            <fieldset class="form-group position-relative has-icon-left mb-0">
                                                <input type="text" class="form-control form-control-lg input-lg" name='username' id="user-name" placeholder="Your Username" <?php
                                                                                                                                                                            if (isset($username)) {
                                                                                                                                                                                echo "value='" . $username . "'";
                                                                                                                                                                            }

                                                                                                                                                                            ?>>
                                                <?php
                                                if (!empty($errors['username_error'])) {
                                                    echo "<span class='text-danger'>" . $errors["username_error"] . "</span>";
                                                }
                                                ?>
                                                <div class="form-control-position">
                                                    <i class="ft-user"></i>
                                                </div>
                                            </fieldset>
                                            <br>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="password" name='password' class="form-control form-control-lg input-lg" id="user-password" placeholder="Enter Password">
                                                <?php
                                                if (!empty($errors['password_error'])) {
                                                    echo "<span class='text-danger'>" . $errors["password_error"] . "</span>";
                                                }
                                                ?>
                                                <div class="form-control-position">
                                                    <i class="la la-key"></i>
                                                </div>
                                            </fieldset>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="password" name='password_Con' class="form-control form-control-lg input-lg" id="user-password" placeholder="Confirm Password">
                                                <?php
                                                if (!empty($errors['password_Con_error'])) {
                                                    echo "<span class='text-danger'>" . $errors["password_Con_error"] . "</span>";
                                                }
                                                ?>
                                                <div class="form-control-position">
                                                    <i class="la la-key"></i>
                                                </div>
                                            </fieldset>
                                            <select class="form-control" name="country">
                                                <option value="empty" selected>Country...</option>
                                                <option value="Gaza" <?php
                                                                        if (isset($country)) {
                                                                            if (strcasecmp($country, "Gaza") == 0) {
                                                                                echo "selected";
                                                                            }
                                                                        }

                                                                        ?>>Gaza</option>
                                                <option value="Syria" <?php
                                                                        if (isset($country)) {
                                                                            if (strcasecmp($country, "Syria") == 0) {
                                                                                echo "selected";
                                                                            }
                                                                        }

                                                                        ?>>Soria</option>
                                                <option value="Eygpt">Eygpt</option>
                                            </select>
                                            <?php
                                            if (!empty($errors['country_error'])) {
                                                echo "<span class='text-danger'>" . $errors["country_error"] . "</span>";
                                            }
                                            ?>
                                            <br>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="customRadioInline1" name="gender" class="custom-control-input" value="0">
                                                <label class="custom-control-label" for="customRadioInline1">Male</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="customRadioInline2" name="gender" class="custom-control-input" value="1">
                                                <label class="custom-control-label" for="customRadioInline2">Female</label>
                                            </div>
                                            <br>
                                            <?php
                                            if (!empty($errors['gender_error'])) {
                                                echo "<span class='text-danger'>" . $errors["gender_error"] . "</span>";
                                            }
                                            ?>
                                            <br>
                                            <br>
                                            <button type="submit" class="btn btn-info btn-lg btn-block"><i class="ft-unlock"></i> Sign up</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="">
                                        <p class="float-sm-right text-center m-0">Have an Account? <a href="login.php" class="card-link">log in</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <?php
    include_once "partial/footer.php";
    ?>
</body>

</html>