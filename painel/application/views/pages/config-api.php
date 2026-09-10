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
                        <h2 class="h4 mb-1">Configuração da API</h2>
                        <p class="mb-3">Edite e configure o tipo de API</p>
                    </div>
                </div>
                <form method="post" action="<?php echo site_url('config/update'); ?>">
                  <div class="card shadow">
                    <div class="card-body">
                    <div class="row">
                    <div class="col-md-6">
                      <div class="form-group mb-3">
                        <label for="apiType">Tipo de API  </label>  
                        <?php if ($myData->apiType == 0): ?>
                            <span class="badge badge-pill badge-primary">Seamless (Transparente)</span>
                        <?php else: ?>
                            <span class="badge badge-pill badge-warning">Wallet (Carteira)</span>
                        <?php endif; ?>

                                            <select class="form-control" id="apiType" name="apiType" onchange="toggleEndPoint()">
                                                <?php if ($myData->apiType == 0): ?>
                                                    <option value="0" selected="selected">Seamless (Transparente)</option>
                                                    <option value="1" >Wallet (Carteira)</option>
                                                <?php else: ?>
                                                    <option value="0" >Seamless (Transparente)</option>
                                                    <option value="1" selected="selected">Wallet (Carteira)</option>
                                                <?php endif; ?>
                                                </select>
                      </div>
                      <div class="form-group mb-3">
                        <label for="ipAddress">IP do servidor</label>
                        <input type="text" id="ipAddress" name="ipAddress" class="form-control" placeholder="IP 127.0.0.1" value="<?php echo $myData->ipAddress; ?>">
                      </div>
                      <div class="form-group mb-3">
                        <label for="example-helping">API EndPoint</label>
                        <input type="text" id="siteEndPoint" name="siteEndPoint" class="form-control" placeholder="Ex: https://seubet.com/callback/" value="<?php echo $myData->siteEndPoint; ?>">
                      </div>
                    </div> <!-- /.col -->
                    <div class="col-md-6">
                      <div class="form-group mb-3">
                        <label for="example-email">Código do Agente</label>
                        <input type="text" class="form-control" value="<?php echo $myData->agentCode; ?>">
                      </div>
                      <div class="form-group mb-3">
                        <label for="example-email">Token</label>
                        <input type="text" class="form-control" value="<?php echo $myData->token; ?>">
                      </div>
                      <div class="form-group mb-3">
                        <label for="example-readonly">Secret-Key</label>
                        <input type="text" class="form-control" value="<?php echo $myData->secretKey; ?>">
                      </div>
                      <div class="form-group mb-3">
                      <label for="example-readonly"></label>
                        <button type="submit" class="form-control btn btg-lg btn-block btn-primary">Salvar</button>
                      </div>
                    </div>
                  </div>
                  
                    </div>
                  </div>
                </form>
                </div> <!-- customized table -->
              </div> <!-- end section -->      
        </div> <!-- .container-fluid -->
      </main>
