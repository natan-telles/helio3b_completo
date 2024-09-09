function alterarRegistro(id) {
    let botao_alterar_dados_cliente = document.getElementById("alterar_dados_cliente");
    let botao_alterar_dados_estagiario = document.getElementById("alterar_dados_estagiario");
    let botao_alterar_dados_empresa = document.getElementById("alterar_dados_empresa");

    botao_alterar_dados_cliente.onclick = function (event) {
        event.preventDefault();
        alterarCliente();
    }


    botao_alterar_dados_estagiario.onclick = function (event) {
        event.preventDefault();
        alterarEstagiario();
    }

    botao_alterar_dados_empresa.onclick = function (event) {
        event.preventDefault();
        alterarEmpresa();
    }


    let tabela = document.getElementById("select").value
    if (tabela == "clientes") {
        uri = `/clientes/${id}`
    } else if (tabela == "estagiarios") {
        uri = `/estagiarios/${id}`
    } else if (tabela == "empresas") {
        uri = `/empresas/${id}`
    }

    function alterarCliente() {
        let nome = document.getElementById("alterar_nome_cliente").value;
        let pedido = document.getElementById("alterar_pedido_cliente").value;
        console.log("Nome: ", nome);
        console.log("Pedido: ", pedido);

        let alterar_cliente = {
            nomeCliente: nome,
            pedidoCliente: pedido
        };

        console.log(alterar_cliente)
        let token = localStorage.getItem('token')
        fetch(uri, {
            method: "PUT",
            headers: {
                'Content-Type': 'application/json',
                'Authorization' : 'Bearer ' + token
            },
            body: JSON.stringify(alterar_cliente)
        }).then((response) => {
            console.log('Resposta do servidor:', response);
            return response.text(); // Alterar para response.text() para ver o conteúdo
        }).then((texto) => {
            console.log("Dados recebidos: ", texto);
            try {
                carregarClientes();
                alert("Cliente alterado com sucesso!");
            } catch (error) {
                console.error("Erro ao analisar JSON: ", error.message);
                alert("Erro ao processar a resposta do servidor.");
            }
        }).catch((error) => {
            console.log("Erro: ", error.message);
        });

    }


    function alterarEstagiario() {
        let nome = document.getElementById("alterar_nome_estagiario").value;
        let data_nascimento = document.getElementById("alterar_data_nascimento").value;
        let telefone = document.getElementById("alterar_telefone").value;
        let email = document.getElementById("alterar_email").value;

        let alterar_estagiario = {
            nome_estagiario: nome,
            data_nascimento: data_nascimento,
            telefone: telefone,
            email: email
        };

        console.log(alterar_estagiario)
        let token = localStorage.getItem('token')
        fetch(uri, {
            method: "PUT",
            headers: {
                'Content-Type': 'application/json',
                'Authorization' : 'Bearer ' + token
            },
            body: JSON.stringify(alterar_estagiario)
        }).then((response) => {
            //console.log('Resposta do servidor:', response);
            return response.text(); // Alterar para response.text() para ver o conteúdo
        }).then((texto) => {
            //console.log("Dados recebidos: ", texto);
            try {
                carregarEstagiarios();
                alert("Estagiario alterado com sucesso!");
            } catch (error) {
                console.error("Erro ao analisar JSON: ", error.message);
                alert("Erro ao processar a resposta do servidor.");
            }
        }).catch((error) => {
            console.log("Erro: ", error.message);
        });

    }

    function alterarEmpresa() {
        let nome = document.getElementById("alterar_nome_empresa").value;
        let Cnpj = document.getElementById("alterar_cnpj").value;
        if (nome == "") {
            alert("Digite nome válido!")
        } else {
            if (Cnpj.length < 18) {
                alert("Digite CNPJ válido!")
            } else {
                let alterar_empresa = {
                    nome_empresa: nome,
                    cnpj: Cnpj
                };

                //console.log(alterar_empresa)
                let token = localStorage.getItem('token')
                fetch(uri, {
                    method: "PUT",
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization' : 'Bearer ' + token
                    },
                    body: JSON.stringify(alterar_empresa)
                }).then((response) => {
                    console.log('Resposta do servidor:', response);
                    return response.text(); // Alterar para response.text() para ver o conteúdo
                }).then((texto) => {
                    console.log("Dados recebidos: ", texto);
                    try {
                        carregarEmpresas();
                        alert("Empresa alterada com sucesso!");
                    } catch (error) {
                        console.error("Erro ao analisar JSON: ", error.message);
                        alert("Erro ao processar a resposta do servidor.");
                    }
                }).catch((error) => {
                    console.log("Erro: ", error.message);
                });

            }
        }
    }

}