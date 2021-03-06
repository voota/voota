<?php use_helper('I18N') ?>
<?php use_helper('SfReview') ?>
<?php use_helper('VoUser') ?>

<?php slot('menu') ?>
	<?php include_partial('global/menu', array('tab' => 'opi')) ?>
<?php end_slot('menu') ?>

<script type="text/javascript">
  <!--
  $(document).ready(function(){
	  $('#f').change(function(){
		  $('#filterForm').submit();
	  });
  });
  //-->
</script>

<div id="content">
  <h2><?php echo __('Propuestas, comentarios y vootos que has hecho hasta ahora (%1%)', array('%1%' => $reviews->getNbResults())) // TODO: Contar propuestas + comentarios + vootos ?></h2>
  <p class="next-step-msg"><?php echo link_to(__('Tu perfil'), "@usuario_edit"); ?></p>
  <p class="next-step-msg"><?php echo link_to(__('Echa un vistazo a cómo otros usuarios ven tu perfil'), "@usuario?username=".$sf_user->getGuardUser()->getProfile()->getVanity()); ?></p>
  <?php if ($politico = isPolitico($sf_user->getGuardUser())): ?>
    <p class="next-step-msg"><?php echo link_to(__('Tu página de político y lo que opinan sobre ti'), "politico/show?id=".$politico->getVanity()) ?></p>
  <?php endif ?>

  <div class="propuestas">
    <h2><?php echo __('Tus propuestas (%1%)', array('%1%' => count($propuestas)))  ?></h2>
    <ol>
	    	<?php foreach ($propuestas as $propuesta):?>
		      <?php include_partial('propuesta', array('propuesta' => $propuesta))  ?>
	    	<?php endforeach ?>
    </ol>
  </div>

  <div class="comments reviews">
    <h2><?php echo __('Comentarios y vootos que has hecho hasta ahora (en total, %1%)', array('%1%' => $reviews->getNbResults()))?></h2>
   	<?php include_component_slot('review_list_by_user', array( 'page' => 1, 'sfReviewType' => $sfReviewType, 'filter' => $text, 'user' => $user, 'userId' => $user->getId() )) ?>
  </div>
</div>