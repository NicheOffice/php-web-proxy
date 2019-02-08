<?php
require(__DIR__ . "/../language.php");
require(__DIR__ . "/../config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $config['website-name']; ?></title>
    <meta charset="utf-8">
    <meta name="description" content="<?php echo $config["website-description"]; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="http://www.iconarchive.com/download/i31446/studiomx/leomx/Web.ico"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
</head>
<body>
<div class="container text-center" style="margin-top:5%;">
    <div class="row">
        <div class="col-md-12">
            <div class="jumbotron">
                <h1 class="display-3"><?php echo $config['website-name']; ?></h1>
                <p class="lead"><?php echo $lang["slogan"]; ?></p>
                <p><?php echo $lang["tos"]; ?></p>
                <a href="<?php echo $config['website-url']; ?>"
                   class="btn btn-primary btn-lg"><?php echo $lang["back"]; ?></a>
            </div>
        </div>
    </div>
</div>
</body>
</html>