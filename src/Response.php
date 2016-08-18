<?php

/**
 * @author Mateus Schmitz <matteuschmitz@gmail.com>
 */

class Response
{
    /**
     * Armazena o endereço do arquivo solicitado na requisição
     * @var string
     */
    private $file;

    /**
     * Armazena os cabeçalhos de resposta
     * @var string
     */
    private $header = "";

    /**
     * Armazena o corpo da resposta
     * @var string
     */
    private $body = "";

    /**
     * Armazena a versão do protocolo HTTP utilizada no server
     * @var string
     */
    private $httpVersion = "HTTP/1.1";

    /**
     * Armazena o código de resposta do server. Default: 200
     * @var string
     */
    private $code = "200 OK";

    /**
     * Armazena o nome e a versão do server
     * @var string
     */
    private $server = "Server Maroto/XPC4000 - v2.8";

    /**
     * Armazena o comportamento da requisição após o envio da resposta
     * @var string
     */
    private $connection = "Close";

    /**
     * Construtor da classe. Recebe o arquivo solicitado na requisição, verifica 
     * se o mesmo existe. Caso não exista, muda o arquivo para o de erro 404.
     * Monta o header e o corpo da resposta .
     * 
     * @param string $file arquivo solicitado na requisição
     */
    public function __construct($file)
    {
        if (!is_readable($file)) {
            $this->code = "404 Not Found";
            $file = ROOT_PATH . DS . 'errors' . DS . '404.html';
        }

        $this->file = $file;

        $this->header .= $this->httpVersion . " " . $this->code . "\r\n";
        $this->header .= "Date: " . date('r e') . "\r\n";
        $this->header .= "Server: " . $this->server . "\r\n";
        $this->header .= "Connection: " . $this->connection . "\r\n";
        $this->header .= "Content-Type: " . mime_content_type($file) . "; charset=UTF-8\r\n";
        $this->header .= "Content-Length: " . filesize($file);
        
        $this->body = file_get_contents($file);
    }

    /**
     * Concatena header e body e o retorna
     * @return string reposta completa para ser enviada ao navegador
     */
    public function getResponse()
    {
        return $this->header . "\r\n\r\n" . $this->body;
    }
}