<?php

if (!defined('MJDH_ENVIRONMENT_LOCAL')) {
    define('MJDH_ENVIRONMENT_LOCAL', 'local');
}

if (!defined('MJDH_ENVIRONMENT_DEVELOPMENT')) {
    define('MJDH_ENVIRONMENT_DEVELOPMENT', 'development');
}

if (!defined('MJDH_ENVIRONMENT_TESTING')) {
    define('MJDH_ENVIRONMENT_TESTING', 'testing');
}

if (!defined('MJDH_ENVIRONMENT_HOMOLOGATION')) {
    define('MJDH_ENVIRONMENT_HOMOLOGATION', 'homologation');
}

if (!defined('MJDH_ENVIRONMENT_PRODUCTION')) {
    define('MJDH_ENVIRONMENT_PRODUCTION', 'production');
}

if (!defined('MJDH_API_STANDARDS_MOCKED')) {
    define('MJDH_API_STANDARDS_MOCKED', 'mock');
}
/**
 * Proxy local sería la misma configuración que tienen los navegadores
 */
if (!defined('MJDH_PROXY_LOCAL')) {
    define('MJDH_PROXY_LOCAL', 'TBD');
}

/**
 * Proxy server es el utilizado por lo ambientes de tipo servidor (desarrollo, homologación, producción, etc)
 */
if (!defined('MJDH_PROXY_SERVER')) {
    define('MJDH_PROXY_SERVER', 'TBD');
}

if (!defined('GCBA_API_TRANSPORTE_CLIENT_ID')) {
    define('GCBA_API_TRANSPORTE_CLIENT_ID', '5a8fb2b41ef84544ac9f253b0d2aa1a5');
}

if (!defined('GCBA_API_TRANSPORTE_CLIENT_SECRET')) {
    define('GCBA_API_TRANSPORTE_CLIENT_SECRET', '4a94e1f29c60494092c7dEC1D8d2d02A');
}
