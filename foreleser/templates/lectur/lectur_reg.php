<div class="container mt-5">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="lectur_fname">Fornavn</label>
            <input name="lectur_fname" type="text" class="form-control" id="lectur_fname" placeholder="Fornavn">
        </div>
        <div class="form-group">
            <label for="lectur_lname">Etternavn</label>
            <input name="lectur_lname" type="text" class="form-control" id="lectur_lname" placeholder="Etternavn">
        </div>
        <div class="form-group">
            <label for="lectur_email">E-postadresse</label>
            <input name="lectur_email" type="email" class="form-control" id="lectur_email" placeholder="E-postadresse">
        </div>
        <div class="form-group">
            <label for="lectur_password">Passord</label>
            <input name="lectur_password" type="password" class="form-control" id="lectur_password" placeholder="Passord">
        </div>
        <div class="form-group">
            <label for="lectur_img">Bilde (JPG/PNG, maks. størrelse 2MB)</label><br />
            <input name="lectur_img" type="file" id="lectur_img">
        </div>
        <button type="submit" name="registerLecturer" class="btn btn-primary">Registrer</button>
        <a href="index.php" class="btn btn-danger">Tilbake</a>
    </form>
</div>
