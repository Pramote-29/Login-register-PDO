<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="sign-in.css">
    <title>Test</title>
</head>

<body>
    <div class="container">
        <?php 
            include("navbar.php");
        ?>
        <main class="form-signin w-100 m-auto">
            <form action="register_db.php" method="post">
                <h1 class="h3 mb-3 fw-normal">Sign Up</h1>
                <?php 
                    if(isset($_SESSION["success"])){ ?>
                <div class="alert alert-success" role="alert">
                    <?php 
                                    echo $_SESSION["success"];
                                    unset($_SESSION["success"]);
                                ?>
                </div>
                <?php }?>

                <?php 
                    if(isset($_SESSION["error"])){ ?>
                <div class="alert alert-danger" role="alert">
                    <?php 
                                    echo $_SESSION["error"];
                                    unset($_SESSION["error"]);
                                ?>
                </div>
                <?php }?>

                <div class="form-floating">
                    <input type="text" class="form-control my-2" name="username" id="userInput"
                        placeholder="Enter your username">
                    <label for="userInput">Username</label>
                </div>

                <div class="form-floating">
                    <input type="email" class="form-control my-2" name="email" id="emailInput"
                        placeholder="name@example.com">
                    <label for="emailInput">Email address</label>
                </div>

                <div class="form-floating">
                    <input type="password" class="form-control my-2" name="password" id="passwordInput"
                        placeholder="Password">
                    <label for="passwordInput">Password</label>
                </div>

                <div class="form-floating">
                    <input type="password" class="form-control my-2" name="c_password" id="confirmPasswordInput"
                        placeholder="Confirm Password">
                    <label for="confirmPasswordInput">Confirm Password</label>
                </div>

                <button class="btn btn-primary w-100 py-2" name="register" type="submit">Sign Up</button>
                <p class="mt-5 mb-3 text-body-secondary">Already have an account? <a href="login.php">Click here</a>to
                    sign-in
                </p>
            </form>
        </main>
        <!-- Footer -->
        <?php 
            include("Footer.php");
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>