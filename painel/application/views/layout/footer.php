</div> <!-- .wrapper -->
    <script src="<?= base_url(); ?>public/js/jquery.min.js"></script>
    <script src="<?= base_url(); ?>public/js/popper.min.js"></script>
    <script src="<?= base_url(); ?>public/js/moment.min.js"></script>
    <script src="<?= base_url(); ?>public/js/bootstrap.min.js"></script>
    <script src="<?= base_url(); ?>public/js/simplebar.min.js"></script>
    <script src='<?= base_url(); ?>public/js/daterangepicker.js'></script>
    <script src='<?= base_url(); ?>public/js/jquery.stickOnScroll.js'></script>
    <script src="<?= base_url(); ?>public/js/tinycolor-min.js"></script>
    <script src="<?= base_url(); ?>public/js/config.js"></script>
    <script src="<?= base_url(); ?>public/js/d3.min.js"></script>
    <script src="<?= base_url(); ?>public/js/topojson.min.js"></script>
    <script src="<?= base_url(); ?>public/js/datamaps.all.min.js"></script>
    <script src="<?= base_url(); ?>public/js/datamaps-zoomto.js"></script>
    <script src="<?= base_url(); ?>public/js/datamaps.custom.js"></script>
    <script src="<?= base_url(); ?>public/js/Chart.min.js"></script>
    <script>
      /* defind global options */
      Chart.defaults.global.defaultFontFamily = base.defaultFontFamily;
      Chart.defaults.global.defaultFontColor = colors.mutedColor;
    </script>
    <script src="<?= base_url(); ?>public/js/gauge.min.js"></script>
    <script src="<?= base_url(); ?>public/js/jquery.sparkline.min.js"></script>
    <script src="<?= base_url(); ?>public/js/apexcharts.min.js"></script>
    <script src="<?= base_url(); ?>public/js/apexcharts.custom.js"></script>
    <script src="<?= base_url(); ?>public/js/apps.js"></script>
    <script src='<?= base_url(); ?>public/js/jquery.dataTables.min.js'></script>
    <script src='<?= base_url(); ?>public/js/dataTables.bootstrap4.min.js'></script>
    <script>
                $(document).ready(function() {
                    $('#dataTable-1').DataTable({
                        language: {
                            url: 'https://cdn.datatables.net/plug-ins/2.0.4/i18n/pt-BR.json',
                        },
                        autoWidth: true,
                        order: [[0, 'desc']] // Ordenar pela primeira coluna (ID) em ordem decrescente
                    });
                });
    </script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];

      function gtag()
      {
        dataLayer.push(arguments);
      }
      gtag('js', new Date());
      gtag('config', 'UA-56159088-1');
    </script>
  </body>
</html>