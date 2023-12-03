jQuery(function($){
	$('#filter').submit(function(){
		var filter = $('#filter');
		$.ajax({
			url:filter.attr('action'),
			data:filter.serialize(), // form data
			type:filter.attr('method'), // POST
			beforeSend:function(xhr){
				filter.find('button').text('Processing...'); // changing the button label
			},
			success:function(data){
				filter.find('button').text('Apply filter'); // changing the button label back
				$('#response').html(data); // insert data
			}
		});
		return false;
	});
});
jQuery(function($){

	$(document).ready(function(){
        $(document).on('click', '.js-filter-item', function(event){
            (event).preventDefault();
            var category = $(this).data('category');

            $.ajax({
                url: wpAjax.ajaxUrl,
                data: { 
	                action: 'filterterm', 
	                category: category, 
	                taxonomy:  $(this).data('taxonomy'),
	                posttype:  $(this).data('posttype')
	                },
                type: 'post',
				beforeSend:function(xhr){
				},
                success: function(result){
                    $('#response').html(result);
                },
                error: function(result){
                    console.warn(result);
                }
            });
        });
    });
});

jQuery(function($){

	$(document).ready(function(){
	    $(".listsegres__a--parent").on( "click", function() {	 
	
			 if($(this).hasClass("open")){
				$(this).removeClass("open");
				$(this).siblings(".parent .listcategorias").slideUp(200);
			 } else {
				$(".listsegres__a--parent").removeClass("open");
				/*$(this).parent().addClass("open");*/
				$(this).addClass("open");
				$(".parent .listcategorias").slideUp(200);
				$(this).siblings(".parent .listcategorias").slideDown(200);
			};
		});
		
	    });
});
jQuery(function($){

	$(document).ready(function(){
	    $(".child .listsegres__a--child").on( "click", function() {
			
				if( $(this).hasClass("openc")){
					$(this).removeClass("openc");
					$(this).siblings(".child .listcategorias").slideUp(200);
				 } else {
					$(".child .listsegres__a--child").removeClass("openc");
					$(this).addClass("openc");
					$(".child .listcategorias").slideUp(200);
					$(".child .listcategorias").slideDown(200);
				};
			 
		});
		
	    });
});