<?php
/*
===============================================
Fonte: ExecuteRequest.php
Descrição: Responsável por executar as requisições e retornar dados
Data: 07/09/2024
Programador(a): Ighor Drummond
===============================================
*/
    /*
    Namespace: App\Models
    Descrição: NameSpace App\Models
    Data: 07/09/2024
    Programador(a): Ighor Drummond.
    */
    namespace App\Models{
        //Bibliotecas
        use App\lib\Connection;

        class ExecuteRequest extends Connection{
            //Constantes
            const API_IV = '`�[�@�݊͈���';//Chave IV para criptográfia
            const API_KEY = 'vLp8rEJV}~%78I;V<Y:]+A"GU%Ç2_x@aNr?)rM,J£zl%\~ptXE';//Chave de criptográfia
            //Atributo
            protected array $json;

            //Construtor 
            /*
            * Método: __construct()
            * Descrição: 
            * Data: 07/09/2024
            * Programador(a): Ighor Drummond
            */
            public function __construct(){
                //Monta Json padrão
                $this->json = [
                    'error' => false,
                    'status' => 200,
                    'message' => '',
                    'data' => []
                ];
                // Chama o construtor da classe pai para realizar conexão com o banco de dados
                parent::__construct(); 
                //Valida se houve problemas na conexão com o Banco de dados
                if($this->message != ''){
                    $this->Error_Set_Json($this->message, 500);
                }
            }

            //Destruidor
            /*
            * Método: __descructy()
            * Descrição: 
            * Data: 07/09/2024
            * Programador(a): Ighor Drummond
            */
            public function __descructy():void
            {
                $this->con = null;//Encerra conexão com o banco de dados
            }

            //Getters
            /*
            * Método: getTask()
            * Descrição: 
            * Data: 07/09/2024
            * Programador(a): Ighor Drummond
            */
            public function getTask(string $name = ''){
                $this->constructQuery(1);

                //Valida se foi repassado o nome da tarefa
                if(!empty($name)){
                    $this->query .= " WHERE UPPER(REPLACE(TRIM(name_task), ' ', '')) LIKE :name";
                    $this->params = [
                        ':name' => '%' . strtoupper(str_replace(' ', '', $name)) . '%'
                    ];
                }

                //Realiza pesquisa e retorna no Json
                if($this-> SearchQuery()){
                    //Recupera a pesquisa de tarefas
                    $this->json['data'] = $this->GetSearch();
                    //Criptografa o Id
                    foreach ($this->json['data'] as $key => $cript) {
                        $this->json['data'][$key]['id_task'] = $this->encryption($this->json['data'][$key]['id_task']);
                    }
                }else{
                    //Retorna mensagem de erro do banco
                    $this->Error_Set_Json($this->message, 500);
                }
            }
            /*
            * Método: getJson()
            * Descrição: 
            * Data: 07/09/2024
            * Programador(a): Ighor Drummond
            */
            public function getJson():string
            {
                return json_encode($this->json, JSON_PRETTY_PRINT);
            }

            //Setters
            /*
            * Método: setTask( nome da tarefa, descrição)
            * Descrição: 
            * Data: 07/09/2024
            * Programador(a): Ighor Drummond
            */
            public function setTask(string $name = '', string $description = ''){
                //Monta query
                $this->constructQuery(2);
                //Parâmetros 
                $this->params = [
                    ':name' => $name,
                    ':description' => $description
                ];
                
                //Realiza pesquisa e retorna no Json
                if($this->SearchQuery()){
                    $this->json['status_include'] = true;
                }else{
                    $this->Error_Set_Json($this->message, 500);
                    $this->json['status_include'] = false;
                }
            }    

            //Métodos
            /*
            * Método: deleteTask(ID CRIPTOGRAFADO)
            * Descrição: Deleta a tarefa 
            * Data: 09/09/2024
            * Programador(a): Ighor Drummond
            */
            public function deleteTask(string $task = ''):bool
            {
                $Ret = false;
                //Descriptografa o id
                $Id = $this->decryption($task);
                //Valida se a descriptografia ocorreu tudo bem
                if($Id != false){
                    //Constrói a query para deletar
                    $this->constructQuery(3);
                    //Parâmetros 
                    $this->params = [
                        ':id_task' => $Id
                    ];
                    //Executa a deletação
                    $Ret = $this->SearchQuery() ? true : false;
                }
                //Retorna status
                return $Ret;    
            }
            /*
            * Método: putTask(ID CRIPTOGRAFADO, STATUS ATUALIZADO)
            * Descrição: Atualiza tarefa
            * Data: 09/09/2024
            * Programador(a): Ighor Drummond
            */
            public function putTask(string $task = '', string $status = ''):bool
            {
                $Ret = false;
                //Descriptografa o id
                $Id = $this->decryption($task);
                //Valida se a descriptografia ocorreu tudo bem
                if($Id != false){
                    //Constrói a query para atualizar tarefa
                    $this->constructQuery(4);
                    //Parâmetros 
                    $this->params = [
                        ':id_task' => $Id,
                        ':status_task' => $status === '1' ? true : false
                    ];
                    //Executa a deletação
                    $Ret = $this->SearchQuery() ? true : false;
                }
                //Retorna status
                return $Ret;    
            }
            /*
            * Método: Error_Set_Json(Mensagem, Código de status)
            * Descrição: 
            * Data: 07/09/2024
            * Programador(a): Ighor Drummond
            */
            public function Error_Set_Json(string $msg, int $Code):void
            {
                $this->json['error'] = true;//Seta erro como verdadeiro
                $this->json['status'] = $Code;//Status
                $this->json['message'] = $msg;//Mensagem de erro
                unset($this->json['data']);//Deleta campo data
            }
            /*
            * Método: constructQuery(Opção)
            * Descrição: 
            * Data: 07/09/2024
            * Programador(a): Ighor Drummond
            */
            private function constructQuery($opc):void
            {
                switch($opc){
                    case 1:
                        $this->query = "
                            SELECT
                                *
                            FROM
                                TASK";
                        break;
                    case 2:
                        $this->query = "
                            INSERT INTO TASK(name_task, description_task) 
                            VALUES(:name, :description);
                        ";
                        break;
                    case 3:
                        $this->query = "
                            DELETE FROM TASK WHERE id_task = :id_task
                        ";
                        break;
                    case 4:
                        $this->query = "
                            UPDATE
                                TASK
                            SET
                                status_task = :status_task
                            WHERE
                                id_task = :id_task
                        ";
                        break;
                }
            }
            /*
            * Método: encryption(valor para criptografar)
            * Descrição: 
            * Data: 07/09/2024
            * Programador(a): Ighor Drummond
            */
            private function encryption($val):string
            {   
                //Realiza criptografia
                @$Ret = openssl_encrypt($val , 'aes-256-cbc', self::API_KEY, 0, self::API_IV);
                @$Ret = base64_encode($Ret);//Converte para base 64 bits
                return $Ret;
            }
            /*
            * Método: decryption(valor para descriptografar)
            * Descrição: Descriptografa o Id correspondente
            * Data: 09/09/2024
            * Programador(a): Ighor Drummond
            */
            private function decryption($val):string
            {   
                return @openssl_decrypt(base64_decode($val), 'aes-256-cbc', self::API_KEY, 0, self::API_IV);
            }
        }
    }
?>