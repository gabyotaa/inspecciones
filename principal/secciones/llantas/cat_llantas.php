<!--
APLICATION NAME: ELECTRONIC INSPECTION SYSTEM
DESCTIPTION: SISTEMA ELECTRONICO DE INSPECCIONES DE CAJAS, PLATAFORMAS, PIPAS Y TRACTORES
AUTHOR:  PADILLA GUTIERREZ ANA GABRIELA
CREATED: DICIEMBRE, 2016
-->
<div class="row" align="center">
  <label for="" class="tamanioTitulosllantas">TIRE BRAND</label>
  <div class="col-md-12">
    <div class="row row-centered">
      
      <label class="btn btn-primary llanta btn-xs col-centered col-md-3 col-sm-4 col-xs-4 selMarca">
        <input type="radio" name="radioMarca" value="BF Goodrich">
        BF Goodrich
      </label>
      
      <label class="btn btn-primary llanta btn-xs col-centered col-md-3 col-sm-4 col-xs-4 selMarca">
        <input type="radio" name="radioMarca" value="Kelly">
        Kelly
      </label>
     
      <label class="btn btn-primary llanta btn-xs col-centered col-md-3 col-sm-4 col-xs-4 selMarca">
        <input type="radio" name="radioMarca" value="Bridgestone">
        Bridgestone
      </label>
     

      <label class="btn btn-primary llanta btn-xs col-centered col-md-3 col-sm-4 col-xs-4 selMarca">
        <input type="radio" name="radioMarca" value="Yokohama">
        Yokohama
      </label>
      <label class="btn btn-primary llanta btn-xs col-centered col-md-3 col-sm-4 col-xs-4 selMarca">
        <input type="radio" name="radioMarca" value="Continental">
        Continental
      </label>
      <label class="btn btn-primary llanta btn-xs col-centered col-md-3 col-sm-4 col-xs-4 selMarca">
        <input type="radio" name="radioMarca" value="Firestone">
        Firestone
      </label>
      <label class="btn btn-primary llanta col-centered btn-xs col-md-3 col-sm-4 col-xs-4 selMarca">
        <input type="radio" name="radioMarca" value="EcoTire">
        EcoTire
      </label>
      <label class="btn btn-primary llanta col-centered btn-xs col-md-3 col-sm-4 col-xs-4 selMarca">
        <input type="radio" name="radioMarca" value="Goodyear">
        Goodyear
      </label>
      <label class="btn btn-primary llanta col-centered btn-xs col-md-3 col-sm-4 col-xs-4 selMarca">
        <input type="radio" name="radioMarca" value="Michelin">
        Michelin
      </label>
      <label class="btn btn-primary llanta col-centered btn-xs col-md-3 col-sm-4 col-xs-4 selMarca">
        <input type="radio" name="radioMarca" value="Other">
        Other
      </label>
     
    </div>
  </div>
  
  <div class="col-md-12 divOtro" id="divOtro" hidden>
    <label for="" class="tamanioTitulosllantas">OTHER TIRE BRAND</label>
    <div class="row row-centered">  
        <div class="col-md-6 col-sm-8 col-xs-8 col-centered">
          <input id="txtOtraMarca" type="text" class="form-control text-center" placeholder="OTHER">
        </div>
    </div>
  </div>
</div>

<style>
.llanta{
    padding: 5px;
    margin: 5px;
    
}
/* centered columns styles */
.row-centered {
    text-align:center;
}
.col-centered {
    display:inline-block;
    float:none;
    
   
    /* inline-block space fix */
    margin-right:-4px;
}
</style>