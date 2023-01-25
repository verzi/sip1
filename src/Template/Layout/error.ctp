<?php
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Utility\Inflector;


$this->assign('title', 'SIP1 - Servicios API transporte');
?>

<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('poncho/dist/css/roboto-fontface.css') ?>
    <?= $this->Html->css('poncho/dist/css/droid-serif.css') ?>
    <?= $this->Html->css('bootstrap/bootstrap.3.3.7.min.css') ?>
    <?= $this->Html->css('font-awesome-5.6.1/css/all.css') ?>
    <?= $this->Html->css('poncho/dist/css/poncho.css') ?>
    <?= $this->Html->css('argentina.css') ?>
    <?= $this->Html->css('servicios.css') ?>
</head>

<body role="document" class="html front not-logged-in no-sidebars page-node i18n-es">
    <div id="skip-link">
        <a href="#main-content" class="element-invisible element-focusable">Pasar al contenido principal</a>
    </div>
    <header>
        <nav class="navbar navbar-top navbar-default" role="navigation">
            <div class="container">
                <div>
                    <div class="navbar-header">
                        <a class="navbar-brand" href="/">
                            <?= $this->Html->image('baac2020.png', array('height' => '65')) ?>
                            <h1 class="sr-only">SIP1 - API Transporte GCBA
                                <small>SIP1 - API Transporte GCBA</small>
                            </h1>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main role="main">
        <a id="main-content"></a>
        <div class="container"></div>
        <div class="region region-content">
            <div id="block-system-main" class="block block-system clearfix">
            <div class="panel-pane pane-imagen-destacada">
                    <div class="pane-content">
                        <section class="jumbotron">
                            <div class="jumbotron_bar">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <ol class="breadcrumb">
                                                <li>
                                                    <a href="/">Inicio</a>
                                                </li>
                                                <li class="active">API Transporte GCBA</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="jumbotron_body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-xs-12 col-md-8 col-md-offset-2 text-center">
                                            <?= $this->fetch('content') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="overlay"></div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="http://poncheado.herokuapp.com/node_modules/html5shiv/html5shiv.js"></script>
    <script src="http://poncheado.herokuapp.com/node_modules/respond.js/respond.min.js"></script>
    <![endif]-->  

    <?= $this->Html->js('servicios.css') ?>
    <?= $this->Html->js('libs/jquery/3.3.1/jquery.min.js') ?>
    <?= $this->Html->js('libs/bootstrap/3.3.7/bootstrap.min.js') ?>
    <?= $this->Html->js('libs/jquery.quicksearch.min.js') ?>
    <?= $this->Html->js('libs/isotype/3.0.6/isotope.pkgd.min.js') ?>
    <?= $this->Html->js('servicios.js') ?>
</body>
</html>
