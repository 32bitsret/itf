jQuery(document).ready(function() {

	var options = '<option value="0" > -- Select -- </option>';

	jQuery.each(wp_data.post_content, function (i, item) {
        options += '<option value="'+item.content_id+'">'+item.post_title+'</option>';
    });

	var quiz_id = jQuery('#wpcw_quiz_details_modify').find('input[name="quiz_id"]').val();

	if (quiz_id) {

	    var selection = '<select id="xapi_content">'+options+'</select>';

		var trHTML = '<tr class="form-field  wpcw_quiz_details_modify_quiz_title_tr">\
						<th>Add xAPI Content</th>\
						<td id="xapi_content_td">'+selection+'</td>\
					  </tr>';

		jQuery('#wpcw_section_break_quiz_general').append(trHTML);

		jQuery.ajax({
            type : "POST",
            dataType : "json",
            url : wp_data.ajax_url,
            data : {action: "wpcw_get_xapi_content_id", quiz_id : quiz_id},
            success:function(data){
            	if (data != null && typeof data == "object" && typeof data.xapi_content_id == "number" && data.xapi_content_id > 0) {
				    jQuery('#xapi_content').val(data.xapi_content_id);
				    jQuery("#xapi_content_td").append(' <a id="edit_xapi_content" class="button-primary" target="_black"href="'+wp_data.admin_url+'post.php?action=edit&message=1&post='+ data.xapi_content_id +'">Edit Content</a>');
				}
			},
			error: function(errorThrown){
			    console.log(errorThrown);
			} 
        }); 

        jQuery('#xapi_content').on('change', function(e) { 

			var xapi_content_id = jQuery('#xapi_content').val();
			if(xapi_content_id > 0) {
				if(jQuery("#edit_xapi_content").length){
					jQuery("#edit_xapi_content").attr("href", wp_data.admin_url+'post.php?action=edit&message=1&post='+xapi_content_id);
				} else {
					jQuery("#xapi_content_td").append(' <a id="edit_xapi_content" class="button-primary" target="_black"href="'+wp_data.admin_url+'post.php?action=edit&message=1&post='+xapi_content_id+'">Edit Content</a>');
				}
			}
			else
				jQuery("#edit_xapi_content").remove();

		}); // end of change

		jQuery('#wpcw_quiz_details_modify').on('submit', function(e) { 

			var xapi_content_id = jQuery('#xapi_content').val();
			
			var quiz_id = jQuery('#wpcw_quiz_details_modify').find('input[name="quiz_id"]').val();

			var data = {"xapi_content_id":xapi_content_id , "quiz_id":quiz_id}

	    	jQuery.ajax({
	            type : "POST",
	            dataType : "json",
	            url : wp_data.ajax_url,
	            data : {action: "wpcw_add_xapi_content", data : data},
	        });   

		}); // end of change

	} // end of if quizId exist

	jQuery("#wpcw-course-builder-metabox").click(function() {

		jQuery('.builder-draggable-quizzes').each(function() {

			var unit_div_id = jQuery(this).parent().attr('id');
			var unit_id = unit_div_id.substring(5);
			var divHTML = '<br><div class="xapi_div">\
								<strong>or  Add xAPI Content   </strong>  \
								<select id="xapi_content'+unit_id+'">'+options+'</select>\
								<button onclick="create_xapi_quiz('+unit_id+');" type=button class="button-primary"><i class="wpcw-fas wpcw-fa-plus-circle"></i>    Add xAPI Content</button>\
						   </div>'; 

			if (((jQuery(this).children('.xapi_div').length) < 1) && ((jQuery(this).children('.builder-quiz').length) < 1)) {
			    jQuery(this).append(divHTML);
			} 
			
			if (jQuery(this).children('.builder-quiz').length){
				jQuery(".builder-quiz").siblings().hide();
			}
		});

	});

}); // end of ready


function create_xapi_quiz(unit_id){

	var content_id = jQuery('#xapi_content'+unit_id+'').val();

	var data = {"xapi_content_id":content_id , "unit_id":unit_id }

	jQuery.ajax({
            type : "POST",
            dataType : "json",
            url : wp_data.ajax_url,
            data : {action: "wpcw_create_xapi_quiz", data : data},
            success:function(data){
			    location.reload();
			},
        });

} // end of create_xapi_quiz
