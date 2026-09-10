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
                        <div class="col-md-12 mt-2">
                            <div class="card shadow text-center">
                                <div class="card-body">
                                    <h5 class="card-title">Pagamento via PIX</h5>
                                    <h5 class="card-title">Recarga de R$<?php echo number_format($valor, 2, ',', '.'); ?></h5>
                                    <p class="card-text">Aponte a câmera do seu celular para realizar o pagamento do QR Code abaixo:</p>
                                    <?php if (isset($qrCodeImage)): ?>
                                        <img src="<?php echo $qrCodeImage; ?>" alt="QR Code" class="img-fluid col-3 mt-2 mb-2">
                                    <?php else: ?>
                                        <p>Erro ao carregar o QR Code. Por favor, tente novamente.</p>
                                    <?php endif; ?>
                                        <br>
                                    <?php if ($status == "COMPLETED"): ?>
                                        <div class="alert alert-success mt-4" role="alert">
                                            Recarga realizada com sucesso! O seu saldo será recarregado em breve.
                                         </div>
                                    <?php else: ?>
                                        <div class="form-group mt-3 mb-2">
                                                <label for="exampleInputEmail1"> Código Pix: </label>
                                                <form class="my-form">
                                                    <input type="text" class="form-control" id="qrCodeTexto" value="<?php echo $codeCopyAndPaste; ?>">
                                                </form>
                                        </div>
                                        <button id="copiarBotao" class="btn btn-primary btn-block btn-lg mt-2">Copiar código de pagamento/chave</button>
                                        
                                        <br>
                                        
                                        <p class="card-text mt-4">Fazer a confirmação do pagamento.</p>
                                        <a href="<?php echo site_url('recharge/check/' . $id); ?>" class="btn btn-primary btn-block btn-lg">Verificar Pagamento</a>
                                    <?php endif; ?>
                                    
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row -->
                </div> <!-- end col-12 -->
            </div> <!-- end row justify-content-center -->
        </div> <!-- end container-fluid -->
    </main>
    <script>
    function copyToClipboard() {
            let textoCopiado = document.getElementById("qrCodeTexto");
            textoCopiado.select();
            textoCopiado.setSelectionRange(0, 99999)
            document.execCommand("copy");
            alert('Código de pagamento/chave copiado com sucesso!');
    }

    document.getElementById('copiarBotao').addEventListener('click', copyToClipboard);
    </script>