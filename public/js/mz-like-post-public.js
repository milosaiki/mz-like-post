jQuery(document).ready(function($){
	
	'use strict';
    /**
	 * Like/liked post
	 */
	if($('.mzlp-btn').length){


        $('.mzlp-btn').on('click', function(e){
                e.preventDefault();
                
                var $this = $(this),
                    item_id = $this.data('item-id'),
                    nonce = $this.data('nonce');
               if($this.hasClass('like')){
                    var action = 'like_post';
               } else {
                    var action = 'unlike_post';
               }
                $.ajax({
                    type: 'post',
                    url: mz_like_post_ajax.ajax_url,
                    data: {
                        'nonce': nonce,
                        'item_id': item_id,
                        'action': action
                    },
                    success: function(data){
                        if($this.hasClass('like')){
                            if(data.is_liked == true){
                                
                                $("span.mzlp-text").text(mz_like_post_ajax.liked_text);
                                $('.notification-link').css('display', 'inline-block');
                            
                            }

                       } else {
                            if(data.is_liked == false){
                                
                                $("span.mzlp-text").text(mz_like_post_ajax.like_text);
                                $('.notification-link').css('display', 'none');
                            
                            }
                       }
                       $this.toggleClass("like liked");
                        
                    },
                    async: 'false',
                    error: function(error){
                        console.log(error);
                    }
                });

        });
       
    }
      

    
});

