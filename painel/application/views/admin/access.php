<main role="main" class="main-content">
        <div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-12">
              <div class="row">
                <!-- Small table -->
                <div class="col-md-12 mt-2">
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="h4 mb-1">Lista de Acessos</h2>
                    </div>
                </div>
                  
                  <div class="card shadow">
                    <div class="card-body">
                    <?php if (empty($access)): ?>
                      <p> Nenhuma acesso</p>
                    <?php else: ?>
                    <table class="table datatables" id="dataTable-1">
                        <thead>
                            <tr>
                                <th scope="col">Data</th>
                                <th scope="col">Agente</th>
                                <th scope="col">IP</th>
                                <th scope="col">Cidade e Região</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($access as $a): ?>
                            <tr>
                                <td><?php echo $this->engine->time($a->createdAt); ?></td>
                                <td><?php echo $a->agentCode; ?></td>
                                <td><?php echo $a->ip; ?></td>
                                <td><?php echo $a->city; ?></td>
                                
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

