$(document).ready(function(){
    getAnos();
    getMunicipiosHistorico();

   });

//  $.ajaxSetup({
//     xhrFields: {
//         withCredentials: true
//      }
//   });

 function getMunicipiosHistorico() {
    $("#formMunicipio").html("");
    $.post('getMunicipios.php',
            function (data, status) {
                
                if (status == "success") {
                    var municipios = jQuery.parseJSON(data);
                    for (var i in municipios) {
                        var option = document.createElement("option");
                        option.setAttribute("value", municipios[i].CODIGO);
                        option.appendChild(document.createTextNode(municipios[i].DESCRICAO));
                        $("#formMunicipio").append(option);
                    }
                    getLocaisHistorico($("#formMunicipio").val());
                }
            });
    getLocaisHistorico(0);
}

function getAnos() {
    $("#formAno").html("");
    $.post('getAno.php',
            function (data, status) {
                if (status == "success") {
                    var anos = jQuery.parseJSON(data);
                    for (var i in anos) {
                        var option = document.createElement("option");
                        option.setAttribute("value", anos[i].ANO);
                        option.appendChild(document.createTextNode(anos[i].ANO));
                        $("#formAno").append(option);
                    }
                }
            });
}


function getLocaisHistorico(municipioID) {
    $("#formLocal").html("");
    $.post('getLocais.php', {municipioID: municipioID},
            function (data, status) {
                if (status == "success") {
                    var locais = jQuery.parseJSON(data);
                    for (var i in locais) {

                        var option = document.createElement("option");
                        var valor = locais[i].CODIGO;
                        valor += "#" + locais[i].LATITUDE;
                        valor += "#" + locais[i].LONGITUDE;
                        option.setAttribute("value", valor);
                        option.appendChild(document.createTextNode(locais[i].BALNEARIO));

                        $("#formLocal").append(option);

                    }

                }
            });
}

