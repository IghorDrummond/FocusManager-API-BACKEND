/*
Função: getTask()
Descrição: Recupera a tarefa
Data: 08/09/2024
*/
export function getTask(search = ''){
	$.ajax({
		url: 'http://localhost:7777/task' + (   isEmpty(search) ? '' : '?name=' + search),
		type: 'GET', 
		dataType: 'json',
		success: function(response){
			//Valida se houve erro na requisição
			if(!response.error){
				constructTask(response.data);//Constroí as tarefas
			}else{
				toasts(response.mensagem, 'Não foi Possivel acessar as Tarefas!');
			}
		},
		error: function (xhr, status, error){
			toasts(error, 'Não foi Possivel acessar as Tarefas!');
		}
	});
}
/*
Função: setTask()
Descrição: Cria uma nova tarefa
Data: 08/09/2024
*/
export function setTask(dados){
	$.ajax({
		url: 'http://localhost:7777/settask',
		type: 'POST',
		data: dados,
		dataType: 'json',
		success: function(response){
			$('aside').remove();//Desliga tela de inserção
			//Valida se houve erro na requisição
			if(!response.error){
				toasts('Tarefa adiciona com sucesso na sua lista!', 'Tarefa Adicionada!');
				getTask();//Constroí as tarefas
			}else{
				toasts(response.mensagem, 'Não foi Possivel adicionar sua tarefa!');
			}
		},
		error: function (xhr, status, error){
			$('aside').remove();//Desliga tela de inserção
			toasts(error, 'Ocorreu um erro!');
		}
	});
}
/*
Função: delTask
Descrição: deleta uma tarefa
Data: 08/09/2024
*/
export function delTask(dados){
	$.ajax({
		url: 'http://localhost:7777/deltask', 
		type: 'DELETE', 
		contentType: 'application/json', 
		data: JSON.stringify({ id: dados }),
		dataType: 'json',
		success: function(response) {
			//Valida se houve erro na requisição
			if(!response.error){
				toasts('Sua tarefa foi deletada com sucesso!', 'Tarefa deletada com sucesso!');
				getTask();//Constroí as tarefas
			}else{
				toasts(response.mensagem, 'Não foi Possivel deletar sua tarefa');
			}
		},
		error: function(xhr, status, error) {
			$('aside').remove();//Desliga tela de inserção
			toasts(error, 'Ocorreu um erro!');
		}
	});
}
/*
Função: putTask()
Descrição: Atualiza uma tarefa
Data: 08/09/2024
*/
export function putTask(id_task, status_task){
	$.ajax({
		url: 'http://localhost:7777/puttask', 
		type: 'PUT', 
		contentType: 'application/json', 
		data: JSON.stringify({ id: id_task, status: status_task }),
		dataType: 'json',
		success: function(response) {
			//Valida se houve erro na requisição
			if(!response.error){
				toasts('Sua tarefa foi atualizada com sucesso!', 'Tarefa atualizada!');
				getTask();//Constroí as tarefas
			}else{
				toasts(response.mensagem, 'Não foi Possivel atualizar sua tarefa');
			}
		},
		error: function(xhr, status, error) {
			$('aside').remove();//Desliga tela de inserção
			toasts(error, 'Ocorreu um erro!');
		}
	});
}
/*
Função: constructTask()
Descrição: constrói o corpo das tarefas em HTML
Data: 08/09/2024
*/
export function constructTask(dados){
	let item = '<ol class="list-group list-group-numbered w-100">';//Inicia a listagem
	let status = '';
	let options = '';

	//Monta os items da lista de tarefas
 	dados.forEach((task)=>{
 		//Alimenta cada item da lista

 		//Valida status da tarefas
 		if(task.status_task === 0){
 			status = 'bg-info';
 			options = ` 
 				<option value="0" selected>A fazer</option>
 				<option value="1">Finalizado</option>`;
 		}else{
 			status = 'bg-success';
 			options = ` 
 				<option value="1" selected>Finalizado</option>
 				<option value="0">A Fazer</option>`;			
 		}

 		//Constrói o item da lista
 		item += `
 			<li class="${status} list-group-item text-white flex-lg-row flex-column flex-wrap d-flex justify-content-between align-items-start">
 				<div class="ms-2 me-auto">
 					<div class="fw-bold">${task.name_task}</div>	
 					${task.description_task}		
 				</div>
				<div id="${task.id_task}">
				 	<select class="form-select border border-primary select_status">
 					${options}
 					</select>
					<button class="btn btn-danger delete rounded mt-2 text-white p-1 w-100">Deletar</button>
				</div>
 			</li>
 		`
 	});
 	//Finaliza listagem
 	item += '</ol>';

 	//Ejeta os items na lista
 	$('section').html(item);
}
/*
Função: toasts
Descrição: Ativa um toasts para avisos no Site
Data: 08/09/2024
*/
export function toasts(msg='', title=''){
	var toast = document.getElementsByClassName('toast')[0];
	//Valida se existe o toast no HTML
	if(toast){
		//Ejeta uma mensagem para a caixa de dialog
		$('.toast-body').text(msg);
		$('.title_toast').text(title);
		//Abre a Caixa do Dialogo
		let showToast = new bootstrap.Toast(toast);
		//Ativa o Toast para escrever uma mensagem
		showToast.show();
	}
}
/*
Função: isEmpty(valor)
Descrição: Verifica se o valor é null, undefined, ou uma string vazia
Data: 09/09/2024
*/
function isEmpty(value) {
    return value === null || value === undefined || value === '' || (typeof value === 'string' && value.trim().length === 0);
}