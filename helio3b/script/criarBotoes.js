function criarBotoes() {
    // Botão Excluir
    let excluir = document.createElement("button");
    excluir.textContent = "Excluir";
    excluir.className = "excluir";

    excluir.onclick = function () {
        if(confirm("Deseja realmente exlcuir?")){
            let tr = excluir.closest("tr"); // Encontra o tr mais próximo
        if (tr) {
            let jsonData = tr.querySelector("td[data-json]");
            if (jsonData) {
                let objJson = JSON.parse(jsonData.getAttribute("data-json"));
                let id;
                if (tabelaAtual === "clientes") {
                    id = objJson.id_cliente;
                } else if (tabelaAtual === "estagiarios") {
                    id = objJson.id_estagiario;
                } else if (tabelaAtual === "empresas") {
                    id = objJson.id_empresa;
                }
                excluirRegistro(tr, id);
            } else {
                console.error("Dados JSON não encontrados na linha.");
            }
        } else {
            console.error("Elemento <tr> não encontrado.");
        }
        }
    }

    // Botão Alterar
    let alterar = document.createElement("button");
    alterar.textContent = "Alterar";
    alterar.className = "alterar";

    alterar.onclick = function () {
        let tr = alterar.closest("tr"); // Encontra o tr mais próximo
        if (tr) {
            let jsonData = tr.querySelector("td[data-json]");
            if (jsonData) {
                let objJson = JSON.parse(jsonData.getAttribute("data-json"));
                let id;
                if (tabelaAtual === "clientes") {
                    id = objJson.id_cliente;
                    let tela = document.getElementById('alterar_cliente');
                    tela.style.display = "block";
                } else if (tabelaAtual === "estagiarios") {
                    id = objJson.id_estagiario;
                    let tela = document.getElementById('alterar_estagiario');
                    tela.style.display = "block";
                } else if (tabelaAtual === "empresas") {
                    id = objJson.id_empresa;
                    let tela = document.getElementById('alterar_empresa');
                    tela.style.display = "block";
                }

                // Configura o botão de alterar dados
                let botao_alterar_dados_cliente = document.getElementById("alterar_dados_cliente");
                if (botao_alterar_dados_cliente) {
                    botao_alterar_dados_cliente.onclick = function (event) {
                        event.preventDefault();
                        alterarRegistro(id);
                    }
                }

                let botao_alterar_dados_empresa = document.getElementById("alterar_dados_empresa");
                if (botao_alterar_dados_empresa) {
                    botao_alterar_dados_empresa.onclick = function (event) {
                        event.preventDefault();
                        alterarRegistro(id);
                    }
                }

                let botao_alterar_dados_estagiario = document.getElementById("alterar_dados_estagiario");
                if (botao_alterar_dados_estagiario) {
                    botao_alterar_dados_estagiario.onclick = function (event) {
                        event.preventDefault();
                        alterarRegistro(id);
                    }
                }
            } else {
                console.error("Dados JSON não encontrados na linha.");
            }
        } else {
            console.error("Elemento <tr> não encontrado.");
        }
    }

    // Botão fechar para cada tipo de alteração
    let botao_close_alterar_cliente = document.getElementById("close_alterar_cliente");
    if (botao_close_alterar_cliente) {
        botao_close_alterar_cliente.onclick = function (event) {
            event.preventDefault();
            let tela = document.getElementById('alterar_cliente');
            tela.style.display = "none";
        }
    }

    let botao_close_alterar_empresa = document.getElementById("close_alterar_empresa");
    if (botao_close_alterar_empresa) {
        botao_close_alterar_empresa.onclick = function (event) {
            event.preventDefault();
            let tela = document.getElementById('alterar_empresa');
            tela.style.display = "none";
        }
    }

    let botao_close_alterar_estagiario = document.getElementById("close_alterar_estagiario");
    if (botao_close_alterar_estagiario) {
        botao_close_alterar_estagiario.onclick = function (event) {
            event.preventDefault();
            let tela = document.getElementById('alterar_estagiario');
            tela.style.display = "none";
        }
    }

    // Span para os botões
    let span = document.createElement("span");
    span.className = "botoes";
    span.appendChild(alterar);
    span.appendChild(excluir);

    return span;
}
