<?php
/*
===============================================
Fonte: IndexController.php
Descrição: Responsável por tratar as requisições
Data: 07/09/2024
Programador(a): Ighor Drummond
===============================================
*/
    /*
    Namespace: Controls
    Descrição: Agrupa classes do Controller
    Data: 07/09/2024
    Programador(a): Ighor Drummond.
    */
    namespace App\Controls{
        session_start();
        //Bibliotecas
        use FM\Controller\Action;//Aciona a classe Action para devidas ações do controller
        use App\Models\ExecuteRequest;//Responsável por tratar as requisições

        /*
         * Classe: IndexController
         * Descrição: Responsável por realizar operações do Controller
         * Data: 07/09/2024
         * Extends: Action
         * Programador(a): Ighor Drummond
         */
        class IndexController extends Action{
            //Constantes
            const API_ACTIVE = true;//Valida se api está ativa
            const API_MAINTENANCE = false;//Valida se está em manutenção
            const API_VERSION = '1.0.0';//Versão da API
            const API_URL = 'http://localhost:7777/';//URL da API
            /*
            * Método: status
            * Descrição: Retorna Status da API
            * Data: 07/09/2024
            * Programador(a): Ighor Drummond
            */
            public function status():void
            {
                $this->startRequest();//Inicia Requisição
                $this->logGeneration('STATUS OK');
                echo  $this->Request->getJson();
            }
            /*
            * Método: getTask()
            * Descrição: Retorna as tarefas existentes
            * Data: 07/09/2024
            * Programador(a): Ighor Drummond
            */
            public function getTask():void
            {
                $this->startRequest();//Inicia Requisição
                
                //Valida requisição
                if($_SERVER['REQUEST_METHOD'] === 'GET'){
                    //Retorna task
                    $this->Request->getTask( isset($_GET['name']) ? $_GET['name'] : '' );
                    //Imprime Log
                    $this->logGeneration('SUCCESS - METHOD geTask() COMPLETED ' .PHP_EOL . 'JSON: ' . $this->Request->getJson());
                }else{
                    $this->Request->Error_Set_Json('Request POST Not Permission!', 405);
                    //Imprime Log
                    $this->logGeneration('ERROR - REQUEST ' . $_SERVER['REQUEST_METHOD'] . ' NOT ALLOWED IN METHOD geTask()!' );
                    //Devolve a resposta para o Client
                    http_response_code(405);
                }

                echo $this->Request->getJson();
            }
            /*
            * Método: setTask()
            * Descrição: adiciona novas tarefas
            * Data: 07/09/2024
            * Programador(a): Ighor Drummond
            */
            public function setTask():void
            {
                $this->startRequest();//Inicia Requisição

                if($_SERVER['REQUEST_METHOD'] === 'POST'){
                    if(
                        isset($_POST['name']) and !empty($_POST['name']) and
                        isset($_POST['description']) and !empty($_POST['description'])
                    ){
                        //Sanatizar os dados
                        @$_POST['name'] = $this->sanatizeVar($_POST['name']);
                        @$_POST['description'] =  $this->sanatizeVar($_POST['description']);
                        //Inclui uma nova Task
                        $this->Request->setTask($_POST['name'], $_POST['description']);
                        //Imprime Log
                        $this->logGeneration('SUCCESS - METHOD setTask COMPLETED ' .PHP_EOL . 'JSON: ' . $this->Request->getJson());
                    }
                }else{
                    $this->Request->Error_Set_Json('Request GET Not Permission!', 405);
                    //Imprime Log
                    $this->logGeneration('ERROR - REQUEST ' . $_SERVER['REQUEST_METHOD'] . ' NOT ALLOWED IN METHOD setTask()!' );
                    //Devolve a resposta para o Client
                    http_response_code(405);
                }

                echo $this->Request->getJson();
            }
            /*
            * Método: putTask()
            * Descrição: atualiza tarefas existentes
            * Data: 07/09/2024
            * Programador(a): Ighor Drummond
            */
            public function putTask():void
            {
                $this->startRequest();//Inicia Requisição

                if($_SERVER['REQUEST_METHOD'] === 'PUT'){
                    //Pegar os dados do corpo da URL via PUT
                    $putData = file_get_contents('php://input');
                    //Descodifica Json para Array
                    $putData = json_decode($putData, true);

                    if(!empty($putData) and isset($putData['id']) 
                        and !empty($putData['id']) and $putData['status'] != ''
                        and $putData['status'] != ''
                    ){
                        //Sanatizar os dados
                        $putData['status'] = $this->sanatizeVar($putData['status']);
                        $putData['id'] = $this->sanatizeVar($putData['id']);
                        //Atualiza Task
                        if(!$this->Request->putTask($putData['id'], $putData['status'])){
                            $this->Request->Error_Set_Json('Not possible refresh your task!', 200);
                            //Imprime Log
                            $this->logGeneration('ERROR - A DATABASE ERROR OCCURED! putTask()');
                        }else{
                            //Imprime Log
                            $this->logGeneration('SUCCESS - METHOD putTask() COMPLETED ' .PHP_EOL . 'JSON: ' . $this->Request->getJson());
                        }
                    }else{
                        //Retorna pedindo campos obrigátorios
                        $this->Request->Error_Set_Json('Fields required!', 200);
                        //Imprime Log
                        $this->logGeneration('ERROR - FIELDS REQUIRED IN METHOD setTask()!' );
                    }
                }else{
                    $this->Request->Error_Set_Json('Request POST, GET OR DELETE Not Permission!', 405);
                    //Imprime Log
                    $this->logGeneration('ERROR - REQUEST ' . $_SERVER['REQUEST_METHOD'] . ' NOT ALLOWED IN METHOD putTask()!' );
                    //Devolve a resposta para o Client
                    http_response_code(405);
                }

                echo $this->Request->getJson();
            }
            /*
            * Método: deleteTask()
            * Descrição: deleta tarefas existentes
            * Data: 07/09/2024
            * Programador(a): Ighor Drummond
            */
            public function deleteTask():void
            {
                $this->startRequest();//Inicia Requisição

                if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
                    //Pegar os dados do corpo da URL via PUT
                    $delData = file_get_contents('php://input');
                    //Descodifica Json para Array
                    $delData = json_decode($delData, true);

                    if(!empty($delData) and isset($delData['id'])){
                        //Sanatizar os dados
                        $delData['id'] = $this->sanatizeVar($delData['id']);

                        //Deleta a Task
                        if(!$this->Request->deleteTask($delData['id'])){
                            $this->Request->Error_Set_Json('Not Possible deleted your task!', 409);
                            //Imprime Log
                            $this->logGeneration('ERROR - A DATABASE ERROR OCCURED! deleteTask()');
                            //Retorna para o Client erro 409
                            http_response_code(409);
                        }else{
                            //Imprime Log
                            $this->logGeneration('SUCCESS - METHOD deleteTask() COMPLETED ' .PHP_EOL . 'JSON: ' . $this->Request->getJson());
                        }
                    }else{
                        $this->Request->Error_Set_Json('Fields required!', 200);
                        //Imprime Log
                        $this->logGeneration('ERROR - FIELDS REQUIRED IN METHOD deleteTask()!' );
                    }
                }else{
                    $this->Request->Error_Set_Json('Request POST, GET OR DELETE Not Permission!', 200);
                    //Imprime Log
                    $this->logGeneration('ERROR - REQUEST ' . $_SERVER['REQUEST_METHOD'] . ' NOT ALLOWED IN METHOD deleteTask()!' );
                    //Devolve a resposta para o Client
                    http_response_code(405);
                }

                echo $this->Request->getJson();
            }
            /*
            * Método: startRequest()
            * Descrição: inicia execuções de requisições
            * Data: 07/09/2024
            * Programador(a): Ighor Drummond
            */
            private function startRequest():void
            {

                //Caso o client mande um OPTIONS como Regra de CORS para validar se o Server aceita um DELETE, retorna para o mesmo como verdadeiro 
                if($_SERVER['REQUEST_METHOD'] === 'OPTIONS'){
                    http_response_code(200);
                    $this->logGeneration('SUCCESS - AUTHORIZED REQUEST!');
                    exit;
                }

                $this->Request = New ExecuteRequest();

                //Valida se API está desativada
                if(!self::API_ACTIVE){
                    $this->Request->Error_Set_Json('API Not Active!', 500);
                    //Devolve a resposa para o Client
                    http_response_code(500);
                    //Atualiza no log
                    $this->logGeneration('ERROR - API NOT ACTIVE!');
                    //Retorna Json para o Client
                    echo $this->Request->getJson();
                    die();
                }
            }
            /*
            * Método: sanatizeVar(dados a ser sanatizado)
            * Descrição: Sanatiza dados
            * Data: 07/09/2024
            * Programador(a): Ighor Drummond
            */
            private function sanatizeVar($var):string
            {
                $var = filter_var($var, FILTER_SANITIZE_STRING);
                $var = filter_var($var, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                return $var;
            }
            /*
            * Método: logGeneration(mensagem gerada)
            * Descrição: Gera o Log e descreve o mesmo
            * Data: 09/09/2024
            * Programador(a): Ighor Drummond
            */
            private function logGeneration($message){
                //Seta data do servidor
                date_default_timezone_set('America/Sao_Paulo');
                //Recupera o logo do dia
                $log = 'log_' . date('d_m_Y') . '.txt';
                //Caso o arquivo não existir, ele cria e abre para edição
                $KeyLog = fopen($log, 'a+');
                $msg = '========================== ' . date('d/m/Y H:i:s')  . ' =============================' . PHP_EOL;
                $msg .=  'STATUS_API = ' . (self::API_ACTIVE ? 'OK' : 'ERROR') . ' - REQUEST = ' . $_SERVER['REQUEST_METHOD'] . ' - CLIENT_USER = '  .   $_SERVER['HTTP_USER_AGENT'] . PHP_EOL;
                $msg .= 'MESSAGE: ' .  $message . PHP_EOL;
                $msg .= '============================================================================' . PHP_EOL;
                //Escreve a mensagem no arquivo
                fwrite($KeyLog, $msg);
                //Fecha arquivo
                fclose($KeyLog);
            }
        }
    }

?>