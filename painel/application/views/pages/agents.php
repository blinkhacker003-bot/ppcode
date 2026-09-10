<main role="main" class="main-content">
        <div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-12">
              <div class="row">
                <!-- Small table -->
                <div class="col-md-12 mt-2">
                <?php if ($this->session->flashdata('error')): ?> 	
                  <div class="text-center">
                    <div class="alert alert-danger" role="alert"> <?= $this->session->flashdata('error'); ?> </div>
                  </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('success')): ?> 	
                  <div class="text-center">
                    <div class="alert alert-success" role="alert"> <?= $this->session->flashdata('success'); ?> </div>
                  </div>
                <?php endif; ?>
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="h4 mb-1">Agentes</h2>
                        <p class="mb-3">Lista de agentes</p>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#novo"></span>Criar Agente </button>
                    </div>
                </div>
                  
                  <div class="card shadow">
                    <div class="card-body">
                    <?php if (empty($myAgents)): ?>
                      <p>Ainda não tem nenhum agente cadastrado!<p>
                    <?php else: ?>
                    <table class="table datatables" id="dataTable-1">
                        <thead>
                            <tr>
                                <th scope="col">Código do agente</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Saldo</th>
                                <th scope="col">GGR %</th>
                                <th scope="col">Status</th>
                                <th scope="col">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($myAgents as $a): ?>
                            <tr>
                                <td><?php echo $a->agentCode; ?></td>
                                <td><?php echo $a->agentName; ?></td>
                                <td>
                                <?php if ($a->agentType == 1): ?>
                                    <span class="badge badge-danger">GERENTE</span>
                                <?php elseif ($a->agentType == 2): ?>
                                    <span class="badge badge-light">API</span> 
                                <?php elseif ($a->agentType == 3): ?>
                                    <span class="badge badge-warning">REVENDEDOR</span> 
                                <?php endif; ?>
                                </td>
                                <td><?php echo $a->balance; ?></td>
                                <td><?php echo $a->percent; ?></td>
                                <td>
                                <?php if ($a->status == 1): ?>
                                    <span class="badge badge-success">ATIVO</span>
                                <?php elseif ($a->status == 2): ?>
                                    <span class="badge badge-danger">BLOQUEADO</span> 
                                <?php else: ?>
                                    <span class="badge badge-warning">DELETADO</span> 
                                <?php endif; ?>

                                </td>
                                <td>
                                    <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="text-muted sr-only">Ação</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="<?= base_url('agents/view/'.$a->id); ?>">EDITAR</a>
                                        <a class="dropdown-item" href="<?= base_url('agents/delete/'.$a->id); ?>">DELETAR</a>
                                    </div>
                                </td>
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




      <!-- Modal novo -->
<div class="modal fade show" id="novo" tabindex="-1" role="dialog" aria-labelledby="novoLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="novoLabel">Novo Agente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
      <form class="col mx-auto" method="post" action="<?php echo site_url('agents/new'); ?>">
          <div class="form-group">
            <label for="inputEmail4">E-mail</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="E-mail">
          </div>
          <div class="form-group">
            <label for="inputEmail4">Código de Agente</label>
            <input type="text" class="form-control" name="agentCode" id="agentCode" placeholder="Escolha um código de agente">
          </div>
          <div class="row mb-4">
            <div class="col-md-6">
              <div class="form-group">
                <label for="inputPassword5">Senha</label>
                <input type="password" class="form-control" id="inputPassword5">
              </div>
              <div class="form-group">
                <label for="inputPassword6">Confirmar Senha</label>
                <input type="password" class="form-control" id="password" name="password">
              </div>
            </div>
            <div class="col-md-6">
                <p class="mb-2">Requisitos de senha</p>
                <p class="small text-muted mb-2"> Para criar sua senha, você deve atender a todos os seguintes requisitos: </p>
                <ul class="small text-muted pl-4 mb-0">
                    <li> Mínimo de 8 caracteres </li>
                    <li>Pelo menos um caractere especial</li>
                    <li>Pelo menos um número</li>
                    <li>Não pode ser igual a uma senha anterior </li>
                </ul>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-lg btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-lg btn-primary">Salvar</button>  </form>
      </div>
    </div>
  </div>
</div>