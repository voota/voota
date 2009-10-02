<!-- MAIN -->

<div id="main">
<!-- CONTENT -->
<div id="content">
<!-- CONTENT LEFT-->
<div id="contentLeftSing">
<div title="ficha">
<span class="tituloAzul">¿Nuevo en Voota? Empieza aquí</span>
<div class="limpiar"></div>
<!--tu email -->
<div class="formSing">
<table>
  <tr>
    <td class="leftSing"><h5>Tu Email</h5></td>

    <td><input name="input3" type="text" class="inputSign"></td>
    <td><h6><img src="/images/icoVale.gif" alt="Ico vale" width="18" height="18"> vale</h6></td>
    </tr>
  <tr>
    <td class="leftSing"><h5>Usuario</h5></td>
    <td><input name="input4" type="text" class="inputSign"></td>
    <td><h6><img src="/images/icoCargar.gif" alt="IcoCargar" width="18" height="18"><img src="image/icoVale.gif" alt="Ico vale" width="18" height="18"> vale</h6></td>

    </tr>
  <tr>
    <td class="leftSing"><h5>Contraseña</h5></td>
    <td><input name="input" type="password" class="inputSign"></td>
    <td><h6><img src="/images/icoFlojito.gif" alt="Ico vale" width="18" height="18"> flojilla<br>
      <img src="/images/icoMejor.gif" alt="Icono Mejor" width="18" height="18">mejor<br>
      <img src="/images/icoVale.gif" alt="Ico vale" width="18" height="18">mucho mejor<br>

      <img src="/images/icoVale.gif" alt="Ico vale" width="18" height="18"><img src="/images/icoVale.gif" alt="Ico vale" width="18" height="18">¡ahora si! perfecto<br>
      <img src="/images/icoNop.gif" alt="Icono NOp" width="18" height="18">en blanco nop</h6></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td><h6><a href="#">Ver la contraseña</a></h6></td>
    <td>&nbsp;</td>

  </tr>
  <tr>
    <td class="leftSing">&nbsp;</td>
    <td class="alingBoton">
      <input name="button" type="submit" class="button" value="Registrate en Voota">     </td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>

<div class="limpiar"></div>
<!--usuario -->
<div class="limpiar"></div>
<!--contraseña -->
</div>
</div>
</div>
<!-- FIN CONTENT LEFT -->
<!-- CONTENT RIGHT -->
<div id="contentRightSing">
  <div title="ficha"> <span class="tituloAzul">¿Ya estás registrado? Adelante :)</span>
  
    <div class="formSing">
<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
<table>
  <tr>
    <td class="leftSing"><h5>Usuario</h5></td>
    <td><input name="signin[username]" id="signin_username" type="text"></td>
    </tr>
  <tr>
    <td class="leftSing"><h5>Contraseña</h5></td>
    <td><input name="signin[password]" id="signin_password" type="password"></td>
    </tr>
  <tr>
    <td class="leftSing">&nbsp;</td>
    <td><input name="signin[remember]" id="signin_remember" type="checkbox"> recordar</td>
    </tr>


  <tr>
    <td>&nbsp;</td>
    <td><h6><a href="olvidarContrasena.html">Olvidaste tu contraseña</a></h6></td>
    </tr>
  <tr>
    <td class="leftSing">&nbsp;</td>
    <td style="text-align:right">
      <input name="button" type="submit" class="button" value="Entrar">     </td>

    </tr>
</table>
</form>
</div>


</div>
  <!-- politico1 -->
</div>
<!--  FIN CONTENT RIGHT -->
<div class="limpiar"></div>
<div title="formulario" class="votaSobre">
  <!-- confirmar -->
  <!-- fin confirmar -->
  <!-- login -->

  <!-- fin login -->
</div>
</div>
<!-- FIN CONTENT -->
</div>
<!--FIN MAIN -->
