// function for loading third category list
function getThirdcatList(subcategory_id)
{ 
	var subcategory_id=subcategory_id;
	var category_id=$("#category_id").val();
	
	if(subcategory_id!='' && category_id!='')
	{
	$.ajax({
			type: "POST",
			url: BASEPATH+"Product/ajaxgetThirdcategoryList",
			data:'subcategory_id='+subcategory_id+"&category_id="+category_id,
			dataType: 'json',
			success: function(response)
			{ 
				$("#thirdcategory_id").html(response.resstr);
			}
			});
	}
	else
	{
		$("#subcategory_id").html('<option value="">--Sub Category--</option>');
		$("#thirdcategory_id").html('<option value="0">--Third Category--</option>');
	}
}

// function for loading subcategory list
function getSubcatListForThird(category_id)
{ 
	var category_id=category_id;
	if(category_id!='')
	{
	$.ajax({
			type: "POST",
			url: BASEPATH+"Product/ajaxgetSubcategoryList",
			data:'category_id='+category_id,
			dataType: 'json',
			success: function(response)
			{ 
				$("#subparent_id").html(response.resstr);
			}
			});
	}
}
// fucntion for slider

function checkSliderType(banner_type)

{

	$("#display_for_product").hide();

	$("#display_for_store").hide();

	

	if(banner_type=="Product")

	{

		//alert(banner_type);

		$("#display_for_product").show();

	}

	

	if(banner_type=="Store")

	{

		//alert(banner_type);

		$("#display_for_store").show();

	}

}



// fucntion for offer type

function checkOfferType(offer_type)

{

	$("#display_product_offer_type").show();

	$("#display_store_offer_type").hide();

	

	if(offer_type=="Products")

	{

		$("#display_product_offer_type").show();

		$("#display_store_offer_type").hide();

	}

	

	if(offer_type=="Stores")

	{

		$("#display_store_offer_type").show();

		$("#display_product_offer_type").hide();

	}

}



// validation for order change



function order_change(order_id,order_no,order_status,customer_id)



{



	if(confirm("Are you really want to change status?"))



	{



		var order_status=order_status;



		var order_id=order_id;

		var order_no=order_no;



		var customer_id=customer_id;



		/*alert(order_status);



		alert(order_id);*/



		$("#display_status_msg").hide();



		$.ajax({



			type: "POST",



			url: BASEPATH+"Order/ajaxSetOrderStatus",



			data:'order_status='+order_status+"&order_id="+order_id+"&customer_id="+customer_id+"&order_no="+order_no,



			dataType: 'json',



			success: function(response)



			{ 



				if(response.chnage_st==1)



				{



					$("#display_status_msg").show();



					$('#display_status_msg').fadeOut(1000);



				}



			}



			});



	}		



	else



	{



		return false;



	}



}



// code for all manage pages



function chk_isDeleteComnfirm()



{



	if(confirm("Are you really want to delete record?"))



		return true;



	else



		return false;



}



// function for changing customer status

function customer_status_change(customer_id,customer_status)

{   

$("#sucess_sttaus").hide();

	var customer_id=customer_id;

	var customer_status=customer_status;

	

	if(customer_id!='')

	{

	$.ajax({

			type: "POST",

			url: BASEPATH+"Customer/ajaxSetcustomerStatus",

			data:'customer_id='+customer_id+"&customer_status="+customer_status,

			dataType: 'json',

			success: function(response)

			{ 

				$("#sucess_sttaus").show();

				$('#sucess_sttaus').fadeOut(3000);

			}

			});

	}

}





// function for loading subcategory list

function getSubcatList(category_id)

{ 

	var category_id=category_id;

	if(category_id!='')

	{

	$.ajax({

			type: "POST",

			url: BASEPATH+"Product/ajaxgetSubcategoryList",

			data:'category_id='+category_id,

			dataType: 'json',

			success: function(response)

			{ 

				$("#subcategory_id").html(response.resstr);

			}

			});

	}

}





// function for loading state list

function getStateList(country_id)

{  

	var country_id=country_id;

	if(country_id!='')

	{

	$.ajax({

			type: "POST",

			url: BASEPATH+"Store/ajaxgetStateList",

			data:'country_id='+country_id,

			dataType: 'json',

			success: function(response)

			{ 

				$("#store_state").html(response.resstr);

			}

			});

	}

}



// function for loading city list

function getCityList(state_id)

{ 

	var state_id=state_id;

	if(state_id!='')

	{

	$.ajax({

			type: "POST",

			url: BASEPATH+"Store/ajaxgetCityList",

			data:'state_id='+state_id,

			dataType: 'json',

			success: function(response)

			{ 

				$("#store_city").html(response.resstr);

			}

			});

	}

}

// function for loading store subcategory list
function getStoreSubcatList(store_category)

{ 

	var category_id=store_category;

	if(category_id!='')

	{

	$.ajax({

			type: "POST",

			url: BASEPATH+"Store/ajaxgetSubcategoryList",

			data:'category_id='+category_id,

			dataType: 'json',

			success: function(response)

			{ 

				$("#store_subcategory").html(response.resstr);

			}

			});

	}

}



$(document).ready(function($) 
{
	/* code for adding category*/
	$('#btn_addCategory').click(function(){ 
	var category_name=$("#category_name").val();
	var category_image=$("#category_image").val();
	
	var cat_listing_image=$("#cat_listing_image").val();
	var ext1 = $("#category_image").val().split('.').pop().toLowerCase();
	var ext2 = $("#cat_listing_image").val().split('.').pop().toLowerCase();
	
	
	$("#err_category_name").html('');
	$("#err_cat_image").html('');
	$("#err_cat_listing_image").html('');
	
	var flag=1;
	
	if(category_name=="")
	{
		$("#err_category_name").html('Enter category name.');
		flag=0;
	}
	if(category_image=="")
	{
		$("#err_category_image").html('Select category image.');
		flag=0;
	}
	if(category_image!="" && $.inArray(ext1, ['gif','png','jpg','jpeg','bmp']) == -1) 
    {
        $("#err_category_image").html('Invalid category image.');
        flag=0;
     }
	if(cat_listing_image=="")
	{		
		$("#err_cat_listing_image").html('Select category listing image');
		flag=0;
	}
	if(cat_listing_image!="" && $.inArray(ext1, ['gif','png','jpg','jpeg','bmp']) == -1) 
    {
        $("#err_cat_listing_image").html('Invalid category listing image.');
        flag=0;
     }
	if(flag==1)
	{	
		return true;
	}
	else
	{
		return false;
	}
});

/* end of code for adding category */

/* code for updating category*/
	$('#btn_updateCategory').click(function(){ 
	var category_name=$("#category_name").val();
	var category_image=$("#category_image").val();
	
	var cat_listing_image=$("#cat_listing_image").val();
	var ext1 = $("#category_image").val().split('.').pop().toLowerCase();
	var ext2 = $("#cat_listing_image").val().split('.').pop().toLowerCase();
	
	
	$("#err_category_name").html('');
	$("#err_category_image").html('');
	$("#err_cat_listing_image").html('');
	
	var flag=1;
	
	if(category_name=="")
	{
		$("#err_category_name").html('Enter category name.');
		flag=0;
	}
	if(category_image!="" && $.inArray(ext1, ['gif','png','jpg','jpeg','bmp']) == -1) 
    {
        $("#err_category_image").html('Invalid category image.');
        flag=0;
     }
	if(cat_listing_image!="" && $.inArray(ext1, ['gif','png','jpg','jpeg','bmp']) == -1) 
    {
        $("#err_cat_listing_image").html('Invalid category listing image.');
        flag=0;
     }
	if(flag==1)
	{	
		return true;
	}
	else
	{
		return false;
	}
});

/* end of code for updating category */

/* code for adding subcategory*/
	$('#btn_addsubCategory').click(function(){ 
	var parent_id=$("#parent_id").val();
	var category_name=$("#category_name").val();
	
	var category_image=$("#category_image").val();
	var ext1 = $("#category_image").val().split('.').pop().toLowerCase();
	
	
	$("#err_parent_id").html('');
	$("#err_category_image").html('');
	$("#err_category_name").html('');
	
	var flag=1;
	
	if(parent_id=="")
	{
		$("#err_parent_id").html('Select category first.');
		flag=0;
	}
	if(category_name=="")
	{
		$("#err_category_name").html('Enter category name.');
		flag=0;
	}
	if(category_image=="")
	{
		$("#err_category_image").html('Select category image.');
		flag=0;
	}
	if(category_image!="" && $.inArray(ext1, ['gif','png','jpg','jpeg','bmp']) == -1) 
    {
        $("#err_category_image").html('Invalid category image.');
        flag=0;
     }
	if(flag==1)
	{	
		return true;
	}
	else
	{
		return false;
	}
});

/* end of code for adding category */

/* code for updating subcategory*/
	$('#btn_updatesubCategory').click(function(){ 
	var parent_id=$("#parent_id").val();
	var category_name=$("#category_name").val();
	var category_image=$("#category_image").val();
	
	var ext1 = $("#category_image").val().split('.').pop().toLowerCase();
	
	
	$("#err_category_name").html('');
	$("#err_category_image").html('');
	$("#err_parent_id").html('');
	
	var flag=1;
	
	if(parent_id=="")
	{
		$("#err_parent_id").html('Select category.');
		flag=0;
	}
	if(category_name=="")
	{
		$("#err_category_name").html('Enter category name.');
		flag=0;
	}
	if(category_image!="" && $.inArray(ext1, ['gif','png','jpg','jpeg','bmp']) == -1) 
    {
        $("#err_category_image").html('Invalid category image.');
        flag=0;
     }
	if(flag==1)
	{	
		return true;
	}
	else
	{
		return false;
	}
});

/* end of code for updating category */
	/* select all customers for notification section*/

	$(".check_all_customers_notification").click(function(){

		 $("input:checkbox.cls_check_all_customers").prop('checked',this.checked);

	});

	

	/* select all products for offer section*/

	$(".check_all_offer_products").click(function(){

		 $("input:checkbox.cls_check_all_products").prop('checked',this.checked);

	});

	

/* select all stores for offer section*/

	$(".check_all_offer_stores").click(function(){

		 $("input:checkbox.cls_check_all_stores").prop('checked',this.checked);

	});	
/* valdiation for add product*/
$('#btn_previousproduct1').click(function(){
	$("#basicinfo-tab").addClass('active show');
		$("#basicinfo").addClass('active show');
		
		
		$("#productdetails-tabs").removeClass('active show');
		$("#productdetails").removeClass('active show');
});

$('#btn_addproduct').click(function(){ 
	var product_name=$("#product_name").val();
	var category_id=$("#category_id").val();
	
	var subcategory_id=$("#subcategory_id").val();
	var thirdcategory_id=$("#thirdcategory_id").val();
	
	
	var supplier_name=$("#supplier_name").val();
	var country_id=$("#country_id").val();
	var product_type=$("#product_type").val();
	var weight=$("#weight").val();
	
	//var product_description=$("#product_description").val();
	
	
	$("#err_product_name").html('');
	$("#err_category_id").html('');
	$("#err_subcategory_id").html('');
	$("#err_thirdcategory_id").html('');
	
	$("#err_supplier_name").html('');
	$("#err_country_id").html('');
	$("#err_product_type").html('');
	
	$("#err_weight").html('');
	//$("#err_product_description").html('');
	
	
	var flag=1;
	
	if(product_name=="")
	{
		$("#err_product_name").html('Enter product name.');
		flag=0;
	}
	if(category_id=="")
	{
		$("#err_category_id").html('Select category.');
		flag=0;
	}
	
	if(subcategory_id=="")
	{		$("#err_subcategory_id").html('Select subcategory ');
		flag=0;
	}
	if(thirdcategory_id=="")
	{
		$("#err_thirdcategory_id").html('Select third category');
		flag=0;
	}
	if(supplier_name=="")
	{
		$("#err_supplier_name").html('Please enter supplier name');
		flag=0;
	}
	if(country_id=="")
	{
		$("#err_country_id").html('select country');
		flag=0;
	}
	
	if(product_type=="")
	{
		$("#err_product_type").html('Select product type');
		flag=0;
	}
	if(weight=="")
	{
		$("#err_weight").html('Please enter weight');
		flag=0;
	}
	/*if(product_description=="")
	{
		$("#err_product_description").html('Please enter description');
		flag=0;
	}*/
	
	if(flag==1)
	{	
		return true;
	}
	else
	{
		return false;
	}
});

$('#btn_addproductnext').click(function(){ 
	var product_name=$("#product_name").val();
	var category_id=$("#category_id").val();
	
	var subcategory_id=$("#subcategory_id").val();
	var thirdcategory_id=$("#thirdcategory_id").val();
	
	
	var supplier_name=$("#supplier_name").val();
	var country_id=$("#country_id").val();
	var product_type=$("#product_type").val();
	
	$("#err_product_name").html('');
	$("#err_category_id").html('');
	$("#err_subcategory_id").html('');
	$("#err_thirdcategory_id").html('');
	
	$("#err_supplier_name").html('');
	$("#err_country_id").html('');
	$("#err_product_type").html('');
	
	var flag=1;
	
	if(product_name=="")
	{
		$("#err_product_name").html('Enter product name.');
		flag=0;
	}
	if(category_id=="")
	{
		$("#err_category_id").html('Select category.');
		flag=0;
	}
	
	if(subcategory_id=="")
	{		$("#err_subcategory_id").html('Select subcategory ');
		flag=0;
	}
	if(thirdcategory_id=="")
	{
		$("#err_thirdcategory_id").html('Select third category');
		flag=0;
	}
	if(supplier_name=="")
	{
		$("#err_supplier_name").html('Please enter supplier name');
		flag=0;
	}
	if(country_id=="")
	{
		$("#err_country_id").html('select country');
		flag=0;
	}
	
	if(product_type=="")
	{
		$("#err_product_type").html('Select product type');
		flag=0;
	}
	
	
	if(flag==1)
	{	
		$("#productdetails-tabs").addClass('active show');
		$("#productdetails").addClass('active show');
		
		
		$("#basicinfo-tab").removeClass('active show');
		$("#basicinfo").removeClass('active show');
	}
	else
	{
		return false;
	}
});

$('#btn_addproductnext1').click(function(){ 
	var weight=$("#weight").val();
	
	//var product_description=$("#product_description").val();
	
	
	
	$("#err_weight").html('');
	//$("#err_product_description").html('');
	
	
	var flag=1;
	
	
	if(weight=="")
	{
		$("#err_weight").html('Please enter weight');
		flag=0;
	}
	/*if(product_description=="")
	{
		$("#err_product_description").html('Please enter description');
		flag=0;
	}*/
	
	if(flag==1)
	{	
		$("#multipleimages-tabs").addClass('active show');
		$("#multipleimages").addClass('active show');
		
		
		$("#productdetails-tabs").removeClass('active show');
		$("#productdetails").removeClass('active show');
		return true;
	}
	else
	{
		return false;
	}
});
/* end of validation for add product*/
/* validation for update store*/
$('#btn_updatestore').click(function(){
	
	var store_name=$("#store_name").val();
	var store_owner_name=$("#store_owner_name").val();
	var store_owner_number=$("#store_owner_number").val();
	var store_owner_email=$("#store_owner_email").val();
	var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
	
	var store_category=$("#store_category").val();
	var store_subcategory=$("#store_subcategory").val();
	
	$("#err_store_name").html('');
	$("#err_store_owner_name").html('');
	$("#err_store_owner_number").html('');
	$("#err_store_owner_email").html('');
	$("#err_store_category").html('');
	$("#err_store_subcategory").html('');
	
	var flag=1;
	
	if(store_name=="")
	{
		$("#err_store_name").html('Please enter store name');
		flag=0;
	}
	if(store_owner_name=="")
	{
		$("#err_store_owner_name").html('Enter store owner name.');
		flag=0;
	}
	if(store_owner_number=="")
	{
		$("#err_store_owner_number").html('Enter store contact number.');
		flag=0;
	}
	if(store_owner_number!="" &&  store_owner_number.length!=9)
	{
		$("#err_store_owner_number").html('Please enter valid contact number of 9 digit.');
		flag=0;
	}
	if(store_owner_number!="" && isNaN(store_owner_number))
	{
		$("#err_store_owner_number").html('Please enter valid contact number.');
		flag=0;
	}
	if(store_owner_email=="")
	{
		$("#err_store_owner_email").html('Please enter valid owner email address');
		flag=0;
	}
	if (store_owner_email!="" && !testEmail.test(store_owner_email))
    {
		$("#err_store_owner_email").html('Please enter a valid email address.');
		flag=0;
	}
	if(store_category=="")
	{
		$("#err_store_category").html('Please select store category');
		flag=0;
	}
	if(store_subcategory=="")
	{
		$("#err_store_subcategory").html('Please select store subcategory');
		flag=0;
	}
	if(flag==1)
	{
		return true;
	}
	else
	{
		return false;
	}
});

$('#btn_updatestore1').click(function(){
	
	
	var store_contact_number=$("#store_contact_number").val();
	var store_logo=$("#store_logo").val();
	var ext1 = $("#store_logo").val().split('.').pop().toLowerCase();
	
	var store_opening_time=$("#store_opening_time").val();
	var store_closing_time=$("#store_closing_time").val();
	var store_address=$("#store_address").val();
	var store_country=$("#store_country").val();
	var store_state=$("#store_state").val();
	var store_city=$("#store_city").val();
	
	var store_commission=$("#store_commission").val();
	
	
	$("#err_store_contact_number").html('');
	$("#err_store_logo").html('');
	$("#err_store_opening_time").html('');
	$("#err_store_closing_time").html('');
	$("#err_store_address").html('');
	$("#err_store_country").html('');
	$("#err_store_state").html('');
	$("#err_store_city").html('');
	
	$("#err_store_commission").html('');
	
	
	var flag=1;
	
	
	if(store_contact_number=="")
	{
		$("#err_store_contact_number").html('Please enter store contact number');
		flag=0;
	}
	if(store_contact_number!="" &&  store_contact_number.length!=9)
	{
		$("#err_store_contact_number").html('Please enter valid contact number of 9 digit.');
		flag=0;
	}
	if(store_contact_number!="" && isNaN(store_contact_number))
	{
		$("#err_store_contact_number").html('Please enter valid contact number.');
		flag=0;
	}
	
	
	if(store_logo!="" && $.inArray(ext1, ['gif','png','jpg','jpeg','bmp']) == -1) 
    {
        $("#err_store_logo").html('Invalid store logo.');
        flag=0;
     }
	if(store_opening_time=="")
	{
		$("#err_store_opening_time").html('Please select store opening time');
		flag=0;
	}
	if(store_closing_time=="")
	{
		$("#err_store_closing_time").html('Please select store closing time');
		flag=0;
	}
	if(store_address=="")
	{
		$("#err_store_address").html('Please enter store address');
		flag=0;
	}
	if(store_country=="")
	{
		$("#err_store_country").html('Please select store country');
		flag=0;
	}
	if(store_state=="")
	{
		$("#err_store_state").html('Please select store state');
		flag=0;
	}
	if(store_city=="")
	{
		$("#err_store_city").html('Please select store city');
		flag=0;
	}
	
	if(store_commission=="")
	{
		$("#err_store_commission").html('Please enter commission');
		flag=0;
	}
	if(flag==1)
	{
		return true;
	}
	else
		return false;
});
	
$('#btn_updatestore2').click(function(){	
	var registration_image=$("#registration_image").val();
	var proof_image=$("#proof_image").val();
	var ext1 = $("#registration_image").val().split('.').pop().toLowerCase();
	var ext2 = $("#proof_image").val().split('.').pop().toLowerCase();
	
	var flag=1;
	
	$("#err_registration_image").html('');
	$("#err_proof_image").html('');
	
	if(registration_image!="" && $.inArray(ext1, ['gif','png','jpg','jpeg','bmp','pdf','doc','docx']) == -1) 
    {
        $("#err_registration_image").html('Invalid registaration image.');
        flag=0;
     }
	if(proof_image!="" && $.inArray(ext2, ['gif','png','jpg','jpeg','bmp','pdf','doc','docx']) == -1) 
    {
        $("#err_proof_image").html('Invalid proof image.');
        flag=0;
     }
	if(flag==1)
	{
		return true;
	}
	else
		return false;
});
	
/* end of update store */	

/* validation for add store*/

$('#btn_addstore1').click(function(){
	
	var store_name=$("#store_name").val();
	var store_owner_name=$("#store_owner_name").val();
	var store_owner_number=$("#store_owner_number").val();
	var store_owner_email=$("#store_owner_email").val();
	var store_owner_password=$("#store_owner_password").val();
	var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
	
	var store_category=$("#store_category").val();
	var store_subcategory=$("#store_subcategory").val();
	
	$("#err_store_name").html('');
	$("#err_store_owner_name").html('');
	$("#err_store_owner_number").html('');
	$("#err_store_owner_email").html('');
	$("#err_store_owner_password").html('');
	$("#err_store_category").html('');
	$("#err_store_subcategory").html('');
	
	var flag=1;
	
	if(store_name=="")
	{
		$("#err_store_name").html('Please enter store name');
		flag=0;
	}
	if(store_owner_name=="")
	{
		$("#err_store_owner_name").html('Enter store owner name.');
		flag=0;
	}
	if(store_owner_number=="")
	{
		$("#err_store_owner_number").html('Enter store contact number.');
		flag=0;
	}
	if(store_owner_number!="" &&  store_owner_number.length!=9)
	{
		$("#err_store_owner_number").html('Please enter valid contact number of 9 digit.');
		flag=0;
	}
	if(store_owner_number!="" && isNaN(store_owner_number))
	{
		$("#err_store_owner_number").html('Please enter valid contact number.');
		flag=0;
	}
	if(store_owner_email=="")
	{
		$("#err_store_owner_email").html('Please enter valid owner email address');
		flag=0;
	}
	if (store_owner_email!="" && !testEmail.test(store_owner_email))
    {
		$("#err_store_owner_email").html('Please enter a valid email address.');
		flag=0;
	}
	if(store_owner_password=="")
	{
		$("#err_store_owner_password").html('Please enter store owner password');
		flag=0;
	}
	if(store_category=="")
	{
		$("#err_store_category").html('Please select store category');
		flag=0;
	}
	if(store_subcategory=="")
	{
		$("#err_store_subcategory").html('Please select store subcategory');
		flag=0;
	}
	if(flag==1)
	{
		return true;
	}
	else
	{
		return false;
	}
});

$('#btn_addstore2').click(function(){
	
	
	var store_contact_number=$("#store_contact_number").val();
	var store_logo=$("#store_logo").val();
	var ext1 = $("#store_logo").val().split('.').pop().toLowerCase();
	
	var store_opening_time=$("#store_opening_time").val();
	var store_closing_time=$("#store_closing_time").val();
	var store_address=$("#store_address").val();
	var store_country=$("#store_country").val();
	var store_state=$("#store_state").val();
	var store_city=$("#store_city").val();
	
	var store_commission=$("#store_commission").val();
	
	
	$("#err_store_contact_number").html('');
	$("#err_store_logo").html('');
	$("#err_store_opening_time").html('');
	$("#err_store_closing_time").html('');
	$("#err_store_address").html('');
	$("#err_store_country").html('');
	$("#err_store_state").html('');
	$("#err_store_city").html('');
	
	$("#err_store_commission").html('');
	
	
	var flag=1;
	
	
	if(store_contact_number=="")
	{
		$("#err_store_contact_number").html('Please enter store contact number');
		flag=0;
	}
	if(store_contact_number!="" &&  store_contact_number.length!=9)
	{
		$("#err_store_contact_number").html('Please enter valid contact number of 9 digit.');
		flag=0;
	}
	if(store_contact_number!="" && isNaN(store_contact_number))
	{
		$("#err_store_contact_number").html('Please enter valid contact number.');
		flag=0;
	}
	
	if(store_logo=="")
	{
		$("#err_store_logo").html('Please select store logo');
		flag=0;
	}
	if(store_logo!="" && $.inArray(ext1, ['gif','png','jpg','jpeg','bmp']) == -1) 
    {
        $("#err_store_logo").html('Invalid store logo.');
        flag=0;
     }
	if(store_opening_time=="")
	{
		$("#err_store_opening_time").html('Please select store opening time');
		flag=0;
	}
	if(store_closing_time=="")
	{
		$("#err_store_closing_time").html('Please select store closing time');
		flag=0;
	}
	if(store_address=="")
	{
		$("#err_store_address").html('Please enter store address');
		flag=0;
	}
	if(store_country=="")
	{
		$("#err_store_country").html('Please select store country');
		flag=0;
	}
	if(store_state=="")
	{
		$("#err_store_state").html('Please select store state');
		flag=0;
	}
	if(store_city=="")
	{
		$("#err_store_city").html('Please select store city');
		flag=0;
	}
	
	if(store_commission=="")
	{
		$("#err_store_commission").html('Please enter commission');
		flag=0;
	}
	if(flag==1)
	{
		return true;
	}
	else
		return false;
});
	
	
$('#btn_addstore3').click(function(){	
	var registration_image=$("#registration_image").val();
	var proof_image=$("#proof_image").val();
	var ext1 = $("#registration_image").val().split('.').pop().toLowerCase();
	var ext2 = $("#proof_image").val().split('.').pop().toLowerCase();
	
	var flag=1;
	
	$("#err_registration_image").html('');
	$("#err_proof_image").html('');
	
	if(registration_image=="")
	{
		$("#err_registration_image").html('Please select registaration image');
		flag=0;
	}
	if(registration_image!="" && $.inArray(ext1, ['gif','png','jpg','jpeg','bmp','pdf','doc','docx']) == -1) 
    {
        $("#err_registration_image").html('Invalid registaration image.');
        flag=0;
     }
	if(proof_image=="")
	{
		$("#err_proof_image").html('Please select proof image');
		flag=0;
	}
	if(proof_image!="" && $.inArray(ext2, ['gif','png','jpg','jpeg','bmp','pdf','doc','docx']) == -1) 
    {
        $("#err_proof_image").html('Invalid proof image.');
        flag=0;
     }
	if(flag==1)
	{
		return true;
	}
	else
		return false;
});

$('#btn_addstore4').click(function(){
	var bank_name=$("#bank_name").val();
	var account_name=$("#account_name").val();
	var account_number=$("#account_number").val();
	var ifsc_code=$("#ifsc_code").val();
	var bank_address=$("#bank_address").val();
	
	
   var flag=1;
	
	$("#err_bank_name").html('');
	$("#err_account_name").html('');
	$("#err_account_number").html('');
	$("#err_ifsc_code").html('');
	$("#err_bank_address").html('');
	
	
	if(bank_name=="")
	{
		$("#err_bank_name").html('Please enter bank name');
		flag=0;
	}
	if(account_name=="")
	{
		$("#err_account_name").html('Please enter account name');
		flag=0;
	}
	if(account_number=="")
	{
		$("#err_account_number").html('Please enter account number');
		flag=0;
	}
	if(account_number!="" && isNaN(account_number))
	{
		$("#err_account_number").html('Please enter valid account number.');
		flag=0;
	}
	if(ifsc_code=="")
	{
		$("#err_ifsc_code").html('Please enter IFSC code');
		flag=0;
	}
	if(bank_address=="")
	{
		$("#err_bank_address").html('Please enter bank address');
		flag=0;
	}
	if(flag==1)
	{
		return true;
	}
	else
		return false;
});	

});