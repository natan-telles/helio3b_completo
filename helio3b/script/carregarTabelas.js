function carregarClientes(filtro) {
    const uri = "/clientes"
    let token = localStorage.getItem('token')
    fetch(uri, {
        method: "GET",
        headers: {
            'Content-Type': 'application/json',
            'Authorization' : 'Bearer ' + token
        }
    }).then((response) => {
        return response.json()
    }).then((textoJson) => {
        //console.log(textoJson.dados) //dados retornados da API
        inserirDados(textoJson.dados,filtro)
    }).catch((error) => {
        console.log("Erro: ", error)
    })
}

function carregarEmpresas(filtro) {
    const uri = "/empresas"
    let token = localStorage.getItem('token')
    fetch(uri, {
        method: "GET",
        headers: {
            'Content-Type': 'application/json',
            'Authorization' : 'Bearer ' + token
        }
    }).then((response) => {
        return response.json()
    }).then((textoJson) => {
        //console.log(textoJson.dados) //dados retornados da API
        inserirDados(textoJson.dados,filtro)
    }).catch((error) => {
        console.log("Erro: ", error)
    })
}

function carregarEstagiarios(filtro) {
    const uri = "/estagiarios"
    let token = localStorage.getItem('token')
    fetch(uri, {
        method: "GET",
        headers: {
            'Content-Type': 'application/json',
            'Authorization' : 'Bearer ' + token
        }
    }).then((response) => {
        return response.json()
    }).then((textoJson) => {
        //console.log(textoJson.dados) //dados retornados da API
        inserirDados(textoJson.dados,filtro)
    }).catch((error) => {
        console.log("Erro: ", error)
    })
}