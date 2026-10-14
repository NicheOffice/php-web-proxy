<?php
require(__DIR__ . "/../language.php");
?>
<style type="text/css">

    html body {
        margin-top: 50px !important;
    }

    #top_form {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        box-sizing: border-box;

        margin: 0;
        padding: 0 10px;

        z-index: 2100000000;
        -webkit-user-select: none;
        user-select: none;

        border-bottom: 1px solid #151515;

        background: #FFC8C8;

        height: 45px;
        line-height: normal;
    }

    #top_form form {
        display: flex;
        align-items: center;
        gap: 6px;
        max-width: 800px;
        height: 100%;
        margin: 0 auto;
        padding: 0;
    }

    #top_form input {
        box-sizing: border-box;
        height: 30px;
        margin: 0;
        font: 13px "Helvetica Neue", Helvetica, Arial, sans-serif;
        color: #000;
    }

    #top_form input[name=url] {
        flex: 1 1 auto;
        min-width: 0;
        padding: 5px;
        border: 0 none;
        background: #FFF;
    }

</style>

<div id="top_form">
    <form method="post" action="index.php" target="_top">
        <input type="button" value="<?php echo e($lang["home"]); ?>" onclick="window.location.href='index.php'">
        <input type="text" name="url" value="<?php echo e($url); ?>" autocomplete="off">
        <input type="hidden" name="form" value="1">
        <input type="submit" value="<?php echo e($lang["go"]); ?>">
    </form>
</div>

<script>
    (function () {
        // select the whole URL on first click so it can be replaced quickly
        var input = document.querySelector('#top_form input[name=url]');
        var selected = false;

        input.addEventListener('blur', function () {
            selected = false;
        });

        input.addEventListener('click', function () {
            if (!selected) {
                this.select();
                selected = true;
            }
        });
    })();
</script>
