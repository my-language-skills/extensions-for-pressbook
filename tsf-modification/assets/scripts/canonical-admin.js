jQuery(document).ready(function () {
	jQuery("input.canonical").on("change",function(){
		var id=jQuery(this).parent("td").siblings("th").children("input").val();
		var val=jQuery(this).prop("checked");
		jQuery.ajax(
			{url:ajaxurl,
			 type:"POST",
			 data:{
			 	action:"efpb_mark_canonical",
			 	book_id:id,
			 	canonical:val,
			 	_ajax_nonce:PB_Aldine_Admin.aldineAdminNonce
			 },
			 success:function(){
			 	if (val == 1) {
			 		alert('Book has no canonical link!');
			    } else {
			    	alert('Book has canonical link!');
			    }
			 }
		    }
		);
	});
});
