<?php

class Server
{
    const ADDRESS = '127.0.0.1';

    const PORT = '8081';

    private $socket;

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
            
            $file = $this->getFileRequested($requestExplode[0]);


            // echo "<pre>" . print_r($requestExplode, 1);
            // echo "<pre>" . print_r($requestExplode[0], 1);

    // $incoming = array();
    // $incoming = explode("\r\n", $input);

    // $fetchArray = array();
    // $fetchArray = explode(" ", $incoming[0]);

    // $file = $fetchArray[1];
    // if($file == "/"){ 

    //     $file = "index.html"; 

    // } else {

    //     $filearray = array();
    //     $filearray = explode("/", $file);
    //     $file = $filearray[1];
    // }

    // echo $fetchArray[0] . " Request " . $file . "\n"; 

    // $output = "";
    // $header = "HTTP/1.1 200 OK \r\n";
    // $header .= "Date: Wed, 17 Aug 2016 23:59:59 GMT \r\n";
    // $header .= "Content-Type: text/html \r\n\r\n";

    // $content = file_get_contents("www" . DIRECTORY_SEPARATOR . $file);
    // $output = $header . $content;

    // socket_write($client,$output,strlen($output));
    // socket_close($client);



        }
    }

    private function sendConsoleMessage($message)
    {
        echo "[" . date('Y-m-d H:i:s') . "] " . $message . "\n";
    }

    private function getFileRequested($stringLine)
    {
        // echo "<pre>" . print_r($stringLine, 1);
    }
}