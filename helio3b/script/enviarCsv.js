
let botao_enviar_csv = document.getElementById("csv");

botao_enviar_csv.onclick = function () {
    let csv = document.getElementById("file_csv");
    let tabelaAtual = document.getElementById("select").value;

    let uri;
    if (tabelaAtual === "estagiarios") {
        uri = "/estagiarios/csv";
    } else if (tabelaAtual === "empresas") {
        uri = "/empresas/csv";
    } else if (tabelaAtual === "clientes") {
        uri = "/clientes/csv";
    } else {
        alert("Selecione uma tabela válida.");
        return;
    }

    const file = csv.files[0];
    if (!file) {
        alert("Por favor, selecione um arquivo CSV.");
        return;
    }

    const formData = new FormData();
    formData.append('csv', file); // Certifique-se de que o campo é 'csv'
    let token = localStorage.getItem('token')
    fetch(uri, {
        method: "POST",
        headers: {
            'Authorization': 'Bearer ' + token // Substitua pelo seu token JWT
        },
        body: formData
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro na rede');
            }
            return response.json();
        })
        .then(data => {
            if (data.status) {
                alert("Cadastro com sucesso!");

                if (tabelaAtual === "estagiarios") {
                    carregarEstagiarios()
                } else if (tabelaAtual === "empresas") {
                    carregarEmpresas()
                } else if (tabelaAtual === "clientes") {
                    carregarClientes()
                }
            } else {
                alert(`Erro: ${data.mensagem}`);
            }
            console.log(data);
        })
        .catch(error => {
            console.error('Erro:', error);
            alert("Ocorreu um erro ao enviar o arquivo.");
        });
};

