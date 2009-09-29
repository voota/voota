
function loadReviewBox(t, e, v) {
	jQuery.ajax({type:'POST',dataType:'html',success:function(data, textStatus){jQuery('#sf_review').html(data);},url:'/review/form?t='+t+'&e='+e+'&v='+v+''}); return false;
}
