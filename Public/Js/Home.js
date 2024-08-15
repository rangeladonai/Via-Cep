function requestViaCepApi()
{
    let cep = document.getElementById("cep").value;
    let url = `https://viacep.com.br/ws/${cep}/json/`;
    fetch(url)
    .then((response) => response.json())
    .then((data) => {
        fillCepDataFields(data);
    })
    .catch((error) => {
        console.error(error);
    });
}

function setCookieCep()
{
    let cep = document.getElementById("cep").value;
    document.getElementById('form').submit();
}

function fillCepDataFields(obj)
{
    console.log(obj)
    document.getElementById("Localidade").value = obj.localidade;
    document.getElementById("UF").value = obj.uf;
    document.getElementById("Bairro").value = obj.bairro;
    document.getElementById("Logradouro").value = obj.logradouro;
}