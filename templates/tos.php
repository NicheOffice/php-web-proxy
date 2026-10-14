<?php require(__DIR__ . "/header.php"); ?>
<div class="p-4 p-md-5 bg-body-tertiary border rounded-3">
    <h1 class="display-4 fw-semibold"><?php echo e(Proxy\Config::get('website-name')); ?></h1>
    <p class="lead"><?php echo e($lang["slogan"]); ?></p>
    <p><?php echo nl2br(e($lang["tos"])); ?></p>
    <a href="index.php" class="btn btn-primary btn-lg"><?php echo e($lang["back"]); ?></a>
</div>
<?php require(__DIR__ . "/footer.php"); ?>
