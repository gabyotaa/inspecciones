<!DOCTYPE HTML>
<html>
<!--
APLICATION NAME: ELECTRONIC INSPECTION SYSTEM
DESCTIPTION: SISTEMA ELECTRONICO DE INSPECCIONES DE CAJAS, PLATAFORMAS, PIPAS Y TRACTORES
AUTHOR: PADILLA GUTIERREZ ANA GABRIELA
CREATED: DICIEMBRE, 2016
-->
<head>
  <title>Right Side</title>
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
  <link href="css/styles.css" rel="stylesheet">
  <script src="../../js/jquery-1.11.0.js"></script>
</head>
<body>
  <div class="container">
    <div class="row" style="margin-bottom: 20px;">
      <div class="col-xs-offset-4 col-xs-4">
        <p class="text-center"><strong>TRAILER LEFT SIDE</strong></p>
      </div>
      <div class="col-xs-4">
        <button  class="btn btn-lg btn-primary pull-right" id="btnListo">DONE</button>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-3">
       

        <div class="form-group">
          <p class="text-center"><strong>JACK HANDLE</strong></p>
          <div class="row">
            <div class="col-xs-6">
              <button type="button"  id="btnManibelaSi" class="btn btn-default btn-block">YES</button>
            </div>
            <div class="col-xs-6">
              <button type="button" id="btnManibelaNo" class="btn btn-default btn-block">NO</button>
            </div>
          </div>
        </div>
        <div class="form-group">
          <p class="text-center"><strong>LANDING GEAR</strong></p>
          <div class="row">
            <div class="col-xs-6">
              <button type="button" id="btnPatinesND" class="btn btn-default btn-block">OK</button>
            </div>
            <div class="col-xs-6">
              <button type="button" id="btnPatinesSD" class="btn btn-default btn-block">DMG</button>
            </div>
            <form class="class_fl_Patines">
              <input id="fl_Patines"  name="archivos[]" accept="image/*"   type="file" capture/>
            </form>
          </div>
        </div>
        <div class="form-group">
          <p class="text-center"><strong>LEFT SKIRT</strong></p>
          <div class="row">
            <div class="col-xs-6">
              <button type="button" id="btnFaldonND" class="btn btn-default btn-block">OK</button>
            </div>
            <div class="col-xs-6">
              <button type="button" id="btnFaldonSD" class="btn btn-default btn-block">DMG</button>
            </div>
            <form class="class_fl_Faldon">
              <input id="fl_Faldon" name="archivos[]" accept="image/*" type="file" capture>
            </form>
          </div>
        </div>
        <div class="form-group">
          <p class="text-center"><strong>FUEL TANK</strong></p>
          <div class="row">
            <div class="col-xs-6">
              <button type="button" id="btnTanqueND" class="btn btn-default btn-block">OK</button>
            </div>
            <div class="col-xs-6">
              <button type="button" id="btnTanqueSD" class="btn btn-default btn-block">DMG</button>
            </div>
            <form class="class_fl_tanque">
              <input id="fl_tanque" name="archivos[]" accept="image/*" type="file" capture>
            </form>
          </div>
        </div>
        <div class="form-group">
          <p class="text-center"><strong>DOT INSPECTION</strong></p>
          <div class="row">
            <div class="col-xs-12">
              <input type="text" id="txtDot" maxlength="7" class="form-control text-center" placeholder='MM/YYYY'>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-6">
        <p class="text-center"><strong>FUEL LEVEL</strong></p>
        <div class="divImgEmpty" style="display: block; float: left; width: 20%;">
          <img id="imgThermo" class="img-responsive"  src="img/empty.png" style="display: inline-block; height: 100px; max-width: 100%; position: relative;">
        </div>
        <div class="divUnCuarto" style="display: block; float: left; width: 20%;">
          <img id="imgThermo" class="img-responsive"  src="img/uncuarto.png" style="display: inline-block; height: 100px; max-width: 100%; position: relative; left: 15%;">
        </div>
        <div class="divMedio" style="display: block; float: left; width: 20%;">
          <img id="imgThermo" class="img-responsive"  src="img/medio.png" style="display: inline-block; height: 100px; max-width: 100%; position: relative; left: 25%;">
        </div>
        <div class="divMedio" style="display: block; float: left; width: 20%;">
          <img id="imgThermo" class="img-responsive"  src="img/trescuartos.png" style="display: inline-block; height: 100px; max-width: 100%; position: relative; left: 50%;">
        </div>
        <div class="divImgFull" style="display: block; float: left; width: 20%;">
          <img id="imgThermo" class="img-responsive"  src="img/full.png" style="display: inline-block; height: 100px; max-width: 100%; position: relative; left: 60%;">
        </div>
        <form oninput="amount.value=barDiesel.value">
          <div class="row row-centered" style="border: 2px solid black;">
            <div class="col-xs-12">
              <input id="barDiesel" type="range"  name="barDiesel" value="75"  step="1" min="0" max="100">
            </div>
            <div class="col-centered col-xs-3" style="text-align:center; margin-top:20px">
              <input id="rangeValue1" type="number"  name="amount" for="barDiesel" value="0" class="form-control " >
            </div>
          </div>
        </form>
      </div>
      <div class="col-xs-3">
        <div class="form-group">
          <p class="text-center"><strong>FUEL CAP</strong></p>
          <div class="row">
            <div class="col-xs-6">
              <button type="button"  id="btnTaponDieselSi" class="btn btn-default btn-block">YES</button>
            </div>
            <div class="col-xs-6">
              <button type="button" id="btnTaponDieselNo" class="btn btn-default btn-block">NO</button>
            </div>
          </div>
        </div>
        <div class="form-group">
          <p class="text-center"><strong>LEFT FLAP</strong></p>
          <div class="row">
            <div class="col-xs-6">
              <button type="button" id="btnLoderaND" class="btn btn-default btn-block">OK</button>
            </div>
            <div class="col-xs-6">
              <button type="button" id="btnLoderaSD" class="btn btn-default btn-block">DMG</button>
            </div>
            <form class="class_fl_lodera">
              <input id="fl_lodera"  name="archivos[]" accept="image/*"   type="file" capture/>
            </form>
          </div>
        </div>
        <div class="form-group">
          <p class="text-center"><strong>X MEMBER</strong></p>
          <div class="row">
            <div class="col-xs-6">
              <button type="button" id="btnCargadoresND" class="btn btn-default btn-block">OK</button>
            </div>
            <div class="col-xs-6">
              <button type="button"  id="btnCargadoresSD" class="btn btn-default btn-block">DMG</button>
            </div>
            <form class="class_fl_cargadores">
              <input id="fl_cargadores"  name="archivos[]" accept="image/*"   type="file" capture/>
            </form>
          </div>
        </div>
        <div class="form-group">
          <p class="text-center"><strong>LEFT TAIL</strong></p>
          <div class="row">
            <div class="col-xs-6">
              <button type="button" id="btnAleronND" class="btn btn-default btn-block">OK</button>
            </div>
            <div class="col-xs-6">
              <button type="button"  id="btnAleronSD" class="btn btn-default btn-block">DMG</button>
            </div>
            <form class="class_fl_aleron">
              <input id="fl_aleron"  name="archivos[]" accept="image/*"   type="file" capture/>
            </form>
          </div>
        </div>
        <div class="form-group" id='divNumLlantas'>
          <p class="text-center"><strong>TIRES</strong></p>
          <div class="row">
            <div class="col-xs-6">
              <button type="button"  id="btnLlantas2" class="btn btn-default btn-block">2</button>
            </div>
            <div class="col-xs-6">
              <button type="button" id="btnLlantas4" class="btn btn-default btn-block">4</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row" style="margin-bottom: 20px;">
      <p class="text-center"><strong>SELECT IF SIDE IS DAMAGED</strong></p>
      <div class="col-xs-12">
        <div class="row">
          <div class="col-xs-offset-2 col-xs-2" style="padding: 0px;">
            <div id="div_c1_der">
              <img id="imgThermo" class="img-responsive" src="img/c1_der.png" style="padding: 2px;">
            </div>
            <form class="class_fl_c1_der">
              <input id="fl_c1_der"  name="archivos[]" accept="image/*" type="file" capture/>
            </form>
          </div>
          <div class="col-xs-2" style="padding: 0px;">
            <div id="div_c2_izq">
              <img id="imgThermo" class="img-responsive" src="img/c2_izq.png" style="padding: 2px;">
            </div>
            <form class="class_fl_c2_izq">
              <input id="fl_c2_izq"  name="archivos[]" accept="image/*" type="file" capture/>
            </form>
          </div>
          <div class="col-xs-2" style="padding: 0px;">
            <div id="div_c3_izq">
              <img id="imgThermo" class="img-responsive" src="img/c3_izq.png" style="padding: 2px;">
            </div>
            <form class="class_fl_c3_izq">
              <input id="fl_c3_izq"  name="archivos[]" accept="image/*" type="file" capture/>
            </form>
          </div>
          <div class="col-xs-2" style="padding: 0px;">
            <div id="div_c4_izq">
              <img id="imgThermo" class="img-responsive" src="img/c4_izq.png" style="padding: 2px;">
            </div>
            <form class="class_fl_c4_izq">
              <input id="fl_c4_izq"  name="archivos[]" accept="image/*" type="file" capture/>
            </form>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-offset-1 col-xs-1">
            <button type="button" id="btnPerfilIzquierdo" class="btn btn-info" style="height: 202px; margin-top: -97px; font-size: 10px;margin-left: -10px;"><i class="fa fa-camera"></i><br>SIDE</button>
            <form class="class_fl_perfil_izq">
              <input id="fl_perfil_izq"  name="archivos[]" accept="image/*"   type="file" capture/>
            </form>
          </div>
          <div class="col-xs-2" style="padding: 0px;">
            <div id="div_c5_der">
              <img id="imgThermo" class="img-responsive"  src="img/c5_der.png" style="padding: 2px;">
            </div>
            <form class="class_fl_c5_der">
              <input id="fl_c5_der"  name="archivos[]" accept="image/*"  type="file" capture/>
            </form>
          </div>
          <div class="col-xs-2" style="padding: 0px;">
            <div id="div_c6_izq">
              <img id="imgThermo" class="img-responsive"  src="img/c6_izq.png" style="padding: 2px;">
            </div>
            <form class="class_fl_c6_izq">
              <input id="fl_c6_izq"  name="archivos[]" accept="image/*"  type="file" capture/>
            </form>
          </div>
          <div class="col-xs-2" style="padding: 0px;">
            <div id="div_c7_izq">
              <img id="imgThermo" class="img-responsive"  src="img/c7_izq.png" style="padding: 2px;">
            </div>
            <form class="class_fl_c7_izq">
              <input id="fl_c7_izq"  name="archivos[]" accept="image/*"  type="file" capture/>
            </form>
          </div>
          <div class="col-xs-2" style="padding: 0px;">
            <div id="div_c8_izq">
              <img id="imgThermo" class="img-responsive"  src="img/c8_izq.png" style="padding: 2px;">
            </div>
            <form class="class_fl_c8_izq">
              <input id="fl_c8_izq"  name="archivos[]" accept="image/*"  type="file" capture/>
            </form>
          </div>
          <div class="col-xs-2">
            <button type="button" id="btnPerfilDerecho" class="btn btn-info" style="height: 202px; margin-top: -97px; font-size: 10px;"><i class="fa fa-camera"></i><br>SIDE</button>
            <form class="class_fl_perfil_der">
              <input id="fl_perfil_der"  name="archivos[]" accept="image/*"   type="file" capture/>
            </form>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-offset-5 col-xs-2">
            <div id="div_foco_ezq">
              <img id="imgThermo" class="img-responsive"  src="img/foco.png" width="60">
            </div>
            <form class="class_fl_foco_ezq">
              <input id="fl_foco_ezq"  name="archivos[]" accept="image/*"  type="file" capture/>
            </form>
          </div>
          <div class="col-xs-offset-1 col-xs-2">
            <div id="div_foco_med">
              <img id="imgThermo" class="img-responsive"  src="img/foco.png" width="60">
            </div>
            <form class="class_fl_foco_med">
              <input id="fl_foco_med"  name="archivos[]" accept="image/*"  type="file" capture/>
            </form>
          </div>
        </div>
      </div>
    </div>
    

    <div class="row" style="margin-bottom: 20px;">
      <div class="col-xs-2">
        <div class="divDosLlantas">
          <div class="div_llantaDer_ext12">
            <label for="">INTERNAL</label><br><strong>12</strong>
            <div class="image-upload" id="div_llantaIzq_int">
              <label for="llantaIzq_int">
                <img id="imgThermo" class="img-responsive"  src="img/rueda3.png" width="90" height="160">
              </label>
            </div>
          </div>
          <label for="">EXTERNAL</label><br><strong>11</strong>
          <div class="image-upload" id="div_llantaIzq_ext">
            <label for="llantaDer_int">
              <img id="imgThermo" class="img-responsive"  src="img/rueda3.png" width="90" height="160">
            </label>
          </div>
        </div>
      </div>
      <div class="col-xs-offset-8 col-xs-2">
        <div class="divCuatroLlantas">
          <label for="">INTERNAL</label><br><strong>16</strong>
          <div class="image-upload" id="div_llantaDer_int">
            <label for="llantaIzq_der">
              <img id="imgThermo" class="img-responsive"  src="img/rueda3.png" width="90" height="160">
            </label>
          </div>
          <label for="">EXTERNAL</label><br><strong>15</strong>
          <div class="image-upload" id="div_llantaDer_ext">
            <label for="llantaDer_der">
              <img id="imgThermo" class="img-responsive"  src="img/rueda3.png" width="90" height="160">
            </label>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include('../llantas/modal_llantas.php');?>

<div class="modal fade" id="mdlDiesel" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">FUEL</h4>
      </div>
      <div class="modal-body">
        <div class="row" align="center">
          <div class="col-md-12">
            <div class="form-group">
              <label for="txtPersona">Approved by</label>
              <input type="text" class="form-control" id="txtPersona" placeholder="Name" maxlength="50">
            </div>
            <div class="form-group">
              <label for="areaRazones" class="col-md-12">Reasons</label>
              <textarea rows="4"  id="areaRazones" maxlength="255" class="col-md-12"></textarea>
            </div>
          </div>
        </div>
        
        
      </div>
      <div class="modal-footer">
        <div class="row">
          <button type="button" class="btn btn-default botonesFoterModal" data-dismiss="modal"><i class="fa fa-times"></i> CLOSE</button>
          <button type="button" class="btn btn-primary botonesFoterModal" id="btnDieselCont" ><i class="fa fa-floppy-o"></i> SAVE</button>
        </div>
      </div>
    </div><!-- /.modal-content-->
  </div><!-- /.modal-dialog--> 
</div><!-- /.modal -->
<!--******************  FIN  **************************** -->
<!--FIN -->
<script src="../../js/bootstrap.min.js"></script>
<script src="../../js/pnotify.custom.min.js"></script>
<script src="../../js/sweetalert.min.js"></script>
<script src="../../js/jquery.blockUI.js"></script>
<script src="../../js/funcionesEstaticas.js"></script>
<script src="js/main.js"></script>
</body>
</html>
