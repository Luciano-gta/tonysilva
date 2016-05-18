/* Atribui ao evento submit do formulário a função de validação de dados */
var form = document.getElementById("form-contato");
if (form.addEventListener) {                   
    form.addEventListener("submit", validaCadastro);
} else if (form.attachEvent) {                  
    form.attachEvent("onsubmit", validaCadastro);
}

/* Atribui ao evento keypress do input cpf a função para formatar o CPF */
var inputCPF = document.getElementById("cpf");
if (inputCPF.addEventListener) {                   
    inputCPF.addEventListener("keypress", function(){mascaraTexto(this, '###.###.###-##')});
} else if (inputCPF.attachEvent) {                  
    inputCPF.attachEvent("onkeypress", function(){mascaraTexto(this, '###.###.###-##')});
}

/* Atribui ao evento keypress do input data de nascimento a função para formatar o data (dd/mm/yyyy) */
var inputDataNascimento = document.getElementById("data_nascimento");
if (inputDataNascimento.addEventListener) {                   
    inputDataNascimento.addEventListener("keypress", function(){mascaraTexto(this, '##/##/####')});
} else if (inputDataNascimento.attachEvent) {                  
    inputDataNascimento.attachEvent("onkeypress", function(){mascaraTexto(this, '##/##/####')});
}

/* Atribui ao evento keypress do input telefone a função para formatar o Telefone (00 0000-0000) */
var inputTelefone = document.getElementById("telefone");
if (inputTelefone.addEventListener) {                   
    inputTelefone.addEventListener("keypress", function(){mascaraTexto(this, '## ####-####')});
} else if (inputTelefone.attachEvent) {                  
    inputTelefone.attachEvent("onkeypress", function(){mascaraTexto(this, '## ####-####')});
}

/* Atribui ao evento keypress do input celular a função para formatar o Celular (00 00000-0000) */
var inputCelular = document.getElementById("celular");
if (inputCelular.addEventListener) {                   
    inputCelular.addEventListener("keypress", function(){mascaraTexto(this, '## #####-####')});
} else if (inputCelular.attachEvent) {                  
    inputCelular.attachEvent("onkeypress", function(){mascaraTexto(this, '## #####-####')});
}

/* Atribui ao evento change do input FILE para upload da foto*/
var inputFile = document.getElementById("foto");
var foto_cliente = document.getElementById("foto-cliente");
if (inputFile.addEventListener) {                   
    inputFile.addEventListener("change", function(){loadFoto(this, foto_cliente)});
} else if (inputFile.attachEvent) {                  
    inputFile.attachEvent("onchange", function(){loadFoto(this, foto_cliente)});
}

/* Função para validar os dados antes da submissão dos dados */
function validaCadastro(evt){
	var nome = document.getElementById('nome');
	var email = document.getElementById('email');
	var cpf = document.getElementById('cpf');
	var status = document.getElementById('status');
	var data_nascimento = document.getElementById('data_nascimento');
	var telefone = document.getElementById('telefone');
	var celular = document.getElementById('celular');
	var filtro = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
	var contErro = 0;


	/* Validação do campo nome */
	caixa_nome = document.querySelector('.msg-nome');
	if(nome.value == ""){
		caixa_nome.innerHTML = "Favor preencher o Nome";
		caixa_nome.style.display = 'block';
		contErro += 1;
	}else{
		caixa_nome.style.display = 'none';
	}

	/* Validação do campo email */
	caixa_email = document.querySelector('.msg-email');
	if(email.value == ""){
		caixa_email.innerHTML = "Favor preencher o E-mail";
		caixa_email.style.display = 'block';
		contErro += 1;
	}else if(filtro.test(email.value)){
		caixa_email.style.display = 'none';
	}else{
		caixa_email.innerHTML = "Formato do E-mail inválido";
		caixa_email.style.display = 'block';
		contErro += 1;
	}	

	/* Validação do campo cpf */
	caixa_data = document.querySelector('.msg-data');
	if(data_nascimento.value == ""){
		caixa_data.innerHTML = "Favor preencher a Data de Nascimento";
		caixa_data.style.display = 'block';
		contErro += 1;
	}else{
		caixa_data.style.display = 'none';
	}

	/* Validação do campo cpf */
	caixa_cpf = document.querySelector('.msg-cpf');
	if(cpf.value == ""){
		caixa_cpf.innerHTML = "Favor preencher o CPF";
		caixa_cpf.style.display = 'block';
		contErro += 1;
	}else{
		caixa_cpf.style.display = 'none';
	}

	/* Validação do campo telefone */
	caixa_telefone = document.querySelector('.msg-telefone');
	if(telefone.value == ""){
		caixa_telefone.innerHTML = "Favor preencher o Telefone";
		caixa_telefone.style.display = 'block';
		contErro += 1;
	}else{
		caixa_telefone.style.display = 'none';
	}

	/* Validação do campo celular */
	caixa_celular = document.querySelector('.msg-celular');
	if(celular.value == ""){
		caixa_celular.innerHTML = "Favor preencher o Celular";
		caixa_celular.style.display = 'block';
		contErro += 1;
	}else{
		caixa_celular.style.display = 'none';
	}

	/* Validação do campo status */
	caixa_status = document.querySelector('.msg-status');
	if(status.value == ""){
		caixa_status.innerHTML = "Favor preencher o Status";
		caixa_status.style.display = 'block';
		contErro += 1;
	}else{
		caixa_status.style.display = 'none';
	}

	if(contErro > 0){
		evt.preventDefault();
	}
}

/* Função para formatar dados conforme parâmetro enviado, CPF, DATA, TELEFONE e CELULAR */
function mascaraTexto(t, mask){
	var i = t.value.length;
	var saida = mask.substring(1,0);
	var texto = mask.substring(i);

	if (texto.substring(0,1) != saida){
		t.value += texto.substring(0,1);
	}
}

/* Função para exibir a imagem selecionada no input file na elemento <img>  */
function loadFoto(file, img){
    if (file.files && file.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
           img.src = e.target.result;
        }
        reader.readAsDataURL(file.files[0]);
    }
}