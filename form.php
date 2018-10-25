/**
 * Created by PhpStorm.
 * User: amadrocky
 * Date: 15/10/18
 * Time: 11:20
 */

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="style.css" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Upload</title>
</head>

<body>

    <div class="container">

        <?php

        if (!empty($_FILES) && ($_FILES['fichier']['error'] == 0)){

            $error = [];

            $filename = $_FILES['fichier']['name'];

            // taille maximum (en octets)
            if($_FILES['fichier']['size'] > 1000000){
                $error = ['Le fichier est trop lourd.'];
            }

            //On fait un tableau contenant les extensions autorisées.
            //On ne prend que des extensions d'images.
            $extensions = array('.png', '.gif', '.jpg',);

            //On récupère l'extension, par exemple "pdf".
            $extension = strrchr($filename, ".");

            //Ensuite on teste
            if(!in_array($extension, $extensions)){ //Si l'extension n'est pas dans le tableau
                $error = ['Vous devez uploader un fichier de type png, gif, jpg.'];
            } else {
                //On concatène le nom de fichier unique avec l'extension récupérée
                $filename = 'image' .uniqid() .$extension;
            }

            $uploadDir = '../upload/img/' .$filename;

            $file_tmp_name = $_FILES['fichier']['tmp_name'];

            if (empty($error)){
                //On déplace le fichier temporaire vers le nouvel emplacement sur le serveur.
                if(move_uploaded_file($file_tmp_name, $uploadDir)){ //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
                    echo 'Upload effectué avec succès !';
                } else { //Sinon (la fonction renvoie FALSE).
                    $error = ['Echec de l\'upload !'];
                    echo $error;
                }
            }
        }

        ?>


        <h1>Send your file</h1>

        <form method="POST" enctype="multipart/form-data">

            <input type="file" name="fichier" multiple="multiple" />

            <button type="submit" class="btn btn-primary">Submit</button>

        </form>

        <ul>
            <?php

            $it = new FilesystemIterator ('../upload/img/');

            foreach ($it as $fileinfo) { ?>
                <li>
                    <form method="post" action="form.php">
                        <?php echo $it . "<br/>"; ?>
                        <img src="img/<?= $it ?>" >
                        <button type="submit" class="btn btn-danger" value="<?php echo $it ?>" name="delete">Delete</button>
                    </form>
                </li>
            <?php } ?>
        </ul>

        <?php

        if (isset($_POST['delete'])) {
            $fileDel = 'img/' . $_POST['delete'];
            unlink($fileDel);
            header("location: form.php");
        }


        ?>

    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>

</html>



