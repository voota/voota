<?php  if ($form->getObject()->getSfGuardUserId()): ?>
<div>
	Usuario: <a href="<?php echo '/'. $form->getObject()->getSfGuardUser()->getProfile()->getVanity() ?>"><?php echo $form->getObject()->getSfGuardUser() ?></a>
</div>
<div>
	Propuesta: <a href="<?php echo '/propuesta/'. $form->getObject()->getVanity() ?>"><?php echo $form->getObject()->getTitulo() ?></a>
</div>
<?php endif ?>	


