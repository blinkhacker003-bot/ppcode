      <main role="main" class="main-content">
        <div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-12">
              <div class="row">
                <!-- Small table -->
                <div class="col-md-12 mt-2">
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="h4 mb-1">Central de Recargas</h2>
                        <p class="mb-3">Lista de Recargas</p>
                    </div>
                </div>
                  
                  <div class="card shadow">
                    <div class="card-body">
                    <?php if (empty($recharge)): ?>
                      <p> Nenhuma recarga até o momento </p>
                    <?php else: ?>
                    <table class="table datatables" id="dataTable-1">
                        <thead>
                            <tr>
                                <th scope="col">Data</th>
                                <th scope="col">Agente</th>
                                <th scope="col">Valor</th>
                                <th scope="col">Transação</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recharge as $a): ?>
                            <tr>
                                <td><?php echo $this->engine->time($a->createdAt); ?></td>
                                <td><?php echo $a->agentCode; ?></td>
                                <td><?php echo $a->valor; ?></td>
                                <td><?php echo $a->transaction_id; ?></td>
                                <td><?php if ($a->status == 'COMPLETED'): ?>
                                    <span class="badge badge-success">COMPLETED</span>
                                <?php else: ?>
                                    <span class="badge badge-light"><?php echo $a->status; ?></span> 
                                <?php endif; ?></td>
                                
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

