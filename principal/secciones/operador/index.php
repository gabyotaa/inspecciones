<!DOCTYPE HTML>
<html>
<!--
APLICATION NAME: ELECTRONIC INSPECTION SYSTEM
DESCTIPTION: SISTEMA ELECTRONICO DE INSPECCIONES DE CAJAS, PLATAFORMAS, PIPAS Y TRACTORES
AUTHOR:  PADILLA GUTIERREZ ANA GABRIELA
CREATED: DICIEMBRE, 2016
-->
<head>
  <title>Driver</title>
  <meta name="application-name" content="Electronic Inspection System">
  <meta name="description" content="Sistema de Inspecciones a Cajas,Plataformas, Pipas y Tractores">
  <meta name="author" content=" PADILLA GUTIERREZ ANA GABRIELA ">
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
  <link href="../../css/pnotify.custom.min.css" rel="stylesheet">
  <link href="../../css/sweetalert.css" rel="stylesheet" type="text/css">
  <link href="../../css/autocomplete.css" rel="stylesheet">
  <link href="css/jquery.signaturepad.css" rel="stylesheet" >
  <link href="css/styles.css" rel="stylesheet">
  <script src="../../js/jquery-1.11.0.js"></script>
</head>
<body>
  <!--INICIO -->
  <div class="container">
    <div class="row" style="margin-bottom: 20px;">
      <div class="col-xs-12 col-sm-10">
        <p class="text-center"><strong>DRIVER INFORMATION</strong></p>
      </div>
      <div class="col-xs-12 col-sm-2">
        <button id="btnListo" class="btn btn-lg btn-primary pull-right"><i id="iListo"></i>DONE</button>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12 col-md-6">
        <div class="form-group">
          <p for="txtNombre"><strong>FIRST NAME</strong></p>
          <input type="text" class="form-control input-sm focus limpiar" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" id="txtNombre" autofocus="autofocus" autocomplete="off" placeholder='FIRST NAME'>
        </div>
      </div>
      <div class="col-xs-12 col-md-6">
        <div class="form-group">
          <p><strong>LAST NAME</strong></p>
          <input type="text" class="form-control input-sm focus limpiar" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" id="txtApePat" autofocus="autofocus" autocomplete="off" placeholder='LAST NAME'>
        </div>
      </div>
      <div class="col-xs-12 col-md-6">
        <div class="form-group">
          <p><strong>LOADLOCKS</strong></p>
          <div class="input-group">
            <span class="input-group-btn">
             <button type="button" class="btn btn-danger btn-number"  data-type="minus" data-field="quant[2]">
               <span class="glyphicon glyphicon-minus"></span>
             </button>
           </span>
           <input type="number" name="quant[2]" class="form-control input-number" id="txtGatas" value="0" min="0" max="100">
           <span class="input-group-btn">
             <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="quant[2]">
               <span class="glyphicon glyphicon-plus"></span>
             </button>
           </span>
         </div>
        </div>
      </div>
      <div class="col-xs-12 col-md-6">
        <p><strong>DRIVER SIGNATURE</strong></p>
        <button id="btnFirma" class="btn btn-lg btn-primary"><i class="fa fa-pencil"></i> DRIVER SIGNATURE</button>
      </div>
    </div>
    <div class="form-group hidden">
      <label for="txtNoOperador" class="col-sm-2 control-label focus numeros">Driver Number:</label>
      <div class="col-sm-4">
        <input type="number" class="form-control input-sm limpiar" id="txtNoOperador" >
      </div>
    </div>
  </div> <!-- /container -->
  <!-- ****************** SECCION DE MODALS **************** -->
  <div class="modal fade" id="mdlFirma" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">DRIVER SIGNATURE</h4>
        </div>
        <div class="modal-body" align="center">
        </br>
        <div class="row">
          
          <div class="col-md-12" align="left">
            <form  id='sigPad' class="sigPad" width=''  style="text-align=center">
              <canvas style='display:inline-block;float:none; margin-right:-4px; border: 1px solid #e1e1e8; border-radius: 11px;'class="pad col-centered" width="1120px" height="300" ></canvas>
              <input type="hidden" name="output" id="txtSalidaFirma" class="output">
            </form>
            <!--   <div id="signature" class="bordeFirma"></div> -->
          </div>
        </div>
        <!-- -->
      </div>
      <div class="modal-footer">
        <button id="btnLimpiarFirma" class="btn btn-default " style="font-size:20px">CLEAR SIGNATURE</button>
        <button type="button" class="btn btn-default botonesFoterModal" data-dismiss="modal"><i class="fa fa-times"></i> CLOSE</button>
        <button type="button" class="btn btn-primary botonesFoterModal" id="btnGuardarFirma" ><i class="fa fa-floppy-o"></i> OK</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--******************  FIN  **************************** -->
<!--FIN -->
<script src="../../js/bootstrap.min.js"></script>
<script src="../../js/sweetalert.min.js"></script>
<script src="../../js/pnotify.custom.min.js"></script>
<script src="js/jquery.signaturepad.min.js"></script>
<script src="js/json2.min.js"></script>
<script src="../../js/autocomplete.min.js"></script>
<script src="../../js/jquery.blockUI.js"></script>
<script src="../../js/funcionesEstaticas.js"></script>
<script src="js/main.js"></script>
</body>
</html>
