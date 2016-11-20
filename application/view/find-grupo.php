<?php include "./includes/page-header.php" ?>
<?php include "./includes/page-middle.php" ?>

<link href="../../assets/external/data-tables/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="../../assets/external/data-tables-responsive/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>

<style>

</style>

<div class="name-page">Localizar Grupo</div>

<div class="row">
    
    <div class="col-xs-12">
        <input id="usuario_id" type="hidden"
               value="<?php echo RestrictedSession::getID() ?>">
        
        <table id='listTable' class="table table-striped table-bordered dt-responsive" 
               cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th class="aln-center">Nome</th>
                    <th class="aln-center">Tipo</th>
                    <th class="aln-center">Dono</th>
                    <th class="aln-center">Membros</th>
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
<script src="../../assets/js/find-grupo.js" type="text/javascript"></script>

<?php include "./includes/page-footer.php" ?>