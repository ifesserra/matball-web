<style>
    .shape-record{
        margin: 10px 0 15px 0;
        border-radius: 10px;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        box-shadow: 2px 2px 4px rgba(0, 0, 0, .5);
    }
    
    .shape-record[cor="azul"]{
        color: #fff;
        background-color: #198f90;
    }
    
    .shape-record[cor="vermelho"]{
        color: #fff;
        background-color: #f1594e;
    }
    
    .divTitulo{
        border-bottom: 3px solid #fff;
        font-size: 28px;
        font-weight: bold;
        padding-top: 5px;
    }
    
    .divSubTitulo{
        font-size: 25px;
        font-weight: bold;
        padding-top: 5px;
    }
    
    .divTituloMenor{
        border-bottom: 3px solid #fff;
        font-size: 20px;
        font-weight: bold;
        padding-top: 5px;
    }
    
    .divSubTituloMenor{
        font-size: 20px;
        font-weight: bold;
        padding-top: 5px;
        display: inline;
        width: 100%;
        text-align: center;
    }
    
    .divSubTituloMenor[tipo="acerto"]{
        border-right: 3px solid #fff;
    }
    
    .divSubTituloMenor[tipo="erro"]{
        color: #f1594e;
        padding-left: 5px;
    }
    
    .divSubSubTitulo{
        font-size: 15px;
        padding-bottom: 10px;
        font-style: italic;
    }
</style>

<div class="row">
    <div class="col-xs-12 aln-center">
        <div cor="vermelho" class="shape-record">
            <div class="divSubTitulo">
                Resultado Geral
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-4 aln-center">
        <div cor="azul" class="shape-record">
            <div class="divTitulo">
                Ranking
            </div>

            <div class="divSubTitulo">
                <?php echo $recordes->posicao ?>
            </div>
            
            <div class="divSubSubTitulo">
                <?php echo "de $recordes->total" ?>
            </div>
        </div>
    </div>
    
    <div class="col-xs-12 col-sm-4 aln-center">
        <div cor="azul" class="shape-record">
            <div class="divTitulo">
                Pontos
            </div>

            <div class="divSubTitulo">
                <?php echo $recordes->pontos_max ?>
            </div>
            
            <div class="divSubSubTitulo">
                <?php echo $recordes->dthr_pontos_max ?>
            </div>
        </div>
    </div>
    
    <div class="col-xs-12 col-sm-4 aln-center">
        <div cor="azul" class="shape-record">
            <div class="divTitulo">
                Nível
            </div>

            <div class="divSubTitulo">
                <?php echo $recordes->nivel_max ?>
            </div>
            
            <div class="divSubSubTitulo">
                <?php echo $recordes->dthr_nivel_max ?>
            </div>
        </div>
    </div>
</div>

<?php
if($diarioHoje != null){
?>
    <div class="row">
        <div class="col-xs-12 aln-center">
            <div cor="vermelho" class="shape-record">
                <div class="divSubTitulo">
                    Resultados de Hoje
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-4 aln-center">
            <div cor="azul" class="shape-record">
                <div class="divTitulo">
                    Ranking
                </div>

                <div class="divSubTitulo">
                    <?php echo $diarioHoje->posicao ?>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-4 aln-center">
            <div cor="azul" class="shape-record">
                <div class="divTitulo">
                    Pontos
                </div>

                <div class="divSubTitulo">
                    <?php echo $diarioHoje->pontos_max; ?>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-4 aln-center">
            <div cor="azul" class="shape-record">
                <div class="divTitulo">
                    Nível
                </div>

                <div class="divSubTitulo">
                    <?php echo $diarioHoje->nivel_max; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-3 aln-center">
            <div cor="azul" class="shape-record">
                <div class="divTituloMenor">
                    Adição
                </div>

                <div tipo="acerto" class="divSubTituloMenor">
                    <?php echo $diarioHoje->acertos_adicao; ?>
                </div>

                <div tipo="erro" class="divSubTituloMenor">
                    <?php echo $diarioHoje->erros_adicao; ?>
                </div>
            </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-3 aln-center">
            <div cor="azul" class="shape-record">
                <div class="divTituloMenor">
                    Subtração
                </div>

                <div tipo="acerto" class="divSubTituloMenor">
                    <?php echo $diarioHoje->acertos_subtracao; ?>
                </div>

                <div tipo="erro" class="divSubTituloMenor">
                    <?php echo $diarioHoje->erros_subtracao; ?>
                </div>
            </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-3 aln-center">
            <div cor="azul" class="shape-record">
                <div class="divTituloMenor">
                    Multiplicação
                </div>

                <div tipo="acerto" class="divSubTituloMenor">
                    <?php echo $diarioHoje->acertos_multiplicacao; ?>
                </div>

                <div tipo="erro" class="divSubTituloMenor">
                    <?php echo $diarioHoje->erros_multiplicacao; ?>
                </div>
            </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-3 aln-center">
            <div cor="azul" class="shape-record">
                <div class="divTituloMenor">
                    Divisão
                </div>

                <div tipo="acerto" class="divSubTituloMenor">
                    <?php echo $diarioHoje->acertos_divisao; ?>
                </div>

                <div tipo="erro" class="divSubTituloMenor">
                    <?php echo $diarioHoje->erros_divisao; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-4 aln-center">
            <div cor="azul" class="shape-record">
                <div class="divTitulo">
                    Quantidade de Jogos
                </div>

                <div class="divSubTitulo">
                    <?php echo $diarioHoje->qtd_jogos; ?>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-4 aln-center">
            <div cor="azul" class="shape-record">
                <div class="divTitulo">
                    Tempo Jogando
                </div>

                <div class="divSubTitulo">
                    <?php echo $diarioHoje->tempo_total; ?>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-4 aln-center">
            <div cor="azul" class="shape-record">
                <div class="divTitulo">
                    Último Jogo
                </div>

                <div class="divSubTitulo">
                    <?php echo $diarioHoje->hr_ultimo_jogo; ?>
                </div>
            </div>
        </div>
    </div>

<?php     
}