<?php 
    if (!empty($_POST)){
    include ("simple_html_dom.php");

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, "https://balneabilidade.ima.sc.gov.br/relatorio/historico");
    curl_setopt($curl, CURLOPT_POSTFIELDS, "municipioID=".$_POST["municipioID"]."&localID=".$_POST["localID"]."&ano=".$_POST["ano"]."&redirect=true");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    
    $respostaHTML = curl_exec($curl);
    
    curl_close($curl);
    
    $html = new simple_html_dom();

    $html->load($respostaHTML); 
}
?>