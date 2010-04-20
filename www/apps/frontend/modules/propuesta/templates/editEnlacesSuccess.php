<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoNotice') ?>

    <form method="post" action="<?php echo url_for('propuesta/new')?>" enctype="multipart/form-data">
      <div><input type="hidden" name="op" value="r" /></div>
      <table>
        <tr>
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
        </tr>
        <tr>
          <td class="submit">
            <input name="button" type="submit" class="button" value="<?php echo __('Guardar')?>" />
          </td>
        </tr>
      </table>
    </form>
