<main role="main" class="main-content">
        <div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-12">
              <div class="row">
                <!-- Small table -->
                <div class="col-md-12 mt-2">
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="h4 mb-1">Usuários</h2>
                        <p class="mb-3">Lista de usuários</p>
                    </div>
                </div>
                  
                  <div class="card shadow">
                    <div class="card-body">
                    <?php if (empty($myUsers)): ?>
                      <p>Ainda não tem nenhum usuário cadastrado!<p>
                    <?php else: ?>
                    <table class="table datatables" id="dataTable-1">
                        <thead>
                            <tr>
                                <th scope="col">Usuário</th>
                                <th scope="col">Saldo</th>
                                <th scope="col">Ganho</th>
                                <th scope="col">Perca</th>
                                <th scope="col">Criado em</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($myUsers as $a): ?>
                            <tr>
                                <td><?php echo $a->userCode; ?></td>
                                <td><?php echo $a->balance; ?></td>
                                <td><?php echo $a->totalCredit; ?></td>
                                <td><?php echo $a->totalDebit; ?></td>
                                <td><?php echo $this->engine->time($a->createdAt); ?></td>
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

