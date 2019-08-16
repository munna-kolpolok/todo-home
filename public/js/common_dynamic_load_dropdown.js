function common_dropdown(id,table_name,value,text,edit_id=null)  //dropdown html id,drop down table name,value of the dropdown,text of the dropdown,dropdown selected id while editing
{
	$("#"+id).find("option:not(:first)").remove();
	var url=urlCommonDropDown;
	var options = $("#"+id);
	$.post(url,{'table_name':table_name},function( data ) {
		$.each(data, function() {
			if(this[value]==edit_id){
				options.append($("<option selected/>").val(this[value]).text(this[text]));
			}else{
				options.append($("<option />").val(this[value]).text(this[text]));
			}
		    
		});
	});
}
function common_dynamic_load_dropdown(parent_id,child_id,child_table_name,parent_id_name,value,text,edit_child_id=null,edit_parent_id=null)  //1st dropdown html id,2nd dropdown html id,2nd drop down table name,FK name of the 2nd drop down table,value of the 2nd selectbox,text of the 2nd selectbox,2nd selectbox selected id while editing
{
	$("#"+child_id).find("option:not(:first)").remove();
	if(edit_parent_id){
		var parent_id=edit_parent_id;
	}else{
		var parent_id=$("#"+parent_id+' option:selected').val();
	}
	var url=urlDynamicDropDown;
	var options = $("#"+child_id);
	$.post(url,{'child_table_name':child_table_name,'parent_id_name':parent_id_name,'parent_id':parent_id},function( data ) {
		$.each(data, function() {
			if(this[value]==edit_child_id){
				options.append($("<option selected/>").val(this[value]).text(this[text]));
			}else{
				options.append($("<option />").val(this[value]).text(this[text]));
			}
		    
		});
	});
}

// function common_dynamic_load_dropdown_date_concat(parent_id,child_id,child_table_name,parent_id_name,value,text,edit_child_id=null,edit_parent_id=null)  //1st dropdown html id,2nd dropdown html id,2nd drop down table name,FK name of the 2nd drop down table,value of the 2nd selectbox,text of the 2nd selectbox,2nd selectbox selected id while editing
// {
// 	$("#"+child_id).find("option:not(:first)").remove();
// 	if(edit_parent_id){
// 		var parent_id=edit_parent_id;
// 	}else{
// 		var parent_id=$("#"+parent_id+' option:selected').val();
// 	}
// 	var url=urlDynamicDropDownDateConcat;
// 	var options = $("#"+child_id);
// 	$.post(url,{'child_table_name':child_table_name,'parent_id_name':parent_id_name,'parent_id':parent_id},function( data ) {
// 		$.each(data, function() {
// 			var from_date = new Date(this.from_date);
// 			var from_date_format=(from_date.getDate() + '/' +from_date.getMonth() + 1) + '/' + from_date.getFullYear();

// 			var to_date = new Date(this.to_date);
// 			var to_date_format=(to_date.getDate() + '/' +to_date.getMonth() + 1) + '/' + to_date.getFullYear();

// 			if(this[value]==edit_child_id){
// 				options.append($("<option selected/>").val(this[value]).text(from_date_format.concat(' to ',to_date_format)));
// 			}else{
// 				options.append($("<option />").val(this[value]).text(from_date_format.concat(' to ',to_date_format)));
// 			}
		    
// 		});
// 	});
// }



