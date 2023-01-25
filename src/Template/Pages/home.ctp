<?php
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Utility\Inflector;


$this->assign('title', 'Servicios');
?>

<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios API - Ministerio de Justicia y Derechos Humanos | Presidencia de la Nación</title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>
</head>
<body class="home">
    <header>
        <div class="header-image">
            <?= $this->Html->image('http://datos.jus.gob.ar/img/jus_logo_1.svg') ?>
            <h1>API pública de Servicios</h1>
        </div>
    </header>

    <div id="content">
                <div class="row">
            <div class="columns large-12">
                <h3 class="">Introducción</h3>
                <p>
                    Para facilitar el acceso a información interna proporcionada por los sistemas del <strong>Ministerio de Justicia y Derechos Humanos de la Nación</strong>, se ha desarrollado concentrador de servicios REST para su consumo. Estos servicios se alinean a los <a href="https://github.com/argob/estandares/blob/master/estandares-apis.md" target="_blank">estándares</a> especificados por la <strong>Dirección Nacional de Servicios Digitales</strong> del <strong>Ministerio de Modernización</strong>.
                </p>

                <?php
                    $dir = new Folder(ROOT . DS . 'plugins');
                    $dirs = $dir->read();
                    $dirs = (!empty($dirs) && isset($dirs[0]) ) ? $dirs[0] : $dirs;
                    
                    if ( $dirs ){
                ?>
                <h3>Servicios</h3>
                <ul>
                <?php foreach ($dirs as $key => $value) { ?>
                    <li><strong><?php echo strtoupper(Inflector::humanize(Inflector::underscore($value))); ?></strong> (<a href="/webroot/api/docs/<?php echo Inflector::dasherize($value); ?>/index.html">documentación</a>)</li>
                <?php } ?>
                </ul>
                <?php } ?>
            </div>
        </div>
    </div>

    <footer>
        <div class="footer-content">
            <p>Ministerio de Justicia y Derechos Humanos de la Nación</p>
        </div>
    </footer>
</body>
</html>
