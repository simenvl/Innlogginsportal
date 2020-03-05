<section class="login">
        <h1>Bruker login</h1>

            <form action="<?php echo htmlspecialchars(
              $_SERVER["PHP_SELF"]
            ); ?>" method="post">
                <div class="form-group">
                    <label for="user_email">E-postadresse</label>
                    <input name="user_email" type="text" class="form-control" id="user_email" placeholder="E-postadresse">
            </div> 
            <div class="form-group">
                <label for="user_password">Passord</label>
                <input name="user_password" type="password" class="form-control" id="user_password" placeholder="Passord">
            </div>
            <div class="form-group">
                <button type="submit" name="loginUser" class="btn btn-primary">Logg inn</button>
                <a href="index.php" class="btn btn-danger">Tilbake</a>
            </div>
            </form>
        </div>
        <div class="loginbtn">
            <a href="registeruser.php">Registrer ny</a>
        </div>
</section>