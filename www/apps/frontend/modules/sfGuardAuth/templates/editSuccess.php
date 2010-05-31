<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoNotice') ?>
<?php use_helper('Number') ?>
<?php use_helper('VoUser') ?>

<?php $maxLength = 280?>

<script type="text/javascript">
  <!--//
  $(document).ready(function() {
	  $("#bajaVoota").click(function(){
		  $("#bajaButtonDiv").addClass('hidden');
		  $("#bajaConfirmDiv").removeClass('hidden');
		  return false;
	  });
	  $("#noConfirm").click(function(){
		  $("#bajaButtonDiv").removeClass('hidden');
		  $("#bajaConfirmDiv").addClass('hidden');
		  return false;
  	  });
	  //controls character input/counter
	  $('#profile_presentacion').keyup(function() {
		  setCounter('#presen_counter', this, 280);
	  });
	  setCounter('#presen_counter', '#profile_presentacion', 280);
	  facebookLoadUserName();
	  <?php if($hasDeepUpdates): ?>
	    facebookPublishStory({ body: '<?php echo __('He hecho profundos cambios en mi perfil de Voota. ')?><?php echo $profileEditForm['presentacion']->getValue()?>' });
	  <?php endif ?>
  });
  
  //-->
</script>


<h2><?php echo __('Hola %1%, este es tu perfil', array('%1%' => fullName($sf_user))) ?></h2>
<p class="next-step-msg"><?php echo link_to(__("Tus comentarios y vootos (en total %1%)", array('%1%' => format_number($numReviews, 'es_ES'))), '@usuario_votos') ?></p>
<p class="next-step-msg"><?php echo link_to(__("Tu perfil público"), "@usuario?username=".$sf_user->getGuardUser()->getProfile()->getVanity()) ?></p>
<?php if ($politico = isPolitico($sf_user->getGuardUser())):  ?>
  <p class="next-step-msg"><?php echo link_to(__('Tu página de político y lo que opinan sobre ti'), "politico/show?id=".$politico->getVanity()) ?></p>
<?php endif ?>

<div id="content">
  <?php echo showNotices( $sf_user ) ?>

  <div id="sidebar">
    <?php include_partial('perfil/boxProfile', array('user' => $sf_user->getGuardUser())) ?>
    <?php include_partial('general/boxPropuestas', array('propuestasCount' => $propuestasCount)) ?>
  </div>

  <form action="<?php echo url_for('@usuario_edit') ?>" method="post" autocomplete="" method="post" enctype="multipart/form-data">
    <table>
      <tr>
        <th><label for="profile_nombre"><?php echo __('Tu nombre') ?></label></th>
        <?php // TODO: Cambiar condición a "Si el usuario es un político" ?>
        <?php if ($politico): ?>
          <td class="politico">
            <?php echo $politico->getNombre(); ?>
          </td>
        <?php else: ?>
          <td>
            <?php echo $profileEditForm['nombre']->render() ?>
            <?php echo $profileEditForm['nombre']->renderError() ?>
          </td>
        <?php endif ?>
        <td class="hints"></td>
      </tr>
      <tr>
        <th><label for="profile_apellidos"><?php echo __('Tus apellidos') ?></label></th>
        <?php // TODO: Cambiar condición a "Si el usuario es un político" ?>
        <?php if ($politico): ?>
          <td class="politico">
            <?php echo $politico->getApellidos(); ?>
          </td>
        <?php else: ?>
          <td>
            <?php echo $profileEditForm['apellidos']->render(array('title' => __("(Opcional, pero ayuda)"))) ?>
            <?php echo $profileEditForm['apellidos']->renderError() ?>
          </td>
        <td class="hints"></td>
        <?php endif ?>
      </tr>
      <tr>
        <th><label for="profile_presentacion"><?php echo __('Presentación') ?></label></th>
        <td>
          <?php echo $profileEditForm['presentacion']->render(array('rows' => 8, 'cols' => 30, 'title' => __("¿Quién eres? ¿A qué te dedicas? ¡Expláyate en 280 caracteres! (Opcional, pero ayuda)"))) ?>
          <?php echo $profileEditForm['presentacion']->renderError() ?>
          <p id="presen_counter" class="counter"></p>
        </td>
        <td class="hints"></td>
      </tr>
      <tr>
        <th><label for="profile_fecha_nacimiento_day"><?php echo __('Fecha de nacimiento') ?></label></th>
        <td>
          <?php echo $profileEditForm['fecha_nacimiento']->render() ?>
          <span class="hints"><?php echo __('(Opcional, pero ayuda)') ?></span>
          <?php echo $profileEditForm['fecha_nacimiento']->renderError() ?>
        </td>
        <td class="hints"></td>
      </tr>
      <tr>
        <th><label for="profile_vanity"><?php echo __('Tu página en Voota') ?></label></th>
        <td class="vanity">
          <?php echo __('http://voota.es/') ?><?php echo $profileEditForm['vanity']->render() ?>
          <?php echo $profileEditForm['vanity']->renderError() ?>
        </td>
        <td class="hints"></td>
      </tr>
      <tr>
        <th><label for="profile_imagen"><?php echo __('Tu avatar') ?></label></th>
        <td class="avatar">
          <?php echo $profileEditForm['imagen']->render() ?>
          <?php echo $profileEditForm['imagen']->renderError() ?>
        </td>
        <td class="hints"></td>
      </tr>
      <tr>
        <th><label for="profile_username"><?php echo __('Tu Email') ?></label></th>
        <td class="email">
          <p>
            <?php echo $profileEditForm['username']->render() ?>
            <?php echo $profileEditForm['username']->renderError() ?>
          </p>
          <p>
            <?php echo $profileEditForm['mails_noticias']->render() ?>
            <label for="profile_mails_noticias"><?php echo __('Recibir emails de Voota') ?></label>
          </p>
          <p>
            <?php echo $profileEditForm['mails_contacto']->render(array('checked' => false)) ?>
            <label for="profile_mails_contacto"><?php echo __('Recibir emails de otros usuarios') ?></label>
          </p>
          <p>
            <?php echo $profileEditForm['mails_comentarios']->render() ?>
            <label for="profile_mails_comentarios"><?php echo __('Recibir un email cuando alguien opine sobre tus comentarios') ?></label>
          </p>
        </td>
        <td class="hints"></td>
      </tr>
      <tr>
        <th><label for="profile_enlace_n1_url"><?php echo __('Tus enlaces')?></label></th>
        <td>
          <ol class="links">
            <li>
              <?php echo $profileEditForm['enlace_n1']['orden']->render(array('value' => 1)) ?>
              <?php echo $profileEditForm['enlace_n1']['url']->render(array('title' => __('Ejemplo: Voota.es'))) ?>
              <?php echo $profileEditForm['enlace_n1']['url']->renderError() ?>
            </li>
            <li>
              <?php echo $profileEditForm['enlace_n2']['orden']->render(array('value' => 2)) ?>
              <?php echo $profileEditForm['enlace_n2']['url']->render() ?>
              <?php echo $profileEditForm['enlace_n2']['url']->renderError() ?>
            </li>
            <li>
              <?php echo $profileEditForm['enlace_n3']['orden']->render(array('value' => 3)) ?>
              <?php echo $profileEditForm['enlace_n3']['url']->render() ?>
              <?php echo $profileEditForm['enlace_n3']['url']->renderError() ?>
            </li>
            <li>
              <?php echo $profileEditForm['enlace_n4']['orden']->render(array('value' => 4)) ?>
              <?php echo $profileEditForm['enlace_n4']['url']->render() ?>
              <?php echo $profileEditForm['enlace_n4']['url']->renderError() ?>
            </li>
            <li>
              <?php echo $profileEditForm['enlace_n5']['orden']->render(array('value' => 5)) ?>
              <?php echo $profileEditForm['enlace_n5']['url']->render() ?>
              <?php echo $profileEditForm['enlace_n5']['url']->renderError() ?>
            </li>
          </ol>
        </td>
        <td class="hints"></td>
      </tr>
      <tr>
        <th><label>Facebook Connect</label></th>
        <td id="facebook-connect">
          <?php include_partial('editFBSuccess', array('sf_user' => $sf_user, 'profileEditForm' => $profileEditForm, 'lastReview' => $lastReview, 'lastReviewOnReview' => $lastReviewOnReview)) ?>
        </td>
      </tr>
      <tr>
        <th><label for="profile_passwordNew"><?php echo __('¿Nueva contraseña?') ?></label></th>
        <td>
          <?php echo $profileEditForm['passwordNew']->render() ?>
          <?php echo $profileEditForm['passwordNew']->renderError() ?>
        </td>
        <td class="hints"><?php echo __('(Déjalo en blanco si no quieres cambios aquí)') ?></td>
      </tr>
      <tr>
        <th><label for="profile_passwordBis"><?php echo __('Repítela nuevamente') ?></label></th>
        <td>
          <?php echo $profileEditForm['passwordBis']->render() ?>
          <?php echo $profileEditForm['passwordBis']->renderError() ?>
        </td>
        <td class="hints"></td>
      </tr>
      <tr>
        <th><label for="profile_passwordOld"><?php echo __('Contraseña actual') ?></label></th>
        <td>
          <?php echo $profileEditForm['passwordOld']->render() ?>
          <?php echo $profileEditForm['passwordOld']->renderError() ?>
        </td>
        <td class="hints"></td>
      </tr>
      <tr>
        <th></th>
        <td class="submit"><input type="submit" value="<?php echo __('Guardar cambios') ?>" /></td>
        <td class="hints"></td>
      </tr>
      <?php if ($isCanonicalVootaUser): ?>
        <tr>
          <th></th>
          <td class="remove">
            <p><?php echo __('Si no deseas utilizar más este servicio, aquí podrás abandonarnos. Por supuesto, todos tus datos asociados a Voota serán borrados.')?></p>
            <div id="bajaButtonDiv"><a href="#" id="bajaVoota"><?php echo __('Borrarse de Voota') ?></a></div>
            <div id="bajaConfirmDiv" class="hidden">
            	<?php echo __('¿Seguro?')?>
            	<?php echo link_to(__('Sí'), '@usuario_remove'
    			, array('class' => 'confirm')) ?>
            	<a href="#" id="noConfirm"><?php echo __('No')?></a>
            </div>
          </td>
          <td class="hints"></td>
        </tr>
    <?php endif ?>
    </table>
  </form>
</div>