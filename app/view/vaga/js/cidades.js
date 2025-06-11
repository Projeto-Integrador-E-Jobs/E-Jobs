const inputCidade = document.getElementById("inputCidade");
const inputCidadeId = document.getElementById("cidadeId");

let cidadesMap = []; 

inputCidade.addEventListener("input", function () {
    const termoDigitado = this.value;

    if (termoDigitado.length < 2) return;

    buscarCidades(BASEURL, termoDigitado);
});

function buscarCidades(BASEURL, nomeCidade) {
    const xhttp = new XMLHttpRequest();

    xhttp.onload = function () {
        const listaCidades = JSON.parse(xhttp.responseText);
        const datalist = document.getElementById("listaCidades");
        datalist.innerHTML = "";

        cidadesMap = listaCidades; // Salva a lista para comparar depois

        listaCidades.forEach(cidade => {
            const option = document.createElement("option");
            option.value = `${cidade.nome} - ${cidade.uf}`;
            option.dataset.id = cidade.id; 
            datalist.appendChild(option);
        });
    };

    const url = `${BASEURL}/controller/CidadeController.php?action=listarPorNome&nome=${encodeURIComponent(nomeCidade)}`;
    xhttp.open("GET", url);
    xhttp.send();
}

inputCidade.addEventListener("input", function () {
    const valorInput = this.value.trim();

    const cidadeSelecionada = cidadesMap.find(cidade => `${cidade.nome} - ${cidade.uf}` === valorInput);

    if (cidadeSelecionada) {
        inputCidadeId.value = cidadeSelecionada.id;
    } else {
        inputCidadeId.value = "";
    }
});


