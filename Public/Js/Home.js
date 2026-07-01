function requestViaCepApi() {
    let cepInput = document.getElementById("cep").value;
    let btn = document.getElementById("btnSearch");
    let spinner = document.getElementById("searchSpinner");
    let alertDiv = document.getElementById("alert-final");
    let resultCard = document.getElementById("resultCard");

    if (!cepInput) {
        showAlert("Digite um CEP válido.", "danger");
        return;
    }

    // Reset status
    alertDiv.innerHTML = "";
    btn.disabled = true;
    spinner.classList.remove("d-none");

    let formData = new FormData();
    formData.append("zipCode", cepInput);

    fetch('/search/cep', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        btn.disabled = false;
        spinner.classList.add("d-none");

        if (data.success) {
            fillCepDataFields(data.data);
            resultCard.classList.add("active");
        } else {
            clearCepDataFields();
            resultCard.classList.remove("active");
            showAlert(data.msg || "Erro ao consultar o CEP.", "danger");
        }
    })
    .catch(error => {
        btn.disabled = false;
        spinner.classList.add("d-none");
        clearCepDataFields();
        resultCard.classList.remove("active");
        console.error(error);
        showAlert("Erro de comunicação com o servidor.", "danger");
    });
}

function submitAddress() {
    let form = document.getElementById("cepForm");
    let btn = document.getElementById("btnSave");
    let spinner = document.getElementById("saveSpinner");
    
    btn.disabled = true;
    spinner.classList.remove("d-none");

    let formData = new FormData(form);
    
    // Captura a estratégia selecionada
    let selectedStrategy = document.querySelector('input[name="strategy"]:checked').value;
    formData.append("strategy", selectedStrategy);

    fetch('/save/cep', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        btn.disabled = false;
        spinner.classList.add("d-none");
        
        let type = data.success ? "success" : "danger";
        showAlert(data.msg, type);
    })
    .catch(error => {
        btn.disabled = false;
        spinner.classList.add("d-none");
        console.error(error);
        showAlert("Erro ao tentar salvar dados.", "danger");
    });
}

function fillCepDataFields(obj) {
    document.getElementById("Localidade").value = obj.city;
    document.getElementById("UF").value = obj.state;
    document.getElementById("Bairro").value = obj.neighborhood;
    document.getElementById("Logradouro").value = obj.place;
}

function clearCepDataFields() {
    document.getElementById("Localidade").value = "";
    document.getElementById("UF").value = "";
    document.getElementById("Bairro").value = "";
    document.getElementById("Logradouro").value = "";
}

function showAlert(message, type) {
    let alertDiv = document.getElementById("alert-final");
    alertDiv.innerHTML = `
        <div class="alert-custom alert-${type}">
            <span>${message}</span>
        </div>
    `;
}