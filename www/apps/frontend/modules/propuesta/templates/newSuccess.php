<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoNotice') ?>

<?php slot('menu') ?>
	<?php include_partial('global/menu', array('tab' => 'pro')) ?>
<?php end_slot('menu') ?>

<script type="text/javascript">
  <!--//
  $(document).ready(function() {
    $('#propuesta_titulo').keyup(function() {
		  setCounter('#propuesta_titulo_counter', this, 80);
	  });
	  setCounter('#propuesta_titulo_counter', '#propuesta_titulo', 80);
	  $('#propuesta_descripcion').keyup(function() {
		  setCounter('#propuesta_descripcion_counter', this, 600);
	  });
	  setCounter('#propuesta_descripcion_counter', '#propuesta_descripcion', 600);
  });
  //-->
</script>

<div class="new-success">
  <h2><?php echo __('Proponer una propuesta política:') ?></h2>

  <?php echo showNotices( $sf_user ) ?>

  <div id="content">
    <form method="post" action="<?php echo url_for('propuesta/new')?>" enctype="multipart/form-data">
      <div><input type="hidden" name="op" value="r" /></div>
      <table>
        <tr>
          <th><label for="propuesta_titulo"><?php echo __('Titular de la propuesta') ?></label></th>
          <td>
            <?php echo $form['titulo']->render() ?>
            <?php echo $form['titulo']->renderError() ?>
            <p id="propuesta_titulo_counter" class="counter"></p>
          </td>
          <td class="hints"><?php echo __('Necesario. Indica brevemente de qué va la propuesta política.') ?></td>
        </tr>
        <tr>
          <th><label for="propuesta_descripcion"><?php echo __('Descripción') ?></label></th>
          <td>
            <?php echo $form['descripcion']->render() ?>
            <?php echo $form['descripcion']->renderError() ?>
            <p id="propuesta_descripcion_counter" class="counter"></p>
          </td>
          <td class="hints"><?php echo __('Necesario. Ofrece al resto de la comunidad una descripción de la propuesta.') ?></td>
        </tr>
        <tr>
          <th><label for="propuesta_imagen"><?php echo __('Imagen') ?></label></th>
          <td class="avatar">
            <?php echo $form['imagen']->render() ?>
            <?php echo $form['imagen']->renderError() ?>
          </td>
          <td class="hints"><?php echo __('Alguna imagen que sirva para ilustrar la propuesta (opcional, pero ayuda)') ?></td>
        </tr>
        <tr>
          <th><label for="propuesta_documento"><?php echo __('Documento') ?></label></th>
          <td>
              <p><?php echo __('PDF, Office, OpenOffice... (Máx 2Mb)')?></p>
            <?php echo $form['doc']->render() ?>
            <?php echo $form['doc']->renderError() ?>
          </td>
          <td class="hints"><?php echo __('Incluye 1 fichero que ofrezca información adicional sobre la propuesta (opcional, pero ayuda)') ?></td>
        </tr>
        <tr>
          <th><label for="propuesta_enlace_n1_url"><?php echo __('Enlaces')?></label></th>
          <td>
            <ol class="links">
              <li>
                <?php echo $form['enlace_n1']['orden']->render(array('value' => 1)) ?>
                <?php echo $form['enlace_n1']['url']->render(array('title' => __('Ejemplo: Voota.es'))) ?>
                <?php echo $form['enlace_n1']['url']->renderError() ?>
              </li>
              <li>
                <?php echo $form['enlace_n2']['orden']->render(array('value' => 2)) ?>
                <?php echo $form['enlace_n2']['url']->render() ?>
                <?php echo $form['enlace_n2']['url']->renderError() ?>
              </li>
              <li>
                <?php echo $form['enlace_n3']['orden']->render(array('value' => 3)) ?>
                <?php echo $form['enlace_n3']['url']->render() ?>
                <?php echo $form['enlace_n3']['url']->renderError() ?>
              </li>
              <li>
                <?php echo $form['enlace_n4']['orden']->render(array('value' => 4)) ?>
                <?php echo $form['enlace_n4']['url']->render() ?>
                <?php echo $form['enlace_n4']['url']->renderError() ?>
              </li>
              <li>
                <?php echo $form['enlace_n5']['orden']->render(array('value' => 5)) ?>
                <?php echo $form['enlace_n5']['url']->render() ?>
                <?php echo $form['enlace_n5']['url']->renderError() ?>
              </li>
            </ol>
          </td>
          <td class="hints"><?php echo __('(opcional, pero ayuda)') ?></td>
        </tr>
        <tr>
          <th></th>
          <td class="submit">
            <span><?php echo __('¿Seguimos?')?></span>
            <input name="button" type="submit" class="button" value="<?php echo __('Ver cómo quedará')?>" />
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>