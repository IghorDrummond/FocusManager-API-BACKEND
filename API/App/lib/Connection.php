<?php
/*
===============================================
Fonte: Connection.php
Descrição: Responsável porConectar o banco de dados a API
Data: 07/09/2024
Programador(a): Ighor Drummond
===============================================
*/
	namespace App\lib{
		/**
 		* Classe: Conncection
		 * Descrição: Realiza conexão com o banco de dados
		 * Programador(a): Ighor Drummond
		 * Extend: não há
		 * Data: 09/09/2024
		 */
		abstract class Connection
		{
			//Atributos
			//Costantes
			const DNS = 'mysql: host=localhost:7787; dbname=DB_FOCUSMANAGE';
			const USER = 'root';
			const PASSWORD = '';
			//Inteiro
			public int $idLast = 0;
			//objeto
			public ?\PDO $con = null;
			public ?\PDOStatement $stmt = null;
			//array 
			public array $params = [];
			//string
			public string $query = '';
			public string $message = '';

			//Construtor
            /*
            * Método: __construct()
            * Descrição: Construtor da Classe
            * Data: 07/09/2024
            * Programador(a): Ighor Drummond
            */
			public function __construct()
			{
				try{
					$this->con = new \PDO(self::DNS, self::USER, self::PASSWORD);
					$this->con->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
				}catch(\PDOException $e){
					//Guarda Mensagem de error
					$this->message = $e->getMessage();
				}
			}

			//Getters
            /*
            * Método: GetId()
            * Descrição: Retorna o ID inserido na ultima inclusão de dados
            * Data: 07/09/2024
            * Programador(a): Ighor Drummond
            */
			protected function GetId():int
			{
				//Retorna o Id inserido
				return $this->idLast;
			}
            /*
            * Método: GetSearch()
            * Descrição: Retorna a pesquisa  realiza no banco de dados
            * Data: 07/09/2024
            * Programador(a): Ighor Drummond
            */
			protected function GetSearch():array
			{
				//Retorna a pesquisa realizada
				return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
			}

			//Métodos
            /*
            * Método: SearchQuery()
            * Descrição: Executa a inclusão, alteração ou exclusão de dados no banco de dados
            * Data: 07/09/2024
            * Programador(a): Ighor Drummond
            */
			protected function SearchQuery():bool
			{
				$Ret = false;
				try{
					//Recupera os índices do array
					$indices = array_keys($this->params);

					//Prepara query para parâmetros configurados
					$this->stmt = $this->con->prepare($this->query);

					//Valida parâmetros
					for ($nCont = 0; $nCont <= count($indices) -1 ; $nCont++) { 
						if(is_bool($this->params[$indices[$nCont]])){
							//Se for booleno, prepara parâmetro da query como booleano
							$this->stmt->bindValue($indices[$nCont], $this->params[$indices[$nCont]], \PDO::PARAM_BOOL);
						}else if(is_int($this->params[$indices[$nCont]])){
							//Se for Inteiro, prepara parâmetro da query como inteiro
							$this->stmt->bindValue($indices[$nCont], $this->params[$indices[$nCont]], \PDO::PARAM_INT);
						}else{
							//Seta string como padrão
							$this->stmt->bindValue($indices[$nCont], $this->params[$indices[$nCont]], \PDO::PARAM_STR);
						}
					} 
					//Prepara transição de dados
					$this->con->beginTransaction();

					//Executa query para busca
					if($this->stmt->execute()){
						$this->idLast = $this->con->lastInsertId();//Recupera o id caso for uma inserção
						$this->con->commit();
						$Ret = true;
					}	
				}catch(\PDOException $e){
					$this->con->rollBack();//Cancela transição de dados
					//Guarda Mensagem de error
					$this->message = $e->getMessage();
				}finally{
					return $Ret;
				}
			}
		}
	}
?>