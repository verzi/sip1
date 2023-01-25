<?php
/**
 * CakePHP(tm) :  Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakefoundation.org CakePHP(tm) Project
 * @since         1.3.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Log\Engine;

use Cake\Core\Configure;
use Cake\Utility\Text;
use Cake\Log\Engine\FileLog;

/**
 * File Storage stream for Logging. Writes logs to different files
 * based on the level of log it is.
 */
class SsoLog extends FileLog
{
    /**
     * Sets protected properties based on config provided
     *
     * @param array $config Configuration array
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    /**
     * Implements writing to log files.
     *
     * @param string $level The severity level of the message being written.
     *    See Cake\Log\Log::$_levels for list of possible levels.
     * @param string $message The message you want to log.
     * @param array $context Additional information about the logged message
     * @return bool success of write.
     */
    public function log($level, $message, array $context = [])
    {
        if ( Configure::check('Sso.debug') && (bool) Configure::read('Sso.debug') === true ){
            return parent::log($level, $message, $context);
        }

        return true;
    }
}
