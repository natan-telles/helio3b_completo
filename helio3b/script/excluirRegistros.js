function excluirRegistro(tr, id) {
    // Verifica se o tr e o seu pai estão presentes
    if (tr && tr.parentNode) {
        let parent = tr.parentNode;

        // Tenta remover o tr do contêiner
        try {
            parent.removeChild(tr);
            console.log("Item excluído da interface");
        } catch (error) {
            console.error("Erro ao remover o item da interface:", error);
        }
    } else {
        console.error("Elemento para exclusão não encontrado ou já removido.");
    }

    // Define a URI com base na tabela atual
    let tabela = document.getElementById("select").value;
    let uri;
    if (tabela === "clientes") {
        uri = `/clientes/${id}`;
    } else if (tabela === "estagiarios") {
        uri = `/estagiarios/${id}`;
    } else if (tabela === "empresas") {
        uri = `/empresas/${id}`;
    } else {
        console.error("Tabela não reconhecida.");
        return;
    }

    // Requisição para deletar o item no servidor
    let token = localStorage.getItem('token');
    fetch(uri, {
        method: "DELETE",
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + token
        }
    }).then((response) => {
        if (response.ok) {
            //return response.json();
        } else {
            throw new Error('Erro na resposta da rede.');
        }
    }).then((textoJson) => {
        console.log("Resposta do servidor:", textoJson);
        alert("Excluído com sucesso");
    }).catch((error) => {
        console.error("Erro: ", error);
        alert("Erro ao excluir o item.");
    });
}
