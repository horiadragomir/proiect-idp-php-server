<?php

// Initialize the session
if(!isset($_SESSION)) {
    session_start(); 
}

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin_adm"]) && $_SESSION["loggedin_adm"] === true){
    header("location: home.php");
    exit;
}

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Introduceti utilizatorul.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Introduceti parola.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        $url = 'http://admin-server:20001/login?';
        $data = array('username' => $username);

        $response = file_get_contents($url . http_build_query($data));

        $result = json_decode($response)->status;

        // Check if username exists, if yes then verify password
        if(count($result) == 1) {
            $hashed_password = $result[0][0];
            if(password_verify($password, $hashed_password)){
                // Password is correct, so start a new session
                if(!isset($_SESSION)) {
                    session_start(); 
                } 
                            
                // Store data in session variables
                $_SESSION["loggedin_adm"] = true;
                $_SESSION["firstname_adm"] = $result[0][1];
                $_SESSION["lastname_adm"] = $result[0][2];                
                            
                // Redirect user to welcome page
                header("location: home.php");
            } else{
                // Display an error message if password is not valid
                $password_err = "Parola introdusa nu este corecta.";
            }
        } else{
            // Display an error message if username doesn't exist
            $username_err = "Administratorul nu exista in baza de date.";
        }
    }
}
?>

<?php require "templates/header.php"; ?>

<!DOCTYPE html>
<html lang="en">
<body>
    <div class="wrapper">
        <h2>Conectare</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <p><div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Utilizator</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div></p>    
            <p><div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Parola</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div></p>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
        </form>
    </div>
</body>
</html>

<?php require "templates/footer.php"; ?>
