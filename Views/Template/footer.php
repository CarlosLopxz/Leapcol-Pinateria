        </div>

        <!-- Offcanvas Toggler -->
        <button class="d2c_offcanvas_toggle position-fixed top-50 start-0 translate-middle-y d-block d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#d2c_sidebar" aria-controls="d2c_sidebar">
            <i class="far fa-hand-point-right"></i>
        </button>
        <!-- End:Offcanvas Toggler -->

        <!-- Initial Javascript -->
        <script src="<?= BASE_URL ?>lib/jQuery/jquery-3.5.1.min.js"></script>
        <script src="<?= BASE_URL ?>lib/bootstrap_5/bootstrap.bundle.min.js"></script>

        <!-- Chart Config -->
        <script src="<?= BASE_URL ?>lib/apexcharts/apexcharts.min.js"></script>
        <?php if($data['page_name'] !== 'dashboard'): ?>
        <script src="<?= BASE_URL ?>assets/js/chart/dashboardPageChart.js"></script>
        <?php endif; ?>
        <!-- custom js -->
        <script src="<?= BASE_URL ?>assets/js/main.js"></script>
        
        <style>
        .loading-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .loading-modal.show {
            opacity: 1;
            visibility: visible;
        }
        
        .loading-modal.hide {
            opacity: 0;
            visibility: hidden;
        }
        
        .loading-content {
            background: white;
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            width: 200px;
            height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        
        .d2c_theme_dark .loading-content {
            background: #292d38;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .d2c_theme_dark .loading-content p {
            color: #fff !important;
        }
        
        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
           
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .loading-content p {
            margin: 0;
            font-size: 16px;
            color: #333;
            font-weight: 500;
        }
        </style>
        
        <script>
        // Funciones para mostrar y ocultar el modal de carga
        const loadingModal = document.getElementById('loadingModal');
        
        function showLoading() {
            loadingModal.classList.remove('hide');
            loadingModal.classList.add('show');
        }
        
        function hideLoading() {
            loadingModal.classList.remove('show');
            loadingModal.classList.add('hide');
        }
        
        // Ocultar modal cuando la página termine de cargar completamente
        window.addEventListener('load', function() {
            hideLoading();
        });
        
        // También verificar si ya está cargada
        if (document.readyState === 'complete') {
            hideLoading();
        }
        
        // Función global para usar en formularios y peticiones AJAX
        window.showLoading = showLoading;
        window.hideLoading = hideLoading;
        </script>
    </body>
</html>