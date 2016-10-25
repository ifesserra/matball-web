<?php include "./includes/page-header.php" ?>
<?php include "./includes/page-middle.php" ?>

<link href="../../assets/external/data-tables/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="../../assets/external/data-tables-responsive/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>

<style>

</style>

<div class="name-page">Detalhes do Grupo</div>

<div class="row">

    <div class="col-xs-12 aln-right margin-bottom-15">
        <a href="convidar.php?id=<?php echo($_GET["id"]); ?>" class="btn btn-primary">
            <i class="fa fa-user"></i>
            <strong>Convidar usuário</strong>
        </a>
    </div>
    
    <div class="col-xs-12">
        <input id="usuario_id" type="hidden" value="<?php echo(RestrictedSession::getID()); ?>">
        <input id="grupo_id" type="hidden" value="<?php echo($_GET["id"]); ?>">
        
        <table id='tbUsers' class="table table-striped table-bordered dt-responsive" 
               cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th class="aln-center"><i class="fa fa-trophy"></i></th>
                    <th class="aln-center">Membro</th>
                    <th class="aln-center">Desde</th>
                    <th class="aln-center">Pontos</th>
                    <th class="aln-center">Dt. Pontos</th>
                    <th class="aln-center">Nível</th>
                    <th class="aln-center">Dt. Nível</th>
                    <th class="aln-center"></th>
                </tr>
            </thead>
            
            <tbody></tbody>

        </table>
    </div>
</div>

<script src="../../assets/external/data-tables/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="../../assets/external/data-tables/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
<script src="../../assets/external/data-tables-responsive/js/dataTables.responsive.min.js" type="text/javascript"></script>
<script src="../../assets/external/data-tables-responsive/js/responsive.bootstrap.min.js" type="text/javascript"></script>

<script src="../../assets/js/descriptions.js" type="text/javascript"></script>
<script src="../../assets/js/view-grupo.js" type="text/javascript"></script>

<?php include "./includes/page-footer.php" ?>