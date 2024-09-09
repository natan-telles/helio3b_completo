let botao_salvar_dados_cliente = document.getElementById("enviar_dados_cliente");
let botao_salvar_dados_estagiario = document.getElementById("enviar_dados_estagiario");
let botao_salvar_dados_empresa = document.getElementById("enviar_dados_empresa");

botao_salvar_dados_cliente.onclick = function (event) {
    event.preventDefault();
    adicionarCliente();
}

botao_salvar_dados_estagiario.onclick = function (event) {
    event.preventDefault();
    adicionarEstagiario();
}

botao_salvar_dados_empresa.onclick = function (event) {
    event.preventDefault();
    adicionarEmpresa();
}



function adicionarCliente() {
    let nome = document.getElementById("novoCliente").value;
    let pedido = document.getElementById("pedidoCliente").value;
    console.log("Nome: ", nome);
    console.log("Pedido: ", pedido);

    let novo_cliente = {
        novoCliente: nome,
        pedidoCliente: pedido
    };

    //console.log("Dados do cliente: ", novo_cliente);

    // Fetch -> inserindo no banco
    let uri = "/clientes";
    let token = localStorage.getItem('token')
    //console.log("Token do localStorage: " + token.trim())
    fetch(uri, {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
            'Authorization': "Bearer " + token
        },
        body: JSON.stringify(novo_cliente)
    }).then((response) => {
        return response.json(); // Se o servidor retornar JSON
    }).then((textoJson) => {
        console.log("Dados recebidos: ", textoJson);
        carregarClientes()
        alert("Registro inserido com sucesso!");
    }).catch((error) => {
        console.log("Erro: ", error.message);
    });
}

function adicionarEstagiario() {
    let nome = document.getElementById("nome_estagiario").value;
    let nascimento = document.getElementById("data_nascimento").value;
    let telefone = document.getElementById("telefone").value;
    let email = document.getElementById("email").value;
    let id_empresa = document.getElementById("id_empresa").value;


    let estagiario = {
        novo_estagiario: nome,
        data_nascimento: nascimento,
        telefone: telefone,
        email: email,
        id_empresa: parseInt(id_empresa)
    };
    console.log(estagiario)

    //console.log("Dados do estagiario: ", novo_estagiario);

    // Fetch -> inserindo no banco
    let uri = "/estagiarios";
    let token = localStorage.getItem('token')
    //console.log("Token do localStorage: " + token.trim())
    fetch(uri, {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
            'Authorization': "Bearer " + token
        },
        body: JSON.stringify(estagiario)
    }).then((response) => {
        return response.json(); // Se o servidor retornar JSON
    }).then((textoJson) => {
        //console.log("Dados recebidos: ", textoJson);
        carregarEstagiarios()
        alert("Registro inserido com sucesso!");
    }).catch((error) => {
        console.log("Erro: ", error.message);
    });
}

function adicionarEmpresa() {
    let nome = document.getElementById("nome_empresa").value;
    let cnpj = document.getElementById("cnpj").value;
    let idClienteEmpresa = document.getElementById("id_cliente_empresa").value;

    let empresa = {
        novaEmpresa: nome,
        cnpjEmpresa: cnpj,
        idClienteEmpresa: parseInt(idClienteEmpresa)
    }
    console.log(empresa)

    //console.log("Dados do estagiario: ", empresa);

    // Fetch -> inserindo no banco
    let uri = "/empresas";
    let token = localStorage.getItem('token')
    //console.log("Token do localStorage: " + token.trim())
    fetch(uri, {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
            'Authorization': "Bearer " + token
        },
        body: JSON.stringify(empresa)
    }).then((response) => {
        return response.json(); // Se o servidor retornar JSON
    }).then((textoJson) => {
        //console.log("Dados recebidos: ", textoJson);
        carregarEmpresas()
        alert("Registro inserido com sucesso!");
    }).catch((error) => {
        console.log("Erro: ", error.message);
    });
}

