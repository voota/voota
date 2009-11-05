<table>
<tr><td>value:</td><td><?php echo $form->getObject()->getValue() ?></td></tr> 
<tr><td>type:</td><td><?php echo $form->getObject()->getSfReviewType() ?></td></tr> 
<tr><td>entity:</td><td><?php echo $form->getObject()->getEntityId() ?></td></tr> 
<tr><td>user:</td><td><?php echo $form->getObject()->getSfGuardUser() ?></td></tr> 
<tr><td>text:</td><td><?php echo $form->getObject()->getText() ?></td></tr> 
<tr><td>ip address:</td><td><?php echo $form->getObject()->getIpAddress() ?></td></tr> 
<tr><td>cookie:</td><td><?php echo $form->getObject()->getCookie() ?></td></tr> 
<tr><td>created at:</td><td><?php echo $form->getObject()->getCreatedAt() ?></td></tr> 
<tr><td>modified at:</td><td><?php echo $form->getObject()->getModifiedAt() ?></td></tr> 
</table>

	