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
                        <h2 class="h4 mb-1">Configuração do perfil</h2>
                        <p class="mb-3">Edite e configure o seu perfil</p>
                    </div>
                </div>
                <form method="post" action="<?php echo site_url('config/update'); ?>">
                  <div class="card shadow">
                    <div class="card-body">
                    <div class="row">
                    <div class="col-md-6">
                      <div class="form-group mb-3">
                      <label for="ipAddress">E-mail</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?php echo $myData->email; ?>">
                      </div>
                      <div class="form-group mb-3">
                        <label for="ipAddress">Senha</label>
                        <input type="password" class="form-control" value="<?php echo $myData->password; ?>">
                      </div>
                      <div class="form-group mb-3">
                        <label for="example-helping">Confirmar Senha</label>
                        <input type="password" id="password" name="password" class="form-control" value="<?php echo $myData->password; ?>">
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
