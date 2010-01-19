      <?php if ($sf_context->getModuleName() != "home"): ?>
        <div id="search">
          <?php echo form_tag_for($searchForm, '@search') ?>
            <fieldset>
              <?php echo input_tag('q', $sf_params->get('q')) ?>
      	      <?php echo submit_tag(__('Buscar'), array('class' => 'button')) ?>
            </fieldset>
          </form>
        </div>
      <?php endif ?>