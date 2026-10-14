<?php require(__DIR__ . "/header.php"); ?>
<?php if (isset($error_msg)) { ?>
    <div class="alert alert-danger" role="alert">
        <?php echo e($error_msg); ?>
    </div>
<?php } ?>
<div class="p-4 p-md-5 mb-3 bg-body-tertiary border rounded-3">
    <h1 class="display-4 fw-semibold"><?php echo e(Proxy\Config::get('website-name')); ?></h1>
    <p class="lead mb-4"><?php echo e($lang["slogan"]); ?></p>

    <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
        <button type="button" class="btn btn-outline-info" data-url="https://x.com">X (Twitter)</button>
        <button type="button" class="btn btn-outline-danger" data-url="https://www.youtube.com">YouTube</button>
        <button type="button" class="btn btn-outline-primary" data-url="https://www.facebook.com">Facebook</button>
        <button type="button" class="btn btn-outline-secondary" data-url="https://www.wikipedia.org"><?php echo e($lang["wikipedia"]); ?></button>
        <button type="button" class="btn btn-outline-success" data-url="https://www.google.com">Google</button>
    </div>

    <form action="index.php" method="post">
        <div class="input-group input-group-lg">
            <input id="url" name="url" type="text" inputmode="url" class="form-control" autocomplete="url"
                   placeholder="https://" value="<?php echo e(isset($url) ? $url : ''); ?>"
                   aria-label="URL" autofocus required>
            <button class="btn btn-primary" type="submit"><?php echo e($lang["go"]); ?></button>
        </div>
    </form>
</div>
<p class="small text-body-secondary">
    <?php echo e($lang["agree"]); ?> <a href="?tos"><?php echo e($lang["tos_2"]); ?></a>
</p>
<script>
    document.querySelectorAll('[data-url]').forEach(function (button) {
        button.addEventListener('click', function () {
            var input = document.getElementById('url');
            input.value = button.getAttribute('data-url');
            input.focus();
        });
    });
</script>
<?php require(__DIR__ . "/footer.php"); ?>
