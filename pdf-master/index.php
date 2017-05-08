
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        //alert('hello');
        $('#submit-return').prop('disabled',true);

        $('#upload-return').on('change',function(){
            //alert('hello');
            if($(this).val() != ''){
                $('#submit-return').prop('disabled',false);
            }
            
        });
        $('#form-return').on('submit',function(event){
            event.preventDefault();
            event.stopPropagation();
            var formData = new FormData();
            formData.append('upload', $('#upload-return')[0].files[0]);
            
            if ($('#upload-return').prop('files')[0].size > 3072000) {
                alert('max upload size is 3 MB')
            }
            else {
                $.ajax({
                        url: 'demo.php',
                        type: 'POST',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(response){
                            alert(response);
                            if(response.length>20){
                                $('#return-data-text').html(response);
                            }
                            else $('#return-data-text').html('File could not be parsed correctly');

                        }
                    });
            }
        });
    });
</script>
<form method="post" enctype="multipart/form-data" id="form-return">
    <input type="file" name="upload" id="upload-return">
    <br>
    <button name="submit" id="submit-return">submit</button>
</form>
<div id="return-data-text"></div>