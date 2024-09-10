<?php
/*
===============================================
Fonte: Route.php
Descrição: Responsável por alinhar as rotas para a aplicação SectoTeca
Data: 07/09/2024
Programador(a): Ighor Drummond
===============================================
*/
	/*
	Namespace: App
	Descrição: Nome do diretório que se encontra o arquivo Routes.php
	Data: 07/09/2024
	Programador(a): Ighor Drummond.
	*/
    namespace App{
        //Importa Bootstap
        use FM\Init\Bootstrap;
		/*
		 * Classe: Route
		 * Descrição: Responsável por preparar, enviar e acionar rotas
		 * Data: 07/09/2024
		 * Extends: Não há.
		 * Programador(a): Ighor Drummond
		 */
        class Route extends Bootstrap{

            //Métodos
            /*
            * Método: initRoutes()
            * Descrição: inicia as Rotas e suas respectivas ações
            * Data: 07/09/2024
            * Programador(a): Ighor Drummond
            */
            protected function initRoutes(){
                $routes = [];
                //Rota para página status da API
                $routes['status'] = array(
                    'route' => '/',
                    'controller' => 'IndexController',
                    'action' => 'status'
                );
                //Rota para recuperar as tarefas
                $routes['task'] = array(
                    'route' => '/task',
                    'controller' => 'IndexController',
                    'action' => 'getTask'
                );
                //Rota para adicionar uma nova tarefa
                $routes['settask'] = array(
                    'route' => '/settask',
                    'controller' => 'IndexController',
                    'action' => 'setTask'
                );
                //Rota para atualizar uma tarefa
                $routes['puttask'] = array(
                    'route' => '/puttask',
                    'controller' => 'IndexController',
                    'action' => 'putTask'
                );
                //Rota para deletar uma tarefa
                $routes['deltask'] = array(
                    'route' => '/deltask',
                    'controller' => 'IndexController',
                    'action' => 'deleteTask'
                );
                
                //Após passar as rotas existentes, ele seta as mesma no atributo routes da classe Bootstrap
                $this->setRoutes($routes);
            }
        }
    }
?>