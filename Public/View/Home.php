<?php require './Templates/Header.php';?>
<body>
    <div class="container">
        <div class="glass-card">
            <h2 class="title text-center">Via-Cep</h2>
            <p class="subtitle text-center">Otimização Arquitetural com Design Patterns (Facade, Adapter & Strategy)</p>

            <form id="cepForm" onsubmit="event.preventDefault();">
                <div class="mb-4">
                    <label for="cep" class="form-label">Digite o CEP</label>
                    <div class="input-group">
                        <input type="text" class="form-control-custom" name="zipCode" id="cep" placeholder="Ex: 01001-000" maxlength="9" required>
                        <button type="button" class="btn-custom btn-search ms-2" id="btnSearch" onclick="requestViaCepApi();">
                            <span id="searchSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            Buscar
                        </button>
                    </div>
                </div>

                <!-- Card container para mostrar o resultado da busca -->
                <div class="address-result-card" id="resultCard">
                    <div class="address-grid">
                        <div>
                            <label class="form-label">Logradouro</label>
                            <input type="text" class="form-control-custom" name="place" id="Logradouro" readonly>
                        </div>
                        <div>
                            <label class="form-label">UF</label>
                            <input type="text" class="form-control-custom" name="state" id="UF" readonly>
                        </div>
                        <div class="full-width">
                            <label class="form-label">Bairro</label>
                            <input type="text" class="form-control-custom" name="neighborhood" id="Bairro" readonly>
                        </div>
                        <div class="full-width">
                            <label class="form-label">Localidade / Cidade</label>
                            <input type="text" class="form-control-custom" name="city" id="Localidade" readonly>
                        </div>
                    </div>

                    <hr class="my-4" style="border-color: var(--border-color);">

                    <!-- Padrão Strategy: Seleção da persistência -->
                    <label class="form-label">Estratégia de Armazenamento (Strategy)</label>
                    <div class="strategy-selector">
                        <label>
                            <input type="radio" name="strategy" value="json" class="strategy-radio" checked>
                            <div class="strategy-option">
                                <span class="strategy-title">Arquivo JSON</span>
                                <span class="strategy-desc">Salva em arquivo .json</span>
                            </div>
                        </label>
                        <label>
                            <input type="radio" name="strategy" value="sql" class="strategy-radio">
                            <div class="strategy-option">
                                <span class="strategy-title">Banco SQL</span>
                                <span class="strategy-desc">Persiste em banco SQL</span>
                            </div>
                        </label>
                    </div>

                    <button type="button" class="btn-custom btn-save" id="btnSave" onclick="submitAddress();">
                        <span id="saveSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        Salvar dados
                    </button>
                </div>
            </form>

            <div id="alert-final" role="alert"></div>

            <!-- Informações Acadêmicas do Estudante -->
            <div class="academic-info">
                <span><strong>Acadêmico:</strong> Rangel Adodnai Cabral Cidral (5714434)</span>
                <span><strong>Turma:</strong> FLD6780708CET</span>
                <span><strong>Professor Regente:</strong> Anderson Alves | <strong>Mediador:</strong> Jairo Prates</span>
            </div>
        </div>
    </div>
    
    <script src="../Js/Home.js"></script>
</body>
<?php require './Templates/Footer.php';?>