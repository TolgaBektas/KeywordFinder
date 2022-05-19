<?php
session_start();
if (isset($_POST['findKeyword'])) {
    $content = isset($_POST['content']) ? $_POST['content'] : null;
    $content = htmlspecialchars($content);
    if ($content == null) {
        $_SESSION['message'] = 'Fill the content!';
    } else {
        $array = str_replace(',', '', $content);
        $array = str_replace('.', '', $array);
        $array = str_replace('"', '', $array);
        $array = str_replace('“', '', $array);
        $array = str_replace("'", '', $array);
        $array = strtolower($array);

        $array = array_count_values(explode(' ', $array));
        arsort($array);
        $newArray = array();
        foreach ($array as $key => $value) {
            if (empty($key)) {
                continue;
            }
            $newArray[] = array($value, $key);
        }
        if ($newArray[0][0] <= 1) {
            $_SESSION['message'] = 'There is no duplicated word!';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Keyword Finder</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
        </symbol>
        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
        </symbol>
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </symbol>
    </svg>



    <div class="container">
        <?php if (isset($_SESSION['message'])) { ?>
            <div class="alert alert-warning d-flex align-items-center alert-dismissible fade show mt-5" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                    <use xlink:href="#exclamation-triangle-fill" />
                </svg>
                <div>
                    <?php
                    echo $_SESSION['message'];
                    session_destroy();
                    ?>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>
        <div class="card card-primary card-outline mt-5">
            <div class="row">
                <div class="col-md-8">
                    <form method="POST">
                        <div class="card-header">
                            <h3 class="card-title">Keyword Finder</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <textarea class="form-control" name="content" rows="10"><?php echo isset($_POST['content']) ? $_POST['content'] : null; ?></textarea>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="float-right">
                                <button type="submit" class="btn btn-primary" name="findKeyword">Find Keywords</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-4">
                    <div class="card-header">
                        <h3 class="card-title">Found Words</h3>
                    </div>
                    <div class="form-group">
                        <div class="card-body">
                            <ul class="nav flex-column">
                                <?php
                                foreach ($newArray as $value) { ?>
                                    <?php if ($value['0'] >= 2) { ?>
                                        <li class="nav-item"><?php echo $value['1']; ?>
                                            <span class="float-right badge bg-primary"><?php echo $value['0']; ?></span>
                                        </li>
                                <?php
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>