<main role="main" class="main-content">
        <div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-12">
              <div class="row">
                <!-- Small table -->
                <div class="col-md-12 mt-2">
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="h4 mb-1">Lista de Agentes</h2>
                    </div>
                </div>
                  
                  <div class="card shadow">
                    <div class="card-body">
                    <?php if (empty($agents)): ?>
                      <p> Nenhuma agente</p>
                    <?php else: ?>
                    <table class="table datatables" id="dataTable-1">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Agente</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Saldo</th>
                                <th scope="col">Data</th>
                                <th scope="col">Status</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($agents as $a): ?>
                            <tr>
                                <td><?php echo $a->id; ?></td>
                                <td><?php echo $a->agentCode; ?></td>
                                <td><?php echo $a->email; ?></td>
                                <td><?php echo $a->balance; ?></td>
                      
                                <td><?php echo $this->engine->time($a->createdAt); ?></td>
                                <td>
                                <?php if ($a->status == 1): ?>
                                    <span class="badge badge-success">ATIVO</span>
                                <?php elseif ($a->status == 2): ?>
                                    <span class="badge badge-danger">BLOQUEADO</span> 
                                <?php else: ?>
                                    <span class="badge badge-warning">DELETADO</span> 
                                <?php endif; ?>

                                </td>
                                <td></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php endif; ?>                
                    </div>
                  </div>
                </div> <!-- customized table -->
              </div> <!-- end section -->      
        </div> <!-- .container-fluid -->
      </main>

