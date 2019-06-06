<?include ("curl_simpleDom.php");?>

<!DOCTYPE html>
<html>
        <head>
            <title>Raspagem - IMA</title>
            <meta charset='utf-8'>
            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
            <meta name='viewport' content='width=device-width, initial-scale=1'>
            <link rel="shortcut icon" type="image/x-icon" href="imagens/bootstrap.ico">

            <!-- STYLESHEETS -->
            <!--CDN - BOOTSTRAP 4-->
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
            <!--BOOTSTRAP 4-->

            <!-- STYLESHEET LOCAL -->
            <link rel="stylesheet" href="main.css">   
            <!-- STYLESHEET LOCAL -->

            <!--SCRIPTS-->
            <!-- CDN - JQUERY -->
            <script  src="https://code.jquery.com/jquery-3.4.1.min.js"  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="  crossorigin="anonymous"></script>
            <!-- CDN - JQUERY -->

            <!--CDN - CHART.JS-->
            <script src='https://cdn.jsdelivr.net/npm/chart.js@2.8.0/dist/Chart.min.js'></script>
            <!--CDN - CHART.JS-->

            <!--ARQUIVO JS LOCAL-->
            <script src='main.js'></script>
            <!--ARQUIVO JS LOCAL-->

            <!-- CDN - POPPER E BOOTSTRAP -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
            <!-- CDN - POPPER E BOOTSTRAP -->
           
            <!--CND - FONTAWESOME -->
            <script src="https://kit.fontawesome.com/cc8d33db1c.js"></script>
            <!--CND - FONTAWESOME -->
        </head>
        <body class="bodyBootstrap">
            <!-- Cabeçalho do formulario -->
            <div class="border border-dark rounded" id="divScrapIMABootstrap">
                <div style ="margin-right: -0px;" class="row">
                    <div class='col-sm-12 col-md-8 col-lg-8 d-flex align-items-center'>
                            <h3>&nbsp;Raspagem de dados -</h3><h3 style="color: rgba(52,58,64,0.8)">&nbsp;IMA</h3>
                    </div>
                    <div class='col-sm-12 col-md-4 col-lg-4 d-flex justify-content-sm-start justify-content-md-end justify-content-lg-end'>
                        <div class="row">
                             <div class="col-12 d-flex justify-content-center">
                                <a href="index.php" class="btnFramework" id="btnBootstrap"></a>
                                <a href="indexSemantic.php" class="btnFramework" id="btnSemantic"></a>
                                <a href="indexMaterialize.php" class="btnFramework" id="btnMaterialize"></a>
                            </div>
                        </div>  
                    </div>
                </div>
                <hr>
                <form action="index.php" method="post">
                    <div class="row">
                        <div class="input-group col-lg-4 col-md-12 col-sm-12">
                            <div class="input-group-prepend">
                                <label class="input-group-text rounded-left" for="formMunicipio">Município</label>
                            </div>
                            <select class="custom-select" name="municipioID" id="formMunicipio">
                            </select>
                        </div>
                        <br>
                        <div class="input-group col-lg-4 col-md-12 col-sm-12">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="formLocal">Local</label>
                            </div>
                            <select class="custom-select" name="localID" id="formLocal">
                            </select>
                        </div>
                        <br>
                        <div class="input-group col-lg-4 col-md-12 col-sm-12">
                            <div class="input-group-prepend">
                                <label class="input-group-text rounded-left" for="formAno">Ano</label>
                            </div>
                            <select class="custom-select" name="ano" id="formAno">
                            </select>
                        </div>
                        <br>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <input type="submit" name="submit" value="Pesquisar" class="btn btn-dark btn-block "/>
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

                                    <div id="cardBody<? echo $codBody ?>" class="collapse" aria-labelledby="cardHead<? echo $codBody ?>">
                                        <div class="card-body">

                                            <div class="row">
                                                <div class="col-lg-6 offset-lg-0 col-md-8 offset-md-2 col-sm-8 offset-sm-2">
                                                    <canvas id="ecoli<? echo $codBody ?>"></canvas>
                                                </div>

                                                <div class="col-lg-6 offset-lg-0 col-md-8 offset-md-2 col-sm-8 offset-sm-2">
                                                    <canvas id="ar_agua<? echo $codBody ?>"></canvas>
                                                </div>

                                                <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-8 offset-sm-2">
                                                    <canvas id="condicaoAgua<? echo $codBody ?>"></canvas>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

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
                                        <div class="row" id="infoPesquisada">
                                            
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <div class="card">
                                                    <div class="card-header">Município</div>
                                                    <div class="card-body">
                                                        <p class="card-text"><?php echo $titulos[0]?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="card">
                                                        <div class="card-header">Balneário</div>
                                                        <div class="card-body">
                                                            <p class="card-text"><?php echo $titulos[1]?></p>
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-12">
                                                <div class="card">
                                                        <div class="card-header">Ano</div>
                                                        <div class="card-body">
                                                            <p class="card-text"><?php echo $_POST["ano"]?></p>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <br>

                                    <?}?>

                                    <div class="card">
                                        <div class="btn btn-dark" id="cardHead<?echo ($iTables-1)?>" type="button" data-toggle="collapse" data-target="#cardBody<?echo ($iTables-1)?>" aria-expanded="true" aria-controls="cardBody<?echo ($iTables-1)?>">
                                            <div class="row justify-content-center">
                                                <div class="col-12 text-justify">
                                                    Ponto de coleta: <? echo $titulos[2]?> | Localização: <?echo $titulos[3]?>
                                                </div>
                                            </div>
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
        </script>
        
    </body>
</html>