<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META NAME="Language" CONTENT="Spanish"/>
<title>Recursos Del Web - Sistema De Login (Logeo) En Ajax</title>
</head>
<script language="javascript">
    <!--      
      /*
        Esta funcion lo que hace es enviar mediante Ajax, por el metodo post, los datos (user y pass) 
        a un archivo "checar.php" para ser comparados en la base de datos. 
        De ser correctos se dará mensaje de bienvenida, sino, 
        entonces marcara error de usuario o password incorrectos
      */
      function POST_AJAX(url, variables) {
        objeto = false;
        //creamos el onjeto XMLHttpRequest para poder enviar datos mediante ajax
        
        if (window.XMLHttpRequest) { // Mozilla, Safari,...
           objeto = new XMLHttpRequest();
           if (objeto.overrideMimeType) {
            objeto.overrideMimeType('text/xml');
           }
        } else if (window.ActiveXObject) { // IE
           try {
              objeto = new ActiveXObject("Msxml2.XMLHTTP");
           } catch (e) {
              try {
                 objeto = new ActiveXObject("Microsoft.XMLHTTP");
              } catch (e) {}
           }
        }
        if (!objeto) {
           alert("No se puede crear la instancia XMLHTTP");
           return false;
        }

        objeto.onreadystatechange = avisos;    /*Cuando el archivo que se mando llamar mediante ajax (checar.php) regrese un resultado, entonces lo primero que se hace es mandar llamar la funcion avios(), que es donde se imprimirá mensaje de bienvenida*/
        objeto.open("POST", url, true);  /* enviaremos los datos por el metodo POST hacia checar.php */
        objeto.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); /*asignamos header. Esto no tiene relacion con el sistema de logeo. Solo es necesario para poder enviar los datos mediante ajax*/
        objeto.setRequestHeader("Content-length", variables.length);
        objeto.setRequestHeader("Connection", "close");
        objeto.send(variables); /* enviamos las variables con un formato como este: "user=minombre&pass=123456&n=0" */
      }


      /* Esta funcion lo unico que hace, es acomodar los datos introducidos en el formulario a una cadena "variables" con este formato: "user=minombre&pass=123456&n=0" o este "n=0"
      NOTA:
      n=1 significa que el formulario esta siendo enviado por el usuario (es decir que en este punto, el ususario previamente tuvo que haber introducido su user y pass y despues presionado el boton "enviar").
      n=0 significa que el formulario se esta enviando automaticamente cuando se carga la pagina. Esto lo hace para verificar si ya se habia logeado un usuario, entonces en cuanto se cargue la pagina, ya no le pedira su user y pass... ahora solo imprimirá mensaje de bienvenida. Es decir que si se logea, cierra el navegador sin haber cerrado sesion y en 3 dias por ejemplo vuelve a entrar a la pagina, lo que se le imprimirá será un mensaje de bienvenida, ya que no cerro sesion la ultima vez que salio. Esto solo dura una semana, es decir que las COOKIES de user y pass expiraran una semana despues de haber sido creadas.
      */
      function enviar(id_form,n) { 
           //si el formulario fue enviado al darle en el boton
          if (n=='1') {
              document.getElementById('inp_enviar').innerHTML = '<input type="submit" class="MC_enviar" name="enviar" value="Enviar"/><img src="ajax.gif"/>';
              
              /*si alguno de los campos de user y pass estan vacios, 
               *entonces se imprime mensaje de error. 
               *NOTA: vacio() es una funcion que verifica que alla algo diferente a "" 
               *o puros espacios en blanco. Esta funcion esta mas abajo */
              if ( vacio(document.getElementById(id_form).user.value)==false || vacio(document.getElementById(id_form).pass.value)==false) {
                  //"r" es un div que tenemos debajo del formulario para imprimir los mensajes de error.
                  document.getElementById('r').innerHTML = '<label class="res">Llena correctamente los campos</label>';
                  document.getElementById('inp_enviar').innerHTML = '<input type="submit" class="MC_enviar" name="enviar" value="Enviar"/>';
              } else { //sí SI habia llenado correctamente el user y pass, entonces se crear una cadena "variables" con los datos de user y pass con el siguiente formato: "user=minombre&pass=123456&n=0"
                  var Formulario = document.getElementById(id_form);
                  var longitudFormulario = Formulario.elements.length;
                  var variables = "";
                  var sepCampos = "";
                  for (var i=0; i<=Formulario.elements.length-1; i++) {
                       variables += sepCampos+Formulario.elements[i].name + '=' + encodeURI(Formulario.elements[i].value);
                       sepCampos="&";
                  }
                  
                  //indice para saber si envio formulario
                  variables += '&n=' + n;
                  /* se envia el nombre del archivo donde se verificaran los datos en la BD 
                   * y la cadena que se acaba de crear con los datos de user y pass, 
                   * hacia la funcion POST_AJAX, que lo que hace es enviar los datos por medio de 
                   * AJAX utilizando el metodo POST hacia "checar.php" */
                  POST_AJAX('checar.php', variables);
              }
          } else { //si el formulario fue enviado automaticamente solo para procesos
            variables = 'n=' + n;
            POST_AJAX('checar.php', variables);
         }
      }

      function avisos() {
         if ((objeto.readyState==4) && (objeto.status==200))                     
           {
            document.getElementById('form').innerHTML = objeto.responseText;  //se inserta en el DIV "form" el mensaje de bienvenida que nos imprimio "checar.php"                   
           }//end if
      }

     enviar('login','0'); //se envia a la funcion "enviar()" el id del formulario y el valor 0 (cero); Este valor (0) nos indicará que el formulario esta siendo enviado cuando la pagina se esta cargando apenas. NO lo esta enviando el usuario

      /*Esta funcion recorre una cadena en busca de algo diferente de espacios en blanco. Si la cadena contenia puros espacios en blanco entonces regresara False*/
      function vacio(q) {
         for ( i = 0; i <q.length; i++ ) {
           if ( q.charAt(i) != " " ) { return true }
         }
         return false
      }
    -->
</script>

<style type="text/css">
  #contenido{
    margin:0 auto;
    margin-top:50px;
    width:275px;
    padding:15px;
    border:solid 1px #990000;
    font-family:Arial, Helvetica, sans-serif;
    color:#990000;
  }

  #contenido label{
    font-size:18px;
    width:200px;
  }

  .MC_input{
    font-size:18px;
    color:#000000;
    width:180px;
    height:25px;
    margin-right:10px;
    margin-bottom:6px;
  }

  .MC_enviar{
     width:80px;
     height:34px;
     font-size:18px;
     margin-right:10px;
  }

  #labels{
    float:left;
    width:90px;
  }

  #lbl_user{
    margin-top:10px;
    margin-bottom:10px;
  }

  #inputs{
    float:right;
    width:180px;
  }

  #inp_enviar{
    margin-bottom:10px;
  }

  .res{
    color:#FF0000;
  }

  #texto{
    font-size:12px;
  }

  #texto a{
    font-size:14px;
  }
</style>

<body>
    <div id="contenido">
      <div id="texto">
        <p>Este es el demo en linea del Sistema De Login en Ajax.</p>
        <p>Para ver el codigo fuente y la expliaci&oacute;n ve a <a href="http://www.recursosdelweb.com/" target="_blank">Recursos Del Web</a></p>
        <p>Para ver su funcionamiento, trata con los siguientes datos:</p>
        <p>User=admin<br />
        Password=123456 </p>
      </div>
      <div id="form"></div>
    </div>
</body>
</html>


