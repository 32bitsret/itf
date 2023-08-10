(function ($) {
  "use strict";

  var course_ajax = null;
  $(document).ready(function () {

    const { __, _x, _n, sprintf } = wp.i18n;

    jQuery('body').addClass('wbcom-ld-dashboard');
    var frame = wp.media({
      title: __("Select or Upload Media", "ld-dashboard" ),
      button: {
        text: __( "Use this media", "ld-dashboard" ),
      },
      multiple: false, // Set to true to allow multiple files to be selected
    });

    if ( jQuery('.ld-dashboard-trial-duration-field').length ) {
      jQuery('.ld-dashboard-trial-duration-field').find('.acf-input-wrap').remove();
    }

    if ( jQuery('.zoom-meeting-wrapper').length ) {
      jQuery('.ld-dashboard-create-meeting-wrap').css( 'opacity', '0' );
      jQuery('.ld-create-meeting-action').on('click', function(e){
        e.preventDefault();
        if ( jQuery(this).hasClass('has-no-credentials') ) {
          let setCredentialPopupContent = '<div class="ld-dashboard-create-zoom-meeting-model-main"><div class="ld-dashboard-create-zoom-meeting-model-inner"><div class="ld-dashboard-create-zoom-meeting-close-btn close-set-cred-modal">×</div><div class="ld-dashboard-create-zoom-meeting-pop-up-content">' + ld_dashboard_js_object.set_credentials_text + '</div></div></div>';
          jQuery('.ld-dashboard-wrapper').append( setCredentialPopupContent );
          return false;
        }
        let type = jQuery(this).data('type');
        let post_id = jQuery(this).data('post');
        let params = {
          action: "ld_dashboard_load_meeting_form",
          type: type,
          nonce: ld_dashboard_js_object.ajax_nonce,
        };
        if( post_id ) {
          params.post_id = post_id;
        }
        jQuery.ajax({
          url: ld_dashboard_js_object.ajaxurl,
          type: "post",
          data: params,
          success: function (response) {
            jQuery('.ld-dashboard-create-meeting-wrap').html( response );
            jQuery('.ld-dashboard-create-meeting-wrap').css( 'opacity', '1' );
            jQuery('.ld-dashboard-create-meeting-wrap').addClass('create-meeting-form-open');
            jQuery('.zoom-meeting-list-wrap').addClass('zoom-meeting-list-wrap-section');
          },
        });
      });
      jQuery(document).on('click', '.close-set-cred-modal', function(){
        jQuery(this).closest('.ld-dashboard-create-zoom-meeting-model-main').remove();
      });
      jQuery(document).on( 'click', '.ld-dashboard-meeting-recordings-btn', function(){
        let meetingId = jQuery(this).data('id');
        let recordings_container = jQuery(this).closest('.zoom-meeting-inner-list').find('.ld-dashboard-meeting-recordings-wrapper');
        if ( ! jQuery(this).closest('.zoom-meeting-inner-list').hasClass('recordings-content-open') ) {
          jQuery( recordings_container ).css( 'opacity', '1' );
          jQuery(this).closest('.zoom-meeting-inner-list').addClass('recordings-content-open');
          let params = {
            action: "ld_dashboard_get_meeting_recordings",
            meeting_id: meetingId,
            nonce: ld_dashboard_js_object.ajax_nonce,
          };
          jQuery.ajax({
            url: ld_dashboard_js_object.ajaxurl,
            type: "post",
            data: params,
            success: function (response) {
              jQuery( recordings_container ).html(response);
            },
          });
        } else {
          jQuery( recordings_container ).css( 'opacity', '0' );
          jQuery(this).closest('.zoom-meeting-inner-list').removeClass('recordings-content-open');
        }
      });
      jQuery( document ).on( 'click', '.ld-dashboard-create-meeting-form-row.ld-create-meeting-btn', function(e){
        e.preventDefault();
        jQuery('#ld-dashboard-meeting-form').trigger('submit');
      });
      jQuery(document).on( 'submit', '#ld-dashboard-meeting-form', function(e){
        e.preventDefault();
        if (!jQuery('.ld-dashboard-form-group-row input[name="zoom_details[topic]"]').val()){
          jQuery('.ld-dashboard-form-group-row input[name="zoom_details[topic]"]').focus();
          return false;
        }
        jQuery('.ld-dashboard-meeting-form-loader').show();
        let data = jQuery('#ld-dashboard-meeting-form').serializeArray();
        let jsonData = {};
        jQuery(data).each(function(key,item){
          jsonData[item.name] = item.value;
        });
        let params = {
          action: "ld_dashboard_create_meeting",
          formData: jsonData,
          nonce: ld_dashboard_js_object.ajax_nonce,
        };
        jQuery.ajax({
          url: ld_dashboard_js_object.ajaxurl,
          type: "post",
          data: params,
          success: function (response) {
            location.reload();
          },
        });
      });
      jQuery('.ld-delete-meeting-action').on('click', function(e){
        e.preventDefault();
        let conf_delete = confirm( __( 'Are you sure?', 'ld-dashboard' ) );
        if ( conf_delete ) {
          let post_id = jQuery(this).data('post');
          let meeting = jQuery(this).data('meeting');
          let params = {
            action: "ld_dashboard_delete_meeting",
            post_id: post_id,
            meeting: meeting,
            nonce: ld_dashboard_js_object.ajax_nonce,
          };
          jQuery.ajax({
            url: ld_dashboard_js_object.ajaxurl,
            type: "post",
            data: params,
            success: function (response) {
              location.reload();
            },
          });
        }
      });
      jQuery(document).on('click', '.ld-dashboard-create-meeting-close-btn', function(e){
        e.preventDefault();
        jQuery('.ld-dashboard-create-meeting-wrap').html('');
        jQuery('.ld-dashboard-create-meeting-wrap').removeClass('create-meeting-form-open');
        jQuery('.zoom-meeting-list-wrap').removeClass('zoom-meeting-list-wrap-section');
      });
    }

    if ( jQuery('.ld-dashboard-submit-msg-wrapper').length ) {
      jQuery("div.ld-dashboard-submit-msg-wrapper").animate(
        {
          left: '20px',
          opacity: '1'
        }
      );
      setTimeout(function() {
        jQuery("div.ld-dashboard-submit-msg-wrapper").animate(
          {
            left: '-300px',
            opacity: '0'
          }
        );
      }, 5000);
    }

    if ( jQuery('#add_withdraw').length ) {
      jQuery('.ld-dashboard-withdraw-method-fields').hide();
      let method = jQuery('.ld-dashboard-selected-method').val();
      if ( '' !== method ) {
        jQuery('.ld-dashboard-withdraw-method-fields').each(function(){
          let currentMethod = jQuery(this).data('type');
          if ( currentMethod == method ) {
            jQuery(this).show();
          }
        });
      }
      jQuery('.ld-dashboard-withdraw-method-radio').on('change', function(){
        jQuery('.ld-dashboard-withdraw-method-single').each(function(){
          jQuery(this).removeClass('ld-dashboard-withdraw-method-active');
        });
        jQuery(this).closest('.ld-dashboard-withdraw-method-single').addClass('ld-dashboard-withdraw-method-active');
        jQuery('.ld-dashboard-withdraw-method-fields').hide();
        let type = jQuery(this).val();
        jQuery('.ld-dashboard-withdraw-method-fields').each(function(){
          jQuery(this).find('input').each(function(){
            jQuery(this).val('');
          });
          let currentType = jQuery(this).data('type');
          if ( currentType == type ) {
            jQuery(this).show();
          }
        });
      });
      jQuery('#ldd_save_withdraw_method').on('click', function(e){
        e.preventDefault();
        jQuery('#add_withdraw').trigger('submit');
      });
      jQuery('#add_withdraw').on('submit', function(e){
        e.preventDefault();
        let fields = jQuery(this).serializeArray();
        let formdata = [];
        fields.forEach(( item ) => {
          formdata[ item.name ] = item.value;
        });
        let params = {
          action: "ld_dashboard_save_withdraw_method",
          form_data: fields,
          nonce: ld_dashboard_js_object.ajax_nonce,
        };
        jQuery.ajax({
          url: ld_dashboard_js_object.ajaxurl,
          type: "post",
          data: params,
          success: function (response) {
            location.reload();
          },
        });
      });
    }

    if ( jQuery('.ld-dashboard-withdrawal-pop-up-wrapper').length ) {
      jQuery('.ld-dashboard-withdraw-modal-btn').on('click', function(){
        jQuery('.ld-dashboard-withdrawal-pop-up-wrapper').css({
          'opacity' : 1,
          'z-index' : 9999999
        });
        jQuery('.ld-dashboard-withdrawal-pop-up-wrapper').addClass('ld-dashboard-popup-active');
      });
      jQuery('.ld-dashboard-cancel-withdrawal-request').on('click', function(){
        jQuery('.ld-dashboard-withdrawal-pop-up-wrapper').css({
          'opacity' : 0,
          'z-index' : -1
        });
        jQuery('.ld-dashboard-withdrawal-pop-up-wrapper').removeClass('ld-dashboard-popup-active');
      });
      jQuery('.ld-dashboard-submit-withdrawal-request').on('click', function(){
        let minAmount = jQuery(this).data('min');
        let earning = jQuery(this).data('earning');
        let amount = jQuery('.ld-dashboard-withdrawal-amount').val();
        let hasError = false;
        if ( amount == '' ) {
          alert( __( 'Please enter an amount', 'ld-dashboard' ) );
          hasError = true;
        } else if ( earning < amount ) {
          alert( __( 'You don`t have sufficent funds.', 'ld-dashboard' ) );
          hasError = true;
        } else if ( minAmount > amount ) {
          alert( __( 'Amount should be greater than ', 'ld-dashboard' ) + minAmount );
          hasError = true;
        }
        if (hasError) {
          return false;
        }
        jQuery(this).attr( 'disabled', 'disabled' );
        let params = {
          action: "ld_dashboard_request_withdrawal",
          nonce: ld_dashboard_js_object.ajax_nonce,
          amount: amount,
        };
        jQuery.ajax({
          url: ld_dashboard_js_object.ajaxurl,
          type: "post",
          data: params,
          success: function (response) {
            location.reload();
          },
        });
      });
    }

    if ( jQuery('#learndash_shortcodes').length ) {
      let atts = {
        popup_title: __( 'LearnDash Shortcodes', 'ld-dashboard'),
        popup_type: 'jQuery-dialog',
        typenow: learndash_admin_shortcodes_assets.typenow,
        pagenow: 'post.php',
        nonce: learndash_admin_shortcodes_assets.nonce,
      }
      let params = {
        action: "learndash_generate_shortcodes_content",
        atts: atts,
      };
      jQuery.ajax({
        url: ld_dashboard_js_object.ajaxurl,
        type: "post",
        data: params,
        success: function (response) {
          jQuery('#learndash_shortcodes').html(response);
          learndash_shortcodes.popup_init();
        },
      });
    }

    if ( jQuery('.ld-dashboard-become-instructor-btn').length ) {
      jQuery('.ld-dashboard-become-instructor-btn').on('click', function(e){
        e.preventDefault();
        let con = confirm('Are you sure?');
        if ( !con ) {
          return;
        }
        let nonce = ld_dashboard_js_object.ajax_nonce;
        let params = {
          action: "ld_dashboard_set_as_instructor_pending",
          nonce: nonce,
        };
        jQuery.ajax({
          url: ld_dashboard_js_object.ajaxurl,
          type: "post",
          data: params,
          success: function (response) {
            location.reload();
          },
        });
      })
    }

    if ( jQuery('.my-announcements-wrapper').length ) {
      jQuery('.ld-dashboard-announcement-course-dropdown').on( 'change', function(){
        let course = jQuery(this).val();
        if ( course != '' ) {
          jQuery('.ld-dashboard-announcement-fields-wrapper').show();
        } else {
          jQuery('.ld-dashboard-announcement-fields-wrapper').hide();
        }
      });
      jQuery('.ld-dashboard-create-announcement-btn').on('click', function(e){
        e.preventDefault();
        jQuery('.ld-dashboard-msg-box').html('');
        jQuery('.ld-dashboard-msg-box.announcement-submit').removeClass('ld-dashboard-announcement-msg-submit');
        jQuery('.ld-dashboard-msg-box.announcement-title').removeClass('ld-dashboard-announcement-msg-title');
        jQuery('#ld-dashboard-new-announcement-form').trigger('submit');
      });
      jQuery('#ld-dashboard-new-announcement-form').on('submit', function(e){
        e.preventDefault();
        tinyMCE.triggerSave();
        let fields = jQuery(this).serializeArray();
        let formdata = [];
        fields.forEach(( item ) => {
          formdata[ item.name ] = item.value;
        });
        if ( formdata['post_title'] == '' ) {
          displayAnnouncementMessageBox( __('Title cannot be empty.', 'ld-dashboard' ), 'error');
          return false;
        }
        let params = {
          action: "ld_dashboard_add_new_announcement",
          form_data: fields,
          nonce: ld_dashboard_js_object.ajax_nonce,
        };
        jQuery.ajax({
          url: ld_dashboard_js_object.ajaxurl,
          type: "post",
          data: params,
          success: function (response) {
            let msg = '';
            if ( parseInt( response ) > 0 ) {
              msg = __( 'Annoucement created successfully.', 'ld-dashboard' );
              displayAnnouncementMessageBox(msg, 'success');
           }
          },
        });
      });
    }

    if ( jQuery('.announcements-wrapper').length ) {
      jQuery('.ld-dashboard-announcement-single-title').on('click', function(){
        let id = jQuery(this).data('id');
        jQuery('.ld-dashboard-announcement-content-wrapper').addClass('ldd-hide-popup');
        jQuery('.ld-dashboard-announcement-content-wrapper').removeClass('ldd-show-popup');
        let params = {
          action: "ld_dashboard_display_announcement_content",
          announcement: id,
          nonce: ld_dashboard_js_object.ajax_nonce,
        };
        jQuery.ajax({
          url: ld_dashboard_js_object.ajaxurl,
          type: "post",
          data: params,
          success: function (response) {
            if ( response ) {
              let title = response.data.title;
              let content = response.data.content;
              jQuery('.ld-dashboard-announcement-content-wrapper .ld-dashboard-announcement-content-header h4').html(title);
              jQuery('.ld-dashboard-announcement-content-wrapper .ld-dashboard-announcement-content-body').html(content);
              jQuery('body').addClass('announcement-modal-open');
              jQuery('.ld-dashboard-announcement-content-wrapper').show();

              jQuery('.ld-dashboard-announcement-content-wrapper').addClass('ldd-show-popup');
              jQuery('.ld-dashboard-announcement-content-wrapper').removeClass('ldd-hide-popup');
           }
          },
        });
      });
      jQuery('.ld-dashboard-announcement-content-close').on('click', function(){
        jQuery('body').removeClass('announcement-modal-open');
        jQuery('.ld-dashboard-announcement-content-wrapper').addClass('ldd-hide-popup');
        jQuery('.ld-dashboard-announcement-content-wrapper').removeClass('ldd-show-popup');
      });
    }

    function displayAnnouncementMessageBox(msg, status) {
      if ( status == 'success' ) {
        jQuery('.ld-dashboard-msg-box.announcement-submit').addClass('ld-dashboard-announcement-msg-submit');
        jQuery('.ld-dashboard-announcement-msg-submit').html(msg);
      } else if ( status == 'error' ) {
        jQuery('.ld-dashboard-msg-box.announcement-title').addClass('ld-dashboard-announcement-msg-title');
        jQuery('.ld-dashboard-announcement-msg-title').html(msg);
      }
    }

    if (jQuery('#ldd_update_user_pass').length) {
      jQuery('#ldd_update_user_pass').on('click', function (e) {
        e.preventDefault();
        jQuery('#adduser').trigger('submit');

      });
      jQuery("#adduser").submit(function (e) {
        e.preventDefault();
        let formData = jQuery('#adduser').serializeArray();
        let nonce = ld_dashboard_js_object.ajax_nonce;
        let params = {
          action: "ld_dashboard_set_user_password",
          nonce: nonce,
        };
        formData.forEach(function (val) {
          if (val.name === 'p_text') {
            params.oldpass = val.value;
          }
          if (val.name === 'pass1') {
            params.newpass = val.value;
          }
          if (val.name === 'pass2') {
            params.confirmnewpass = val.value;
          }
        });
        jQuery.ajax({
          url: ld_dashboard_js_object.ajaxurl,
          type: "post",
          data: params,
          success: function (response) {
            if (response) {
              let data = JSON.parse(response);
              if (data.error == 1) {
                let errorMsg = data.error_msg;
                jQuery('.ld_dashboard_message_container').addClass('ld-dashboard-warning');
                jQuery('.ld_dashboard_message_container').text(errorMsg);
              }
              if (data.error == 0) {
                let successMsg = data.error_msg;
                jQuery('.ld_dashboard_message_container').addClass('ld-dashboard-success');
                jQuery('.ld_dashboard_message_container').text(successMsg);
              }
            }
          },
        });
      });
    }

    function removeCourseBuilderActiveClass() {
      jQuery('.ld-dashboard-course-builder-content').find('.ld-dashboard-course-builder-lesson').each(function(){
        if (jQuery(this).hasClass('ldd-active-lesson')) {
          jQuery(this).removeClass('ldd-active-lesson');
        }
      });
    }

	function addCourseBuilderContainers(type) {
		let html = '';
		if ( type == 'topic' ) {
			html = '<div class="ld-dashboard-course-lesson-builder-topic-wrapper"><div class="ld-dashboard-course-builder-topic-header"><h4>' + ld_dashboard_js_labels.topics + '</h4></div><div class="ld-dashboard-is-sortable ld-dashboard-topics-is-sortable ld-dashboard-course-lesson-builder-quiz-content ui-sortable"></div></div>';
		} else if ( type == 'quiz' ) {
			html = '<div class="ld-dashboard-course-lesson-builder-quiz-wrapper"><div class="ld-dashboard-course-builder-topic-header"><h4>' + ld_dashboard_js_labels + '</h4></div><div class="ld-dashboard-is-sortable ld-dashboard-quizzes-is-sortable ld-dashboard-course-lesson-builder-quiz-content ui-sortable"></div></div>';
		}
		jQuery('.ldd-active-lesson').find('.ld-dashboard-lesson-builder-wrapper').append(html);
	}

    // Course Builder active lesson.
    if ( jQuery('.ld-dashboard-course-builder-content').length ) {
      jQuery('.ld-dashboard-course-builder-content').on('click', '.ld-dashboard-course-builder-lesson', function(){
        removeCourseBuilderActiveClass();
        jQuery(this).addClass('ldd-active-lesson');
      });
    }

    // Course Builder Add Lesson Topic Quiz.
    jQuery(document).on('click', '.ld-dashboard-share-post-add', function(){
      let wrapper = jQuery(this).closest('.ld-dashboard-share-post-single');
      let type = jQuery(wrapper).data('type');
      let postID = jQuery(wrapper).data('id');
      let postTitle = jQuery(wrapper).data('title');
      let lessonCount = jQuery('.ld-dashboard-course-builder-lesson').length;
      let topicCount = jQuery('.ldd-active-lesson').find('.ld-dashboard-course-lesson-builder-quiz-content').find('.ld-dashboard-course-lesson-builder-topic-single').length;
      let quizCount = jQuery('.ldd-active-lesson').find('.ld-dashboard-course-lesson-builder-quiz-content').find('.ld-dashboard-course-lesson-builder-quiz-single').length;
      let lesson_id = jQuery('.ldd-active-lesson').data('id');
      jQuery('.ld-dashboard-share-steps-dropper').hide();
      if ( type == 'lesson' ) {
        let lessonHtml = '<div class="ld-dashboard-single-wrap ld-dashboard-course-builder-lesson ldd-active-lesson" data-item_key="' + lessonCount + '" data-name="' + postTitle + '" data-type="lesson" data-id="' + postID + '" data-value="' + postID + '" style="position: relative; top: 0px; left: 0px;"><span class="ld-dashboard-sortable-input"><input type="hidden" data-lesson="' + postTitle + '" name="ld_dashboard_course_builder[' + lessonCount + ']" value="' + postID + '"></span><div class="ld-dashboard-course-builder-lesson-title"><h4>' + postTitle + '</h4></div><div class="ld-dashboard-remove-wrapper ld-dashboard-course-lesson-remove">' + __( 'Remove', 'ld-dashboard' ) + '</div><div class="ld-dashboard-course-builder-lesson-dropdown ld-dashboard-accordian ld-dashboard-accordian-closed"><span class="ld-dashboard-accordian-icon ld-dashboard-accordian-open"></span><span class="ld-dashboard-accordian-icon ld-dashboard-accordian-close" style="display: none;"></span></div><div class="ld-dashboard-lesson-builder-wrapper" style="display: none;"><div class="ld-dashboard-course-lesson-builder-topic-wrapper"><div class="ld-dashboard-course-builder-topic-header"><h4>' + ld_dashboard_js_labels.topics + '</h4></div><div class="ld-dashboard-is-sortable ld-dashboard-topics-is-sortable ld-dashboard-course-lesson-builder-quiz-content"></div><div class="ld-dashboard-share-steps-dropper">' + __( 'Drop ' + ld_dashboard_js_labels.topics + ' Here', 'ld-dashboard')+'</div></div><div class="ld-dashboard-course-lesson-builder-quiz-wrapper"><div class="ld-dashboard-course-builder-topic-header"><h4>' + ld_dashboard_js_labels.quizzes +'</h4></div><div class="ld-dashboard-is-sortable ld-dashboard-quizzes-is-sortable ld-dashboard-course-lesson-builder-quiz-content"></div><div class="ld-dashboard-share-steps-dropper">'+__( 'Drop ' + ld_dashboard_js_labels.quizzes + ' Here', 'ld-dashboard')+'</div></div></div><div class="ld-dashboard-crate-topics-quiz" style="display: none;"><button class="ld_dashboard_builder_new_topic">' +__( 'New ' + ld_dashboard_js_labels.topic, 'ld-dashboard')+'</button>&nbsp;<button class="ld_dashboard_builder_new_quiz">'+__( 'New ' + ld_dashboard_js_labels.quiz, 'ld-dashboard')+'</button></div></div>';
        removeCourseBuilderActiveClass();
        jQuery('.ld-dashboard-course-builder-content').append(lessonHtml);
        initSortableLessons();
      }
      if ( jQuery('.ldd-active-lesson').length ) {
        if ( type == 'topic' ) {
          if ( ! jQuery('.ldd-active-lesson').find('.ld-dashboard-course-lesson-builder-topic-wrapper').length ) {
            addCourseBuilderContainers('topic');
          }
          let topicHtml = '<div class="ld-dashboard-single-wrap ld-dashboard-is-sortable-item ld-dashboard-course-lesson-builder-topic-single ui-sortable-handle" data-name="' + postTitle + '" data-type="topic" data-item_key="' + topicCount + '" data-id="' + lesson_id + '" data-value="' + postID + '"><span class="ld-dashboard-sortable-input"><input type="hidden" name="ld_dashboard_lesson_builder[' + lesson_id + '][topic][' + topicCount + ']" value="' + postID + '"></span><div class="ld-dashboard-course-builder-topic-title">' + postTitle + '</div><div class="ld-dashboard-remove-wrapper ld-dashboard-course-lesson-topic-remove">' + __( 'Remove', 'ld-dashboard' ) + '</div></div>';
          jQuery('.ldd-active-lesson').find('.ld-dashboard-course-lesson-builder-topic-wrapper > .ld-dashboard-course-lesson-builder-quiz-content').append(topicHtml);
        }
        if ( type == 'quiz' ) {
          if ( ! jQuery('.ldd-active-lesson').find('.ld-dashboard-course-lesson-builder-quiz-wrapper').length ) {
            addCourseBuilderContainers('quiz');
          }
          let quizHtml = '<div class="ld-dashboard-single-wrap ld-dashboard-is-sortable-item ld-dashboard-course-lesson-builder-quiz-single ui-sortable-handle" data-name="' + postTitle + '" data-type="quiz" data-item_key="' + quizCount + '" data-id="' + lesson_id + '" data-value="' + postID + '"><span class="ld-dashboard-sortable-input"><input type="hidden" name="ld_dashboard_lesson_builder[' + lesson_id + '][quiz][' + quizCount + ']" value="' + postID + '"></span><div class="ld-dashboard-course-builder-quiz-title">' + postTitle + '</div><div class="ld-dashboard-remove-wrapper ld-dashboard-course-lesson-quiz-remove">' + __( 'Remove', 'ld-dashboard' ) + '</div></div>';
          jQuery('.ldd-active-lesson').find('.ld-dashboard-course-lesson-builder-quiz-wrapper > .ld-dashboard-course-lesson-builder-quiz-content').append(quizHtml);
        }
        jQuery(wrapper).hide();
        initSortableBuilders();
      } else {
        alert('Please select a ' + ld_dashboard_js_labels.lesson);
      }
    });

    jQuery('.ld-dashboard-course-builder-wrapper').on('mouseover', '.ld-dashboard-course-builder-lesson, .ld-dashboard-course-lesson-builder-topic-single, .ld-dashboard-course-lesson-builder-quiz-single', function(){
      jQuery(this).find('.ld-dashboard-remove-wrapper ').show();
    });
    jQuery('.ld-dashboard-course-builder-wrapper').on('mouseleave', '.ld-dashboard-course-builder-lesson, .ld-dashboard-course-lesson-builder-topic-single, .ld-dashboard-course-lesson-builder-quiz-single', function(){
      jQuery(this).find('.ld-dashboard-remove-wrapper ').hide();
    });
    jQuery(document).on('click', '.ld-dashboard-remove-wrapper', function(){
      let wrapper = jQuery(this).closest('.ld-dashboard-single-wrap');
      if ( jQuery(wrapper).hasClass('ld-dashboard-course-builder-lesson') ) {
        let lessonsCount = jQuery('.ld-dashboard-single-wrap.ld-dashboard-course-builder-lesson').length;
        let html = '<div class="ld-dashboard-share-steps-dropper">Add lessons here.</div>';
        if ( lessonsCount == 1 ) {
          jQuery(wrapper).after(html);
        }
      }
      let title = jQuery(wrapper).attr('data-name');
      let postId = jQuery(wrapper).attr('data-value');
      let postType = jQuery(wrapper).attr('data-type');
      let postClasses = '';
      let targetContainer = '.ld-dashboard-share-toggle-content';
      if ( postType === 'lesson' ) {
        postClasses = 'ld-dashboard-share-single-lesson';
        targetContainer +='.ld-dashboard-share-lesson-content';
      }
      if ( postType === 'topic' ) {
        postClasses = 'ld-dashboard-share-single-topic';
        targetContainer +='.ld-dashboard-share-topic-content';
      }
      if ( postType === 'quiz' ) {
        postClasses = 'ld-dashboard-share-single-quiz';
        targetContainer +='.ld-dashboard-share-quiz-content';
      }
      if ( postClasses !== '' ) {
        let sharePostHtml = '<div class="ld-dashboard-share-post-single ' + postClasses + '" data-id="' + postId + '" data-type="' + postType + '" data-title="' + title + '"><span>' + title + '</span><span><button class="ld-dashboard-share-post-add">' + __( 'Add', 'ld-dashboard' ) + '</button></span></div>';
        jQuery(targetContainer).append(sharePostHtml);
      }
      jQuery(wrapper).remove();
    });

    jQuery('.ld-dashboard-share-course-toggle').on('click', function(){
      let showContent = false;
      if ( jQuery(this).hasClass('dashicons-arrow-down') ) {
        showContent = true;
      }
      if ( showContent ) {
        jQuery(this).parent().find('.dashicons-arrow-up').show();
        jQuery(this).parent().parent().next('div.ld-dashboard-share-toggle-content').show();
      } else {
        jQuery(this).parent().find('.dashicons-arrow-down').show();
        jQuery(this).parent().parent().next('div.ld-dashboard-share-toggle-content').hide();
      }
      jQuery(this).hide();
    });

    if (jQuery('.acf-taxonomy-field').length) {
      jQuery('.acf-taxonomy-field').find('.acf-actions').addClass('ldd-custom-zindex');
    }

    function initSortableQuestionBuilder() {
      jQuery('.ld-dashboard-assigned-questions-list').sortable({
        // scrollSpeed: 1,
        axis: "y",
        cursor: "move",
        items: "> li",
        containment: "parent",
        // scrollSensitivity: 1,
        start: function (event, ui) {
          $("#ldd_questions_list > li").draggable("disable");
          $(".ld-dashboard-assigned-questions-wrapper").droppable("disable");
        },
        stop: function (event, ui) {
          $("#ldd_questions_list > li").draggable("enable");
          $(".ld-dashboard-assigned-questions-wrapper").droppable("enable");
        },
        update: function (event, ui) {
          let elem = ui.item[0];
          // let elemMovedIndex = elem.getAttribute("data-item_key");
          jQuery(".ld-dashboard-assigned-questions-wrapper > ul").find('li').each(function (index, elm) {
            let questionId = jQuery(this).find("input").val();
            let value = jQuery(this).attr("data-value");
            let html = '<input type="hidden" name="ld_quiz_builder[' + index + ']" value="' + questionId + '">';
            jQuery(this).find("input").remove();
            jQuery(this).append(html);
          });
          initSortableQuestionBuilder();
        },
      });
    }

    function initDragNDropQuestionBuilder() {
      jQuery("#ldd_questions_list > li").draggable({
        revert: "invalid",
        helper: "clone"
      });
      jQuery(".ld-dashboard-assigned-questions-wrapper").droppable({
        drop: function (event, ui) {
          let inputElement = jQuery(ui.draggable)[0].querySelectorAll('input');
          let spanElement = jQuery(ui.draggable)[0].querySelectorAll('span');
          let inputElementCount = inputElement.length;
          let spanElementCount = spanElement.length;
          let element = jQuery(ui.draggable)[0].querySelectorAll('div');
          let html = element[0].outerHTML;
          let questionId = jQuery(ui.draggable)[0].dataset.question;
          let count = jQuery('.ld-dashboard-assigned-questions-wrapper > ul').find('li').length;
          let content = '<li><span class="ld-dashboard-sortable-input"></span>' + html + '<input type="hidden" name="ld_quiz_builder[' + count + ']" value="' + questionId + '"><span class="remove-question"></span></li>';
          jQuery('.ld-dashboard-assigned-questions-wrapper > ul').append(content);
          initSortableQuestionBuilder();
          $(ui.draggable).remove();
        }
      });
    }

    if ( jQuery('.ld-dashboard-course-filter-submit').length ) {
      let html = '<button class="ld-dashboard-course-filter-reset ld-dashboard-btn-bg">' + __( 'Reset', 'ld-dashboard' ) + '</button>';
      jQuery('.ld-dashboard-course-filter-submit').after(html);
      jQuery('.ld-dashboard-course-filter').on( 'click', '.ld-dashboard-course-filter-reset', function(){
        jQuery(".ld-dashboard-tab-content-filter").val('0').trigger('change');
        if ( jQuery(".ld-dashboard-lesson-filter-select").length ) {
          jQuery(".ld-dashboard-lesson-filter-select").val('0').trigger('change');
        }
        if ( jQuery(".ld-dashboard-quiz-filter-select").length ) {
          jQuery(".ld-dashboard-quiz-filter-select").val('0').trigger('change');
        }
        jQuery("button.ld-dashboard-course-filter-submit").trigger("click");
      });
    }

    function setCourseLessons(courseId) {
      let nonce = ld_dashboard_js_object.ajax_nonce;
      jQuery.ajax({
        url: ld_dashboard_js_object.ajaxurl,
        type: "post",
        data: {
          action: "ld_dashboard_get_course_lessons",
          nonce: nonce,
          course_id: courseId,
        },
        success: function (response) {
          if (response) {
            jQuery("#ld_dashboard_associated_lesson").html('<option value="">' + __( 'Select', 'ld-dashboard' ) + '</option>');
            jQuery("#ld_dashboard_associated_lesson").append(response);
          }
        },
      });
    }

    if (jQuery('#ld_dashboard_associated_lesson').length) {
      jQuery('.ldd-lesson-input').find('.acf-input-wrap').remove();
      jQuery('#ld_dashboard_associated_lesson').select2();
      let element = jQuery('.ldd-course-select2').find('select');
      let el = element[0];
      jQuery(el).on('change', function () {
        let courseId = jQuery(this).val();
        setCourseLessons(courseId);
      })
    }

    if (jQuery('.ld-dashboard-quiz-builder-wrapper').length) {
      initDragNDropQuestionBuilder();
      initSortableQuestionBuilder();
    }

    jQuery(document).on('click', '.remove-question', function () {
      let elem = jQuery(this).parent().find('div');
      let questionId = elem[0].dataset.question;
      let html = elem[0].outerHTML;
      let removeCount = 0;
      jQuery('.ld-dashboard-questions-list > li').each(function () {
        let exists = jQuery(this).find('input').length;
        if (exists) {
          removeCount++;
        }
      });
      let content = '<li data-question="' + questionId + '" ><span class="ld-dashboard-sortable-input"></span>' + html + '<input type="hidden" name="ld_quiz_builder_remove[' + removeCount + ']" value="' + questionId + '"></li>';
      jQuery('.ld-dashboard-quiz-builder-question > ul').append(content);
      initDragNDropQuestionBuilder();
      jQuery(this).parent().remove();
    });

    if (jQuery(".ld-dashboard-form-tab-switch").length) {
      function toggleFormTabs(tab) {
        jQuery(".ld-dashboard-form-post-data-tab").hide();
        jQuery(".ld-dashboard-form-settings-data-tab").hide();
        jQuery(".ld-dashboard-course-builder-wrapper").hide();

        if (tab == "post") {
          jQuery('.acf-form-submit').show();
          jQuery(".ld-dashboard-form-post-data-tab").show();
        }
        if (tab == "builder") {
          if (jQuery(".ld-dashboard-course-builder-wrapper").length) {
            jQuery(".ld-dashboard-course-builder-wrapper")
              .find(".acf-input")
              .find(".acf-input-wrap")
              .hide();
            jQuery(".ld-dashboard-course-builder-wrapper").show();
          }
          if ( ! jQuery(".ld-dashboard-course-builder-wrapper").hasClass('ld-dashboard-shareable-course-steps-enabled') ) {
            if (jQuery('.ld-dashboard-course-builder-content').length && !jQuery('.ld-dashboard-course-builder-lesson').length) {
              jQuery('.acf-form-submit').hide();
            }
            if (jQuery('.ld-dashboard-quiz-builder-wrapper').length && !jQuery('.ld-dashboard-quiz-builder-content').length) {
              jQuery('.acf-form-submit').hide();
            }
          }
        }
        if (tab == "setting") {
          jQuery('.acf-form-submit').show();
          jQuery(".ld-dashboard-course-builder-wrapper").hide();
          jQuery(".ld-dashboard-form-settings-data-tab").show();
        }
      }

      toggleFormTabs("post");

      jQuery(".ld-dashboard-form-tab-switch").on("click", function (e) {
        e.preventDefault();
        let tab = jQuery(this).data("tab");
        jQuery(this)
          .closest("ul.ld-dashboard-inline-links-ul")
          .find("li")
          .each(function () {
            jQuery(this).removeClass("course-nav-active");
          });
        jQuery(this).parent().addClass("course-nav-active");
        toggleFormTabs(tab);
      });
    }

    function initSortableLessons() {
      jQuery(".ld-dashboard-course-builder-content").sortable({
        scrollSpeed: 1,
        axis: "y",
        cursor: "move",
        items: "> .ld-dashboard-course-builder-lesson",
        containment: "parent",
        scrollSensitivity: 1,
        update: function (event, ui) {
          let elem = ui.item[0];
          let elemMovedIndex = elem.getAttribute("data-item_key");
          jQuery(".ld-dashboard-course-builder-lesson").each(function (
            index,
            elm
          ) {
            let oldIndex = jQuery(this).data("item_key");
            let value = jQuery(this).attr("data-value");
            jQuery(this).attr("data-item_key", index);
            let html = '<input type="hidden" name="ld_dashboard_course_builder[' + index + ']" value="' + value + '">';
            let section_html = '<input type="hidden" name="course_sections[' + index + ']" value="' + value + '">';
            jQuery(this).find('span.ld-dashboard-sortable-input').html(html);
            jQuery(this).find('span.ld-dashboard-sortable-input-section').html(section_html);
          });
        },
      });
    }

    function initSortableBuilders() {
	  // Topic Sortable
      jQuery(".ld-dashboard-topics-is-sortable").sortable({
        //scrollSpeed: 1,
		connectWith: '.ld-dashboard-topics-is-sortable',
        axis: "y",
        cursor: "move",
        //items: "> .ld-dashboard-is-sortable-item",
        //containment: "parent",
		revert: true,
        //scrollSensitivity: 1,
        update: function (event, ui) {
          let elem = ui.item[0];
          let elemMovedIndex = elem.getAttribute("data-item_key");
          let elemType = elem.getAttribute("data-type");

          jQuery(".ld-dashboard-topics-is-sortable .ld-dashboard-is-sortable-item").each(function (
            index,
            elm
          ) {
            let oldIndex = jQuery(this).data("item_key");
            let type = jQuery(this).data("type");
            let id = jQuery(this).attr("data-id");
            let lesson_id = $(this).parent().parent().parent().parent().data('id');
			if ( lesson_id != id) {
				id = lesson_id;
				$(this).attr('data-id', id );
			}

            let value = jQuery(this).attr("data-value");
            if (type === elemType) {
              let html = '<input type="hidden" name="ld_dashboard_lesson_builder[' + id + '][' + type + '][' + index + ']" value="' + value + '">';
              jQuery(this).find('span.ld-dashboard-sortable-input').html(html);
              jQuery(this).attr("data-item_key", index);
            }

          });
        },
      });

	  // Quizz Sortable
      jQuery(".ld-dashboard-quizzes-is-sortable").sortable({
        //scrollSpeed: 1,
		connectWith: '.ld-dashboard-quizzes-is-sortable',
        axis: "y",
        cursor: "move",
        //items: "> .ld-dashboard-is-sortable-item",
        //containment: "parent",
		revert: true,
        //scrollSensitivity: 1,
        update: function (event, ui) {
          let elem = ui.item[0];
          let elemMovedIndex = elem.getAttribute("data-item_key");
          let elemType = elem.getAttribute("data-type");

          jQuery(".ld-dashboard-quizzes-is-sortable .ld-dashboard-is-sortable-item").each(function (
            index,
            elm
          ) {
            let oldIndex = jQuery(this).data("item_key");
            let type = jQuery(this).data("type");
            let id = jQuery(this).attr("data-id");
            let lesson_id = $(this).parent().parent().parent().parent().data('id');
			if ( lesson_id != id) {
				id = lesson_id;
				$(this).attr('data-id', id );
			}

            let value = jQuery(this).attr("data-value");
            if (type === elemType) {
              let html = '<input type="hidden" name="ld_dashboard_lesson_builder[' + id + '][' + type + '][' + index + ']" value="' + value + '">';
              jQuery(this).find('span.ld-dashboard-sortable-input').html(html);
              jQuery(this).attr("data-item_key", index);
            }

          });
        },
      });
    }

    if (jQuery(".ld-dashboard-course-builder-wrapper")) {
      if (jQuery(".ld-dashboard-accordian").length) {
        jQuery(".ld-dashboard-accordian-close").hide();
        jQuery('.ld-dashboard-lesson-builder-wrapper').hide();
        jQuery('.ld-dashboard-crate-topics-quiz').hide();

      }
      initSortableLessons();
      initSortableBuilders();
    }

    jQuery('.ld-dashboard-course-builder-wrapper').on( 'click', 'span.ld-dashboard-accordian-icon', function (e) {
      e.stopPropagation();
      if (jQuery(this).closest(".ld-dashboard-accordian").hasClass("ld-dashboard-accordian-closed")) {
        jQuery(this).hide();
        jQuery(this).closest(".ld-dashboard-accordian").find(".ld-dashboard-accordian-close").show();
        jQuery(this).closest(".ld-dashboard-accordian").addClass("ld-dashboard-accordian-opened");
        jQuery(this).closest(".ld-dashboard-accordian").removeClass("ld-dashboard-accordian-closed");
        jQuery(this).closest(".ld-dashboard-accordian").next('.ld-dashboard-lesson-builder-wrapper').show(350);
        jQuery(this).closest(".ld-dashboard-accordian").next().next('.ld-dashboard-crate-topics-quiz').show(350);
        jQuery(".ld-dashboard-course-builder-content").sortable("disable");
      }
      else if (jQuery(this).closest(".ld-dashboard-accordian").hasClass("ld-dashboard-accordian-opened")) {
        jQuery(this).closest(".ld-dashboard-accordian").find(".ld-dashboard-accordian-open").show();
        jQuery(this).hide();
        jQuery(this).closest(".ld-dashboard-accordian").removeClass("ld-dashboard-accordian-opened");
        jQuery(this).closest(".ld-dashboard-accordian").addClass("ld-dashboard-accordian-closed");
        jQuery(this).closest(".ld-dashboard-accordian").next('.ld-dashboard-lesson-builder-wrapper').hide(350);
        jQuery(this).closest(".ld-dashboard-accordian").next().next('.ld-dashboard-crate-topics-quiz').hide(350);
        jQuery(".ld-dashboard-course-builder-content").sortable("enable");
      }
    });

    function getInstructorTabContent(type, id, page) {
      let nonce = ld_dashboard_js_object.ajax_nonce;
      let params = {
        action: "ld_dashboard_get_instructor_tab_content",
        nonce: nonce,
        post_type: type,
        course_id: id,
        page: page,
      };
      let lesson = jQuery(".ld-dashboard-lesson-filter-select").val();
      let quiz = jQuery(".ld-dashboard-quiz-filter-select").val();
      if (type != "lesson" && lesson != undefined && lesson != "") {
        params.lesson_id = lesson;
      }
      if (type != "lesson" && quiz != undefined && quiz != "") {
        params.quiz_id = quiz;
      }
      jQuery.ajax({
        url: ld_dashboard_js_object.ajaxurl,
        type: "post",
        data: params,
        success: function (response) {
          if (response) {
            let data = JSON.parse(response);
            jQuery(".ld-dashboard-tab-content-wrapper").html(data.content);

            if (data.prev) {
              jQuery("button.ld-dashboard-prev-btn").attr(
                "data-page",
                page - 1
              );
              jQuery(".custom-learndash-pagination-prev .ld-dashboard-prev-btn").show();
            } else {
              jQuery(".custom-learndash-pagination-prev .ld-dashboard-prev-btn").hide();
            }
            if (data.next) {
              jQuery("button.ld-dashboard-next-btn").attr(
                "data-page",
                parseInt(page) + 1
              );
              jQuery(".custom-learndash-pagination-next").show();
            } else {
              jQuery(".custom-learndash-pagination-next").hide();
            }
          }
        },
      });
    }

    function setLessonOptions(course) {
      let nonce = ld_dashboard_js_object.ajax_nonce;
      jQuery.ajax({
        url: ld_dashboard_js_object.ajaxurl,
        type: "post",
        data: {
          action: "ld_dashboard_get_course_lessons",
          nonce: nonce,
          course_id: course,
        },
        success: function (response) {
          if (response) {
            jQuery("select.ld-dashboard-lesson-filter-select").html(response);
            jQuery("select.ld-dashboard-quiz-filter-select").html(
              '<option value=""></option>'
            );
          }
        },
      });
    }

    function setQuizOptions(course, lesson) {
      let nonce = ld_dashboard_js_object.ajax_nonce;
      jQuery.ajax({
        url: ld_dashboard_js_object.ajaxurl,
        type: "post",
        data: {
          action: "ld_dashboard_get_course_lesson_quizzes",
          nonce: nonce,
          course_id: course,
          lesson_id: lesson,
        },
        success: function (response) {
          if (response) {
            jQuery("select.ld-dashboard-quiz-filter-select").html(response);
          }
        },
      });
    }

    if (jQuery('.ld-dashboard-assignment-content').length) {
      jQuery('.ld-dashboard-assignment-content').on('click', '.ld-dashboard-approve-assignment-btn', function (e) {
        e.preventDefault();
        let confirm1 = confirm('Are you sure?');
        if (confirm1) {
          let assignmentId = jQuery(this).attr('data-id');
          let that = jQuery(this);
          $.ajax({
            url: ld_dashboard_js_object.ajaxurl,
            type: "post",
            data: {
              action: "ld_dashboard_approve_assignment",
              nonce: ld_dashboard_js_object.ajax_nonce,
              assignment_id: assignmentId,
            },
            success: function (response) {
              if (response == 1) {
                that.remove();
                location.reload();
              }
            },
          });
        }
      });
    }

    if (jQuery(".ld-dashboard-course-filter").length) {
      jQuery(".ld-dashboard-tab-content-filter").select2({
        placeholder: "Select an option",
        ajax: {
          url: ld_dashboard_js_object.ajaxurl,
          data: function (params) {
            let query = {
              search: params.term,
              page: params.page,
              action: 'ld_dashboard_tab_content_filter',
              nonce: ld_dashboard_js_object.ajax_nonce,
              type: 'public',
            }
            return query;
          },
          processResults: function (data, params) {
            params.page = params.page || 1;
            let courses = JSON.parse(data);
            return {
              results: courses.results,
              pagination: {
                more: (params.page * 200) < courses.count
              }
            };
          }
        },
      });

      if (jQuery('.ld-dashboard-sec-filter').length) {
        jQuery('.ld-dashboard-sec-filter').select2({
          placeholder: "Select an option",
        });
      }

      // Set lesson dropdown options for course
      jQuery(".ld-dashboard-tab-content-filter").on("change", function () {
        if (jQuery(this).hasClass("ld-dashboard-course-filter-select")) {
          let courseId = jQuery(this).val();
          if (jQuery(".ld-dashboard-lesson-filter-select").length) {
            setLessonOptions(courseId);
          }
        }
      });

      // Set Quiz dropdown options for lesson and course
      jQuery(".ld-dashboard-lesson-filter-select").on("change", function () {
        let courseId = jQuery(".ld-dashboard-course-filter-select").val();
        let lessonId = jQuery(this).val();
        if (jQuery(".ld-dashboard-quiz-filter-select").length) {
          setQuizOptions(courseId, lessonId);
        }
      });

      // Filter instructor tab content
      jQuery("button.ld-dashboard-course-filter-submit").on(
        "click",
        function (e) {
          e.preventDefault();
          let type = jQuery(this).data("type");
          let id = jQuery(".ld-dashboard-course-filter-select").val();
          getInstructorTabContent(type, id, 1);
        }
      );
      jQuery("button.ld-dashboard-course-filter-submit").trigger("click");
    }

    jQuery(".ld-dashboard-pagination-btn").on("click", function () {
      let page = jQuery(this).attr("data-page");
      let type = jQuery("button.ld-dashboard-course-filter-submit").data(
        "type"
      );
      let id = jQuery(".ld-dashboard-course-filter-select").val();
      getInstructorTabContent(type, id, page);
    });

    // Remove post
    if (jQuery(".ld-dashboard-tab-content-wrapper").length) {
      jQuery('.ld-dashboard-tab-content-wrapper').on("click", '.ld-dashboard-element-delete-btn', function (e) {
        e.preventDefault();
        let postType = jQuery(this).data("type");
        let postID = jQuery(this).data("type_id");
        let nonce = ld_dashboard_js_object.ajax_nonce;
        if (confirm("Are you sure you want to delete this " + postType + "?")) {
          $.ajax({
            url: ld_dashboard_js_object.ajaxurl,
            type: "post",
            data: {
              action: "ld_dashboard_remove_post",
              nonce: nonce,
              post_type: postType,
              post_id: postID,
            },
            success: function (response) {
              location.reload();
            },
          });
        }
      });
    }

    // Select image for user avatar
    frame.on("select", function () {
      let attachment = frame.state().get("selection").first().toJSON();
      jQuery(".ld-dashboard-profile-avatar-id").val(attachment.id);
      jQuery(".ld-dashboard-profile-avatar-uploaded").val(1);
      let al_sizes = [];
      let userId = jQuery(".ld-dashboard-avatar-field").data("user");
      let nonce = ld_dashboard_js_object.ajax_nonce;
      let avatar_url = "";
      for (const [key, value] of Object.entries(attachment.sizes)) {
        let size = {};
        if (key == "ld-medium") {
          avatar_url = value.url;
        } else if (key == "medium") {
          avatar_url = value.url;
        }
        size[key] = value.url;
        al_sizes.push(size);
      }
      jQuery(".ld-dashboard-user-avatar").attr("src", avatar_url);
      jQuery.ajax({
        url: ld_dashboard_js_object.ajaxurl,
        type: "post",
        data: {
          action: "ld_set_user_avatar",
          nonce: nonce,
          user_id: userId,
          sizes: al_sizes,
        },
        success: function (response) { },
      });
      frame.close();
    });

    // Update/Delete user avatar
    if (jQuery(".ld-dashboard-profile-settings")) {
      jQuery(".ld-dashboard-profile-settings").on("click", function (e) {
        e.preventDefault();
        let userId = jQuery(this).parent().data("user");
        if (jQuery(this).hasClass("change-avatar")) {
          if (frame) {
            frame.open();
            return;
          }
        }
        if (jQuery(this).hasClass("delete-avatar")) {
          let del = confirm("Are you sure?");
          if (del) {
            let nonce = ld_dashboard_js_object.ajax_nonce;
            jQuery.ajax({
              url: ld_dashboard_js_object.ajaxurl,
              type: "post",
              data: {
                action: "ld_remove_user_avatar",
                nonce: nonce,
                user_id: userId,
              },
              success: function (response) {
                if (response == 1) {
                  jQuery(".ld-dashboard-profile-avatar-uploaded").val(0);
                  jQuery(".ld-dashboard-profile-avatar-id").val("");
                  jQuery(".ld-dashboard-user-avatar").attr(
                    "src",
                    ld_dashboard_js_object.ld_default_avatar
                  );
                  jQuery('#updateuser').trigger('click');
                }
              },
            });
          }
        }
      });
    }

    // Quiz attempt by student
    if (jQuery("#ld_quiz_attempt_student").length) {
      jQuery("#ld_quiz_attempt_student").select2({
        placeholder: "Select a student",
      });

      jQuery("#ld_quiz_attempt_student").on("change", function () {
        let userId = jQuery(this).val();
        let nonce = ld_dashboard_js_object.ajax_nonce;
        jQuery.ajax({
          url: ld_dashboard_js_object.ajaxurl,
          type: "post",
          data: {
            action: "get_student_quiz_attempt",
            nonce: nonce,
            user_id: userId,
          },
          success: function (response) {
            if (response) {
              jQuery(".ld-dashboard-student-quiz-attempt-container").html(response);
              if ( jQuery('.quiz_progress_details .ld-quiz-progress-content-container').length ) {
                jQuery( '.ld-quiz-progress-content-container p' ).each(function(index, el){
                  jQuery(el).find('a:contains("(edit)")').remove();
                  jQuery(el).find('a:contains("(remove)")').remove();
                  jQuery(el).find('abbr:contains("(m)")').remove();
                });
                loadQuizStatisticsMethods(userId);
              }
            }
          },
        });
      });
      jQuery('#ld_quiz_attempt_student').trigger('change');
    }

    if ( jQuery('.my-quiz-attempts-wrapper').length ) {
      if ( jQuery('.quiz_progress_details .ld-quiz-progress-content-container').length ) {
        jQuery( '.ld-quiz-progress-content-container p' ).each(function(index, el){
          jQuery(el).find('a:contains("(edit)")').remove();
          jQuery(el).find('a:contains("(remove)")').remove();
          jQuery(el).find('abbr:contains("(m)")').remove();
        });
      }
    }

    function loadQuizStatisticsMethods(userId) {
      if ( jQuery('.ldd_user_statistic_hidden_field').length && ld_dashboard_js_object.is_instructor == 1 ) {
        jQuery('.ldd_user_statistic_hidden_field').each(function(){
          let id = jQuery(this).attr('data-id');
          let statistic_nonce = jQuery(this).attr('data-statistic_nonce');
          let user_id = jQuery(this).attr('data-user_id');
          let quiz_id = jQuery(this).attr('data-quiz_id');
          let ref_id = jQuery(this).attr('data-ref_id');
          let statistics_html = '<a class="user_statistic" data-statistic_nonce="' + statistic_nonce + '" data-user_id="' + user_id + '" data-quiz_id="' + quiz_id + '" data-ref_id="' + ref_id + '" href="#"> ' + ld_dashboard_js_labels.statistics + '</a>';
          jQuery('#' + id + ' > span').after(statistics_html);
        });
      }
      jQuery(document).on('click', 'a.user_statistic', function(e){
        e.preventDefault();
        var refId 				= 	jQuery( this ).data( 'ref_id' );
        var quizId 				= 	jQuery( this ).data( 'quiz_id' );
        var userId 				= 	jQuery( this ).data( 'user_id' );
        var statistic_nonce 	= 	jQuery( this ).data( 'statistic_nonce' );
        var post_data = {
          action: 'wp_pro_quiz_admin_ajax_statistic_load_user',
          func: 'statisticLoadUser',
          data: {
            quizId: quizId,
            userId: userId,
            refId: refId,
            statistic_nonce: statistic_nonce,
            avg: 0,
          },
        };

        jQuery( '#wpProQuiz_user_overlay, #wpProQuiz_loadUserData' ).show();
        var content = jQuery( '#wpProQuiz_user_content' ).hide();

        jQuery.ajax( {
          type: 'POST',
          url: ldVars.ajaxurl,
          dataType: 'json',
          cache: false,
          data: post_data,
          error: function( jqXHR, textStatus, errorThrown ) {
          },
          success: function( reply_data ) {
            if ( 'undefined' !== typeof reply_data.html ) {
              content.html( reply_data.html );
              jQuery( '#wpProQuiz_user_content' ).show();
              jQuery( 'body' ).trigger( 'learndash-statistics-contentchanged' );
              jQuery( '#wpProQuiz_loadUserData' ).hide();
              content.find( '.statistic_data' ).on( 'click', function() {
                jQuery( this ).parents( 'tr' ).next().toggle( 'fast' );
                return false;
              } );
            }
          },
        } );

        jQuery( '#wpProQuiz_overlay_close' ).on( 'click', function() {
          jQuery( '#wpProQuiz_user_overlay' ).hide();
        } );
      });

    }

    /* Progress bar */
    $(".ld-dashboard-progressbar").each(function () {
      $(this).animate(
        {
          width: $(this).attr("data-percentage-value") + "%",
        },
        1000
      );
    });

    /* Acitvity Pagination */
    $(document).on(
      "click",
      ".ld-dashboard-report-pager-info .ld-dashboard-button",
      function (e) {
        var data = {
          action: "ld_dashboard_activity_rows_ajax",
          nonce: ld_dashboard_js_object.nonce,
          paged: $(this).data("page"),
        };
        $.ajax({
          url: ld_dashboard_js_object.ajaxurl,
          type: "GET",
          data: data,
          success: function (response) {
            $("#ld-dashboard-feed").html(response);
          },
        });
      }
    );

    /* Course Chart report */
    ld_dashboard_load_course_details(
      $("#ld-dashboard-courses-id option:first").val()
    );
    $("#ld-dashboard-courses-id").on("change", function () {
      ld_dashboard_load_course_details($(this).val());
    });

    $(document.body).on(
      "click",
      ".ld-course-details.ld-dashboard-pagination a.ld-pagination",
      function (e) {
        e.preventDefault();
        ld_dashboard_load_course_details(
          $(this).data("course"),
          $(this).data("page")
        );
      }
    );

    function ld_dashboard_load_course_details(course_id, page = 1, sort_by = '') {
      if (typeof course_id === "undefined") {
        return;
      }
      $(".ld-dashboard-course-report").addClass("disable-this");
      $(".ld-dashboard-loader").show();
      var data = {
        action: "ld_dashboard_course_details",
        nonce: ld_dashboard_js_object.nonce,
        course_id: course_id,
        page: page,
        sort_by: sort_by,
      };
      $.ajax({
        dataType: "JSON",
        url: ld_dashboard_js_object.ajaxurl,
        type: "POST",
        data: data,
        success: function (response) {
          $(".ld-dashboard-course-report").removeClass("disable-this");
          $(".ld-dashboard-loader").hide();
          $(".ld-dashboard-course-details").html(response["data"]["html"]);

          var notStarted = parseInt(
            jQuery("#ld-dashboard-chart-data #ld-dashboard-not-started").val()
          );
          var progress = parseInt(
            jQuery("#ld-dashboard-chart-data #ld-dashboard-progress").val()
          );
          var complete = parseInt(
            jQuery("#ld-dashboard-chart-data #ld-dashboard-complete").val()
          );
          let id = 'ld-dashboard-instructor-highchart-student-progress';
          ld_dashboard_highchart_prepare( notStarted, progress, complete, id, 'course' );
        },
      });
    }

    /**
     * Prepare highchart data
     */
    function ld_dashboard_highchart_prepare(notStarted, progress, complete, id, filter) {
      let ctx = document.getElementById(id);
      let chartLabel = __(  + ld_dashboard_js_labels.course + ' Progress', 'ld-dashboard' );
      let values = [ notStarted, progress, complete ];
      var labels = [];
      if ( 'course' === filter ) {
        labels = [ 'Not Started', 'Progress', 'Complete' ];
      } else if ( 'assignment' === filter ) {
        labels = [ 'Approved Assignment', 'Unapproved Assignment', 'Pending Assignment' ];
      } else if ( 'quiz' === filter ) {
        if ( notStarted == 0 && progress == 0 ) {
          labels = [ 'No '+ ld_dashboard_js_labels.quiz + ' Started' ];
          values = [ complete ];
        } else {
          labels = [ 'Completed ' +  ld_dashboard_js_labels.quizzes, 'Uncompleted ' + ld_dashboard_js_labels.quizzes ];
          values = [ notStarted, progress ];
        }

      }
      loadPieDesignChart( ctx, labels, values, chartLabel );
    }

    function loadBarDesignChart( ctx, labels, values, title ){
			const data = {
				labels: labels,
				datasets: [{
					label: title,
					data: values,
					backgroundColor: [
            'rgb(124, 181, 236)',
            'rgb(67, 67, 72)',
            'rgb(144, 237, 125)'
          ],
					borderColor: [
            'rgb(124, 181, 236)',
            'rgb(67, 67, 72)',
            'rgb(144, 237, 125)'
          ],
					borderWidth: 1,
				}]
			};
			var widgetChart = new Chart(ctx, {
				type: 'bar',
				data: data,
				options: {
					scales: {
						y: {
							beginAtZero: true
						}
					}
				}
			});
		}

    function loadPieDesignChart( ctx, labels, values, chartLabel ){
      let colors = ['#FF7272','#0EACF5','#00BB30'];
      if ( labels.length == 1 ) {
        colors = ['#FF7272'];
      }
      const data = {ctx,
          labels: labels,
          datasets: [{
              label: chartLabel,
              data: values,
              backgroundColor: colors,
              hoverOffset: 4
          }]
      };
      var widgetChart = new Chart(ctx, {
          type: 'pie',
          data: data,
      });
    }

      function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
          color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
      }

      function getRandomColorArray( count ) {
        let colors = [];
        for (var i = 0; i < count; i++) {
          let color = getRandomColor();
          colors.push( color );
        }
        return colors;
      }

    /* studet Wise chart report */
    ld_dashboard_load_student_details(
      $(".ld-dashboard-student option:first").val()
    );
    $(".ld-dashboard-student").on("change", function () {
      ld_dashboard_load_student_details($(this).val());
    });

    $(document.body).on(
      "click",
      ".ld-student-course-details.ld-dashboard-pagination a.ld-pagination",
      function (e) {
        e.preventDefault();
        ld_dashboard_load_student_details(
          $(this).data("student"),
          $(this).data("page")
        );
      }
    );

    function ld_dashboard_load_student_details(student_id, page = 1) {
      $(".ld-dashboard-student-status-block").addClass("disable-this");
      $(".ld-dashboard-student-loader").show();
      var data = {
        action: "ld_dashboard_student_details",
        nonce: ld_dashboard_js_object.nonce,
        student_id: student_id,
        page: page,
      };
      $.ajax({
        dataType: "JSON",
        url: ld_dashboard_js_object.ajaxurl,
        type: "POST",
        data: data,
        success: function (response) {
          $(".ld-dashboard-student-status-block").removeClass("disable-this");
          $(".ld-dashboard-student-loader").hide();
          $(".ld-dashboard-student-details").html(response["data"]["html"]);

          var notStarted = parseInt(
            jQuery("#ld-dashboard-student-course-not-started").val()
          );
          var progress = parseInt(
            jQuery("#ld-dashboard-student-course-progress").val()
          );
          var complete = parseInt(
            jQuery("#ld-dashboard-student-course-complete").val()
          );

          /* Student Course progress chart prepare */
          if ($("#ld-dashboard-student-course-progress-highchart").length) {
            ld_dashboard_highchart_prepare(notStarted, progress, complete, 'ld-dashboard-student-course-progress-highchart', 'course');
          }

          var approved_assignment = parseInt(
            jQuery("#ld-dashboard-student-approved-assignment").val()
          );
          var unapproved_assignment = parseInt(
            jQuery("#ld-dashboard-student-unapproved-assignment").val()
          );
          var pending_assignment = parseInt(
            jQuery("#ld-dashboard-student-pending-assignment").val()
          );

          /* Student Assignment progress chart prepare */
          if (
            $("#ld-dashboard-student-course-assignment-progress-highchart")
              .length
          ) {
            ld_dashboard_highchart_prepare(approved_assignment, unapproved_assignment, pending_assignment, 'ld-dashboard-student-course-assignment-progress-highchart', 'assignment');
          }

          var completed_quizze = parseInt(
            jQuery("#ld-dashboard-student-completed-quizze").val()
          );
          var uncompleted_quizze = parseInt(
            jQuery("#ld-dashboard-student-uncompleted-quizze").val()
          );
          /* Student Quiz progress chart prepare */
          if (
            $("#ld-dashboard-student-course-quizze-progress-highchart").length
          ) {
            ld_dashboard_highchart_prepare(completed_quizze, uncompleted_quizze, 1, 'ld-dashboard-student-course-quizze-progress-highchart', 'quiz');
          }

          $(".ld-dashboard-progressbar").each(function () {
            $(this).animate(
              {
                width: $(this).attr("data-percentage-value") + "%",
              },
              1000
            );
          });
        },
      });
    }

    /* Select 2 Dropdown */
    $(".ld-dashboard-select").select2({
      allowClear: true,
    });
    $(".ld-dashboard-email-course-students").select2({
      allowClear: true,
    });

    $("#ld-email-students").select2({
      allowClear: true,
    });

    $("#ld-email-course-students-checkbox").click(function () {
      if ($("#ld-email-course-students-checkbox").is(":checked")) {
        $(".ld-dashboard-email-course-students > option").prop(
          "selected",
          "selected"
        );
        $(".ld-dashboard-email-course-students").trigger("change");
      } else {
        $(".ld-dashboard-email-course-students > option").removeAttr(
          "selected"
        );
        $(".ld-dashboard-email-course-students").trigger("change");
      }
    });

    $("#ld-buddypress-message-students-checkbox").click(function () {
      if ($("#ld-buddypress-message-students-checkbox").is(":checked")) {
        $("#ld-email-students > option").prop(
          "selected",
          "selected"
        );
        $("#ld-email-students").trigger("change");
      } else {
        $("#ld-email-students > option").removeAttr("selected");
        $("#ld-email-students").trigger("change");
      }
    });

    /*
     * Display Selected group wise Course and student list on dropdown
     */
    $("#ld-email-groups").on("change", function () {
      var group_id = $(this).val();

      var data = {
        action: "ld_dashboard_group_id_course_student",
        group_id: group_id,
        nonce: ld_dashboard_js_object.nonce,
      };
      $("#ld-email-student-loader").show();
      $("#ld-email-cource-loader").show();
      course_ajax = $.ajax({
        url: ld_dashboard_js_object.ajaxurl,
        type: "POST",
        data: data,
        dataType: "json",
        beforeSend: function () {
          $("#ld-email-student-loader").show();
          $("#ld-email-cource-loader").show();
          if (course_ajax != null) {
            course_ajax.abort();
          }
        },
        success: function (response) {
          $("#ld-email-student-loader").hide();
          $("#ld-email-cource-loader").hide();
          $("#ld-email-cource").find("option").remove();
          $.each(response["data"]["course_info"], function (key, val) {
            $("#ld-email-cource").append(
              $("<option></option>")
                .attr("value", val["course_id"])
                .text(val["course_name"])
            );
          });

          $("#ld-email-students").find("option").remove();
          if ($("#ld-email-course-students-checkbox").is(":checked")) {
            $("#ld-email-course-students-checkbox").prop("checked", false);
          }
          $.each(response["data"]["user_info"], function (key, val) {
            $("#ld-email-students").append(
              $("<option></option>")
                .attr("value", val["user_id"])
                .text(val["user_name"])
            );
          });
        },
      });
    });
    /*
     * Display Selected Course wise student list on dropdown
     */
    $("#ld-email-cource").on("change", function () {
      var course_id = $(this).val();
      var data = {
        action: "ld_dashboard_couse_students",
        course_id: course_id,
        nonce: ld_dashboard_js_object.nonce,
      };
      $("#ld-email-student-loader").show();
      course_ajax = $.ajax({
        url: ld_dashboard_js_object.ajaxurl,
        type: "POST",
        data: data,
        dataType: "json",
        beforeSend: function () {
          $("#ld-email-student-loader").show();
          if (course_ajax != null) {
            course_ajax.abort();
          }
        },
        success: function (response) {
          $("#ld-email-student-loader").hide();
          $("#ld-email-students").find("option").remove();
          if ($("#ld-email-course-students-checkbox").is(":checked")) {
            $("#ld-email-course-students-checkbox").prop("checked", false);
          }
          $.each(response["data"], function (key, val) {
            $("#ld-email-students").append(
              $("<option></option>")
                .attr("value", val["user_id"])
                .text(val["user_name"])
            );
          });
        },
      });
    });

    /*
     * email trigger send
     */
    $("#ld-email-send").on("click", function (event) {
      event.preventDefault();

      tinyMCE.triggerSave(true, true);
      var submit_from = $("form#ld-dashboard-email-frm").serialize();
      $(".ls-email-success-error").remove();
      $(".ls-email-success-msg").remove();
      $("#ld-email-loader").show();
      $.ajax({
        url: ld_dashboard_js_object.ajaxurl,
        type: "POST",
        data:
          submit_from +
          "&action=ld_dashboard_email_send&nonce=" +
          ld_dashboard_js_object.nonce,
        dataType: "json",
        success: function (response) {
          $("#ld-email-loader").hide();
          $("form#ld-dashboard-email-frm")[0].reset();
          $(".ld-dashboard-select").val(null).trigger("change");
		  $("#ld-email-student-loader").hide();
          if (response["data"]["error"] == 1) {
            $("#ld-email-send").after(
              '<p class="ls-email-success-error">' +
              response["data"]["message"] +
              "</p>"
            );
          } else {
            $("#ld-email-send").after(
              '<p class="ls-email-success-msg">' +
              response["data"]["email_sent"] +
              "</p>"
            );
          }

          setTimeout(function () {
            $(".ls-email-success-error").remove();
            $(".ls-email-success-msg").remove();
          }, 5000);
        },
      });
      return false;
    });

    /*
     * message trigger send
     */
    $("#ld-buddypress-message-send").on("click", function (event) {
      event.preventDefault();
      tinyMCE.triggerSave(true, true);
      var submit_from = $(
        "form#ld-dashboard-buddypress-message-frm"
      ).serialize();
      $(".ls-message-success-error").remove();
      $(".ls-message-success-msg").remove();
      $("#ld-buddypress-message-loader").show();
      $.ajax({
        url: ld_dashboard_js_object.ajaxurl,
        type: "POST",
        data:
          submit_from +
          "&action=ld_dashboard_buddypress_message_send&nonce=" +
          ld_dashboard_js_object.nonce,
        dataType: "json",
        success: function (response) {
          $("#ld-buddypress-message-loader").hide();
          $("form#ld-dashboard-buddypress-message-frm")[0].reset();
          $(".ld-dashboard-select").val(null).trigger("change");
          if (response["data"]["success"] == false) {
            $("#ld-buddypress-message-send").after(
              '<p class="ls-message-success-error">' +
              response["data"]["message_sent"] +
              "</p>"
            );
          } else if (response["data"]["error"] == 1) {
            $("#ld-buddypress-message-send").after(
              '<p class="ls-message-success-error">' +
              response["data"]["message"] +
              "</p>"
            );
          } else {
            $("#ld-buddypress-message-send").after(
              '<p class="ls-message-success-msg">' +
              response["data"]["message_sent"] +
              "</p>"
            );
          }

          setTimeout(function () {
            $(".ls-message-success-error").remove();
            $(".ls-message-success-msg").remove();
          }, 5000);
        },
      });
      return false;
    });

    /* Studet Course Progress chart report */
    if ($("#ld-dashboard-student-courses-id").length != 0) {
      let course = $("#ld-dashboard-student-courses-id option:first").val();
      ld_dashboard_load_student_course_progress( course );
      $("#ld-dashboard-student-courses-id").on("change", function () {
        ld_dashboard_load_student_course_progress($(this).val());
      });
    }

    function ld_dashboard_load_student_course_progress(course_id) {
      $(".ld-dashboard-student-status-block").addClass("disable-this");
      $(".ld-dashboard-loader").show();
      var data = {
        action: "ld_dashboard_student_course_progress",
        nonce: ld_dashboard_js_object.nonce,
        course_id: course_id,
      };
      $.ajax({
        dataType: "JSON",
        url: ld_dashboard_js_object.ajaxurl,
        type: "POST",
        data: data,
        success: function (response) {
          $(".ld-dashboard-student-status-block").removeClass("disable-this");
          $(".ld-dashboard-loader").hide();
          $("#course_container").html(response["data"]["html"]);
          let chartValues = response["data"]["values"];
          let courseTitle = response["data"]["title"];
          let labels = [ ld_dashboard_js_labels.course + ' Progress', ld_dashboard_js_labels.quiz + ' Progress', 'Assignment Progress' ];
          let values = [ chartValues.course_progress, chartValues.quizze_progress, chartValues.assignment_progress ];
          let course_report_chart = '<canvas id="course_container"></canvas>'
          jQuery('.ld-dashboard-student-course-report-container').html(course_report_chart);
          let ctx = document.getElementById('course_container');
          loadBarDesignChart( ctx, labels, values, courseTitle );
        },
      });
    }

    $(".ld-dashboard-error").hide();
    $("#ld-instructor-reg-form").submit(function (event) {
      var flg = false;
      if ($("#ld_dashboard_first_name").val() == "") {
        $(".ld_dashboard_first_name").show();
        flg = true;
      } else {
        $(".ld_dashboard_first_name").hide();
      }

      if ($("#ld_dashboard_last_name").val() == "") {
        $(".ld_dashboard_last_name").show();
        flg = true;
      } else {
        $(".ld_dashboard_last_name").hide();
      }

      if ($("#ld_dashboard_username").val() == "") {
        $(".ld_dashboard_username").show();
        flg = true;
      } else {
        $(".ld_dashboard_username").hide();
      }

      if ($("#ld_dashboard_email").val() == "") {
        $(".ld_dashboard_email").show();
        flg = true;
      } else if (!ld_dashboard_validateEmail($("#ld_dashboard_email").val())) {
        $(".ld_dashboard_email").hide();
        $(".ld_dashboard_email_wrong").show();
        flg = true;
      } else {
        $(".ld_dashboard_email").hide();
        $(".ld_dashboard_email_wrong").hide();
      }

      if ($("#ld_dashboard_password").val() == "") {
        $(".ld_dashboard_password").show();
        flg = true;
      } else {
        $(".ld_dashboard_password").hide();
      }

      if ($("#ld_dashboard_password_confirmation").val() == "") {
        $(".ld_dashboard_password_confirmation").show();
        flg = true;
      } else if (
        $("#ld_dashboard_password").val() !=
        $("#ld_dashboard_password_confirmation").val()
      ) {
        $(".ld_dashboard_password_confirmation").hide();
        $(".ld_dashboard_password_confirmation_wrong").show();
        flg = true;
      } else {
        $(".ld_dashboard_password_confirmation").hide();
        $(".ld_dashboard_password_confirmation_wrong").hide();
      }

      if (flg === true) {
        return false;
      }
      return true;
    });

    function ld_dashboard_validateEmail(email) {
      var re =
        /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(String(email).toLowerCase());
    }

    $(document).on("change", ".ld-dashboard-groups", function () {
      var course_ids = $(this).data("course-id");
      var group_id = $(this).val();
      var data = {
        action: "ld_dashboard_group_course_student",
        course_ids: course_ids,
        group_id: group_id,
      };
      $.ajax({
        url: ld_dashboard_js_object.ajaxurl,
        type: "GET",
        data: data,
        success: function (response) {
          $(".ld-dashboard-student").find("option").remove();
          $(".ld-dashboard-student").append(response);
          if ($(".ld-dashboard-student option:first").val() != "") {
            ld_dashboard_load_student_details(
              $(".ld-dashboard-student option:first").val()
            );
          }
        },
      });
    });

    $(document).on( 'keyup', '.ld-dashboard-lesson-title-input',function(e) {
      e.preventDefault();
      if (e.keyCode === 13) {
        jQuery( '.ld__builder--new-entity-button.ld-dashboard-add-new-lesson-submit' ).trigger('click');
      }
    });

	/* Create a New Section Heading */
	$(document).on("click", ".ld_dashboard_builder_new_section_heading", function ( e ) {
		e.preventDefault();
		var lesson_html = '<div class="ld-dashboard-section-form"><input class="ld-dashboard-section-title-input" type="text" placeholder="Enter a title" name="ld_dashboard_course_section_heading" value=""><span><input type="submit" class="is-primary ld-dashboard-add-new-section-submit ld__builder--new-section-button" value="Add Section heading" data-value="add_lesson" ><input type="button" class="is-default ld__builder--new-section-button" data-value="cancel" value="Cancel"></span><div></div></div>';
		if ( jQuery('.ld-dashboard-section-form').length ) {
		  return false;
		}
		$( '.ld-dashboard-crate-lesson' ).append(lesson_html);
		$( '.ld-dashboard-crate-lesson .ld_dashboard_builder_new_section_heading' ).hide();
    });
	$(document).on("click", ".ld__builder--new-section-button", function ( e ) {
		e.preventDefault();
		var val = $( this).data( 'value' );


		if ( val == 'cancel' ) {
			$( '.ld-dashboard-crate-lesson .ld-dashboard-section-form' ).remove();
			$( '.ld-dashboard-crate-lesson .ld_dashboard_builder_new_section_heading' ).show();
		} else {
			let lessonCount = jQuery('.ld-dashboard-course-builder-lesson').length;
			var new_title =  $('input[name="ld_dashboard_course_section_heading"]').val();
            var postID = $('#_acf_post_id').val();

			$( '.ld-dashboard-crate-lesson .ld-dashboard-section-form' ).remove();
			$( '.ld-dashboard-crate-lesson .ld_dashboard_builder_new_section_heading' ).show();

			let lessonHtml = '<div class="ld-dashboard-single-wrap ld-dashboard-course-builder-lesson ldd-active-lesson" data-item_key="' + lessonCount + '" data-id="' + postID + '" data-value="' + new_title + '" style="position: relative; top: 0px; left: 0px;"><span class="ld-dashboard-sortable-input-section"><input type="hidden" name="course_sections[' + lessonCount + ']" value="' + new_title + '"></span><div class="ld-dashboard-course-builder-section-title"><h4>' + new_title + '</h4></div><div class="ld-dashboard-remove-wrapper ld-dashboard-course-lesson-remove">' + __( 'Remove', 'ld-dashboard' ) + '</div></div>';
			removeCourseBuilderActiveClass();
			jQuery('.ld-dashboard-share-steps-dropper').hide();
			jQuery('.ld-dashboard-course-builder-content').prepend(lessonHtml);
			initSortableLessons();
			jQuery('.acf-form-submit').show();
			jQuery(".ld-dashboard-course-builder-lesson").each(function (
            index,
            elm
          ) {
            let oldIndex = jQuery(this).data("item_key");
            let value = jQuery(this).attr("data-value");
            jQuery(this).attr("data-item_key", index);
            let html = '<input type="hidden" name="ld_dashboard_course_builder[' + index + ']" value="' + value + '">';
            let section_html = '<input type="hidden" name="course_sections[' + index + ']" value="' + value + '">';
            jQuery(this).find('span.ld-dashboard-sortable-input').html(html);
            jQuery(this).find('span.ld-dashboard-sortable-input-section').html(section_html);
          });
		}

	});

	/* Create a New Lesson */
	$(document).on("click", ".ld_dashboard_builder_new_lesson", function ( e ) {
		e.preventDefault();
		var lesson_html = '<div class="ld-dashboard-lesson-form"><input class="ld-dashboard-lesson-title-input" type="text" placeholder="Enter a title" name="ld_dashboard_course_lesson" value=""><span><input type="submit" class="is-primary ld-dashboard-add-new-lesson-submit ld__builder--new-entity-button" value="Add ' + ld_dashboard_js_labels.lesson + '" data-value="add_lesson" ><input type="button" class="is-default ld__builder--new-entity-button" data-value="cancel" value="Cancel"></span><div></div></div>';
		if ( jQuery('.ld-dashboard-lesson-form').length ) {
		  return false;
		}
		$( '.ld-dashboard-crate-lesson' ).append(lesson_html);
		$( '.ld-dashboard-crate-lesson .ld_dashboard_builder_new_lesson' ).hide();
    });

	$(document).on("click", ".ld__builder--new-entity-button", function ( e ) {
		e.preventDefault();
		var val = $( this).data( 'value' );

		if ( val == 'cancel' ) {
			$( '.ld-dashboard-crate-lesson .ld-dashboard-lesson-form' ).remove();
			$( '.ld-dashboard-crate-lesson .ld_dashboard_builder_new_lesson' ).show();
		} else {
			let lessonCount = jQuery('.ld-dashboard-course-builder-lesson').length;
			let postTitle = $('input[name="ld_dashboard_course_lesson"]').val();
			let params = {
				action: "ld_dashboard_save_course_lesson",
				new_title: $('input[name="ld_dashboard_course_lesson"]').val(),
        post_id: $('#_acf_post_id').val(),
        post_type: 'sfwd-lessons',
				nonce: ld_dashboard_js_object.ajax_nonce,
			};
			jQuery.ajax({
				url: ld_dashboard_js_object.ajaxurl,
				type: "post",
				dataType: "JSON",
				data: params,
				success: function (response) {
					$( '.ld-dashboard-crate-lesson .ld-dashboard-lesson-form' ).remove();
					$( '.ld-dashboard-crate-lesson .ld_dashboard_builder_new_lesson' ).show();
					let postID = response['data']['lesson_id'];
					let lessonHtml = '<div class="ld-dashboard-single-wrap ld-dashboard-course-builder-lesson ldd-active-lesson" data-item_key="' + lessonCount + '" data-id="' + postID + '" data-value="' + postID + '" style="position: relative; top: 0px; left: 0px;"><span class="ld-dashboard-sortable-input"><input type="hidden" data-lesson="' + postTitle + '" name="ld_dashboard_course_builder[' + lessonCount + ']" value="' + postID + '"></span><div class="ld-dashboard-course-builder-lesson-title"><h4>' + postTitle + '</h4></div><div class="ld-dashboard-remove-wrapper ld-dashboard-course-lesson-remove">' + __( 'Remove', 'ld-dashboard' ) + '</div><div class="ld-dashboard-course-builder-lesson-dropdown ld-dashboard-accordian ld-dashboard-accordian-closed"><span class="ld-dashboard-accordian-icon ld-dashboard-accordian-open"></span><span class="ld-dashboard-accordian-icon ld-dashboard-accordian-close" style="display: none;"></span></div><div class="ld-dashboard-lesson-builder-wrapper" style="display: none;"><div class="ld-dashboard-course-lesson-builder-topic-wrapper"><div class="ld-dashboard-course-builder-topic-header"><h4>' + ld_dashboard_js_labels.topics + '</h4></div><div class="ld-dashboard-is-sortable ld-dashboard-topics-is-sortable ld-dashboard-course-lesson-builder-quiz-content"></div><div class="ld-dashboard-share-steps-dropper">' + __( 'Drop ' + ld_dashboard_js_labels.topics + ' Here', 'ld-dashboard')+'</div></div><div class="ld-dashboard-course-lesson-builder-quiz-wrapper"><div class="ld-dashboard-course-builder-topic-header"><h4>' + ld_dashboard_js_labels.quizzes + '</h4></div><div class="ld-dashboard-is-sortable ld-dashboard-quizzes-is-sortable ld-dashboard-course-lesson-builder-quiz-content"></div><div class="ld-dashboard-share-steps-dropper">'+__( 'Drop '+ ld_dashboard_js_labels.quizzes +' Here', 'ld-dashboard')+'</div></div></div><div class="ld-dashboard-crate-topics-quiz" style="display: none;"><button class="ld_dashboard_builder_new_topic">' +__( 'New ' + ld_dashboard_js_labels.topic, 'ld-dashboard')+'</button>&nbsp;<button class="ld_dashboard_builder_new_quiz">'+__( 'New ' + ld_dashboard_js_labels.quiz, 'ld-dashboard')+'</button></div></div>';
					removeCourseBuilderActiveClass();
					jQuery('.ld-dashboard-share-steps-dropper').hide();
					jQuery('.ld-dashboard-course-builder-content').append(lessonHtml);
					initSortableLessons();
					jQuery('.acf-form-submit').show();
				},
			});
		}

	});

	/* Create new Topic */
	$(document).on("click", ".ld_dashboard_builder_new_topic", function ( e ) {
		e.preventDefault();
		var topic_html = '<div class="ld-dashboard-topic-form"><input type="text" placeholder="Enter a title" name="ld_dashboard_course_lesson_topic" value=""><span><input type="submit" class="is-primary ld__builder--new-topic-button" value="Add ' + ld_dashboard_js_labels.topic + '" data-value="add_topic" ><input type="button" class="is-default ld__builder--new-topic-button" data-value="cancel" value="Cancel"></span><div></div></div>';

		$(this).parent().prepend(topic_html);
		$( this ).hide();
    });

	$(document).on("click", ".ld__builder--new-topic-button", function ( e ) {
		e.preventDefault();
		var val = $( this).data( 'value' );

		if ( val == 'cancel' ) {
			$(this).parent().parent().parent().find( '.ld_dashboard_builder_new_topic' ).show();
			$(this).parent().parent().remove();
		} else {
			let lessonCount = jQuery('.ld-dashboard-course-builder-lesson').length;
			let postTitle = $('input[name="ld_dashboard_course_lesson_topic"]').val();
			let lesson_id = $(this).parent().parent().parent().parent().data( 'id');
			let params = {
				action: "ld_dashboard_save_course_lesson_topic",
				 new_title: $('input[name="ld_dashboard_course_lesson_topic"]').val(),
                 post_id: $('#_acf_post_id').val(),
                 lesson_id: lesson_id,
                 post_type: 'sfwd-topic',
				 nonce: ld_dashboard_js_object.ajax_nonce,
			};
			var new_topic_button = $(this);
			jQuery.ajax({
				url: ld_dashboard_js_object.ajaxurl,
				type: "post",
				dataType: "JSON",
				data: params,
				success: function (response) {
					new_topic_button.parent().parent().parent().find( '.ld_dashboard_builder_new_topic' ).show();
					new_topic_button.parent().parent().remove();

					let wrapper = jQuery(this).closest('.ld-dashboard-share-post-single');

					let postID = response['data']['topic_id'];
					let topicCount = jQuery('.ldd-active-lesson').find('.ld-dashboard-course-lesson-builder-quiz-content').find('.ld-dashboard-course-lesson-builder-topic-single').length;
					jQuery('.ld-dashboard-share-steps-dropper').hide();

					if ( jQuery('.ldd-active-lesson').length ) {

						if ( ! jQuery('.ldd-active-lesson').find('.ld-dashboard-course-lesson-builder-topic-wrapper').length ) {
							addCourseBuilderContainers('topic');
						}
						let topicHtml = '<div class="ld-dashboard-single-wrap ld-dashboard-is-sortable-item ld-dashboard-course-lesson-builder-topic-single ui-sortable-handle" data-name="' + postTitle + '" data-type="topic" data-item_key="' + topicCount + '" data-id="' + lesson_id + '" data-value="' + postID + '"><span class="ld-dashboard-sortable-input"><input type="hidden" name="ld_dashboard_lesson_builder[' + lesson_id + '][topic][' + topicCount + ']" value="' + postID + '"></span><div class="ld-dashboard-course-builder-topic-title">' + postTitle + '</div><div class="ld-dashboard-remove-wrapper ld-dashboard-course-lesson-topic-remove">' + __( 'Remove', 'ld-dashboard' ) + '</div></div>';

						//jQuery('.ld-dashboard-course-lesson-builder-topic-wrapper').find('.ld-dashboard-course-lesson-builder-quiz-content').append(topicHtml);
						jQuery('.ld-dashboard-course-builder-lesson[data-value="'+lesson_id+'"] .ld-dashboard-course-lesson-builder-topic-wrapper .ld-dashboard-course-lesson-builder-quiz-content').append(topicHtml);

						jQuery(wrapper).hide();
						initSortableBuilders();
					}
				},
			});
		}
	});

  /* Mobile Toggle Menu */
  jQuery('#ld-dashboard-menu').on('click', function(e){
    e.preventDefault();
    if( jQuery('.ld-dashboard-location').hasClass('ld-dashboard-show-mobile-menu') ) {
      jQuery('.ld-dashboard-location').removeClass('ld-dashboard-show-mobile-menu');
    } else {
      jQuery('.ld-dashboard-location').addClass('ld-dashboard-show-mobile-menu');
    }
  });

	/* Create new Quizz */
	$(document).on("click", ".ld_dashboard_builder_new_quiz", function ( e ) {
		e.preventDefault();
		var topic_html = '<div class="ld-dashboard-quiz-form"><input type="text" placeholder="Enter a title" name="ld_dashboard_course_lesson_quiz" value=""><span><input type="submit" class="is-primary ld__builder--new-quiz-button" value="Add ' + ld_dashboard_js_labels.quiz + '" data-value="add_quiz" ><input type="button" class="is-default ld__builder--new-quiz-button" data-value="cancel" value="Cancel"></span><div></div></div>';

		$(this).parent().prepend(topic_html);
		$( this ).hide();
    });

	$(document).on("click", ".ld__builder--new-quiz-button", function ( e ) {
		e.preventDefault();
		var val = $( this).data( 'value' );


		if ( val == 'cancel' ) {
			$(this).parent().parent().parent().find( '.ld_dashboard_builder_new_quiz' ).show();
			$(this).parent().parent().remove();
		} else {
			let lessonCount = jQuery('.ld-dashboard-course-builder-lesson').length;
			let postTitle = $('input[name="ld_dashboard_course_lesson_quiz"]').val();
			let lesson_id = $(this).parent().parent().parent().parent().data( 'id');
			let params = {
				action: "ld_dashboard_save_course_lesson_quiz",
				 new_title: $('input[name="ld_dashboard_course_lesson_quiz"]').val(),
                 post_id: $('#_acf_post_id').val(),
                 lesson_id: lesson_id,
                 post_type: 'sfwd-quiz',
				 nonce: ld_dashboard_js_object.ajax_nonce,
			};
			var new_topic_button = $(this);
			jQuery.ajax({
				url: ld_dashboard_js_object.ajaxurl,
				type: "post",
				dataType: "JSON",
				data: params,
				success: function (response) {
					new_topic_button.parent().parent().parent().find( '.ld_dashboard_builder_new_quiz' ).show();
					new_topic_button.parent().parent().remove();

					let wrapper = jQuery(this).closest('.ld-dashboard-share-post-single');

					let postID = response['data']['quiz_id'];
					let quizCount = jQuery('.ldd-active-lesson').find('.ld-dashboard-course-lesson-builder-quiz-content').find('.ld-dashboard-course-lesson-builder-quiz-single').length;
					jQuery('.ld-dashboard-share-steps-dropper').hide();

					if ( jQuery('.ldd-active-lesson').length ) {

						if ( ! jQuery('.ldd-active-lesson').find('.ld-dashboard-course-lesson-builder-quiz-wrapper').length ) {
							addCourseBuilderContainers('quiz');
						  }
						  let quizHtml = '<div class="ld-dashboard-single-wrap ld-dashboard-is-sortable-item ld-dashboard-course-lesson-builder-quiz-single ui-sortable-handle" data-name="' + postTitle + '" data-type="quiz" data-item_key="' + quizCount + '" data-id="' + lesson_id + '" data-value="' + postID + '"><span class="ld-dashboard-sortable-input"><input type="hidden" name="ld_dashboard_lesson_builder[' + lesson_id + '][quiz][' + quizCount + ']" value="' + postID + '"></span><div class="ld-dashboard-course-builder-quiz-title">' + postTitle + '</div><div class="ld-dashboard-remove-wrapper ld-dashboard-course-lesson-quiz-remove">' + __( 'Remove', 'ld-dashboard' ) + '</div></div>';

						  //jQuery('.ld-dashboard-course-lesson-builder-quiz-wrapper').find('.ld-dashboard-course-lesson-builder-quiz-content').append(quizHtml);

						  jQuery('.ld-dashboard-course-builder-lesson[data-value="'+lesson_id+'"] .ld-dashboard-course-lesson-builder-quiz-wrapper .ld-dashboard-course-lesson-builder-quiz-content').append(quizHtml);

						jQuery(wrapper).hide();
						initSortableBuilders();
					}
				},
			});
		}
	});


    $('.ld-dashboard-date-picker').datepicker({beforeShow: ld_dashboard_customRange, dateFormat: "yy-mm-dd",});

	$(document).on( 'change', "#ld-dashboard-sort-by", function () {
		var course_id =  $("#ld-dashboard-courses-id option:selected").val();
		ld_dashboard_load_course_details( course_id, 1, $(this).val());

    });

	function ld_dashboard_customRange( input ){
		if (input.id == 'ld-dashboard-end-date') {
			var minDate = new Date($('#ld-dashboard-start-date').val());
			minDate.setDate(minDate.getDate() + 1)

			return {
				minDate: minDate

			};
		}

		if (input.id == 'ld-dashboard-start-date') {
			var maxDate = new Date($('#ld-dashboard-end-date').val());
			maxDate.setDate(maxDate.getDate() - 1)

			return {
				maxDate: maxDate

			};
		}
		return {}
	}
  });
})(jQuery);
