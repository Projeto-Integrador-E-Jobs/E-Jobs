function aplicarMascara() {
    const tipo = parseInt(document.getElementById("selPapel").value);
    const input = document.getElementById("txtDocumento");
    if (tipo === 1) {
        Inputmask("999.999.999-99").mask(input);
        input.disabled = false;
    } else if (tipo === 3) {
        Inputmask("99.999.999/9999-99").mask(input);
        input.disabled = false;
    } else {
        input.disabled = true;
    }
}

function aplicarMascaraTelefone() {
    const input = document.getElementById("txtTelefone");
    Inputmask("(99)99999-9999").mask(input);
}

document.addEventListener("DOMContentLoaded", function() {
    // Aplica a máscara ao carregar a página, caso o tipo de usuário já esteja selecionado
    aplicarMascara();
    aplicarMascaraTelefone();
    // Garante que a máscara seja atualizada ao mudar o tipo de usuário
    document.getElementById("selPapel").addEventListener("change", aplicarMascara);
});