function inserirDados(dados, filtro) {
    // Obtém o elemento onde a tabela será inserida
    let divResposta = document.getElementById("resposta");

    // Limpa a div antes de adicionar novos dados
    divResposta.innerHTML = '';

    // Verifica se 'dados' é um array e não está vazio
    if (!Array.isArray(dados) || dados.length === 0) {
        console.log("Erro: 'dados' não é um array ou está vazio.");
        return;
    }

    // Se um filtro for fornecido, filtra os dados
    if (filtro) {
        dados = dados.filter(dado => {
            return Object.values(dado).some(value => {
                // Garantir que 'value' não é null ou undefined e é uma string antes de chamar 'toString()'
                const stringValue = value ? value.toString().toLowerCase() : '';
                return stringValue.includes(filtro.toLowerCase());
            });
        });
    }

    // Cria a tabela e o corpo da tabela
    let tabela = document.createElement("table");
    let thead = document.createElement("thead");
    let tbody = document.createElement("tbody");

    // Cria o cabeçalho da tabela
    let trHead = document.createElement("tr");
    Object.keys(dados[0]).forEach(key => {
        let th = document.createElement("th");
        th.textContent = key;
        trHead.appendChild(th);
    });

    // Adiciona uma coluna extra para os botões
    let thActions = document.createElement("th");
    thActions.textContent = "Ações";
    trHead.appendChild(thActions);

    thead.appendChild(trHead);

    // Adiciona o cabeçalho à tabela
    tabela.appendChild(thead);

    // Adiciona as linhas da tabela
    dados.forEach((dado, index) => {
        let tr = document.createElement("tr");

        // Adiciona células com dados e o atributo data-json
        Object.entries(dado).forEach(([key, value], cellIndex) => {
            let td = document.createElement("td");
            td.textContent = value;

            // Adiciona o atributo data-json apenas à primeira célula
            if (cellIndex === 0) {
                td.setAttribute("data-json", JSON.stringify(dado));
            }

            tr.appendChild(td);
        });

        // Cria e adiciona botões à linha
        let tdActions = document.createElement("td");
        let botoes = criarBotoes(); // Presume-se que a função criarBotoes() existe
        tdActions.appendChild(botoes);
        tr.appendChild(tdActions);

        tbody.appendChild(tr);
    });

    // Adiciona o corpo da tabela à tabela
    tabela.appendChild(tbody);

    // Adiciona a tabela ao elemento divResposta
    divResposta.appendChild(tabela);
}
