<?php
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Utility\Inflector;
use Cake\Core\Configure;
?>
<!DOCTYPE html>
<!--[if IEMobile 7 ]> <html lang="es"class="iem7"> <![endif]-->
<!--[if lt IE 7 ]> <html lang="es" class="ie6 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7 ]>    <html lang="es" class="ie7 lt-ie8"> <![endif]-->
<!--[if IE 8 ]>    <html lang="es" class="ie8"> <![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html lang="es"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SIP1 - Servicios API transporte</title>
	<meta name="description" content="Para facilitar el acceso a información interna proporcionada por los sistemas del Gobierno de la Ciudad de Buenos Aires, se ha desarrollado un concentrador de servicios REST para su consumo.">
	<meta name="author" content="Gobierno de la Ciudad de Buenos Aires">
	<link rel="shortcut icon" href="/favicon.ico">

	<!-- Nav and address bar color -->
	<meta name="theme-color" content="#0072b8">
	<meta name="msapplication-navbutton-color" content="#0072b8">
	<meta name="apple-mobile-web-app-status-bar-style" content="#0072b8">
    <meta property="og:site_name" content=""/>
	<meta property="og:url" content="http://verzi.com.ar" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="SIP1 - API Transporte GCBA" />
	<meta property="og:description" content="Para facilitar el acceso a información interna proporcionada por los sistemas del Gobierno de la Ciudad de Buenos Aires, se ha desarrollado un concentrador de servicios REST para su consumo." />
	<meta property="og:image" content="img/baac2020.png" />
	<meta property="og:locale" content="es_AR" />

	<meta name="twitter:card" content="summary" />
	<meta name="twitter:title" content="SIP1 - API Transporte GCBA" />
	<meta name="twitter:description" content="Para facilitar el acceso a información interna proporcionada por los sistemas del Gobierno de la Ciudad de Buenos Aires, se ha desarrollado un concentrador de servicios REST para su consumo." />
	<meta name="twitter:image" content="img/baac2020.png" />

    <link href="css/poncho/dist/css/roboto-fontface.css" rel="stylesheet">
    <link href="css/poncho/dist/css/droid-serif.css" rel="stylesheet">
    <link href="css/bootstrap/bootstrap.3.3.7.min.css" rel="stylesheet">
    <link href="css/font-awesome-5.6.1/css/all.css" rel="stylesheet">
    <link href="css/poncho/dist/css/poncho.css" rel="stylesheet">
    <link href="css/argentina.css" rel="stylesheet">
    <link href="css/servicios.css" rel="stylesheet">
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
                            <img src="img/baac2020.png" alt="Inicio" height="65" />
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
                        <section class="jumbotron" style="background-image: url(img/servicios/justicia_3_0.jpg);">
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
                                            <h1>API Transporte GCBA</h1>
                                            <p>
                                                <p>Para facilitar el acceso a información interna proporcionada por el Gobierno de la Ciudad de Buenos Aires, se ha desarrollado un concentrador de servicios REST para su consumo.</p>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="overlay"></div>
                        </section>
                    </div>
                </div>
                <section>
                    <div class="container">
                        <div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h2 class="text-center">¿Qué servicio estás buscando?</h2>
                                </div>
                            </div>
                            <div class="row">
                                <div id="buscador" class="col-md-8 col-md-offset-2">
                                    <div>
                                        <div style="display:none;">
                                            <div class="form-item form-item-tarro-de-miel form-type-textfield form-group">
                                                <label class="control-label" for="edit-tarro-de-miel">Dejar en blanco </label>
                                                <input class="form-control form-text" type="text" id="edit-tarro-de-miel" name="tarro_de_miel" value="" size="60" maxlength="128" />
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <input placeholder="Ingresá alguna palabra referida al servicio..." class="quicksearch form-control form-text" type="text" id="edit-keys" name="keys" value="" size="20" maxlength="255" />
                                            <span class="input-group-btn">
                                                <button class="btn-primary btn form-submit" type="submit" id="edit-submit" name="op" value="&lt;i class=&quot;fa fa-search&quot;&gt;&lt;/i&gt;">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-separator"></div>
                            <div class="panel-pane pane-texto">
                                <div class="pane-content">
                                    <div class="">
                                        <section class="m-y-0 p-y-1">
                                            <div class="">
                                                <h2>Servicios</h2>
                                                <div class="row panels-row m-t-2">
                                                    <div class="col-xs-12 col-sm-12 col-md-12 quicksearch-no-results" style="display:none;">
                                                        <p class="lead">No hay resultados para su búsqueda.</p>
                                                    </div>
                                                    <?php 
                                                        $f = new File(APP . DS . 'servicios.json');
                                                        $content = $f->read();
                                                        $f->close();
                                                        $services = json_decode($content);
                                                        if (is_array($services)){
                                                            $env = Configure::read('App.environment');
                                                            foreach ($services as $key => $service) { 
                                                                if ( !property_exists($service->environments, $env) ){
                                                                    continue;
                                                                }
                                                                if ( !property_exists($service->environments->{$env}, 'enabled') ){
                                                                    continue;
                                                                }
                                                                if ( $service->environments->{$env}->enabled === false ){
                                                                    continue;
                                                                }
                                                    ?>
                                                            <div class="col-xs-12 col-sm-6 col-md-4 service-item">
                                                                <a class="panel panel-default" target="_blank" href="<?php echo (isset($service->environments->{$env}->documentationUrl) && !empty($service->environments->{$env}->documentationUrl)) ? $service->environments->{$env}->documentationUrl : "#"; ?>">
                                                                    <div class="panel-body">
                                                                        <div class="media">
                                                                            <div class="media-left" style="padding:15px 15px 0px 0px">
                                                                                <i class="fa <?php echo (isset($service->fontAwesomeIcon) && $service->fontAwesomeIcon) ? $service->fontAwesomeIcon : "fa-database fa-fw fa-2x"; ?> text-primary"></i>
                                                                            </div>
                                                                            <div class="media-body">
                                                                                <h3><?php echo $service->name;?></h3>
                                                                                <p><?php echo $service->description; ?></p>
                                                                            </div>
                                                                            <div class="hidden service-item-tags"><?php echo isset($service->tags)?$service->tags : "";?></div>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                    <?php 
                                                            }
                                                        }
                                                     ?>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>
    <footer class="main-footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <section class="block block-block clearfix">
                        <img class="image-responsive" src="img/baac2020.png" alt="Gobierno de la Ciudad de Buenos Aires" />
                    </section>
                </div>
            </div>
        </div>
    </footer>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="http://poncheado.herokuapp.com/node_modules/html5shiv/html5shiv.js"></script>
    <script src="http://poncheado.herokuapp.com/node_modules/respond.js/respond.min.js"></script>
    <![endif]-->  


    <script src="js/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="js/libs/bootstrap/3.3.7/bootstrap.min.js"></script>
    <script src="js/libs/jquery.quicksearch.min.js"></script>
    <script src="js/libs/isotype/3.0.6/isotope.pkgd.min.js"></script>
    <script src="js/servicios.js"></script>
</body>
</html>
