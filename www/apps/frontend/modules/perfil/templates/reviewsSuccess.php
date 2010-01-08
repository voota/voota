<?php use_helper('I18N') ?>
<?php use_helper('SfReview') ?>
     
      <h2><?php echo __('Comentarios y vootos que has hecho hasta ahora (en total, %1%)', array('%1%' => $reviews->getNbResults()))?></h2>
      <p class="next-step-msg"><?php echo link_to(__('Tus preferencias'), "@usuario_edit"); ?></p>
      <p class="next-step-msg"><?php echo link_to(__('Echa un vistazo a cómo otros usuarios ven tu perfil'), "@usuario?username=".$sf_user->getGuardUser()->getProfile()->getVanity()); ?></p>
      
      <div id="content">
      <?php /* ?>
        <p class="filter">
          <label for="filter"><?php echo __('Filtrar comentarios por:')?></label>
          <br />
          <select name="filter" id="filter">
            <option value="todos"><?php echo __('Todos los comentarios')?></option>
            <option value="partidos">Por partidos</option>
            <option value="partidos">Por respuestas a otros comentarios</option>
          </select>
        </p>
      <?php */ ?>
        
        <div class="comments">
          <table>
          
<?php foreach ($reviews->getResults() as $review): ?>
	<?php include_component_slot('profileReview', array('review' => $review)) ?>
<?php endforeach ?>

          </table>
        <div id="more_reviews">
		  <?php if ($reviews->haveToPaginate() && $reviews->getLastPage() > $reviews->getPage()): ?>
		      <?php echo jq_form_remote_tag(array(
		    	'update'   => "more_reviews",
		    	'url'      => "@profile_more_comments",
  	  			'before' => "re_loading('more_reviews')"
		      ),
		        array('id' => "frm_more_reviews"
		      )) ?>
			  <?php echo input_hidden_tag('username', $user->getProfile()->getVanity())?>
			  <?php echo input_hidden_tag('page', 1)?>
			  <?php echo submit_tag(__('más')) ?>
			</form>
		  <?php endif ?>
        </div>
        </div>
      </div>
