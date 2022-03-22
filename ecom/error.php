<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>eCom Error</title>
        <meta http-equiv = "refresh" content = "3; url = index.php" />
        <?php require_once 'components/boot.php'?>
    </head>
    <body>
        <div class="container">  
            <div class="mt-3 mb-3">
                <h1>Invalid Request</h1>
            </div>
            <div class="alert alert-warning" role="alert">
                <p>You've made an invalid request. Please <a href="index.php" class="alert-link">go back</a> to index and try again.</p>
                <p>You will be redirected in 3 seconds.</p>
            </div>
        </div>
    </body>
</html>