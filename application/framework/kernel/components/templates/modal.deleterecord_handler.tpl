<script>
/**
* Eliminar un registro* 
* @return
*/
function deleterecord_handler(id){
	bootbox.confirm({
	    title: "<span style=\"text-transform: uppercase;\">:text - <small>{Lang::get('dashboard.info.delete')}</small></span>",
	    size: "small",
	    message: "{Lang::get('dashboard.actions.delete_confir')}",
	    buttons: {
	        cancel: {
	            label: '<i class="fa fa-times"></i> {Lang::get("cancel")}',
	            className: "btn-danger"
	        },
	        confirm: {
	            label: '<i class="fa fa-check"></i> {Lang::get("confir")}',
	            className: "btn-success"
	        }
	    },
	    callback: function (result) {
	    	if( result ){
	    		deleterecord_callback(id);
	    	}
	    }
	});
}

function deleterecord_callback( id ){
	$.ajax({
		url : ":controller_delete" + id,
		type : "DELETE",
		dataType: "JSON",
		beforeSend: function( e ) {
			$.loading({ text: "{Lang::get('processing')}..." });
		}
	}).done(function( data ) {
		$("#tr_" + id).addClass("delete_success");
		if( data.status == 204 ){
			setTimeout(function(){
				_dt_data.row("#tr_"+id).remove().draw( false );
			}, 1100);
		}
		$.loading("hide");
	});
}
</script>