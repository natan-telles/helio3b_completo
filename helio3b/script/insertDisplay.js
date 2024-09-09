// Obtendo divs com os inputs distintos
let divInserirCliente = document.getElementById("inserir_cliente");
let divInserirEstagiario = document.getElementById("inserir_estagiario");
let divInserirEmpresa = document.getElementById("inserir_empresa");

//obtendo botoes salvar e fechar
let botaoAbrir = document.querySelector(".add");

let botaoFecharCliente = document.getElementById("close_inserir_cliente");
let botaoFecharEstagiario = document.getElementById("close_inserir_estagiario");
let botaoFecharEmpresa = document.getElementById("close_inserir_empresa");

//mostrar div dependendo da tabela
botaoAbrir.onclick = function () {
    let tabela = document.getElementById("select").value
    if (tabela == "clientes") {
        divInserirCliente.style.display = "block";
    } else if (tabela == "estagiarios") {
        divInserirEstagiario.style.display = "block";
    } else if (tabela == "empresas"){
        divInserirEmpresa.style.display = "block";
    }
}

// Ocultar a div com o botao fechar
botaoFecharCliente.onclick = function () {
    divInserirCliente.style.display = "none";
}
botaoFecharEstagiario.onclick = function () {
    divInserirEstagiario.style.display = "none";
}
botaoFecharEmpresa.onclick = function(){
    divInserirEmpresa.style.display = "none";
}

