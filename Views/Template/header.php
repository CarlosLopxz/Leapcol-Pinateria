<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="<?= BASE_URL ?>assets/images/logo/logo-sm.png" type="image/gif" sizes="16x16">
        <title><?= $data['page_tag'] ?></title>
        <meta name="description" content="Sistema de gestión para piñatería">
        <meta name="robots" content="index, follow">
        <!-- bootstrap css link -->
        <link rel="stylesheet" href="<?= BASE_URL ?>lib/bootstrap_5/bootstrap.min.css">
        <!-- Font Awesome CDN -->
        <link rel="stylesheet" href="<?= BASE_URL ?>lib/fontawesome/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/gh/yesiamrocks/cssanimation.io@1.0.3/cssanimation.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
        <!-- main css -->
        <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/global.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
        <!-- responsive css -->
        <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/responsive.css">
    </head>

    <body class="d2c_theme_light">
     

        <div class="d2c_wrapper"><?php include_once "navbar.php"; ?>