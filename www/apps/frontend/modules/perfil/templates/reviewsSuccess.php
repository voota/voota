<?php use_helper('I18N') ?>
     
      <h2>Comentarios y vootos que has hecho hasta ahora (en total, 34)</h2>
      <p class="next-step-msg"><?php echo link_to(__('Tus preferencias'), "@usuario_edit"); ?></p>
      <p class="next-step-msg"><?php echo link_to(__('Echa un vistazo a cómo otros usuarios ven tu perfil'), "@usuario?username=".$sf_user->getGuardUser()->getProfile()->getVanity()); ?></p>
      
      <div id="content">
        <p class="filter">
          <label for="filter">Filtrar comentarios por:</label>
          <br />
          <select name="filter" id="filter">
            <option value="todos">Todos los comentarios</option>
            <option value="partidos">Por partidos</option>
            <option value="partidos">Por respuestas a otros comentarios</option>
          </select>
        </p>
        
        <div class="comments">
          <table>
            <tr>
              <td class="photo">
                <img alt="Foto Carlos Paramio" src="http://imagesvoota.s3.amazonaws.com/usuarios/cc_s_Carlos-Paramio-0017.jpg" />
              </td>
              <td class="name">
                Carlos A. Paramio (Usuario), el 23/12/2009
              </td>
              <td class="vote">
                <img src="/images/icoDown.gif" alt="buu" />
              </td>
              <td class="body">
                La primera llamada de teléfono realizada desde un teléfono considerado "móvil" la realizó Martin Cooper la mañana del 3 de abril de 1973&hellip;
              </td>
              <td class="actions">
                <a href="#">Hacer cambios</a>
              </td>
            </tr>
            
            <tr>
              <td class="photo">
                <img alt="Foto Carlos Paramio" src="http://imagesvoota.s3.amazonaws.com/usuarios/cc_s_Carlos-Paramio-0017.jpg" />
              </td>
              <td class="name">
                Carlos A. Paramio (Usuario), el 23/12/2009
              </td>
              <td class="vote">
                <img src="/images/icoDown.gif" alt="buu" />
              </td>
              <td class="body">
                La primera llamada de teléfono realizada desde un teléfono considerado "móvil" la realizó Martin Cooper la mañana del 3 de abril de 1973&hellip;
              </td>
              <td class="actions">
                <a href="#">Hacer cambios</a>
              </td>
            </tr>
            
            <tr>
              <td class="photo">
                <img alt="Foto Carlos Paramio" src="http://imagesvoota.s3.amazonaws.com/usuarios/cc_s_Carlos-Paramio-0017.jpg" />
              </td>
              <td class="name">
                Carlos A. Paramio (Usuario), el 23/12/2009
              </td>
              <td class="vote">
                <img src="/images/icoDown.gif" alt="buu" />
              </td>
              <td class="body">
                La primera llamada de teléfono realizada desde un teléfono considerado "móvil" la realizó Martin Cooper la mañana del 3 de abril de 1973&hellip;
              </td>
              <td class="actions">
                <a href="#">Hacer cambios</a>
              </td>
            </tr>
          </table>
        </div>
      </div>
