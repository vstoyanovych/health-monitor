<?php /* Smarty version 2.6.26, created on 2025-11-07 20:32:49
         compiled from page_header.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'page_header.tpl', 50, false),)), $this); ?>
<!DOCTYPE html>
<html lang="en"><head><?php echo $this->_tpl_vars['special']['document']['headstart']; ?>
<?php echo $this->_tpl_vars['special']['document']['headdef']; ?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="robots" content="noindex">

    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900' rel='stylesheet' type='text/css'>
    
    <!-- Vendor styles -->
    <link rel="stylesheet" href="themes/<?php echo $this->_tpl_vars['special']['theme']; ?>
/styles/css/regular.css"/>
    <link rel="stylesheet" href="themes/<?php echo $this->_tpl_vars['special']['theme']; ?>
/styles/css/solid.css"/>
    <link rel="stylesheet" href="themes/<?php echo $this->_tpl_vars['special']['theme']; ?>
/styles/css/fontawesome.min.css"/>
    <link rel="stylesheet" href="themes/<?php echo $this->_tpl_vars['special']['theme']; ?>
/vendor/fontawesome/css/font-awesome.css"/>
    <link rel="stylesheet" href="themes/<?php echo $this->_tpl_vars['special']['theme']; ?>
/vendor/animate.css/animate.css"/>
    <link rel="stylesheet" href="themes/<?php echo $this->_tpl_vars['special']['theme']; ?>
/vendor/bootstrap/css/bootstrap.css"/>
    <link rel="stylesheet" href="themes/<?php echo $this->_tpl_vars['special']['theme']; ?>
/vendor/toastr/toastr.min.css"/>
    <link type="text/css" href="themes/<?php echo $this->_tpl_vars['special']['theme']; ?>
/assets/js/required/jquery-ui-1.11.0.custom/jquery-ui.min.css" rel="stylesheet" />
    <link type="text/css" href="themes/<?php echo $this->_tpl_vars['special']['theme']; ?>
/assets/js/required/jquery-ui-1.11.0.custom/jquery-ui.structure.min.css" rel="stylesheet" />
    <link type="text/css" href="themes/<?php echo $this->_tpl_vars['special']['theme']; ?>
/assets/js/required/jquery-ui-1.11.0.custom/jquery-ui.theme.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="themes/<?php echo $this->_tpl_vars['special']['theme']; ?>
/styles/selectize.bootstrap3.css"/>
    <!-- App styles -->
    <link rel="stylesheet" href="themes/<?php echo $this->_tpl_vars['special']['theme']; ?>
/styles/pe-icons/pe-icon-7-stroke.css"/>
    <link rel="stylesheet" href="themes/<?php echo $this->_tpl_vars['special']['theme']; ?>
/styles/pe-icons/helper.css"/>
    <link rel="stylesheet" href="themes/<?php echo $this->_tpl_vars['special']['theme']; ?>
/styles/stroke-icons/style.css"/>
    <link rel="stylesheet" href="themes/<?php echo $this->_tpl_vars['special']['theme']; ?>
/styles/style.css">
    <script type="text/javascript" src="themes/<?php echo $this->_tpl_vars['_settings']['default_theme']; ?>
/scripts/sharing.js"></script>
    <script src="themes/<?php echo $this->_tpl_vars['special']['theme']; ?>
/vendor/jquery/dist/jquery.min.js"></script>

	<script type="text/javascript" src="themes/<?php echo $this->_tpl_vars['special']['theme']; ?>
/script.js"></script>
    <link type="text/css" href="themes/<?php echo $this->_tpl_vars['special']['theme']; ?>
/vendor/niceselect/css/nice-select.css" rel="stylesheet">
	<link type="text/css" href="themes/<?php echo $this->_tpl_vars['special']['theme']; ?>
/stylesheets.css" rel="stylesheet">
	<link type="text/css" href="themes/<?php echo $this->_tpl_vars['special']['theme']; ?>
/styles.css" rel="stylesheet">
    <link type="text/css" href="themes/<?php echo $this->_tpl_vars['special']['theme']; ?>
/scripts/confirm-box.css" rel="stylesheet">
    <link type="text/css" href="themes/default/notifications.css" rel="stylesheet">
    <link rel="stylesheet" href="themes/current/vendor/datetimepicker/bootstrap-datetimepicker.css"/>

    <?php if ($this->_tpl_vars['userinfo']['level'] != 0): ?>
        <link rel="stylesheet" href="themes/<?php echo $this->_tpl_vars['special']['theme']; ?>
/aiassistant.css"/>
    <?php endif; ?>

<?php echo $this->_tpl_vars['_settings']['meta_header_text']; ?>

<?php echo $this->_tpl_vars['special']['document']['headend']; ?>
</head>
<?php echo smarty_function_config_load(array('file' => "main.cfg"), $this);?>

<body <?php if ($this->_tpl_vars['special']['body_onload'] != ""): ?> onload="<?php echo $this->_tpl_vars['special']['body_onload']; ?>
"<?php endif; ?><?php echo $this->_tpl_vars['special']['document']['bodymodifier']; ?>
 class="<?php if ($this->_tpl_vars['sm']['s']['body_class'] != ""): ?><?php echo $this->_tpl_vars['sm']['s']['body_class']; ?>
<?php endif; ?> <?php if ($this->_tpl_vars['userinfo']['level'] == 0): ?>signwrapper<?php endif; ?>"><?php echo $this->_tpl_vars['special']['document']['bodystart']; ?>

<?php if ($this->_tpl_vars['_settings']['header_static_text'] != ""): ?><?php echo $this->_tpl_vars['_settings']['header_static_text']; ?>
<?php endif; ?>
