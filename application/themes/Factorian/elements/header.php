<!DOCTYPE html>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Factorian</title>
		<script type="text/javascript" src="<?php echo $view->getThemePath();?>/js/jquery-3.1.1.min.js"></script>
        <link href="<?php echo $view->getThemePath();?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <script src="<?php echo $view->getThemePath();?>/bootstrap/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo $view->getThemePath();?>/css/style.css">
        <?php Loader::element('header_required');?>
    </head>
    
<body id="black">
    <div class="container" id="white">
    
    <header>
        <div class="row">
            <div class="col-md-12">
                <nav class="navbar navbar">
                    <div class="col-md-2">
                        <img src="<?php echo $view->getThemePath();?>/Images/logofacto.png">
                    </div>
                    <div class="col-md-10">                 
                            <?php
                                $a = new GlobalArea('Menu');
                                $a->display($c);
                            ?>                
                    </div>
                </nav>
            </div>
        </div>
    </header>
