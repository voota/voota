<?php include_component_slot((isset($slot) && $slot)?$slot:'review_list', array(
	'entityId' => $entityId, 'value' => $value
	, 'page' => $page
	, 'sfReviewType' => $sfReviewType
	, 'entity' => isset($entity)?$entity:null
	, 'filter' => $filter
)) ?>