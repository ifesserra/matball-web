<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            
            <div class="div-perfil">
                <img src="../../<?php echo RestrictedSession::getUrlFoto() ?>" alt="Foto de Perfil"/>
                <label id="lblLogin"><?php echo RestrictedSession::getLogin() ?></label>
            </div>
            
            <ul class="sidebar-nav">
                <li>
                    <a href="../../index.php" class="menu-home">
                        <h4>
                            <i class="fa fa-home"></i>
                            HOME
                        </h4>
                    </a>
                </li>
                
                <?php
                    include "includes/menu-usuario.php"; 
                ?>
                
            </ul>
        </div>
        
        <!-- MODAL MESSAGE -->
        <div id="modalMessage" data-remodal-id="modalMessage">
            
            <button data-remodal-action="close" class="remodal-close"></button>
            <br>
            <div class="div-full aln-center message"></div>
            <br>
            <div class="div-full aln-right">
                <button data-remodal-action="confirm" class="btn btn-primary">Fechar</button>
            </div>
        </div>
        
        <!-- MODAL CONFIRM -->
        <div id="modalConfirm" data-remodal-id="modalConfirm">
            <div class="div-full aln-center message"></div>
            <br>
            <div class="div-full aln-right">
                <button data-remodal-action="confirm" class="btn btn-primary confirm-yes"></button>
                <button data-remodal-action="cancel" class="btn btn-default confirm-no"></button>
            </div>
        </div>
        
        <!-- MODAL LOAD -->
        <div id="modalLoad" data-remodal-id="modalLoad">
            <div class="div-full aln-center">
                <img src="../../assets/img/load.gif" alt=""/>
            </div>
            <div class="div-full aln-center message" style="margin-top: 20px;"></div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row" style="padding: 0;">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-xs-2 aln-left" style="padding: 0; margin: 0;">
                                <a id="menu-toggle"  href="#menu-toggle" class="btn btn-default" 
                                   style="padding-bottom: 3px;">
                                    <i class="fa fa-bars font-size-18"></i>
                                </a>
                            </div>
                            
                            <div class="col-xs-10 aln-right">
                                <img src="../../assets/img/logotipo_200.png" alt="MatBall Logotipo"/>
                            </div>
                        </div>