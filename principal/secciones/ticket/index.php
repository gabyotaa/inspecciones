  <!DOCTYPE HTML>
<html> 
<!--
APLICATION NAME: ELECTRONIC INSPECTION SYSTEM
DESCTIPTION: SISTEMA ELECTRONICO DE INSPECCIONES DE CAJAS, PLATAFORMAS, PIPAS Y TRACTORES
AUTHOR: BECERRA AVIÑA ISAAC ALI, MARTINEZ APARICIO JOSE LUIS, PADILLA GUTIERREZ ANA GABRIELA
CREATED: DICIEMBRE, 2016
-->
<head> 
  <title>Ticket</title> 
  <meta name="application-name" content="Electronic Inspection System">
  <meta name="description" content="Sistema de Inspecciones a Cajas,Plataformas, Pipas y Tractores">
  <meta name="author" content="BECERRA AVIÑA ISAAC ALI, MARTINEZ APARICIO JOSE LUIS, PADILLA GUTIERREZ ANA GABRIELA ">
  <meta name="revised" content="DICIEMBRE, 2016">
  <meta name="viewport" content="width=device-width, initial-scale=1"> 
  <meta charset="utf-8">
  <!--<meta http-equiv="Cache-control" content="no-cache">
  <meta http-equiv="Expires" content="-1">-->
  <meta http-equiv="Expires" content="0">
  <meta http-equiv="Last-Modified" content="0">
  <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <link href="../../css/font-awesome.css" rel="stylesheet">
  <link href="../../css/bootstrap.min.css" rel="stylesheet">  
  <link href="css/styles.css" rel="stylesheet">
  <script src="../../js/jquery-1.11.0.js"></script>
  <script src="../../js/printThis.js"></script>
  <script src="../../js/jquery.PrintArea.js"></script>
</head> 
<body> 
	<!--INICIO -->
  <div class="container">
          
          <div id="divGuardar" class="" style="margin-top:20px">
            <div class="row">
              <div class="col-md-12">
                <button id='btnGuardarIntercambio' type="button" class="btn btn-default btn-lg btn-block btnGuardarIntercambio"><i class=""></i>SAVE</button>
                
              </div>
              
            </div>
        </div>  
        <div id='divTicket' style="margin-top:20px; font-size:20px" class="panel panel-primary">
          <div id="divTicketHead" class="panel-heading text-right"><button id='btnImpTicket' class='btn btn-default' ><span class="glyphicon glyphicon-print" aria-hidden="true"></span></button></div>
          <div id="divTicketBody" class="panel-body"></div>
          
        </div>
        
        <!-- ALERTA -->
        <div id="divAlerta" align="center" class="alert alert-info">
           <p id="imgCargando"><img src="../../img/ajax-loader.gif" alt="Cargando..."/> Wait Please...</h4></p>
            <div class="row divMensaje" align="center">           
            </div>
            <div class="row divBtnSalir" align="center">
              <div class="col-md-12">
                <button id='btnSalAutomatica' type="button" class="btn btn-default btn-lg btn-block btnSalAutomatica" hidden>THIS INSPECTION'S DEPARTURE</button> 
                <button type="button" id="btnOtroIntercambio" class="btn btn-default btn-lg btn-block">CONTINUE TO NEXT INSPECTION</button>

                <button type="button" id="btnSalirAplicacion" class="btn btn-primary btn-lg btn-block">EXIT</button>  
              </div>            
            </div>
        </div>
        <!-- FIN ALERTA -->
   </div> <!-- /container -->
	<!--FIN -->
   <script src="../../js/bootstrap.min.js"></script>
   <script src="../../js/jquery.blockUI.js"></script>
   <script src="../../js/funcionesEstaticas.js"></script>
   <script src="js/main.js"></script>
</body>
</html>