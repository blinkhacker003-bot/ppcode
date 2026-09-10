<main role="main" class="main-content">
    <div class="container-fluid">
         <?php if ($this->session->flashdata('error')): ?> 	
            <div class="text-center">
              <div class="alert alert-danger" role="alert"> <?= $this->session->flashdata('error'); ?> </div>
            </div>
          <?php endif; ?>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row">
                    <!-- Small table -->
                    <div class="col-md-12 mt-2">
                        <div class="row align-items-center">
                            <div class="col text-center">
                                <h2 class="h4 mb-1">Recargas</h2>
                                <p class="mb-3">Escolha um valor para recarregar</p>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                        <?php 
                            foreach ($values as $value): 
                                $total_credit = ($value * 100) / $discount_rate;
                                $discount = ($discount_rate / 100) * $total_credit;
                            ?>
                                <div class="col-md-4 mb-4">
                                    <div class="card shadow text-center">
                                        <div class="card-body">
                                            <h5 class="card-title">Recarga de R$<?php echo number_format($value, 2, ',', '.'); ?></h5>
                                            <p class="card-text">Clique no botão abaixo para recarregar seu saldo em R$<?php echo number_format($value, 2, ',', '.'); ?>.</p>
                                            <p class="card-text"><b>Total de crédito:</b> R$<?php echo number_format($total_credit, 2, ',', '.'); ?></p>
                                            <p class="card-text"><b>GGR pago:</b> R$<?php echo number_format($discount, 2, ',', '.'); ?> (<?php echo $discount_rate; ?>%)</p>
                                            <a href="<?php echo site_url('recharge/pay/' . $value); ?>" class="btn btn-primary btn-lg">Recarregar Agora</a>
                                            <br><small>** Recarga feita por pix! </small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div> <!-- end col-md-12 -->
                </div> <!-- end row -->
            </div> <!-- end col-12 -->
        </div> <!-- end row justify-content-center -->
    </div> <!-- end container-fluid -->
</main>
