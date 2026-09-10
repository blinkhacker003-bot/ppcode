<main role="main" class="main-content">
        <div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-12">
              <div class="row align-items-center mt-4">
                <div class="col">
                  <h2 class="h5 page-title">Dashboard</h2>
                  <p class="text-muted">Bem vindo de volta!</p>
                </div>
              </div>
              <div class="card shadow my-4">
                <div class="card-body">
                  <div class="row align-items-center my-4">
                    <div class="col-md-6">
                      <div class="mx-4">
                        <strong class="mb-0 text-uppercase text-muted">Saldo do agente</strong><br />
                        <h3>R$ <?php echo $myData->balance; ?></h3>
                        <p class="text-muted">Saldo atual do agente.</p>
                      </div>
                      <div class="row align-items-center">
                        <div class="col-6">
                          <?php if($this->session->userdata('agent')->agentType == 3): ?>
                            <div class="p-4">
                              <p class="small text-uppercase text-muted mb-0">Agentes</p>
                              <span class="h2 mb-0"><?php echo $allAgents; ?></span>
                            </div>
                          <?php elseif($this->session->userdata('agent')->agentType == 2): ?>     
                            <div class="p-4">
                              <p class="small text-uppercase text-muted mb-0">Usuários</p>
                              <span class="h2 mb-0"><?php echo $allUsers; ?></span>
                              <p class="small mb-0"><span class="text-muted ml-1">Cadastrados</span></span>
                            </div>
                          <?php endif; ?>
                        </div>
                        <div class="col-6">
                          <div class="p-4">
                            <p class="small text-uppercase text-muted mb-0">GGR</p>
                            <span class="text-success fe-12">%</span>
                            <span class="h2 mb-0"><?php echo $this->session->userdata('agent')->percent; ?></span>
                            <p class="small mb-0"><span class="text-muted ml-1">GGR Inicial</span></span>
                          </div>
                        </div>
                      </div>
                      <div class="row align-items-center">
                        <div class="col-6">
                          <div class="p-4">
                            <p class="small text-uppercase text-muted mb-0">Ganho</p>
                            <span class="h2 mb-0">R$ <?php echo $winloss->credit; ?></span>
                            <p class="small mb-0">
                            <span class="fe fe-arrow-up text-success fe-12"></span>
                              <span class="text-muted ml-1">0%</span>
                            </p>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="p-4">
                            <p class="small text-uppercase text-muted mb-0">Perca</p>
                            <span class="h2 mb-0">R$ <?php echo $winloss->debit; ?></span>
                            <p class="small mb-0">
                              <span class="fe fe-arrow-down text-danger fe-12"></span>
                              <span class="text-muted ml-1">0%</span>
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mr-4">
                       
                      </div>
                    </div> <!-- .col-md-8 -->
                  </div> <!-- end section -->
                </div> <!-- .card-body -->
              </div> <!-- .card -->

        </div> <!-- .container-fluid -->

      </main> <!-- main -->