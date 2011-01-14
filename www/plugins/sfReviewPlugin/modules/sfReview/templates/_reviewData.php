<table>
<tr><td>value:</td><td><?php echo $form->getObject()->getValue() ?></td></tr> 
<tr><td>type:</td><td><?php echo $form->getObject()->getSfReviewType() == null?'An other review':$form->getObject()->getSfReviewType() ?></td></tr> 
<tr><td>entity:</td><td>
<?php echo link_to($entityText, "$type/edit?id=".$entityId) ?>
</td></tr> 
<tr><td>user:</td><td>
<?php echo $form->getObject()->getAnonymous()?'voto secreto':link_to($form->getObject()->getSfGuardUser(), "sfGuardUser/edit?id=".$form->getObject()->getSfGuardUser()->getId()) ?>
</td></tr> 
<tr><td>text:</td><td><?php echo $form->getObject()->getText() ?></td></tr> 
<tr><td>ip address:</td><td><?php echo $form->getObject()->getIpAddress() ?></td></tr> 
<tr><td>cookie:</td><td><?php echo $form->getObject()->getCookie() ?></td></tr> 
<tr><td>created at:</td><td><?php echo $form->getObject()->getCreatedAt() ?></td></tr> 
<tr><td>modified at:</td><td><?php echo $form->getObject()->getModifiedAt() ?></td></tr> 
<tr><td>is active:</td><td><?php echo $form->getObject()->getIsActive() ?></td></tr> 
<tr><td>sent to Facebook:</td><td><?php echo $form->getObject()->getToFb() ?></td></tr> 
<tr><td>sent to Twitter:</td><td><?php echo $form->getObject()->getToTw() ?></td></tr> 
<tr><td>source:</td><td><?php echo $form->getObject()->getSource() ?></td></tr> 
</table>

	