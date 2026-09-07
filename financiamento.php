<section class="financiamento py-5">
    <div class="container">
        <div class="titulo-secao">
            <h2>Ficha de financiamento</h2>
            <p>Preencha os dados abaixo para solicitar uma análise de crédito.</p>
        </div>

        <form id="formFinanciamento" class="form-financiamento">
            <fieldset>
                <legend>1. Dados pessoais</legend>
                <div class="row g-3">
                    <div class="col-md-6"><label>Nome completo (*)<input name="nome" required></label></div>
                    <div class="col-md-3"><label>CPF (*)<input name="cpf" data-mask="cpf" inputmode="numeric" required></label></div>
                    <div class="col-md-3"><label>RG (*)<input name="rg" required></label></div>
                    <div class="col-md-3"><label>Data de nascimento (*)<input type="date" name="nascimento" required></label></div>
                    <div class="col-md-5"><label>Nome completo da mãe (*)<input name="mae" required></label></div>
                    <div class="col-md-4"><label>Estado civil (*)<select name="estado_civil" required><option value="">Selecione</option><option>Solteiro(a)</option><option>Casado(a)</option><option>União estável</option><option>Divorciado(a)</option><option>Viúvo(a)</option></select></label></div>
                    <div class="col-md-4"><label>Celular/WhatsApp (*)<input name="celular" data-mask="phone" inputmode="numeric" required></label></div>
                    <div class="col-md-8"><label>E-mail (*)<input type="email" name="email" required></label></div>
                </div>
            </fieldset>

            <fieldset>
                <legend>2. Endereço</legend>
                <div class="row g-3">
                    <div class="col-md-3"><label>CEP (*)<input name="cep" data-mask="cep" inputmode="numeric" required></label></div>
                    <div class="col-md-7"><label>Endereço (*)<input name="endereco" required></label></div>
                    <div class="col-md-2"><label>Número (*)<input name="numero" required></label></div>
                    <div class="col-md-4"><label>Complemento<input name="complemento"></label></div>
                    <div class="col-md-4"><label>Bairro (*)<input name="bairro" required></label></div>
                    <div class="col-md-4"><label>Cidade (*)<input name="cidade" required></label></div>
                    <div class="col-md-4"><label>Estado (*)<select name="estado" required><option value="">Selecione</option><?php foreach (['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'] as $uf): ?><option><?= $uf ?></option><?php endforeach; ?></select></label></div>
                    <div class="col-md-4"><label>Tipo de residência (*)<select name="residencia" required><option value="">Selecione</option><option>Própria</option><option>Alugada</option><option>Cedida</option><option>Financiada</option></select></label></div>
                    <div class="col-md-4"><label>Tempo de residência (*)<input name="tempo_residencia" required></label></div>
                </div>
            </fieldset>

            <fieldset>
                <legend>3. Dados profissionais</legend>
                <div class="row g-3">
                    <div class="col-md-5"><label>Situação profissional (*)<select name="situacao" required><option value="">Selecione</option><option>CLT</option><option>Autônomo(a)</option><option>Empresário(a)</option><option>Funcionário(a) público(a)</option><option>Profissional liberal</option><option>Aposentado(a)/Pensionista</option><option>Outro</option></select></label></div>
                    <div class="col-md-7"><label>Profissão/Ocupação (*)<input name="profissao" required></label></div>
                    <div class="col-md-6"><label>Nome da empresa<input name="empresa"></label></div>
                    <div class="col-md-3"><label>CNPJ da empresa<input name="cnpj" inputmode="numeric"></label></div>
                    <div class="col-md-3"><label>Tempo de atividade/emprego (*)<input name="tempo_emprego" required></label></div>
                    <div class="col-md-4"><label>Renda mensal aproximada (*)<input name="renda" data-mask="money" inputmode="numeric" required></label></div>
                </div>
            </fieldset>

            <fieldset>
                <legend>4. Dados do financiamento</legend>
                <div class="row g-3">
                    <div class="col-md-6"><label>Veículo de interesse (*)<input name="veiculo" required></label></div>
                    <div class="col-md-3"><label>Ano do veículo (*)<input name="ano" inputmode="numeric" required></label></div>
                    <div class="col-md-3"><label>Valor do veículo (*)<input name="valor_veiculo" data-mask="money" inputmode="numeric" required></label></div>
                    <div class="col-md-4"><label>Valor disponível para entrada (*)<input name="entrada" data-mask="money" inputmode="numeric" required></label></div>
                    <div class="col-md-4"><label>Possui veículo para troca? (*)<select name="troca" id="possuiTroca" required><option value="">Selecione</option><option>Sim</option><option>Não</option></select></label></div>
                </div>
                <div id="dadosTroca" class="row g-3 mt-1" hidden>
                    <div class="col-md-4"><label>Marca/Modelo<input name="troca_modelo"></label></div>
                    <div class="col-md-2"><label>Ano<input name="troca_ano" inputmode="numeric"></label></div>
                    <div class="col-md-3"><label>Km<input name="troca_km" inputmode="numeric"></label></div>
                    <div class="col-md-3"><label>Valor aproximado<input name="troca_valor" data-mask="money" inputmode="numeric"></label></div>
                </div>
            </fieldset>

            <fieldset>
                <legend>6. Autorização</legend>
                <label class="check-aceite"><input type="checkbox" name="autorizacao" required> Autorizo a Faustino Motors Multimarcas a utilizar os dados informados para encaminhar minha solicitação às instituições financeiras parceiras, exclusivamente para análise de crédito e financiamento do veículo. (*)</label>
                <label class="check-aceite"><input type="checkbox" name="veracidade" required> Declaro que as informações fornecidas são verdadeiras e estou ciente de que o preenchimento não garante a aprovação do financiamento. (*)</label>
                <div class="alert alert-warning mt-3"><strong>Esclarecimento ao cliente:</strong> o envio representa uma solicitação de análise de crédito, não uma aprovação automática. As condições são definidas exclusivamente pela instituição financeira, conforme seus critérios.</div>
            </fieldset>

            <button type="submit" class="btn btn-whatsapp"><i class="bi bi-whatsapp"></i> Enviar ficha pelo WhatsApp</button>
        </form>
    </div>
</section>

<script>
(function () {
    const form = document.getElementById('formFinanciamento');
    const troca = document.getElementById('possuiTroca');
    const dadosTroca = document.getElementById('dadosTroca');
    const phone = '5514997533055';

    function digits(value) { return value.replace(/\D/g, ''); }
    function money(value) {
        const number = digits(value);
        return number ? 'R$ ' + (Number(number) / 100).toLocaleString('pt-BR', { minimumFractionDigits: 2 }) : '';
    }
    function mask(input) {
        const type = input.dataset.mask;
        let value = digits(input.value);
        if (type === 'cpf') value = value.replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        if (type === 'phone') value = value.replace(/^(\d{2})(\d)/, '($1) $2').replace(/(\d{5})(\d)/, '$1-$2');
        if (type === 'cep') value = value.replace(/^(\d{5})(\d)/, '$1-$2');
        input.value = type === 'money' ? money(input.value) : value;
    }
    form.querySelectorAll('[data-mask]').forEach(input => input.addEventListener('input', () => mask(input)));
    troca.addEventListener('change', () => {
        const enabled = troca.value === 'Sim';
        dadosTroca.hidden = !enabled;
        dadosTroca.querySelectorAll('input').forEach(input => { input.required = enabled; });
    });
    form.addEventListener('submit', event => {
        event.preventDefault();
        const data = new FormData(form);
        const labels = {
            nome: 'Nome completo', cpf: 'CPF', rg: 'RG', nascimento: 'Data de nascimento', mae: 'Nome da mãe',
            estado_civil: 'Estado civil', celular: 'Celular/WhatsApp', email: 'E-mail', cep: 'CEP', endereco: 'Endereço',
            numero: 'Número', complemento: 'Complemento', bairro: 'Bairro', cidade: 'Cidade', estado: 'Estado',
            residencia: 'Tipo de residência', tempo_residencia: 'Tempo de residência', situacao: 'Situação profissional',
            profissao: 'Profissão/Ocupação', empresa: 'Empresa', cnpj: 'CNPJ', tempo_emprego: 'Tempo de atividade/emprego',
            renda: 'Renda mensal', veiculo: 'Veículo de interesse', ano: 'Ano do veículo', valor_veiculo: 'Valor do veículo',
            entrada: 'Valor disponível para entrada', troca: 'Possui veículo para troca?', troca_modelo: 'Marca/Modelo da troca',
            troca_ano: 'Ano da troca', troca_km: 'Km da troca', troca_valor: 'Valor aproximado da troca'
        };
        let message = 'Olá! Gostaria de solicitar uma análise de financiamento.\n\n';
        Object.keys(labels).forEach(key => {
            const value = data.get(key);
            if (value) message += '*' + labels[key] + ':* ' + value + '\n';
        });
        message += '\n*Autorizações confirmadas:* Sim';
        window.open('https://wa.me/' + phone + '?text=' + encodeURIComponent(message), '_blank');
    });
}());
</script>
