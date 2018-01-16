<!--
APLICATION NAME: ELECTRONIC INSPECTION SYSTEM
DESCTIPTION: SISTEMA ELECTRONICO DE INSPECCIONES DE CAJAS, PLATAFORMAS, PIPAS Y TRACTORES
AUTHOR:  PADILLA GUTIERREZ ANA GABRIELA
CREATED: DICIEMBRE, 2016
-->
<div class="row" align="center">
          <div class="col-md-12">
            <label for="" class="tamanioTitulosllantas">DAMAGE TYPE</label>
            <div id="groupRdDanio" class='row-centered'>
              <label class="btn btn-primary col-centered llanta btn-xs col-md-5 col-sm-5 col-xs-5 selDanio">
                <input type="radio" name="radiosDanios"  value="PONCHADA">
                FLAT TIRE
              </label>
              <label class="btn btn-primary col-centered  llanta btn-xs col-md-5 col-sm-5 col-xs-5 selDanio">
                <input type="radio" name="radiosDanios" value="TRONADA">
                BLOW OUT TIRE
              </label>
              <label class="btn btn-primary col-centered llanta btn-xs col-md-5 col-sm-5 col-xs-5 selDanio">
                <input type="radio" name="radiosDanios"  value="DESGASTADA">
                WORN OUT TIRE
              </label>

              <label class="btn btn-primary col-centered llanta btn-xs col-md-5 col-sm-5 col-xs-5 selDanio">
                <input type="radio" name="radiosDanios" value="NORMAL">
                NORMAL
              </label>
              <label class="btn btn-primary col-centered llanta btn-xs col-md-5 col-sm-5 col-xs-5 selDanio">
                <input type="radio" name="radiosDanios"  value="GOLPE">
                HITTED TIRE
              </label>
              <label class="btn btn-primary col-centered llanta btn-xs col-md-5 col-sm-5 col-xs-5 selDanio">
                <input type="radio" name="radiosDanios" value="BURBUJA">
                BUBBLE
              </label>
              <label class="btn btn-primary col-centered llanta btn-xs col-md-5 col-sm-5 col-xs-5 selDanio">
                <input type="radio" name="radiosDanios" value="SIN LLANTA">
                NO TIRE
              </label>
              <form class="class_fl_Baja"> <!-- PONCHADA -->
                <input id="fl_Baja" type="file" capture name="archivos[]" accept="image/*">
              </form>
              <form class="class_fl_Tronada">
                <input id="fl_Tronada" type="file" capture name="archivos[]" accept="image/*">
              </form>
              <form class="class_fl_Desgastada">
                <input id="fl_Desgastada" type="file" capture name="archivos[]" accept="image/*">
              </form>
              <form class="class_fl_Golpe">
                <input id="fl_Golpe" type="file" capture name="archivos[]" accept="image/*">
              </form>
               <form class="class_fl_Burbuja">
                <input id="fl_Burbuja" type="file" capture name="archivos[]" accept="image/*">
              </form>
              <form class="class_fl_Sinllanta">
                <input id="fl_Sinllanta" type="file" capture name="archivos[]" accept="image/*">
              </form>
            </div>
          </div>
        </div>