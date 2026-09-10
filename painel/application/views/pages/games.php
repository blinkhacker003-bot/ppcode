<main role="main" class="main-content">
        <div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-12">
              <div class="row">
                <!-- Small table -->
                <div class="col-md-12 mt-2">
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="h4 mb-1">Jogos</h2>
                        <p class="mb-3">Lista de jogos</p>
                    </div>
                </div>
                  
                  <div class="card shadow">
                    <div class="card-body">
                    <?php if (empty($game)): ?>
                      <p>Ainda não tem nenhum cadastrado!<p>
                    <?php else: ?>
                    <table class="table datatables" id="dataTable-1">
                        <thead>
                            <tr>
                                <th scope="col-1"></th>
                                <th scope="col-7">Nome</th>
                                <th scope="col-2">Codigo</th>
                                <th scope="col-2">Provedora</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($game as $a): ?>
                            <tr>
                                <td><img src="<?php echo $a->banner; ?>" alt="<?php echo $a->game_name; ?>" class="img-fluid rounded mx-auto d-block" width="150" height="150"> </td>
                                <td><?php echo $a->game_name; ?></td>
                                <td><?php echo $a->game_code; ?></td>
                                <td><?php echo $a->provider; ?></td>
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

