<?php
namespace Home\Qiniu;
use Home\Qiniu\Pili\Utils;
use Home\Qiniu\Pili\HttpResponse;
use Home\Qiniu\Pili\HttpRequest;
use Home\Qiniu\Pili\Mac;
use Home\Qiniu\Pili\Config;
use Home\Qiniu\Pili\Transport;
use Home\Qiniu\Pili\Hub;
use Home\Qiniu\Pili\Stream;
use Home\Qiniu\Pili\Client;
$root = dirname(__QINIU__);

require(join(DIRECTORY_SEPARATOR, array('Pili', 'Utils.php')));
require(join(DIRECTORY_SEPARATOR, array('Pili', 'HttpResponse.php')));
require(join(DIRECTORY_SEPARATOR, array('Pili', 'HttpRequest.php')));
require(join(DIRECTORY_SEPARATOR, array('Pili', 'Mac.php')));
require(join(DIRECTORY_SEPARATOR, array('Pili', 'Config.php')));
require(join(DIRECTORY_SEPARATOR, array('Pili', 'Transport.php')));
require(join(DIRECTORY_SEPARATOR, array('Pili', 'Hub.php')));
require(join(DIRECTORY_SEPARATOR, array('Pili', 'Stream.php')));
require(join(DIRECTORY_SEPARATOR, array('Pili', 'Client.php')));
?>
