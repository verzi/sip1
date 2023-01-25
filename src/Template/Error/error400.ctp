<?php
use Cake\Core\Configure;
use Cake\Error\Debugger;

if ( $_mustBeJSONResponse ){
    echo $this->element('api_error_response', [
            'status' => isset($code) ? $code : 400,
            'developerMessage' => isset($message) ? $message : 'Error 4XX',
            'userMessage' => isset($message) ? $message : 'Error 4XX',
            'errorCode' => isset($code) ? $code : 400,
            'moreInfo' => ''
        ]
    );
}else{
    $this->layout = 'error';

    if (Configure::read('debug')):
        $this->layout = 'dev_error';

        $this->assign('title', $message);
        $this->assign('templateName', 'error400.ctp');

        $this->start('file');
    ?>
    <?php if (!empty($error->queryString)) : ?>
        <p class="notice">
            <strong>SQL Query: </strong>
            <?= h($error->queryString) ?>
        </p>
    <?php endif; ?>
    <?php if (!empty($error->params)) : ?>
            <strong>SQL Query Params: </strong>
            <?php Debugger::dump($error->params) ?>
    <?php endif; ?>
    <?= $this->element('auto_table_warning') ?>
    <?php
        if (extension_loaded('xdebug')):
            xdebug_print_function_stack();
        endif;

        $this->end();
    endif;
    ?>
    <div class="row">
        <div class="columns large-12">
            <h3 class=""><?= h($message) ?></h3>
            <p>
                <strong><?= __d('cake', 'Error') ?>:</strong> <?= sprintf(
    __d('cake', '%s no fue encontrada en el servidor'),
    "<strong>'{$url}'</strong>"
    ) ?>.
            </p>
        </div>
    </div>
<?php } ?>