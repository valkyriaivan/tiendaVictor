
    <div class="container">

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Your Website 2014</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/js/bootstrap.min.js"></script>
    <?php if (isset($bottomScripts)): ?>
      <?php foreach ($bottomScripts as $script): ?>
        <script src="/js/<?php echo $script;?>"></script>
      <?php endforeach; ?>
    <?php endif; ?>
    <script src="/js/modalIframeProducto.js"></script>

  </body>

</html>
