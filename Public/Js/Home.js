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
        clearCepDataFields();
        console.error(error);
        alert("Zip Code data not found!");
    });
}

function submit()
{
    let form = new FormData(document.forms[0]);
    fetch('/save/cep/json',{
        method: 'POST',
        body: form
    })
    .then((response) => response.json())
    .then(data => {
        document.getElementById('alert-final').innerHTML = data.msg;
        document.getElementById('alert-final').className = data.class;
    });
}

function fillCepDataFields(obj)
{
    document.getElementById("Localidade").value = obj.localidade;
    document.getElementById("UF").value = obj.uf;
    document.getElementById("Bairro").value = obj.bairro;
    document.getElementById("Logradouro").value = obj.logradouro;
}

function clearCepDataFields()
{
    document.getElementById("Localidade").value = "";
    document.getElementById("UF").value = "";
    document.getElementById("Bairro").value = "";
    document.getElementById("Logradouro").value = "";
}