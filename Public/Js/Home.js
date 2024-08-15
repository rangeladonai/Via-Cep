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

function clearCepDataFields()
{
    document.getElementById("Localidade").value = "";
    document.getElementById("UF").value = "";
    document.getElementById("Bairro").value = "";
    document.getElementById("Logradouro").value = "";
}