<?php
/*
===============================================
Fonte: Route.php
Descrição: Responsável por alinhar as rotas para a aplicação SectoTeca
Data: 08/09/2024
Programador(a): Ighor Drummond
===============================================
*/
	/*
	Namespace: App
	Descrição: Nome do diretório que se encontra o arquivo Routes.php
	Data: 08/09/2024
	Programador(a): Ighor Drummond.
	*/
    namespace App{
        //Importa Bootstap
        use FM\Init\Bootstrap;
		/*
		 * Classe: Route
		 * Descrição: Responsável por preparar, enviar e acionar rotas
		 * Data: 08/09/2024
		 * Extends: Não há.
		 * Programador(a): Ighor Drummond
		 */
        class Route extends Bootstrap{

            //Métodos
            /*
            * Método: initRoutes()
            * Descrição: inicia as Rotas e suas respectivas ações
            * Data: 08/09/2024
            * Programador(a): Ighor Drummond
            */
            protected function initRoutes(){
                $routes = [];
                //Rota para página Home
                $routes['home'] = array(
                    'route' => '/',
                    'controller' => 'indexController',
                    'action' => 'index'
                );
                //Rota para página de adição de tarefas
                $routes['addTask'] = array(
                    'route' => '/addtask',
                    'controller' => 'indexController',
                    'action' => 'addTask'
                );
                //Após passar as rotas existentes, ele seta as mesma no atributo routes da classe Bootstrap
                $this->setRoutes($routes);
            }
        }
    }
?>