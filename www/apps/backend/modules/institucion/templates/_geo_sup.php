            <div class="sf_admin_form_row sf_admin_text sf_admin_form_field_orden">
        <div>
      <label for="institucion_orden">Geo superior</label>
      <div class="content">&nbsp;
<?php 
if ($form->getObject()->getGeo()){
	echo $form->getObject()->getGeo()->getGeoRelatedByGeoId();
}
?>
</div>

          </div></div>


