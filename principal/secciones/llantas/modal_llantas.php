<!--
APLICATION NAME: ELECTRONIC INSPECTION SYSTEM
DESCTIPTION: SISTEMA ELECTRONICO DE INSPECCIONES DE CAJAS, PLATAFORMAS, PIPAS Y TRACTORES
AUTHOR:  PADILLA GUTIERREZ ANA GABRIELA
CREATED: DICIEMBRE, 2016
-->
<div class="modal fade" id="mdlLlantas" data-backdrop="static">
  <div class="modal-dialog" style="width:90%!important;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">WHEELS</h4>
      </div>
      <div class="modal-body">
        <div class="row" align="center">
          

          <div class="col-md-12 col-sm-12 col-xs-12">
            <label for="" class="tamanioTitulosllantas">RIM TYPE</label><br>
            <div id="groupRdTipoRin" class=" row-centered">
              <label class="btn btn-primary col-centered llanta btn-xs col-md-5 selRin" style="width:45%!important">
                <input type="radio" name="radiosTipoRin" id="rdCargada" value="Aluminio">&nbsp;&nbsp;Aluminum&nbsp;&nbsp;
              </label>
              <label class="btn btn-primary col-centered llanta btn-xs col-md-5 selRin" style="width:45%!important">
                <input type="radio" name="radiosTipoRin" id="rdVacia" value="Acero">&nbsp;&nbsp;Steel&nbsp;&nbsp;
              </label>
            </div>
          </div>
          
        </div>
        <div id="grupoRdMarcas" align="center">
          <?php include('cat_llantas.php'); ?>
        </div>
        <?php include('danios_llantas.php'); ?>
        <div class="row" align="center">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <label for="" class="tamanioTitulosllantas">TREAD DEPTH</label><br>
            <div id="" class="row-centered">
              <div class="col-md-8  col-centered" style="width:66.6666%!important">
                <input id="txtProfundidad" value="0" type="number" class=" form-control" min="0" max="32" onKeyUp="if(this.value>32){this.value='32';}else if(this.value<0){this.value='0';}">
              </div>
              <label class="col-md-2  col-centered text-left" style="padding:0px !important;">/32</label>
            </div>
          </div>  
        </div>
      </div>
      <div class="modal-footer">
        <div class="row">
          <button type="button" class="btn btn-default botonesFoterModal" data-dismiss="modal"><i class="fa fa-times"></i> CLOSE</button>
          <button type="button" class="btn btn-primary botonesFoterModal " id="btnLlantasCont" ><i class="fa fa-floppy-o"></i> SAVE</button>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->