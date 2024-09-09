let botaoEnviarCSV = document.getElementById("enviar_csv")
let csv = document.getElementById("csv")

botaoEnviarCSV.onclick = function(){
    let dados = new FormData()
    dados.append('csv',csv.files[0])

    let tabela = document.getElementById("select").value
    let uri
    if(tabela == "Clientes"){
        uri = "/clientes/csv"
    }else if(tabela == "Estagiarios"){
        uri = "/estagiarios/csv"
    }else if(tabela == "Empresas"){
        uri = "/empresas/csv"
    }
    fetch(uri,{
        method : "POST",
        body : dados
        /*
        headers : {
            'Authorization' : 'Bearer'
        }
        */
    }).then((response) => {
        return response.text()
    }).then(response_converted => {
        console.log(response_converted)
        const response = JSON.parse(response_converted)
        if(response.status == true){
            alert("Clientes cadastrados com sucesso!")
        }
    }).catch(erro => {
        console.log(erro)
    })
}