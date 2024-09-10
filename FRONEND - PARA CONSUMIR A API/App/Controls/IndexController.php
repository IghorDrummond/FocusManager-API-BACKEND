<?php
/*
===============================================
Fonte: Route.php
Descrição: Responsável por alinhar as rotas para a aplicação FocusManage
Data: 08/09/2024
Programador(a): Ighor Drummond
===============================================
*/
    /*
    Namespace: Controls
    Descrição: Agrupa classes do Controller
    Data: 08/09/2024
    Programador(a): Ighor Drummond.
    */
    namespace App\Controls{
        use FM\Controller\Action;//Aciona a classe Action para devidas ações do controller
        /*
         * Classe: IndexController
         * Descrição: Responsável por realizar operações do Controller
         * Data: 08/09/2024
         * Extends: Não há.
         * Programador(a): Ighor Drummond
         */
        class IndexController extends Action{
            /*
            * Método: index()
            * Descrição: renderiza a view do Index
            * Data: 08/09/2024
            * Programador(a): Ighor Drummond
            */
            public function index(){
                $this->render('index');
            }
            /*
            * Método: editTask()
            * Descrição: Renderiza e retorna um HTML formulario para editar a tarefa
            * Data: 08/09/2024
            * Programador(a): Ighor Drummond
            */
            public function editTask(){
                echo $this->renderHtml('editTask');             
            } 
            /*
            * Método: addTask()
            * Descrição: Renderiza e retorna um HTML formulario para adicionar uma nova tarefa
            * Data: 08/09/2024
            * Programador(a): Ighor Drummond
            */
            public function addTask(){
               echo $this->renderHTML('addTask');
            }
        }
    }

?>