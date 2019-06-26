// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Arial', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var ctx = document.getElementById("relatorio");
var ctxReserva = document.getElementById('relatorioReserva');
var ctxReservaCategoria = document.getElementById('relatorioReservaCategoria');
var ctxReservaEmprestimo = document.getElementById('relatorioEmprestimoCategoria');
var ctxEmprestimoReservaMes = document.getElementById('relatorioEmprestimoReservaMes');

var colorEmprestimo = ['#32e3ff', '#FFB399', '#FF33FF', '#FFFF99', '#00B3E6', 
                  '#E6B333', '#3366E6', '#999966', '#99FF99', '#B34D4D',
                  '#80B300', '#809900'];
var colorReserva = ['#08dd28', '#6680B3', '#66991A', 
                  '#FF99E6', '#CCFF1A', '#FF1A66', '#E6331A', '#33FFCC',
                  '#66994D', '#B366CC', '#4D8000', '#B33300'];
var colorReservaCategoria = ['#f7eb0e',
                  '#66664D', '#991AFF', '#E666FF', '#4DB3FF', '#1AB399',
                  '#E666B3', '#33991A'];             
var colorEmprestimoCategoria = ['#BE09E2', '#B3B31A', '#00E680', 
                  '#4D8066', '#809980', '#E6FF80', '#1AFF33', '#999933'];              
var colorReservaEmprestimoMes = ['#E22609', '#CCCC00', '#66E64D', '#4D80CC', '#9900B3', 
                  '#E64D66', '#4DB380', '#FF4D4D', '#99E6E6', '#6666FF'];

function geraGraficoPizza(elemento, labels, data, colorArray){
  var myPieChart = new Chart(elemento, {
    type: 'pie',
    data: {
      labels: labels,
      datasets: [{
        data: data,
        backgroundColor: colorArray.slice(0, data.length),
        hoverBorderColor: "rgba(234, 236, 244, 1)",
      }],
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        caretPadding: 10,
      },
      legend: {
        display: true
      },
      //Define o fundo recortado
      //cutoutPercentage: 80,
    },
  });
}

$(document).ready(function(){
  $.ajax({
    type: 'POST',
    url: 'retornaDados.php?metodo=emprestimo',
    success: function(data){
      geraGraficoPizza(ctx, data[0], data[1], colorEmprestimo);
    }
  });
});

$(document).ready(function(){
  $.ajax({
    type: 'POST',
    url: 'retornaDados.php?metodo=reserva',
    success: function(data){
      geraGraficoPizza(ctxReserva, data[0], data[1], colorReserva);
    }
  });
});

$(document).ready(function(){
  $.ajax({
    type: 'POST',
    url: 'retornaDados.php?metodo=reservaCategoria',
    success: function(data){
      geraGraficoPizza(ctxReservaCategoria, data[0], data[1], colorReservaCategoria);
    }
  });
});

$(document).ready(function(){
  $.ajax({
    type: 'POST',
    url: 'retornaDados.php?metodo=EmprestimoCategoria',
    success: function(data){
      geraGraficoPizza(ctxReservaEmprestimo, data[0], data[1], colorEmprestimoCategoria);
    }
  });
});

$(document).ready(function(){
  $.ajax({
    type: 'POST',
    url: 'retornaDados.php?metodo=EmprestimoReservaCategoria',
    success: function(data){
      geraGraficoPizza(ctxEmprestimoReservaMes, data[0], data[1], colorReservaEmprestimoMes);
    }
  });
});

function getPDF(){
  var indice = $('#grafico').val();

  var canvas = document.getElementById(arr[indice]);
  var context = canvas.getContext('2d');
  
  // only jpeg is supported by jsPDF
  var imgData = canvas.toDataURL("image/png", 1.0);
  var pdf = new jsPDF();

  pdf.text($('#grafico :selected').text(), 20, 10);

  pdf.addImage(imgData, 'PNG', 20, 15);

  
  pdf.save(arr[indice] + ".pdf");

}

var arr = ["relatorio", 'relatorioReserva', 'relatorioReservaCategoria', 'relatorioEmprestimoCategoria', 'relatorioEmprestimoReservaMes'];