<!-- footer start-->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 footer-copyright">
                        <p class="mb-0">Copyright <?php echo date('Y');?> © Bhooljao All rights reserved.</p>
                    </div>
                    <div class="col-md-6">
                        <!--<p class="pull-right mb-0">Hand crafted & made with<i class="fa fa-heart"></i></p>-->
                    </div>
                </div>
            </div>
        </footer>
        <!-- footer end-->
    </div>

</div>

<!-- latest jquery-->
<script src="<?php echo base_url('template/admin/');?>assets/js/jquery-3.3.1.min.js"></script>

<!-- Bootstrap js-->
<script src="<?php echo base_url('template/admin/');?>assets/js/popper.min.js"></script>
<script src="<?php echo base_url('template/admin/');?>assets/js/bootstrap.js"></script>

	<script src="<?php echo base_url('template/admin/');?>assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<!-- feather icon js-->
<script src="<?php echo base_url('template/admin/');?>assets/js/icons/feather-icon/feather.min.js"></script>
<script src="<?php echo base_url('template/admin/');?>assets/js/icons/feather-icon/feather-icon.js"></script>




<!--Timepicker jquery-->
<script src="<?php echo base_url('template/admin/');?>assets/scss/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>

<!-- Sidebar jquery-->
<script src="<?php echo base_url('template/admin/');?>assets/js/sidebar-menu.js"></script>

<!--chartist js-->
<script src="<?php echo base_url('template/admin/');?>assets/js/chart/chartist/chartist.js"></script>

<!--chartjs js-->
<script src="<?php echo base_url('template/admin/');?>assets/js/chart/chartjs/chart.min.js"></script>

<!-- lazyload js-->
<script src="<?php echo base_url('template/admin/');?>assets/js/lazysizes.min.js"></script>

<!--copycode js-->
<script src="<?php echo base_url('template/admin/');?>assets/js/prism/prism.min.js"></script>
<script src="<?php echo base_url('template/admin/');?>assets/js/clipboard/clipboard.min.js"></script>
<script src="<?php echo base_url('template/admin/');?>assets/js/custom-card/custom-card.js"></script>

<!--counter js-->
<script src="<?php echo base_url('template/admin/');?>assets/js/counter/jquery.waypoints.min.js"></script>
<script src="<?php echo base_url('template/admin/');?>assets/js/counter/jquery.counterup.min.js"></script>
<script src="<?php echo base_url('template/admin/');?>assets/js/counter/counter-custom.js"></script>

<!--peity chart js-->
<script src="<?php echo base_url('template/admin/');?>assets/js/chart/peity-chart/peity.jquery.js"></script>

<!--sparkline chart js-->
<script src="<?php echo base_url('template/admin/');?>assets/js/chart/sparkline/sparkline.js"></script>

<!--Customizer admin-->
<script src="<?php echo base_url('template/admin/');?>assets/js/admin-customizer.js"></script>

<!--dashboard custom js-->
<script src="<?php echo base_url('template/admin/');?>assets/js/dashboard/default.js"></script>

<!--right sidebar js-->
<script src="<?php echo base_url('template/admin/');?>assets/js/chat-menu.js"></script>

<!--height equal js-->
<script src="<?php echo base_url('template/admin/');?>assets/js/height-equal.js"></script>

<!-- lazyload js-->
<script src="<?php echo base_url('template/admin/');?>assets/js/lazysizes.min.js"></script>

<!--script admin-->
<script src="<?php echo base_url('template/admin/');?>assets/js/admin-script.js"></script>
<script src="<?php echo base_url('template/admin/');?>assets/js/admin_validation.js"></script>

<!-- ckeditor js-->
<script src="<?php echo base_url('template/admin/');?>assets/js/editor/ckeditor/ckeditor.js"></script>
<script src="<?php echo base_url('template/admin/');?>assets/js/editor/ckeditor/styles.js"></script>
<script src="<?php echo base_url('template/admin/');?>assets/js/editor/ckeditor/adapters/jquery.js"></script>
<script src="<?php echo base_url('template/admin/');?>assets/js/editor/ckeditor/ckeditor.custom.js"></script>


<!-- Rating Js-->
<script src="<?php echo base_url('template/admin/');?>assets/js/rating/jquery.barrating.js"></script>
<script src="<?php echo base_url('template/admin/');?>assets/js/rating/rating-script.js"></script>

<!-- Owlcarousel js-->
<script src="<?php echo base_url('template/admin/');?>assets/js/owlcarousel/owl.carousel.js"></script>
<script src="<?php echo base_url('template/admin/');?>assets/js/dashboard/product-carousel.js"></script>
<!--Customizer admin-->
<script src="<?php echo base_url('template/admin/');?>assets/js/admin-customizer.js"></script>

<!-- lazyload js-->
<script src="<?php echo base_url('template/admin/');?>assets/js/lazysizes.min.js"></script>


<!--dropzone js-->
<?php if($this->router->fetch_method()=="addMainCategory"){?>
<script src="<?php echo base_url('template/admin/');?>assets/js/dropzone/dropzone.js"></script>
<script src="<?php echo base_url('template/admin/');?>assets/js/dropzone/dropzone-script.js"></script>	
<?php }?>


<?php if($this->router->fetch_method()=="viewinvoice"){ ?>
<script type="text/javascript">
$(function() {
document.getElementById("doPrintinvoice").addEventListener("click", function() {  
     var printContents = document.getElementById('printDiv').innerHTML;
     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;
     window.print();
     document.body.innerHTML = originalContents;
});	
});
</script>
<?php } ?> 
<script src="<?php echo base_url('template/admin/');?>assets/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('template/admin/');?>assets/datatables/media/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url('template/admin/');?>assets/datatables/extras/TableTools/Buttons-1.4.2/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url('template/admin/');?>assets/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url('template/admin/');?>assets/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url('template/admin/');?>assets/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.print.min.js"></script>
<script src="<?php echo base_url('template/admin/');?>assets/datatables/extras/TableTools/JSZip-2.5.0/jszip.min.js"></script>
<script src="<?php echo base_url('template/admin/');?>assets/datatables/extras/TableTools/pdfmake-0.1.32/pdfmake.min.js"></script>
<script src="<?php echo base_url('template/admin/');?>assets/datatables/extras/TableTools/pdfmake-0.1.32/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
$(document).ready(function(){
    // $(".select2").select2();
  var rowIdx = 1;
    //Add Label
    $('.addLabel').on('click', function () {
  
    // Adding a row inside the tbody.
    $('#tbody').append(`<tr id="R${++rowIdx}">
           <td>
           <input type="text" class="form-control option_label" id="option_label" name="option_label[]" placeholder="Enter Label Name"  >
            <div id="err_option_label" class="error_msg err_option_label"></div>
            </td>
            <td>
            <select class="form-control " id="option_type" name="option_type" required>
                <option value="">Select Option Type</option>
                <option value="Dropdown">Dropdown</option>
                <option value="Input">Input</option>
                <option value="Radio">Radio</option>
            </select>
            <div id="err_option_type" class="error_msg err_option_type"></div>
            </td>
            <td class="text-center">
            <button class="btn btn-danger remove" 
                type="button"><i class="fa fa-remove"></i></button>
            </td>
            </tr>
            <tr>
                <!-- <td  class="row-index text-center"></td> -->
                <td> <input type="text" class="form-control optionsArr" id="optionsArr" name="optionsArr[]" placeholder="Enter Option"  >
                    <div id="err_optionsArr" class="error_msg err_optionsArr"></div>
                </td>
                <td> <input type="text" class="form-control amountArr" id="amountArr" name="amountArr[]" placeholder="Enter Amount"  >
                    <div id="err_amountArr" class="error_msg err_amountArr"></div>
                </td>
                    <td  class="text-center"><button class="btn btn-md btn-success" id="addBtn" type="button">
                <!-- <i class="fa fa-plus"></i> --> Add Option
                </button> </td>
            </tr>`);
    });

    // Remove opion row
    // jQuery button click event to remove a row
    $('#tbody').on('click', '.remove', function () {
  
    // Getting all the rows next to the 
    var child = $(this).closest('tr').nextAll();

    child.each(function () {
        var id = $(this).attr('id');
        // Getting the <p> inside the .row-index class.
        var idx = $(this).children('.row-index').children('p');
        // Gets the row number from <tr> id.
        var dig = parseInt(id.substring(1));
        // Modifying row index.
        idx.html(`${dig - 1}`);
        // Modifying row id.
        $(this).attr('id', `R${dig - 1}`);
    });
    // Removing the current row.
    $(this).closest('tr').remove();
    // Decreasing the total number of rows by 1.
    rowIdx--;
    });

    var rowIdx = 1;
    //Add Option row
    $('#addBtn').on('click', function () {
  
    // Adding a row inside the tbody.
    $('#tbody').append(`<tr id="R${++rowIdx}">
           <td>
            <input type="text" class="form-control optionsArr" id="optionsArr" name="optionsArr[]" placeholder="Enter Option" required >
            <div id="err_optionsArr" class="error_msg err_optionsArr"></div>
            </td>
            <td>
            <input type="text" class="form-control amountArr" id="amountArr" name="amountArr[]" placeholder="Enter Amount" required >
            <div id="err_optionsArr" class="error_msg err_optionsArr"></div>
            </td>
            <td class="text-center">
            <button class="btn btn-danger remove" 
                type="button"><i class="fa fa-remove"></i></button>
            </td>
            </tr>`);
    });


//Add Option row
    $('#addimagesBtn').on('click', function () {
  
    // Adding a row inside the tbody.
    $('#tbody').append(`<tr id="R${++rowIdx}">
           <td>
           <input type="file" class="form-control optionsArr" id="service_image" name="service_image[]">
            <div id="err_optionsArr" class="error_msg err_optionsArr"></div>
            </td>
            
            <td class="text-center">
            <button class="btn btn-danger remove" 
                type="button"><i class="fa fa-remove"></i></button>
            </td>
            </tr>`);
    });




    // Remove opion row
    // jQuery button click event to remove a row
    $('#tbody').on('click', '.remove', function () {
  
    // Getting all the rows next to the 
    var child = $(this).closest('tr').nextAll();

    child.each(function () {
        var id = $(this).attr('id');
        // Getting the <p> inside the .row-index class.
        var idx = $(this).children('.row-index').children('p');
        // Gets the row number from <tr> id.
        var dig = parseInt(id.substring(1));
        // Modifying row index.
        idx.html(`${dig - 1}`);
        // Modifying row id.
        $(this).attr('id', `R${dig - 1}`);
    });
    // Removing the current row.
    $(this).closest('tr').remove();
    // Decreasing the total number of rows by 1.
    rowIdx--;
    });

// Add More label row
$('#addRow').on('click', function () {
  
  // Adding a row inside the tbody.
  $('#tbodyLabel').append(`<tr id="L${++rowIdx}">
         <td>
          <input type="text" class="form-control labelArr" id="labelArr" name="labelArr[]" placeholder="Enter Label" required >
          <div id="err_labelArr" class="error_msg err_labelArr"></div>
          </td>
          <td>
          <input type="text" class="form-control labelvalueArr" id="labelvalueArr" name="labelvalueArr[]" placeholder="Enter Values(ex.Yes,No)" required >
          <div id="err_labelvalueArr" class="error_msg err_labelvalueArr"></div>
          </td>
          <td class="text-center">
          <button class="btn btn-danger removeRow" 
              type="button"><i class="fa fa-remove"></i></button>
          </td>
          </tr>`);
  });

// Remove Label row
    // jQuery button click event to remove a row
    $('#tbodyLabel').on('click', '.removeRow', function () {
  
  // Getting all the rows next to the 
  var child = $(this).closest('tr').nextAll();

  child.each(function () {
      var id = $(this).attr('id');
      // Getting the <p> inside the .row-index class.
      var idx = $(this).children('.row-index').children('p');
      // Gets the row number from <tr> id.
      var dig = parseInt(id.substring(1));
      // Modifying row index.
      idx.html(`${dig - 1}`);
      // Modifying row id.
      $(this).attr('id', `L${dig - 1}`);
  });
  // Removing the current row.
  $(this).closest('tr').remove();
  // Decreasing the total number of rows by 1.
  rowIdx--;
  });

$(document).ready(function(){

    $("#select_type").change(function () { 
        // alert();                           
       var select_type= $('select[name=select_type]').val() // Here we can get the value of selected item
    //    alert(select_type);
        if(select_type=="Service Provider") 
        {
            $("#serviceproviderDiv").show();
            $("#customerDiv").hide();
        }
        else if(select_type=="Customer") 
        {
            $("#serviceproviderDiv").hide();
            $("#customerDiv").show();
        }
        else
        {
            $("#serviceproviderDiv").hide();
            $("#customerDiv").hide();
        }
    }); 
});



  $("#frm_addCuisine").on("submit", function(){
    $("#body").fadeOut();
    $("#pageloader").fadeIn();

  });//submit
});//document ready

$(document).ready(function(){
  $("#frm_addimportproduct1").on("submit", function(){
    $("#body").fadeOut();
    $("#pageloader").fadeIn();

  });//submit
});//document ready


$(document).ready(function(){
  $("#frm_addimportproduct2").on("submit", function(){
    $("#body").fadeOut();
    $("#pageloader").fadeIn();

  });//submit
});//document ready
  </script>
<script type="text/javascript">
//setInterval(getNotification, 5000);
//Declaration of function that will insert data into database
 function senddata(filename){
        var file = filename;
        alert(file);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('backend/');?>Products/manageProductsNew",
            data: {file},
            async: true,
            success: function(html){
                $("#result").html(html);
            }
        })
        }

function getNotification()
{
    //console.log("test");
    //get state
   //var sender_country=$("#receiver_country").val();

      $.ajax({
            type:"POST",
            url:"<?php echo base_url('backend/');?>Enquiry/getAllNotification",
             data:{
                  
               }              
            }).done(function(message){
            
            //alert(message);
            var res=message.split('_|_');
                    $('#noticount').empty();
                     $('#noticount').append(res[0]);
                     //alert(res[1]);
                    $('#notification_div').empty();
                     $('#notification_div').append(res[1]);
                
             });

}
function getStoreByMainCategory()
{
    
   var main_cat=$("#main_cat").val();
   var btn_rst=$("#btn_rst").val();
   var btn_grc=$("#btn_grc").val();
   var btn_vices=$("#btn_vices").val();

   if(main_cat==1)
   {
        $("#btn_rst").show();
        $("#btn_grc").hide();
        $("#btn_vices").hide();

   }
   else if(main_cat==2)
   {
        $("#btn_rst").hide();
        $("#btn_grc").show();
        $("#btn_vices").hide();
   }
   else
   {
        $("#btn_rst").hide();
        $("#btn_grc").hide();
        $("#btn_vices").show();
   }
      $.ajax({
            type:"POST",
            url:"<?php echo base_url('backend/');?>Products/getRestByMainCategory",
             data:{
                  main_cat:main_cat
               }              
            }).done(function(message){
            
                //alert(message);
                var res=message.split('_|_');
            
                    $('#rst_id').empty();
                     $('#rst_id').append(message);


                    
             });
   
   
   

}
function getStoreByMainCategoryFromUser()
{
    
   var main_cat=$("#main_cat").val();

   $("#recent_status").val("recent_order");
  
      $.ajax({
            type:"POST",
            url:"<?php echo base_url('backend/');?>Products/getRestByMainCategory",
             data:{
                  main_cat:main_cat
               }              
            }).done(function(message){
            
                //alert(message);
                var res=message.split('_|_');
            
                    $('#rst_name').empty();
                     $('#rst_name').append(message);

                     
                    
             });
   
   
   

}
function getCategoy()
{
    
   var rst_id=$("#rst_id").val();

      $.ajax({
            type:"POST",
            url:"<?php echo base_url('backend/');?>Products/getRestCategory",
             data:{
                  rst_id:rst_id
               }              
            }).done(function(message){
            
            //alert(message);
            var res=message.split('_|_');
            
                    $('#rst_category_id').empty();
                     $('#rst_category_id').append(message);
                    
             });

}

$(document).ready(function() {
	
	$('#datatable-mayur').DataTable(
		{
			dom: 'Bfrtip',
			"paging": true,
			"autoWidth": true,
			buttons: [
				 
				'copyHtml5',
				'csvHtml5',
				'excelHtml5',
				'pdfHtml5',
				'print',
				 
			]
		}
	);

  

 
});
$("#clr_btn").click(function () {
    $(".checkBoxClass").prop('checked',false);
    $("#ckbCheckAll").prop('checked',false);
});
function getChangeContent()
{
    //alert();
    var banner_subtype=document.getElementById('banner_subtype').value;
    if(banner_subtype=="normal")
    {
        $('#div_url').show();
        $('#div_rest').hide();
        $('#div_product').hide();
       
    }
    else if(banner_subtype=="product")
    {
        $('#div_url').hide();
        $('#div_rest').show();
        $('#div_product').show();
        
    }
    else
    {
         $('#div_url').hide();
        $('#div_rest').show();
        $('#div_product').hide();
        

    }
}
function getProductByRest()
{
    //alert();
    var sel_rest=document.getElementById('sel_rest').value;
    $.ajax({
                      type:"POST",
                      url:"<?php echo base_url();?>backend/Banner/getProductByStore",
                       data:{
                               sel_rest:sel_rest,
                               
                             }              
                        }).done(function(message){
                        var res=message.split('_|_');
                          

                            $('#sel_product').empty();
                            $('#sel_product').append(message);
      
                       });
}
</script>
<!--Datepicker jquery-->
<script src="<?php echo base_url('template/admin/');?>assets/js/datepicker/datepicker.js"></script>
<script src="<?php echo base_url('template/admin/');?>assets/js/datepicker/datepicker.en.js"></script>
<script src="<?php echo base_url('template/admin/');?>assets/js/datepicker/datepicker.custom.js"></script>


</body>
</html>