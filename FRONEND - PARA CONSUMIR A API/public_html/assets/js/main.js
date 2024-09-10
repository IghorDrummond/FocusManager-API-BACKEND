//Importar scripts de Terceiros
import {getTask, setTask, constructTask, delTask, putTask,toasts} from './script.js';

/* Inicia as requisições no Site */
$(document).ready(function(){
	//Alimenta o Site usando uma API para construir o corpo da mesma
	getTask();

	//Eventos
	/*
	*Evento: .add_task
	*Disparo: click
	*Descrição: Executa uma janela de adição para uma nova playlist
	*Programador(a): Ighor Drummond
	*Data: 09/08/204
	*/
	$('.add_task').click(()=>{
		$.ajax({
			url: '/addtask',
			type: 'GET',
			success: function(response){
				//Adiciona janela nova para a adição de janela
				$('body').prepend(response);
			},
			error: function (xhr, status, error){
				toasts(error, 'Não foi Possivel Adicionar Tarefas!');
			}
		});
	});
	/*
	*Evento: .search
	*Disparo: change
	*Descrição: Executa uma pesquisa
	*Programador(a): Ighor Drummond
	*Data: 09/08/204
	*/
	$('.search').change((event)=>{
		event.preventDefault();//Não atualiza a página
		getTask($('.search').val());//Recupera valor da pesquisa
	});
	/*
	*Evento: .delete
	*Disparo: click
	*Descrição: Deleta uma tarefa específica
	*Programador(a): Ighor Drummond
	*Data: 09/08/204
	*/
	$(document).on('click', '.delete', function() {
		if(confirm('Tem certeza que deseja deletar está tarefa?')){
			//Pega o Id criptografado
			let cId = $(this).parents('div').attr('id');
			delTask(cId);//Chama a função de deletar
		}
	});
	/*
	*Evento: .form_add_task
	*Disparo: submit
	*Descrição: Salva uma nova tarefa
	*Programador(a): Ighor Drummond
	*Data: 09/08/204
	*/
	$(document).on('submit', '.form_add_task', function(event) {
		event.preventDefault();//Impede de recarregar a página
		//Adiciona uma nova tarefa
		setTask($(this).serialize());
	});
	/*
	*Evento: .select_status
	*Disparo: change
	*Descrição: Atualiza status da tarefa
	*Programador(a): Ighor Drummond
	*Data: 09/08/204
	*/
	$(document).on('change', '.select_status', function() {
		let cId = $(this).parents('div').attr('id');
		let cStatus = $(this).val();
		//Adiciona uma nova tarefa
		putTask(cId, cStatus);
	});
});