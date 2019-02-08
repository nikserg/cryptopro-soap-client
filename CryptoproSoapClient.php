<?php
/**
 * Created by PhpStorm.
 * User: n.zarubin
 * Date: 08.02.2019
 * Time: 13:28
 */

namespace nikserg\cryptoproSoapClient;

class CryptoproSoapClient
{
    private $wsdl;
    private $curlExec;
    /**
     * @var \SoapClient
     */
    private $soapClient;

    public function __construct($wsdl, $curlExec = '/opt/cprocsp/bin/amd64/curl')
    {
        $this->curlExec = $curlExec;
        $this->wsdl = $this->cryptcpCall($wsdl);
        $file = tempnam(sys_get_temp_dir(), 'soap');
        file_put_contents($file, $this->wsdl);
        $this->soapClient = new \SoapClient($file);
        unlink($file);
    }

    public function __call($name, $arguments)
    {
        $endpoint = $this->getEndpoint($name);
        print_r($name);
        // TODO: Implement __call() method.
    }

    public function getFunctions()
    {
        return $this->soapClient->__getFunctions();
    }

    public function getTypes()
    {
        return $this->soapClient->__getTypes();
    }

    private function getEndpoint($action)
    {
        $xml = simplexml_load_string($this->wsdl);
        print_r($xml->children('wsdl'));exit;
    }

    private function soapCall($action, $params)
    {

    }
    /**
     * @param      $url
     * @param null $data
     * @param null $header
     * @param null $cert
     * @return string
     * @throws \Exception
     */
    private function cryptcpCall($url, $data = null, $header = null, $cert = null)
    {
        $shellCommand = $this->curlExec .
            ' -k -s ' . $url .
            ' --header "Content-Type: text/xml; charset=\"UTF-8\"" ';
        if ($header) {
            $shellCommand .= '--header "' . $header . '" ';
        }
        if ($cert) {
            $shellCommand .= '--cert ' . $cert . ' ';
        }
        if ($data) {
            $shellCommand .= '--data \'' . $data . '\'';
        }
        $result = shell_exec($shellCommand);
        if (!$result) {
            throw new \Exception('No response for command ' . $shellCommand, 500);
        }
        return $result;

    }

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