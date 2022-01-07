<?php

interface proto
{
    function conn($url);

    function get();

    function post($body);

    function close();
}


class Http implements proto
{
    const CRLF = "\r\n";

    protected $errno = -1;
    protected $errstr = '';
    protected $response = '';
    protected $url = array();
    protected $fh = null;
    protected $version = 'HTTP/1.1';
    protected $line = array();
    protected $header = array();
    protected $body = array();




    public function __construct($url)
    {
        $this->conn($url);
        $this->setHeader('Host: ' . $this->url['host']);
        // 注意：这边要在 Header 中加上 Connection Close
        // 如果不加，$this->fh 会一直保持连接
        // 此时 feof($this->fh) 会永远为 false
        // request 函数中的 while 会变成死循环，直到 Apache timeout
        $this->setHeader('Connection: Close');
    }

    protected function setLine($method)
    {
        $this->line[0] = $method . ' ' . $this->url['path'] . ' ' . $this->version;
    }
    protected function setHeader($headerline)
    {
        $this->header[] = $headerline;
    }

    protected function setBody($body)
    {

        $this->body[] = http_build_query($body);;
    }

    public function conn($url)
    {
        $this->url = parse_url($url);

        if (!isset($this->url['port'])) {
            $this->url['port'] = 80;
        }

        $this->fh = fsockopen($this->url['host'], $this->url['port'], $this->errno, $this->errstr, 3);
    }

    public function get()
    {
        $this->setLine('GET');
        $this->request();

        return $this->response;
    }

    public function post($body = array())
    {
        $this->setLine('POST');
        $this->setHeader('Content-type: application/x-www-form-urlencoded');
        $this->setBody($body);
        $this->setHeader('Content-length: ' . strlen($this->body[0]));
        $this->request();

        return $this->response;
    }

    public function request()
    {
        $req = array_merge($this->line, $this->header, array(''), $this->body, array(''));

        $req = implode(self::CRLF, $req);

        fwrite($this->fh, $req);

        while (!feof($this->fh)) {
            $this->response .= fread($this->fh, 1024);
        }

        $this->close();
    }

    public function close()
    {
        fclose($this->fh);
    }
}

//$url = "http://www.example.com/";
//$http = new Http($url);
//echo $http->get();


$url = 'http://localhost:5000/api/http-post';
$http = new Http($url);

echo $http->post(array('tit' => 'weikun', 'con' => 'haha', 'submit' => '留言'));