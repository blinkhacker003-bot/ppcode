<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row">
                    <!-- Small table -->
                    <div class="col-md-12 mt-2">
                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="text-center">
                                <div class="alert alert-success" role="alert"> <?= $this->session->flashdata('success'); ?> </div>
                            </div>
                        <?php endif; ?>
                        <div class="row align-items-center">
                            <div class="col">
                                <h2 class="h4 mb-1">Guia da API
                                    <?php if ($myData->apiType == 0): ?>
                                        <span class="badge badge-pill badge-primary">Seamless (Transparente)</span>
                                    <?php else: ?>
                                        <span class="badge badge-pill badge-warning">Wallet (Carteira)</span>
                                    <?php endif; ?>
                                </h2>
                                <p class="mb-3">Como utilizar a API</p>
                            </div>
                        </div>

                        <div class="card shadow">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm">
                                        <h5 class="mt-4">URL de Acesso</h5>
                                        <p>Todas as requisições devem ser enviadas para a seguinte URL:</p>
                                        <pre><code>https://api.expertsbet.online</code></pre>

                                        <h5 class="mt-4">Método de Requisição</h5>
                                        <p>Utilize o método HTTP POST para enviar as requisições à API.</p>

                                        <h5 class="mt-4">Corpo da Requisição</h5>
                                        <p>No corpo da requisição, envie os dados em formato JSON conforme o método escolhido. Abaixo estão os métodos disponíveis e seus respectivos formatos:</p>

                                        <br>
                                        <?php if ($myData->apiType == 0): ?>
    <p>Modo Seamless (Transparente): Neste modo, você só precisa fazer requisições POST nos seguintes métodos:</p>
    <div class="accordion w-100" id="accordionMethods">
        <!-- Acordeão para o método "Lançar o jogo" -->
        <div class="card shadow">
            <div class="card-header" id="headingLaunchGame">
                <a role="button" href="#collapseLaunchGame" data-toggle="collapse" data-target="#collapseLaunchGame" aria-expanded="true" aria-controls="collapseLaunchGame">
                    <strong>Lançar o jogo <span class="badge badge-pill badge-success">POST</span></strong>
                </a>
            </div>
            <div id="collapseLaunchGame" class="collapse" aria-labelledby="headingLaunchGame" data-parent="#accordionMethods">
                <div class="card-body">
                    Utilize este método para lançar um jogo específico para o usuário.
                    <p>Este método lança um jogo específico para o usuário.</p>
                                                                <pre>{
    "method": "game_launch",
    "agent_code": "<?php echo $myData->agentCode; ?>",
    "agent_token": "<?php echo $myData->token; ?>",
    "user_code": "test",
    "provider_code": "PGSOFT",
    "game_code": "fortune-tiger",
    "lang": "pt"
}</pre>
<p> Resposta: </p>
<pre>{
    "status": 1,
    "msg": "SUCCESS",
    "launch_url": "GAME URL"
}</pre>
                </div>
            </div>
        </div>

        <!-- Acordeão para o método "Obter lista de provedores" -->
        <div class="card shadow">
            <div class="card-header" id="headingProviderList">
                <a role="button" href="#collapseProviderList" data-toggle="collapse" data-target="#collapseProviderList" aria-expanded="false" aria-controls="collapseProviderList">
                    <strong>Obter lista de provedores <span class="badge badge-pill badge-success">POST</span></strong>
                </a>
            </div>
            <div id="collapseProviderList" class="collapse" aria-labelledby="headingProviderList" data-parent="#accordionMethods">
                <div class="card-body">
                    Este método retorna uma lista de todos os provedores de jogos disponíveis.
                    <pre>{
    "method": "provider_list",
    "agent_code": "<?php echo $myData->agentCode; ?>",
    "agent_token": "<?php echo $myData->token; ?>"
}</pre>
<p> Resposta: </p>
<pre>{
    "status": 1,
    "msg": "Lista de provedores",
    "providers": [
        {
            "id": "1",
            "code": "PGSOFT",
            "name": "PGSoft",
            "type": "slot",
            "status": "1"
        }
    ]
}</pre>
                </div>
            </div>
        </div>

        <!-- Acordeão para o método "Obter lista de jogos" -->
        <div class="card shadow">
            <div class="card-header" id="headingGameList">
                <a role="button" href="#collapseGameList" data-toggle="collapse" data-target="#collapseGameList" aria-expanded="false" aria-controls="collapseGameList">
                    <strong>Obter lista de jogos <span class="badge badge-pill badge-success">POST</span></strong>
                </a>
            </div>
            <div id="collapseGameList" class="collapse" aria-labelledby="headingGameList" data-parent="#accordionMethods">
                <div class="card-body">
                    Utilize este método para obter uma lista de jogos de um determinado provedor.
                    <pre>{
    "method": "game_list",
    "agent_code": "<?php echo $myData->agentCode; ?>",
    "agent_token": "<?php echo $myData->token; ?>",
    "provider_code": "PGSOFT"
}</pre>
<p> Resposta: </p>
<pre>{
    "status": 1,
    "msg": "SUCCESS",
    "games": [
        {
            "id": "1",
            "game_code": "diaochan",
            "game_name": "Honey Trap of Diao Chan",
            "banner": "https://resource.fdsigaming.com/thumbnail/slot/pgsoft/11309.png",
            "status": "1",
            "provider": "PGSOFT"
        }
      ]
}</pre>
                </div>
            </div>
        </div>
    </div>
    <br>
    <p>Importante: Neste modo, vamos fazer POST na URL configurada nas configurações da API.</p>
    <p>Sua URL de callback: <?php echo $myData->siteEndPoint; ?></p>
    
    <div class="accordion w-100" id="accordionMethods">
    <div class="card shadow">
        <div class="card-header" id="headingUserBalance">
            <a role="button" href="#collapseUserBalance" data-toggle="collapse" data-target="#collapseUserBalance" aria-expanded="false" aria-controls="collapseUserBalance">
                <strong>Obter saldo do usuário <span class="badge badge-pill badge-warning">GET</span></strong>
            </a>
        </div>
        <div id="collapseUserBalance" class="collapse" aria-labelledby="headingUserBalance" data-parent="#accordionMethods">
            <div class="card-body">
                Vamos fazer POST na sua URL <?php echo $myData->siteEndPoint; ?> para obter o saldo do usuário.

                O corpo da requisição será um JSON com os seguintes campos:
                <pre>{
    "method": "user_balance",
    "agent_code": "<?php echo $myData->agentCode; ?>",
    "agent_secret": "<?php echo $myData->secretKey; ?>",
    "user_code": "test"
}</pre>
                <p> Resposta esperada:</p>
                <pre>{
    "status": 1,
    "user_balance": 1000
}</pre>
                <p>Se a resposta for diferente do esperado, pode ocorrer do saldo ficar zerado no jogo!</p>
            </div>
        </div>
    </div>
     <!-- Novo acordeão -->
     <div class="card shadow">
        <div class="card-header" id="headingNovoAccordion">
            <a role="button" href="#collapseNovoAccordion" data-toggle="collapse" data-target="#collapseNovoAccordion" aria-expanded="false" aria-controls="collapseNovoAccordion">
                <strong>Transações da API <span class="badge badge-pill badge-warning">GET</span></strong>
            </a>
        </div>
        <div id="collapseNovoAccordion" class="collapse" aria-labelledby="headingNovoAccordion" data-parent="#accordionMethods">
            <div class="card-body">
            Vamos fazer POST na sua URL <?php echo $myData->siteEndPoint; ?> a cada transação efetuada nos jogos

            O corpo da requisição será um JSON com os seguintes campos:
            <pre> {
        "method": "transaction",
        "agent_code": "<?php echo $myData->agentCode; ?>",
        "agent_secret": "<?php echo $myData->secretKey; ?>",
        "agent_balance": 10000000,
        "user_code": "test",
        "user_balance": 99200,
        "game_type": "slot",
        "slot": {
            "provider_code": "PGSOFT",
            "game_code": "fortune-tiger",
            "type": "BASE",
            "bet_money": 1000,
            "win_money": 200,
            "txn_id": "MVGKE8FJE3838EFN378DF",
            "txn_type": "debit_credit" // or "debit" or "credit"
        }
    }</pre>
                <p> Resposta esperada:</p>
                <pre>{
    "status": 1,
    "user_balance": 1000
}</pre>
                <p>Se a resposta for diferente do esperado, pode ocorrer do saldo ficar zerado no jogo!</p>
            </div>
        </div>
    </div>
</div>
                                        <?php else: ?>
                                        <div class="accordion w-100" id="accordion1">

                                            <div class="container">
                                                <div id="accordion1">
                                                    <!-- Método 1 -->
                                                    <div class="card shadow">
                                                        <div class="card-header" id="heading1">
                                                            <a role="button" href="#collapse1" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                                                <strong>1. Criar novo usuário <span class="badge badge-pill badge-success">POST</span></strong>
                                                            </a>
                                                        </div>
                                                        <div id="collapse1" class="collapse" aria-labelledby="heading1" data-parent="#accordion1">
                                                            <div class="card-body">
                                                                <p>Este método é utilizado para criar um novo usuário no sistema.</p>
                                                                <pre>{
    "method": "user_create",
    "agent_code": "<?php echo $myData->agentCode; ?>",
    "agent_token": "<?php echo $myData->token; ?>",
    "user_code": "test" // exemplo de código de usuário
}</pre>
<p> Resposta: </p>
<pre>{
    "status": 1,
    "msg": "SUCCESS",
    "user_code": "test",
    "user_balance": 0
}</pre>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Método 2 -->
                                                    <div class="card shadow">
                                                        <div class="card-header" id="heading2">
                                                            <a role="button" href="#collapse2" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                                                <strong>2. Depositar saldo a usuário <span class="badge badge-pill badge-success">POST</span></strong>
                                                            </a>
                                                        </div>
                                                        <div id="collapse2" class="collapse" aria-labelledby="heading2" data-parent="#accordion1">
                                                            <div class="card-body">
                                                                <p>Este método permite depositar saldo na conta de um usuário.</p>
                                                                <pre>{
    "method": "user_deposit",
    "agent_code": "<?php echo $myData->agentCode; ?>",
    "agent_token": "<?php echo $myData->token; ?>",
    "user_code": "test",
    "amount": 10000
}</pre>
<p> Resposta: </p>
<pre>{
    "status": 1,
    "msg": "SUCCESS",
    "agent_balance": "100000",
    "user_balance": "10000"
}</pre>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Método 3 -->
                                                    <div class="card shadow">
                                                        <div class="card-header" id="heading3">
                                                            <a role="button" href="#collapse3" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                                                <strong>3. Retirar saldo de usuário <span class="badge badge-pill badge-success">POST</span></strong>
                                                            </a>
                                                        </div>
                                                        <div id="collapse3" class="collapse" aria-labelledby="heading3" data-parent="#accordion1">
                                                            <div class="card-body">
                                                                <p>Este método permite retirar saldo da conta de um usuário.</p>
                                                                <pre>{
    "method": "user_withdraw",
    "agent_code": "<?php echo $myData->agentCode; ?>",
    "agent_token": "<?php echo $myData->token; ?>",
    "user_code": "test",
    "amount": 10000
}</pre>
<p> Resposta: </p>
<pre>{
    "status": 1,
    "msg": "SUCCESS",
    "agent_balance": "110000",
    "user_balance": "0"
}</pre>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Método 4 -->
                                                    <div class="card shadow">
                                                        <div class="card-header" id="heading4">
                                                            <a role="button" href="#collapse4" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                                                <strong>4. Redefinir o saldo do usuário <span class="badge badge-pill badge-success">POST</span></strong>
                                                            </a>
                                                        </div>
                                                        <div id="collapse4" class="collapse" aria-labelledby="heading4" data-parent="#accordion1">
                                                            <div class="card-body">
                                                                <p>Este método redefine o saldo do usuário para zero.</p>
                                                                <pre>{
    "method": "user_withdraw_reset",
    "agent_code": "<?php echo $myData->agentCode; ?>",
    "agent_token": "<?php echo $myData->token; ?>",
    "user_code": "test"
}</pre>
<p> Resposta: </p>
<pre>{
    "status": 1,
    "msg": "SUCCESS",
    "agent_balance": "110000",
    "user_balance": "0"
}</pre>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Método 5 -->
                                                    <div class="card shadow">
                                                        <div class="card-header" id="heading5">
                                                            <a role="button" href="#collapse5" data-toggle="collapse" data-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                                                <strong>5. Lançar o jogo <span class="badge badge-pill badge-success">POST</span></strong>
                                                            </a>
                                                        </div>
                                                        <div id="collapse5" class="collapse" aria-labelledby="heading5" data-parent="#accordion1">
                                                            <div class="card-body">
                                                                <p>Este método lança um jogo específico para o usuário.</p>
                                                                <pre>{
    "method": "game_launch",
    "agent_code": "<?php echo $myData->agentCode; ?>",
    "agent_token": "<?php echo $myData->token; ?>",
    "user_code": "test",
    "provider_code": "PGSOFT",
    "game_code": "fortune-tiger",
    "lang": "pt"
}</pre>
<p> Resposta: </p>
<pre>{
    "status": 1,
    "msg": "SUCCESS",
    "launch_url": "GAME URL"
}</pre>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Método 6 -->
                                                    <div class="card shadow">
                                                        <div class="card-header" id="heading6">
                                                            <a role="button" href="#collapse6" data-toggle="collapse" data-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                                                                <strong>6. Obter saldo de agente e usuário <span class="badge badge-pill badge-success">POST</span></strong>
                                                            </a>
                                                        </div>
                                                        <div id="collapse6" class="collapse" aria-labelledby="heading6" data-parent="#accordion1">
                                                            <div class="card-body">
                                                                <p>Este método retorna o saldo do agente e do usuário.</p>
                                                                <pre>{
    "method": "money_info",
    "agent_code": "<?php echo $myData->agentCode; ?>",
    "agent_token": "<?php echo $myData->token; ?>",
    "user_code": "test" 
    
    ** Se retirar o user_code ele retorna somente o saldo do agente
}</pre>

<p> Resposta: </p>
<pre> {
        "status": 1,
        "msg": "SUCCESS",
        "agent": {
            "agent_code": "<?php echo $myData->agentCode; ?>",
            "balance": 1000000,
        }
    }
</pre>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Método 7 -->
                                                    <div class="card shadow">
                                                        <div class="card-header" id="heading7">
                                                            <a role="button" href="#collapse7" data-toggle="collapse" data-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                                                                <strong>7. Obter a lista de provedores <span class="badge badge-pill badge-success">POST</span></strong>
                                                            </a>
                                                        </div>
                                                        <div id="collapse7" class="collapse" aria-labelledby="heading7" data-parent="#accordion1">
                                                            <div class="card-body">
                                                                <p>Este método retorna uma lista de todos os provedores de jogos disponíveis.</p>
                                                                <pre>{
    "method": "provider_list",
    "agent_code": "<?php echo $myData->agentCode; ?>",
    "agent_token": "<?php echo $myData->token; ?>"
}</pre>
<p> Resposta: </p>
<pre>{
    "status": 1,
    "msg": "Lista de provedores",
    "providers": [
        {
            "id": "1",
            "code": "PGSOFT",
            "name": "PGSoft",
            "type": "slot",
            "status": "1"
        }
    ]
}</pre>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Método 8 -->
                                                    <div class="card shadow">
                                                        <div class="card-header" id="heading8">
                                                            <a role="button" href="#collapse8" data-toggle="collapse" data-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                                                                <strong>8. Obter lista de jogos <span class="badge badge-pill badge-success">POST</span></strong>
                                                            </a>
                                                        </div>
                                                        <div id="collapse8" class="collapse" aria-labelledby="heading8" data-parent="#accordion1">
                                                            <div class="card-body">
                                                                <p>Este método retorna uma lista de jogos de um determinado provedor.</p>
                                                                <pre>{
    "method": "game_list",
    "agent_code": "<?php echo $myData->agentCode; ?>",
    "agent_token": "<?php echo $myData->token; ?>",
    "provider_code": "PGSOFT"
}</pre>
<p> Resposta: </p>
<pre>{
    "status": 1,
    "msg": "SUCCESS",
    "games": [
        {
            "id": "1",
            "game_code": "diaochan",
            "game_name": "Honey Trap of Diao Chan",
            "banner": "https://resource.fdsigaming.com/thumbnail/slot/pgsoft/11309.png",
            "status": "1",
            "provider": "PGSOFT"
        }
      ]
}</pre>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Método 9 -->
<!-- Método 9 -->
<div class="card shadow">
    <div class="card-header" id="heading9">
        <a role="button" href="#collapse9" data-toggle="collapse" data-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
            <strong>9. Obter histórico do jogo <span class="badge badge-pill badge-success">POST</span></strong>
        </a>
    </div>
    <div id="collapse9" class="collapse" aria-labelledby="heading9" data-parent="#accordion1">
        <div class="card-body">
            <p>Este método retorna o histórico de jogos de um usuário em um determinado período.</p>
            <pre>
<code id="get-slot-game-history">
    {
        "method": "get_game_log",
        "agent_code": "<?php echo $myData->agentCode; ?>",
        "agent_token": "<?php echo $myData->token; ?>",
        "user_code": "test",
        "game_type": "slot",
        "start": "2022-09-29 00:00:00",
        "end": "2022-09-30 23:59:00",
        "page": 0,
        "perPage": 1000
    }
</code>
<p> Resposta: </p>
<code>
    {
        "status": 1,
        "total_count": 112,
        "page": 0,
        "perPage": 10,
        "slot": [
            {
                "history_id": 245,
                "agent_code": "<?php echo $myData->agentCode; ?>",
                "user_code": "test",
                "provider_code": "PGSOFT",
                "game_code": "forune-tiger",
                "type": "BASE",
                "bet_money": 0.40,
                "win_money": 250,
                "txn_id": "64a83f2fc597acc9004eec52c3f84c30",
                "txn_type": "credit",
                "user_after_balance": 1741708,
                "created_at": "2022-09-29T12:50:42.000Z"
            },

        ]
    }

<p> Resposta falha: </p>
    {
        "status": 0,
        "error": "INVALID_PARAMETER"
    }
</code>
            </pre>
        </div>
    </div>
</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> <!-- customized table -->
                </div> <!-- end section -->
            </div> <!-- .container-fluid -->
        </main>
