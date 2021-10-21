function toStore() {
    location.replace("\\SeventeenJuly\\staff\\store\\")
}

function readURL(input) {
    //https://stackoverflow.com/questions/651700/how-to-have-jquery-restrict-file-types-on-upload
    var ext = $('#img').val().split('.').pop().toLowerCase();
    if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
        alert('Invalid extension! Only "gif", "png", "jpg" and "jpeg" are allowed!');
    } else {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#thumbnail')
                    .attr('src', e.target.result)
            };
        
            reader.readAsDataURL(input.files[0]);
        }
    }
  
}

$(document).ready(function(){
    $('#price').on('input',function(e){
        $pricevalue = $('#price').val();
        if (!$.isNumeric($pricevalue) & $pricevalue !== ''){
            $('#price').val('');
            alert('Only Number is Allowed!');
        }
      
    });
    $('#quantity').on('input',function(e){
        $pricevalue = $('#quantity').val();
        if (!$.isNumeric($pricevalue) & $pricevalue !== ''){
            $('#quantity').val('');
            alert('Only Number is Allowed!');
        }
      
    });
    $(".new-size").click(function(){
        $(".mid-box:last").clone().appendTo(".size-quantity");
        $(".quantity:last").val(0);

        // if > 1 class then show x button
        let numItems = $('.mid-box').length;
        if (numItems > 1){
            $(".remove-icon").show();
        } else {
            $(".remove-icon").hide();
        }

        remove();
    })
   

  })

// if > 1 class then show x button
function remove() {
    $(".remove-icon").click(function(){
        $(this).parent().remove();
        if (numItems > 1){
            $(".remove-icon").show();
        } else {
            $(".remove-icon").hide();
        }
    })
}

