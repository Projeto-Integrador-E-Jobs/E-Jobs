carregarCidades(BASEURL, idCidadeSelecionada);

function carregarCidades(BASEURL, idCidadeSelecionada) {
    
    //1- Pegar o ID do estado que foi selecionado pelo usuário
    var id = parseInt(document.getElementById("selEstado").value);
    
    //2- Fazer uma requisição AJAX para carregar a lista de cidades do estado selecinado (JSON)
    const xhttp = new XMLHttpRequest();

    xhttp.onload = function() {
        const jsonCidades = xhttp.responseText;

        const listaCidades = JSON.parse(jsonCidades);

        //3- Criar os options no select de cidades
        const selectCidades = document.getElementById("selCidade");
        
        selectCidades.innerHTML = "";
        var option = document.createElement("option");
        option.value = 0;
        option.text = "Selecione a cidade";
        selectCidades.appendChild(option);
        
        listaCidades.forEach(c => {
            var option = document.createElement("option");
            option.value = c.id;
            option.text = c.nome;

            if(c.id == idCidadeSelecionada)
                option.selected = true;

            selectCidades.appendChild(option);
        }); 

    }


    xhttp.open("GET", BASEURL + "/controller/CidadeController.php?action=listarPorEstado&id_estado=" + id);
    xhttp.send();
}