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
                <?php if ($this->session->flashdata('error')): ?> 	
                    <div class="text-center">
                        <div class="alert alert-danger" role="alert"> <?= $this->session->flashdata('error'); ?> </div>
                    </div>
                <?php endif; ?>

                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="h4 mb-1"><?php echo $agent->agentName; ?></h2>
                        <p class="mb-3">Editar agente <?php echo $agent->agentName; ?></p>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-lg btn-danger" data-toggle="modal" data-target="#saldo"></span>Adicionar Saldo </button>
                    </div>
                </div>
                  
                <form method="post" action="<?php echo site_url('agents/update/'. $agent->id); ?>">
                  <div class="card shadow">
                    <div class="card-body">
                    <div class="row">
                    <div class="col-md-6">
                      <div class="form-group mb-3">
                      <label for="ipAddress">E-mail</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?php echo $agent->email; ?>">
                      </div>
                      <div class="form-group mb-3">
                        <label for="ipAddress">Saldo</label>
                        <input type="text" class="form-control" value="<?php echo $agent->balance; ?>" readonly>
                      </div>
                      <div class="form-group mb-3">
                        <label for="example-helping">GGR %</label>
                        <input type="text" class="form-control" name="percent" value="<?php echo $agent->percent; ?>">
                      </div>
                    
                    </div> <!-- /.col -->
                    <div class="col-md-6">
                      <div class="form-group mb-3">
                        <label for="example-helping">Status</label>
                        <select class="form-control" id="status" name="status">
                          <option value="1">ATIVO</option>
                          <option value="2">BLOQUEADO</option>
                        </select>
                      </div>

                      <div class="form-group mb-3">
                        <label for="example-helping">Tipo de conta</label>
                        <select class="form-control" id="agentType" name="agentType">
                          <option value="1">GERENTE</option>
                          <option value="2">API</option>
                          <option value="3">REVENDEDOR</option>
                        </select>
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
      <!-- Modal -->
        <div class="modal fade" id="saldo" tabindex="-1" role="dialog" aria-labelledby="saldo" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="saldoLongTitle">Adicionar saldo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form method="post" action="<?php echo site_url('agents/addSaldo/'. $agent->id); ?>">
                    <div class="form-group mb-3">
                        <label for="ipAddress">Saldo</label>
                        <input type="text" class="form-control" name="newbalance" value="0">
                      </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-lg btn-block">Salvar</button>
                </form>
            </div>
            </div>
        </div>
        </div>