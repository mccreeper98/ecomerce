<?php
  require_once './admin/conect.php';

  $presupuesto = '0';

  $obtenPresupuesto = mysqli_query($connect, "SELECT * FROM presupuesto");

  while($pres = mysqli_fetch_array($obtenPresupuesto)){
    $presupuesto = $pres['presupuesto'];
  }


?>

<!DOCTYPE html>
  <html>
    <head>
      <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
      <title>Casa Famosos</title>
      <meta http-equiv="X-UA-Compatible" content="IE=8">
      <meta http-equiv="Content-Language" content="es-MX">
      <meta name="apple-mobile-web-app-capable" content="yes">
      <meta name="apple-mobile-web-app-status-bar-style" content="black">
      <link href="img/favicon.png" rel="shortcut icon" type="image/x-icon" />
      <!--Import Google Icon Font-->
      <link href="css/materialicons.css" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen,projection"/>
      <link rel="stylesheet" href="css/main.css">
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
      
    </head>
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <body>

      <div class="todo hide" id="lo">
        <div class="loader" id="loader">Cargando...</div>
    </div>

      <main>
        <div class="nav">
          <div class="telemundo">
            <img src="img/TELEMUNDO_LOGO_CMYK_COLOR_WITH_WHITE_TEXT.png" alt="">
          </div>

          <div class="lcdlf">
            <img src="img/LCDLF_LOGO.png" alt="">
          </div>

          <div class="botones">

            <a class="waves-effect waves-light btn red comprar" onclick="return comprar()"><i class="material-icons left">shopping_cart</i>Comprar</a>
            <div class="espacio"></div>
            <div class="presupuesto">
              <p class="white-text">DISPONIBLE</p>
              <p class="white-text" id="monto">$ 500.00</p>
            </div>

          </div>
        </div>

        <div class="content">
          <div class="productos">
            <br>
            <div class="">
              <div class="row">
                  
                <?php
                
                  $obtenProds = mysqli_query($connect, "SELECT * FROM productos");

                  while($prod = mysqli_fetch_array($obtenProds)){
                    ?>

                      <div class="col s3 m6 l3">
                        <div class="es">
                          <div class="card z-depth-3 colum">
                            <img src="img/productos/<?php echo $prod['img'];?>" class="product-img" id="t">
                            <div class="vpan">
                              <div class="hpan">
                                <p class="name"><?php echo $prod['nombre'];?></p>
                                <p class="cantidad" id="cantidad<?php echo $prod['id'];?>">0</p>
                              </div>
                              <div class="hpan">
                                <p class="precio" id="pre<?php echo $prod['id'];?>">$ </p>
                              </div>
                              <div class="hpan">
                                  <a class="btn-floating waves-effect waves-light blue" onclick="add(<?php echo $prod['id'];?>, '<?php echo $prod['precio'];?>')"><i class="material-icons">add</i></a>
                                  <div class="espacio"></div>
                                  <a class="btn-floating waves-effect waves-light" style="background-color:gray" onclick="remove(<?php echo $prod['id'];?>, '<?php echo $prod['precio'];?>')"><i class="material-icons">remove</i></a>
                                </div>
                            </div>
                          </div>
                        </div>
                        <div class="espacio"></div><br><br>
                      </div>
                      <script>
                        var presss = <?php echo $prod['precio'];?>;
                        presupuestos = parseFloat(presss);
                        $('#pre<?php echo $prod['id'];?>').html('');
                        $('#pre<?php echo $prod['id'];?>').html(new Intl.NumberFormat("en-EU", {style: "currency", currency: "USD"}).format(presupuestos));
                      </script>
                    <?php
                  }
                
                ?>
              </div>
            </div>
                  <!-- <button onclick="mos()">asd</button> -->
          </div>
          <div class="footerContainer">
            <p class="copy">La Casa de los Famosos © powered by EndemolShine Boomdog | Banana Geek ®</p>
          </div>
        </div>

      </main>

      <!-- Modal Structure -->
      <div id="modal1" class="modal">
        <div class="modal-content center">
          <br>
            <img src="img/LCDLF_LOGO.png" class="logo">
            <br>
            <div class="espacio"></div>
            <br>
            <h4 class="letras">Tu pedido se ha enviado.</h4>
            <br>
            <a class="waves-effect btn comprar" href="gracias.html" style="background-color:#ad3b3a;">Aceptar</a>
        </div>
        </div>
      <!--Import jQuery before materialize.js-->
      
      <script type="text/javascript" src="js/materialize.min.js"></script>
      <script type="text/javascript" src="js/sweetalert2@11.js"></script>
      <script>

        var presupuesto;
        var productos = [];

                  function mos(){
                    alert($('#t').width())
                  }

        $(document).ready(function(){
          $('.modal').modal();
          var press = <?php echo $presupuesto; ?>;
          presupuesto = parseFloat(press);
          $('#monto').html('');
          $('#monto').html(new Intl.NumberFormat("en-EU", {style: "currency", currency: "USD"}).format(presupuesto));
        });

        function add(id, precio){
          var cantidad = $('#cantidad'+id).html();
          cantidad++;

          presupuesto = presupuesto - parseFloat(precio);

          let producto = productos.find(a => a.id === id);

          if(producto === undefined){
            productos.push({
              "id": id,
              "precio": precio,
              "cantidad": cantidad
            });
          }else{
            let index = productos.indexOf(producto);
            producto.cantidad = cantidad;
            productos[index] = producto;
          }
          
          console.log(producto);

          if(presupuesto <=0 ){
            $('#monto').removeClass('white-text');
            $('#monto').addClass('red-text');
          }

          $('#cantidad'+id).html('');
          $('#cantidad'+id).html(cantidad);
          $('#monto').html('');
          $('#monto').html(new Intl.NumberFormat("en-EU", {style: "currency", currency: "USD"}).format(presupuesto));
        }

        function remove(id, precio){
          var cantidad = $('#cantidad'+id).html();
          if(cantidad > 0){
            cantidad--;

            presupuesto = presupuesto + parseFloat(precio);

            let producto = productos.find(a => a.id === id);

            if(producto != undefined){
              let index = productos.indexOf(producto);
              if(cantidad != 0){
                producto.cantidad = cantidad;
                productos[index] = producto;
              }else{
                productos.splice(index,1);
              }
            }

            console.log(producto);

            if(presupuesto >0 ){
              $('#monto').removeClass('red-text');
              $('#monto').addClass('white-text');
            }

            $('#cantidad'+id).html('');
            $('#cantidad'+id).html(cantidad);
            $('#monto').html('');
            $('#monto').html(new Intl.NumberFormat("en-EU", {style: "currency", currency: "USD"}).format(presupuesto));
          }
        }
        
        function comprar(){
          if(productos.length > 0){
            $('#lo').removeClass('hide');

            var data = JSON.stringify(productos);

            $.ajax({
              type: "POST",
              url: "compra.php",
              data: {data: data, presupuesto: presupuesto},
              cache: false,
              success: function (res){
                console.log(res);
                $('#lo').addClass('hide');
                $('#modal1').modal('open');
              }
            });
          }
        }
      </script>
    </body>
  </html>