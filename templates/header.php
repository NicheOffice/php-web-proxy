<?php

use Proxy\Config;

require(__DIR__ . "/../language.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e(Config::get('website-name')); ?></title>
    <meta name="description" content="<?php echo e(Config::get('website-description')); ?>">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🌐</text></svg>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script>
        // follow the visitor's light/dark preference
        document.documentElement.setAttribute('data-bs-theme',
            window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
    </script>
</head>
<body>
<main class="container text-center py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
