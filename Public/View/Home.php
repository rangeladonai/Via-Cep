<?php require './Templates/Header.php';?>
<body>
    <div class="container">
        <form action="/save/cep/json" id="form" method="post">
            <h2>Via-Cep</h2>
            <input type="text" name="zipCode" id="cep" style="align-content: center;" maxlength="9">
            <br>
            <button class="btn btn-primary" onclick="event.preventDefault();requestViaCepApi();" style="align-content: center;">Buscar</button>
            <table>
                <tbody>
                    <td>
                        <input type="text" name="city" id="Localidade" placeholder="Localidade" readonly>
                        <input type="text" name="state" id="UF" placeholder="UF" readonly>
                        <input type="text" name="neighborhood" id="Bairro" placeholder="Bairro" readonly>
                        <input type="text" name="place" id="Logradouro" placeholder="Logradouro" readonly>
                    </td>
                </tbody>
            </table>
            <button type="button" class="btn btn-success" onclick="event.preventDefault();submit();">Salvar dados</button>
            <?php if (!empty($msg)): ?>
            <div class="alert alert-success" id="alert-final" role="alert"><?=$msg?></div>
            <?php endif; ?>
        </form>
    </div>
    <script src="./Js/Home.js"></script>
</body>
<?php require './Templates/Footer.php';?>