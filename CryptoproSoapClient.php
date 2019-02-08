<?php
/**
 * Created by PhpStorm.
 * User: n.zarubin
 * Date: 08.02.2019
 * Time: 13:28
 */

namespace nikserg\cryptoproSoapClient;
class CryptoproSoapClient {

    public function get($url)
    {
        $shellCommand = self::getCurlExec() .
            ' -k -s https://' . self::getSoapGatewayHTTPS() . '/RA/RegAuthLegacyService.svc ' .
            '--header "Content-Type: text/xml; charset=\"UTF-8\"" ' .
            '--header "SOAPAction: \"http://cryptopro.ru/pki/registration/service/2010/03/RegAuthLegacyContract/' . $action . '\"" ' .
            '--cert ' . self::getCertificate() . ' ' .
            '--data \'' . $xml . '\'';
    }
}