<?include ("curl_simpleDom.php");?>

<!DOCTYPE html>
<html>
        <head>
            <title>Raspagem - IMA</title>
            <meta charset='utf-8'>
            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
            <meta name='viewport' content='width=device-width, initial-scale=1'>
            <link rel="shortcut icon" type="image/x-icon" href="imagens/materialize.ico">

            <!-- STYLESHEETS -->
            <!--CDN - MATERIALIZE-->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
            <!--CDN - MATERIALIZE-->

            <!-- STYLESHEET LOCAL -->
            <link rel="stylesheet" href="main.css">   
            <!-- STYLESHEET LOCAL -->

            <!-- ICONS MATERIALIZE-->
            <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
            <!-- ICONS MATERIALIZE-->

            <!--SCRIPTS-->
            <!-- CDN - JQUERY -->
            <script  src="https://code.jquery.com/jquery-3.4.1.min.js"  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="  crossorigin="anonymous"></script>
            <!-- CDN - JQUERY -->

            <!--CDN - CHART.JS-->
            <script src='https://cdn.jsdelivr.net/npm/chart.js@2.8.0/dist/Chart.min.js'></script>
            <!--CDN - CHART.JS-->

            <!--CDN - MATERIALIZE-->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
            <!--CDN - MATERIALIZE-->
            
            <!--CND - FONTAWESOME -->
            <script src="https://kit.fontawesome.com/cc8d33db1c.js"></script>
            <!--CND - FONTAWESOME -->

            <!--ARQUIVO JS LOCAL-->
            <script src='main.js'></script>
            <!--ARQUIVO JS LOCAL-->
        </head>
        <body class="bodyMaterialize">
            <!-- Cabeçalho do formulario -->
            <div class="borderCabecalhoMaterialize" id="divScrapIMAMaterialize">
                <div class="row">
                    <div class='col s12 m8 l8'>
                            <h5>&nbsp;Raspagem de dados - IMA</h5>    
                    </div>
                    <div class='col s12 m4 l4 right-align'>
                        <div class="row">
                                <button class="btnFramework" id="btnBootstrap" onclick="location.href='index.php'"></button>
                                <button class="btnFramework" id="btnSemantic" onclick="location.href='indexSemantic.php'"></button>
                                <button class="btnFramework" id="btnMaterialize" onclick="location.href='indexMaterialize.php'"></button>
                        </div>  
                    </div>
                </div>
                <hr>
                <form action="indexMaterialize.php" method="post">
                    <div class="row">
                    </select>
                        
                        <div class="input-field col s12 m4 l4">
                            Município
                            <select class="browser-default" name="municipioID" id="formMunicipio"></select>
                        </div>
                        <div class="input-field col s12 m4 l4">
                            Balneário
                            <select class="browser-default" name="localID" id="formLocal"></select>
                        </div>
                        <div class="input-field col s12 m4 l4">
                            Ano
                            <select class="browser-default" name="ano" id="formAno"></select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                        <button class="btn waves-effect waves-light" type="submit" name="action">Pesquisar
                            <i class="material-icons right">search</i>
                        </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Painel principal onde serão inseridos os graficos -->
            <div id="painelGraficos">
                <?php 
                    //Verificar se há um html carregado antes de prosseguir
                    if (!empty($html)){
                        //Indice para contagem de tabelas
                        $iTables = 1;
                        //Laço para pegar todas as tabelas
                        foreach ($html->find('.table') as $tables) {  
                            //Condição para ignorar a primeira tabela do laço pois não será utilizada
                            if($iTables!=1){        
                                //Condição para verificar se é uma tabela par ou impar, para saber como tratar os dados dela.
                                if ($iTables%2) {
                                    //Se for uma tabela par, serão carregados em variaveis os dados vindos das colunas ecoli, data, ar, agua e condicao
                                    $ecolis = array();
                                    foreach ($tables->find('td.ecoli') as $ecoli) {
                                        $ecolis [] = $ecoli->innertext;                 
                                    }
                    
                                    $datas = array();
                                    foreach ($tables->find('td.data') as $data) {
                                        $datas [] = $data->innertext;                 
                                    }
                    
                                    $tempAr = array();
                                    $iTempAr = 0;
                                    foreach ($tables->find('td.ar') as $ar) {          
                                        $pedacos = explode(" ", $ar->innertext);                
                                        $tempAr[$iTempAr]=$pedacos[0];
                                        $iTempAr++;    
                                    }
                    
                                    $tempAgua = array();
                                    $iTempAgua = 0;
                                    foreach ($tables->find('td.agua') as $agua) {          
                                        $pedacos = explode(" ", $agua->innertext);                
                                        $tempAgua[$iTempAgua]=$pedacos[0];
                                        $iTempAgua++;                   
                                    }
                    
                                    $somaProprio=0;
                                    $somaImproprio=0;
                                    foreach ($tables->find('td.condicao') as $condicao){                                       
                                        if (($condicao->innertext) == "PRÓPRIA"){
                                            $somaProprio++;
                                        }else{
                                            $somaImproprio++;
                                        }
                                    }
                                    //Define um indicador unico para cada grupo de graficos
                                    $codBody = ($iTables-2);
                                    ?>
                                            <div class="collapsible-body">
                                                <div class="row">
                                                        <div class="col s12 m6 l6">
                                                            <canvas id="ecoli<? echo $codBody ?>"></canvas>
                                                        </div>

                                                        <div class="col s12 m6 l6">
                                                            <canvas id="ar_agua<? echo $codBody ?>"></canvas>
                                                        </div>

                                                        <div class="col s12 m6 l6">
                                                            <canvas id="condicaoAgua<? echo $codBody ?>"></canvas>
                                                        </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>

                                <br>
                                <script>
                                var canvasEcoli<? echo $codBody ?> = document.getElementById("ecoli<? echo $codBody ?>");
                                var dataEcoli<? echo $codBody ?> = {
                                    labels: [
                                            <?php for($i=0; $i<sizeof($datas); $i++){
                                                echo "\"".$datas[$i]."\",";
                                            };?>
                                            ],
                                    datasets: [
                                        {
                                            label: "E.Coli NMP*/100ml",
                                            backgroundColor: "rgba(52,58,64,0.2)",
                                            borderColor: "rgba(52,58,64,1)",
                                            borderWidth: 3,
                                            data: [
                                                    <?php for($i=0; $i<sizeof($ecolis); $i++){
                                                        echo $ecolis[$i].",";
                                                    }?>
                                                ]
                                        }
                                    ]
                                };

                                var chartEcoli<? echo $codBody ?> = Chart.Line(canvasEcoli<? echo $codBody ?>,{
                                    data:dataEcoli<? echo $codBody ?>,
                                    options: {
                                    responsive: true,
                                    legend: {
                                            labels: {
                                                usePointStyle: true
                                            }
                                        },
                                    tooltips: {
                                        mode: 'index',
                                        intersect: false,
                                    },
                                    hover: {
                                        mode: 'nearest',
                                        intersect: true
                                    },
                                }
                                });

                                var canvasArAgua<? echo $codBody ?> = document.getElementById("ar_agua<? echo $codBody ?>");

                                var dataArAgua<? echo $codBody ?> = {
                                    labels: [                                            
                                            <?php for($i=0; $i<sizeof($datas); $i++){
                                                echo "\"".$datas[$i]."\",";
                                            }?>
                                            ],
                                    datasets: [
                                        {
                                            label: "Agua (Cº)",
                                            backgroundColor: "rgba(52,58,64,0.2)",
                                            borderColor: "rgba(52,58,64,1)",
                                            borderWidth: 3,
                                            data: [
                                                    <?php for($i=0; $i<sizeof($tempAgua); $i++){
                                                        echo $tempAgua[$i].",";
                                                    }?>
                                                  ]   
                                        },
                                        {
                                            label: "Ar (Cº)",
                                            backgroundColor: "rgba(52,58,64,0.2)",
                                            borderColor: "rgba(52,58,64,1)",
                                            borderWidth: 3,
                                            pointStyle: 'rectRot',
                                            pointRadius: 5,
                                            pointBorderColor: 'rgb(0, 0, 0)',
                                            data: [
                                                    <?php for($i=0; $i<sizeof($tempAr); $i++){
                                                        echo $tempAr[$i].",";
                                                    }?>
                                                  ]   
                                        }
                                    ]
                                };

                                var chartArAgua<? echo $codBody ?> = Chart.Line(canvasArAgua<? echo $codBody ?>,{
                                    data:dataArAgua<? echo $codBody ?>,
                                    options: {
                                    responsive: true,
                                    legend: {
                                            labels: {
                                                usePointStyle: true
                                            },
                                            display: true                        
                                        },
                                    tooltips: {
                                        mode: 'index',
                                        intersect: false,
                                    },
                                    hover: {
                                        mode: 'nearest',
                                        intersect: true
                                    },
                                }
                                });

                                var canvasCondicaoAgua<? echo $codBody ?> = document.getElementById("condicaoAgua<? echo $codBody ?>").getContext("2d");

                                var configCondicaoAgua<? echo $codBody ?> = {
                                    type: 'pie',
                                    data: {
                                        datasets: [{
                                            data: [<? echo $somaProprio.",".$somaImproprio ?>],
                                            backgroundColor: [
                                                "rgba(52,58,64,0.2)",
                                                "rgba(52,58,64,0.8)",
                                            ]					
                                        }],
                                        labels: [
                                            'Próprio',
                                            'Impróprio'
                                        ]
                                    },
                                    options: {
                                        responsive: true
                                    }
                                };

                                new Chart(canvasCondicaoAgua<? echo $codBody ?>, configCondicaoAgua<? echo $codBody ?>);
                       
                                </script>

                                <?php
                                }else{
                                    $titulos = array();
                                    $iTitulos = 0;
                                    foreach ($tables->find('label') as $label) {
                                        $pedacos = explode(":</b> ", $label->innertext);                
                                        $titulos[$iTitulos]=$pedacos[1];
                                        $iTitulos++;
                                    }

                                    if ($iTables==2){
                                        ?>
                                        <hr>
                                        <div class="row" id="infoPesquisada">
                                            
                                            <div class="col s12 m4 l4">
                                                <div class="card">
                                                    <div class="card-header">Município</div>
                                                    <div class="card-body">
                                                        <p><?php echo $titulos[0]?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col s12 m4 l4">
                                                <div class="card">
                                                        <div class="card-header">Balneário</div>
                                                        <div class="card-body">
                                                            <p><?php echo $titulos[1]?></p>
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="col s12 m4 l4">
                                                <div class="card">
                                                        <div class="card-header">Ano</div>
                                                        <div class="card-body">
                                                            <p><?php echo $_POST["ano"]?></p>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>

                                    <?}?>
                                    <ul class="collapsible">
                                        <li>
                                        <div class="collapsible-header">
                                            <i class="material-icons">place</i>Ponto de coleta: <? echo $titulos[2]?> | Localização: <?echo $titulos[3]?>
                                        </div>
                                <?php                                        
                                }                                
                            }
                            $iTables++;
                        }
                    }
                ?>
        <script>
            $("#formMunicipio").change(function (event) {
                getLocaisHistorico($("#formMunicipio").val());
            });

            $(document).ready(function(){
                $('select').formSelect();
                $('.collapsible').collapsible();
            });
        </script>
        
    </body>
</html>