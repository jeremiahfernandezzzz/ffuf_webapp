<!-- app/view/layout/main.php -->

<!DOCTYPE html>
<html>
<head>
    <?php $this->section('head'); ?>
    <meta charset="UTF-8"/>
    <meta name="csrf-token" content="<?php echo $_csrfToken; ?>">
    <base href="<?php echo $_baseurl; ?>">
    <title><?php $this->section('title'); ?><?php echo isset($_title)
            ? $_title : 'App-Name'; ?><?php $this->end(); ?></title>
    <?php $this->section('stylesheets'); ?>
    <link rel="stylesheet" href="assets/components/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/components/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/components/iCheck/css/blue.css">
    <link rel="stylesheet" type="text/css" href="assets/css/layout.css"/>
    <?php $this->end(); ?>
    <?php $this->end(); ?>
</head>
<body>
<div id="wrapper">
    <?php $this->section('content'); ?>
    <?= $this->getChildBuffer(); ?>
    <?php $this->end(); ?>
</div>
<?php $this->section('javascripts'); ?>
<script src="assets/components/jquery/jquery.js"></script>
<script src="assets/components/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/components/iCheck/js/icheck.min.js"></script>
<script type="text/javascript" src="assets/js/main.js"></script>

<?php $this->end(); ?>
</body>
</html>