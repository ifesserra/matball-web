<?php
$ROOT = dirname(__DIR__, 2);
require_once "$ROOT/processes/RestrictedSession.class.php";
    
if(!RestrictedSession::isLogged()){
    header("Location: http://" . $_SERVER['HTTP_HOST'] . '/matball-web');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>MatBall</title>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'>
    <meta name="author" content="matball">
    
    <link rel="icon" href="../../assets/img/favicon.png">
    
    <link href="../../assets/external/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../assets/external/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../assets/external/remodal/remodal.css" rel="stylesheet" type="text/css"/>
    <link href="../../assets/external/remodal/remodal-default-theme.css" rel="stylesheet" type="text/css"/>
    
    <script src="../../assets/external/jquery/jquery.min.js" type="text/javascript"></script>
    <script src="../../assets/external/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    
    <link href="../../assets/css/page-default.css" rel="stylesheet" type="text/css"/>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <link href="../../assets/css/styles.css" rel="stylesheet" type="text/css"/>
</head>
