<?php

/**
 * @author Mateus Schmitz <matteuschmitz@gmail.com>
 */

require_once("Response.php");

class Server
{
    /**
     * Define o endereço do web server
     */
    const ADDRESS = '127.0.0.1';

    /**
     * Define a porta na qual server será aberto
     */
    const PORT = '8081';

    /**
     * Armazena o socket
     */
    private $socket;

    /**
     * Inicia o servidor web. Responsável por instanciar e gerenciar o socket e suas
     * conexões.
     * 
     * @return void
     */
    public function startServer()
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, 0);
        if(!socket_bind($this->socket, self::ADDRESS, self::PORT)) {
            $this->sendConsoleMessage("Não foi possível iniciar o servidor!");
            die();
        }

        $this->sendConsoleMessage("Aguardando conexão em " . self::ADDRESS . ":" . self::PORT . "...");

        while (1) {
            socket_listen($this->socket);
            $connectionAccepted = socket_accept($this->socket);

            $requestContent = socket_read($connectionAccepted, 1024); // máx 1024 bytes
            $requestExplode = explode("\r\n", $requestContent);
            $this->sendConsoleMessage($requestExplode[0]);

            $file = $this->getFileRequested($requestExplode[0]);
            $response = (new Response($file))->getResponse();
 
            socket_write($connectionAccepted, $response, strlen($response));
            socket_close($connectionAccepted);
        }
    }

    /**
     * Formata e imprime informações de log no terminal
     * 
     * @param  mixed $message mensagem a ser mostrada no console
     * @return void
     */
    private function sendConsoleMessage($message)
    {
        echo "[" . date('Y-m-d H:i:s') . "] " . $message . "\n";
    }

    /**
     * Retorna o endereço do arquivo solicitado pela requisição. Neste ponto, não
     * se sabe se o arquivo solicitado existe ou não
     * 
     * @param  string $stringLine dados da requisição, contendo a URL acessada
     * @return string             arquivo solicitado na requisição.
     */
    private function getFileRequested($stringLine)
    {
        $explodeStringLine = explode(" ", $stringLine);
        $fileRequested = (isset($explodeStringLine[1]))
            ? $explodeStringLine[1]
            : "/";

        return ($fileRequested == '/') 
            ? ROOT_PATH . DS . 'index.html'
            : ROOT_PATH . DS . $fileRequested;
    }
}