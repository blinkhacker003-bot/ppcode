<main role="main" class="main-content">
        <div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-12">
              <div class="row">
                <!-- Small table -->
                <div class="col-md-12 mt-2">
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="h4 mb-1">Central de notificações</h2>
                        <p class="mb-3">Lista de notificações</p>
                    </div>
                </div>
                  <div class="card shadow">
                    <div class="card-body">
                    <?php if (empty($popup)): ?>
                    <?php else: ?>
                    <table class="table datatables" id="dataTable-1">
                        <thead>
                            <tr>
                                <th scope="col">id</th>
                                <th scope="col">Conteúdo</th>
                                <th scope="col">Status</th>
                                <th scope="col"></th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($popup as $a): ?>
                            <tr>
                                <td><?php echo $a->id; ?></td>
                                <td><?php echo $a->content; ?></td>
                                <td><?php if ($a->status == 0): ?>
                                    <span class="badge badge-danger">Ativado</span>
                                <?php else: ?>
                                    <span class="badge badge-light">Desativado</span> 
                                <?php endif; ?></td>
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