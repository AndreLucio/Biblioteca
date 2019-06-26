function getPDF(){
    
    var urlParameter = $('#relatorioSelecionado').val();

	window.open('controllerPDF.php?pagina=' + urlParameter, '_blank');

}