<section class="financiamento py-5">
    <div class="container">
        <div class="titulo-secao">
            <h2>Pré-simulação de financiamento</h2>
            <p>Preencha os dados abaixo para solicitar uma pré-simulação de financiamento do veículo de seu interesse.</p>
        </div>

        <form id="formPreSimulacao" class="form-financiamento">
            <fieldset>
                <legend>Dados do veículo</legend>
                <div class="row g-3">
                    <div class="col-md-3"><label>Marca (*)<input name="marca" required></label></div>
                    <div class="col-md-3"><label>Modelo (*)<input name="modelo" required></label></div>
                    <div class="col-md-3"><label>Ano (*)<input name="ano" inputmode="numeric" required></label></div>
                    <div class="col-md-3"><label>Cor (*)<input name="cor" required></label></div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Dados para pré-simulação</legend>
                <div class="row g-3">
                    <div class="col-md-4"><label>CPF (*)<input name="cpf" data-mask="cpf" inputmode="numeric" required></label></div>
                    <div class="col-md-4"><label>Data de nascimento (*)<input type="date" name="nascimento" required></label></div>
                    <div class="col-md-4"><label>Possui CNH? (*)<select name="cnh" required><option value="">Selecione</option><option>Sim</option><option>Não</option></select></label></div>
                    <div class="col-md-6"><label>Valor de entrada (*)<input name="entrada" data-mask="money" inputmode="numeric" placeholder="R$" required></label></div>
                </div>
            </fieldset>

            <div class="pre-simulacao-aviso">
                <h3>Importante</h3>
                <p>Esta é uma pré-simulação de financiamento realizada com base nas informações fornecidas.</p>
                <p>O resultado da pré-simulação não representa aprovação definitiva de crédito. As condições de financiamento, taxas, prazo e aprovação estão sujeitas aos critérios da instituição financeira.</p>
            </div>

            <div class="pre-simulacao-aviso">
                <h3>Quer simular outro CPF?</h3>
                <p>Para realizar uma nova simulação para o mesmo veículo utilizando outro CPF, basta enviar novamente este formulário com os dados do novo solicitante.</p>
                <p>Cada envio será considerado uma solicitação independente.</p>
            </div>

            <button type="submit" class="btn btn-whatsapp">Solicitar pré-simulação</button>
        </form>
    </div>
</section>

<script>
(function () {
    const form = document.getElementById('formPreSimulacao');
    const phone = '5514997533055';

    function digits(value) {
        return value.replace(/\D/g, '');
    }

    function mask(input) {
        let value = digits(input.value);
        if (input.dataset.mask === 'cpf') {
            value = value.replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        }
        if (input.dataset.mask === 'money' && value) {
            value = 'R$ ' + (Number(value) / 100).toLocaleString('pt-BR', { minimumFractionDigits: 2 });
        }
        input.value = value;
    }

    form.querySelectorAll('[data-mask]').forEach(input => input.addEventListener('input', () => mask(input)));
    form.addEventListener('submit', event => {
        event.preventDefault();
        const data = new FormData(form);
        const labels = {
            marca: 'Marca', modelo: 'Modelo', ano: 'Ano', cor: 'Cor', cpf: 'CPF',
            nascimento: 'Data de nascimento', cnh: 'Possui CNH?', entrada: 'Valor de entrada'
        };
        let message = 'Olá! Gostaria de solicitar uma pré-simulação de financiamento.\\n\\n';
        Object.keys(labels).forEach(key => {
            const value = data.get(key);
            if (value) message += '*' + labels[key] + ':* ' + value + '\\n';
        });
        window.open('https://wa.me/' + phone + '?text=' + encodeURIComponent(message), '_blank');
    });
}());
</script>
