
	$(document).ready(function() {
		$(".fancybox").fancybox();
        $(".fancybox-thumb").fancybox({
		prevEffect	: 'none',
		nextEffect	: 'none',
		helpers	: {
			thumbs	: {
				width	: 50,
				height	: 50
			}
		}
	});
        
            $(".datepicker").datepicker({
                dateFormat:"yy-mm-dd"
            });
    
	
$(".fancybox")
    .attr('rel', 'gallery')
    .fancybox({
        beforeLoad: function() {
            this.title = $(this.element).attr('caption');
        }
    });

$(".fancybox")
    .attr('rel', 'gallery')
    .fancybox({
        padding : 0
    });
$("#username").on('keyup', function(){
	var input_username = $('#username').val();
	console.log(input_username);
	jsondata={keyup_username: input_username};
	request = $.ajax({
      url: 'ajax/ajax.php',
      type: 'post',
      data: jsondata,
      dataType: 'text',
      error: function(error) {
          console.log(error);
      }
    });

    request.success(function(data) {
    	data=JSON.parse(data);
		console.log(data);

		if(data==0){
			$("#submit").addClass('hidden');
			$("#ajax_error").text('No such user on file.');
		}
		if(data==1){
			$("#submit").removeClass('hidden');
			$("#ajax_error").text('');
		}
	});
});

var element=document.getElementById('logged_in');
console.log(element);
$(".fancybox").fancybox({
    afterLoad: function() {
    	
        window.title=this.title;
        console.log(title);
        var field=document.getElementById("title");
        console.log(field);
field.setAttribute("value", title);
       
    },
    helpers : {
        title: {
            type: 'inside'
        }
    }
});



        

    });



