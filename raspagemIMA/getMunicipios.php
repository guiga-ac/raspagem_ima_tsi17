<?php 
//Verifica se há post antes de prosseguir
    //Inclui a biblioteca simple_html_dom, utilizada para converter a resposta do curl e disponibilizar função de find
    include ("simple_html_dom.php");

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, "https://balneabilidade.ima.sc.gov.br/municipio/getMunicipios");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    
    $respostaHTML = curl_exec($curl);
    
    curl_close($curl);
    
//    $html = new simple_html_dom();

//  $html->load($respostaHTML); 
echo ($respostaHTML);

?>