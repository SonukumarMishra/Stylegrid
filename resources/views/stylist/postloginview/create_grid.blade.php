@include("stylist.postloginview.partials.header.header")
@include("stylist.postloginview.partials.navigate.navigate")
<meta name="csrf-token" content="{{ csrf_token() }}">
 <!-- BEGIN: Content-->
<style>
.mjcheckinput {
    opacity: 0;
	margin-left: -50px;
}

.mjcheckatag {
    position: absolute;
    left: 45%;
	 top: 31%;
	
}

</style>
    <div class="app-content content bg-white">
        <div class="content-wrapper">

            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Revenue, Hit Rate & Deals -->
                <div class="flex-column-reverse flex-md-row mt-lg-3 row">
                    <div class="col-md-8">
                    <div class="col-md-8">
                        <h1>Let&apos;s get styling.</h1>
                        <h3>Create a new StyleGrid and send to your clients via PDF or weblink.</h3>
                    </div>
                    </div>
                    <div class="col-md-4 quick-link text-right">
                        <span class="mr-5"><a hrf="">Quick Link</a></span>
                        <div class="row justify-content-end my-2">
                            <a href="" class="mx-1"><img src="stylist/app-assets/images/icons/Chat.svg" alt=""></a>
                            <a href="" class="mx-1"><img src="stylist/app-assets/images/icons/File Invoice.svg" alt=""></a>
                            <a href="" class="mx-1"><img src="app-assets/images/icons/Gear.svg" alt=""></a>

                        </div>

                    </div>
                </div>
				
                <!-------------------- fulfil souring request--------->
                <div id="create-grid" class="mt-5">
                    <div class="row">

                        <div class="col-lg-11">

                            <div class="grid-bg mx-4 mt-3 mb-2 p-4">
                                <a href="grid-design.html">
                                    <h1>STYLEGRID</h1>
                                </a>
                                <div class="row">
                                    <div class="col-lg-6 d-flex align-items-center">
                                        <input type="text" placeholder="Name your grid here..." class="w-100 name-grid">

                                    </div>
                                    <div class="col-lg-6">

                                        <div class="Neon Neon-theme-dragdropbox mt-5 mx-lg-4">
                                         <!--   <input name="files[]" id="filer_input2" multiple="multiple" type="file">-->
                                            <div class="Neon-input-dragDrop py-5 px-4 mm">
                                                <div class="Neon-input-inner py-4">
                                                    <div class="Neon-input-text">
                                                        <h3>Add your feature image here...</h3>
                                                    </div><a class="Neon-input-choose-btn blue"><img
                                                            src="stylist/app-assets/images/icons/plus.png" alt=""></a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-1 d-lg-block d-flex justify-lg-content-start justify-content-center my-auto">
                       
							<div class='numbering'></div>
                            
                           
                                <div class="gradiant-bg text-center mt-1 mx-lg-0 mx-2 plussign" onclick="addgrid();"><span><img
                                            src="stylist/app-assets/images/icons/green-logo.png" class="img-fluid " alt="" >
                                    </span></div>
                            
                        </div>
                    </div>
                    <div class="appendrowhere">
					<div class="showmodal"></div>
					</div>
					
					  
                </div>
            </div>
        </div>
    </div>
	
	
	
    <!--------------------end of fulfil souring request--------->
    <!--  Modal -->
    
	   @include("stylist.postloginview.partials.footer.footerjs")
  <input type="hidden" value="2" id="randomnum" readonly>
  <input type="hidden" value="2" id="randomnum_inner" readonly>


<script>

$('document').ready(function(){  // fetch grid and block in differ array in order to show serializely
			$.ajax({
		type: "POST",
		headers: 
				{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		url: "/get-grid-data",
		data: '',
		cache: true,
		contentType: false,
		processData: false,
		async:false,
        processData: false,
		success: function(ajaxresponse){
			var data = JSON.parse(ajaxresponse);
			// console.log(data)
		var dataa =  	data[0].grid_data;
		var block_dataa =  	data[0].block_data;
		// alert(dataa)
			console.log(dataa)
			console.log(block_dataa)
			
			// alert(block_dataa.length)
			// alert(dataa.length)
			 if (dataa.length > 0) {
			 // if (1!=1) {
				 // alert("if data avail");
				 console.log("if data avail");
				for (i = 0; i < dataa.length; i++) {
					
				var html ='<div class="row mt-2 mjrowtrack" id="row_'+dataa[i].grid_id+'"><div class="col-lg-11"><div class="grid-bg mx-4 px-4 py-2 mb-4"><div class="row"><div class="col-8"><h1>STYLEGRID</h1></div><div class="col-4 text-right "><img src="stylist/app-assets/images/icons/Empty-Trash.png" class="img-fluid deletegrid"  value="mybutton1" onclick="removegrid(this)" alt=""/></div></div><div class="row add-item">';

				html +='<div class="col-lg-6 d-flex align-items-center"><div class="row">';

				html +='<div class="showblock_'+dataa[i].grid_id+' d-flex flex-wrap"></div>';

				
				html +='<div class="col-lg-2 px-0 text-lg-left text-center mjaddanother" id="addanother1"><button type="submit" class=" px-3 form-border addblock" onclick="addblock('+dataa[i].grid_id+')"   ><img src="stylist/app-assets/images/icons/plus.png" alt=""><br>Add another block</button></div>';

				html +='</div></div>';



				html +='<div class="col-lg-6 px-lg-5"><div class="Neon Neon-theme-dragdropbox mt-5"><input name="files[]" id="filer_input2" multiple="multiple" type="file"><div class="Neon-input-dragDrop py-5 px-4 mx-lg-3"><div class="Neon-input-inner py-2"><div class="Neon-input-text"><h3>Add your feature image here...</h3></div><a class="Neon-input-choose-btn blue"><imgsrc="stylist/app-assets/images/icons/plus.png" alt=""></a></div></div></div></div></div></div></div><div class="col-lg-1"></div></div>';

				$('.appendrowhere').append(html);
				
					checknumberng();
					// alert(block_dataa.length);
				for(j = 0; j < block_dataa.length; j++){
					var img=constants.base_url+'/stylist/grid_block/'+block_dataa[j].block_image;
					console.log(img)
					// alert('block id '+block_dataa[j].block_id)
					var mjblock='<div class="mjrowtrack_inner col-6" grid="1" id="row_'+dataa[i].grid_id+'_block_'+block_dataa[j].block_id+'" data-toggle="modal"   data-target="#row_'+dataa[i].grid_id+'_gridmodal_'+block_dataa[j].block_id+'"><div class="Neon Neon-theme-dragdropbox "><div class="Neon-input-dragDrop "><div class="Neon-input-inner py-3"><div class="Neon-input-text"><h3>Add an item here</h3></div><a class="Neon-input-choose-btn blue"><img src="'+img+'" alt="" style="height: 50%; width: 100%;"></a></div></div></div><img src="stylist/app-assets/images/icons/Empty-Trash.png" class="img-fluid deletegrid" value="1" onclick="removeblock(this)" alt="" style="position: absolute;top: 0;">';
		
		
		
		
		$('.showblock_'+dataa[i].grid_id).append(mjblock);
		modaladd(dataa[i].grid_id,dataa[i].grid_id,block_dataa[j].block_id,block_dataa[j]);
	  
		checkanother_block(dataa[i].grid_id)
				}
				
			
}
		
			 }else{
				 alert("else");
			
		
			
		


   // $('#image_preview_remove').click(function(){
	   function image_preview_remove(val){
		   console.log(val)
		   var clickedid =	$(val).attr('newatr');
		   // alert(clickedid)
		    // $("#firstcol"+clickedid).load(" #div > *");
        var mjval=$('#'+clickedid).val();
		 // alert('mjval'+mjval)
        $('#image_preview_remove'+clickedid).hide();
        $("#divImageMediaPreview"+clickedid).hide();
		 $("#image_error"+clickedid).hide();
        $("#divImageMediaPreview"+clickedid).html('');
       
        $("#prd_img"+clickedid).val('');
		 // $("#commonclick"+clickedid).html('');
        // $("#commonclick"+clickedid).remove();
       
	   }
    // })
    // $(".modal in").on('change',function () {
	
	
	
	
	
	
	$('document').ready(function(){
	var html ='<div class="row mt-2 mjrowtrack" id="row_1"><div class="col-lg-11"><div class="grid-bg mx-4 px-4 py-2 mb-4"><div class="row"><div class="col-8"><h1>STYLEGRID</h1></div><div class="col-4 text-right "><img src="stylist/app-assets/images/icons/Empty-Trash.png" class="img-fluid deletegrid"  value="mybutton1" onclick="removegrid(this)" alt=""/></div></div><div class="row add-item">';
	
	 
	 
	 html +='<div class="col-lg-6 d-flex align-items-center"><div class="row">';
	 
	 html +='<div class="showblock_1 d-flex flex-wrap"></div>';
	 
	 // html +='<div class="col-lg-5"><div class="Neon Neon-theme-dragdropbox mt-5"><input name="files[]" id="filer_input2" multiple="multiple"type="file"><div class="Neon-input-dragDrop"><div class="Neon-input-inner py-3"><div class="Neon-input-text"><h3>Add an item here</h3></div><a class="Neon-input-choose-btn blue"><imgsrc="stylist/app-assets/images/icons/plus.png" alt=""></a></div></div></div></div>';
	 
	 html +='<div class="col-lg-2 px-0 text-lg-left text-center mjaddanother" id="addanother1"><button type="submit" class=" px-3 form-border addblock" onclick="addblock(1)"   ><img src="stylist/app-assets/images/icons/plus.png" alt=""><br>Add another block</button></div>';
	
	 html +='</div></div>';
	 
	 
	  
	  html +='<div class="col-lg-6 px-lg-5"><div class="Neon Neon-theme-dragdropbox mt-5"><input name="files[]" id="filer_input2" multiple="multiple" type="file"><div class="Neon-input-dragDrop py-5 px-4 mx-lg-3"><div class="Neon-input-inner py-2"><div class="Neon-input-text"><h3>Add your feature image here...</h3></div><a class="Neon-input-choose-btn blue"><imgsrc="stylist/app-assets/images/icons/plus.png" alt=""></a></div></div></div></div></div></div></div><div class="col-lg-1"></div></div>';

	$('.appendrowhere').append(html);
	
	

	checknumberng();
	});
	
	
	
	$('document').ready(function(){   //inner block
		var mjblock='<div class="mjrowtrack_inner col-6" grid="1" id="row_1_block_1" data-toggle="modal"   data-target="#row_1_gridmodal_1"><div class="Neon Neon-theme-dragdropbox "><div class="Neon-input-dragDrop "><div class="Neon-input-inner py-3"><div class="Neon-input-text"><h3>Add an item here</h3></div><a class="Neon-input-choose-btn blue"><imgsrc="stylist/app-assets/images/icons/plus.png" alt=""></a></div></div></div><img src="stylist/app-assets/images/icons/Empty-Trash.png" class="img-fluid deletegrid" value="1" onclick="removeblock(this)" alt="" style="position: absolute;top: 0;">';
		
		
		// mjblock +='</div>';
		 // mjblock +='<div class="modal fade" id="row_1_gridmodal_1" tabindex="-1" role="dialog" aria-labelledby="acceptLabel"aria-hidden="true"><div class="modal-dialog" role="document"><div class="modal-content pt-1"><div class="mr-2"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
		
         // mjblock +='<div class="modal-body py-2"><h1 class="text-center modal-submit-request">Submit Sourcing Request</h1><div id="browse-soursing" class="mt-2"><div class="row align-items-center" id="fulfill-request"><div class="col-lg-6 "><div class="Neon Neon-theme-dragdropbox mt-3"><input name="files[]" id="filer_input2" multiple="multiple" type="file"><div class="Neon-input-dragDrop py-5 px-4"><div class="Neon-input-inner py-4"><div class="Neon-input-text "><h3>Upload an image of the product here</h3></div><a class="Neon-input-choose-btn blue"><img src="app-assets/images/icons/plus.png" alt=""></a></div></div></div></div>';
		
		
          // mjblock +='<div class="col-lg-6"><div class="p-3 lg-border-left "><form id="submit-request" action="client-submit-request-complete.html" class=" "><div class="form-group"><label for="">Enter the name of the product here:</label><input type="text" class="form-control submit-input"aria-describedby="emailHelp" placeholder="Enter product name..."></div><div class="form-group"><label for="">Tell us the brand of the product:</label><input type="text" class="form-control submit-input"aria-describedby="emailHelp" placeholder="Enter brand name..."></div><div class="form-group"><label for="">What is the product type? (Bag, Dress, Heels etc)</label><input type="text" class="form-control submit-input"aria-describedby="emailHelp" placeholder="Enter product type..."></div><div class="form-group"><label for="">Does the product have a size? Leave blank if none.</label><input type="text" class="form-control submit-input"aria-describedby="emailHelp" placeholder="Enter product size..."></div></form></div></div></div>';
		 
          // mjblock +='<div class="row justify-content-center"><a href=""><button type="submit" class="submit-request px-3  ">Submitrequest</button></a><div><a href=""><button class="back-btn ml-2" type="button" class="close" data-dismiss="modal" aria-label="Close">Go Back</button></a></div></div></div></div></div></div></div></div>';
		
		$('.showblock_1').append(mjblock);
		modaladd('1','1','1');
	  
		checkanother_block('1')
		
	});









		}  // else end of fetch call


		}
		});	

		});  // starting document ready ending
		
		
			

function formvalidation(val){
	
	var clickedid =	$(val).attr('id');
		// alert(clickedid)
	
    // $('.error').html('');
    // $('#submit-request-form input, select ').css('border', '1px solid #ccc');
    var prd_name=makeTrim($('#prd_name'+clickedid).val());
    var brand_name=makeTrim($('#brand_name'+clickedid).val());
    var prd_type=makeTrim($('#prd_type'+clickedid).val());
    var prd_price=makeTrim($('#prd_price'+clickedid).val());
    var prd_size=makeTrim($('#prd_size'+clickedid).val());
    // 
    
    var status=true;
    if(prd_name==''){
        $('#prd_name'+clickedid).css('border', '2px solid #cc0000');
        status=false;
    }else{
		$('#prd_name'+clickedid).css('border', '2px solid green');
        status=true;
	}
    if(brand_name==''){
        $('#brand_name'+clickedid).css('border', '2px solid #cc0000');
        status=false;
    }else{
		$('#brand_name'+clickedid).css('border', '2px solid green');
        status=true;
	}
    if(prd_price==''){
        $('#prd_price'+clickedid).css('border', '2px solid #cc0000');
        status=false;
    }else{
		$('#prd_price'+clickedid).css('border', '2px solid green');
        status=true;
	}
    if(prd_type==''){
        $('#prd_type'+clickedid).css('border', '2px solid #cc0000');
        status=false;
    }else{
		$('#prd_type'+clickedid).css('border', '2px solid green');
        status=true;
	}
    if(prd_size==''){
        $('#prd_size'+clickedid).css('border', '2px solid #cc0000');
        status=false;
    }else{
		$('#prd_size'+clickedid).css('border', '2px solid green');
        status=true;
	}
   
    // return status;
	if(status)
	{
		  
			$.ajax({
		type: "POST",
		headers: 
				{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		url: "/add-grid",
		data: new FormData($("#submitrequest_"+clickedid)[0]),
		cache: true,
		contentType: false,
		processData: false,
		async:false,
        processData: false,
		success: function(ajaxresponse){
			var data = JSON.parse(ajaxresponse);
		console.log(data)
		window.location.reload();
			
		
		}
	});	
	}
}
function makeTrim(x) {
    if (x) {
        return x.replace(/^\s+|\s+$/gm, '');
    } else {
        return x;
    }
}
		
		
			function mjtest1(val){
		// var clickedid=	$(val).attr('id');
		var clickedid=	$(val).attr('idattr');
		// alert(clickedid)
		// console.log(val)
		// console.log(typeof (FileReader))
        if (typeof (FileReader) != "undefined") {
			// alert("defined");
			$("#divImageMediaPreview"+clickedid).css('display','block');
			 $("#image_error"+clickedid).hide();
			 $("#savedimg"+clickedid).hide();
            var dvPreview = $("#divImageMediaPreview"+clickedid);
            dvPreview.html("");            
           
                var file = $(val)[0].files;
                var ext = $(val).val().split('.').pop().toLowerCase();
				console.log(ext)
                if ($.inArray(ext, ['gif','png','jpg','jpeg']) == -1){
					 $("#image_error"+clickedid).css('display','block');
                    $('#image_error'+clickedid).html('Invalid Image Format! Image Format Must Be JPG, JPEG, PNG or GIF.');
                    $(val).val('');
                    return false;
                }else{
                    var image_size = (val.files[0].size);
					// alert(image_size)
                    if(image_size>1000000){
						 $("#image_error"+clickedid).css('display','block');
                        $('#image_error'+clickedid).html('Maximum File Size Limit is 1MB');
                        $(val).val('');
                        return false;
                    }else{
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            var img = $("<img />");
                            img.attr("style", "width: 150px; height:100px; padding: 10px");
                            img.attr("src", e.target.result);
                            dvPreview.html(img);
                        }
                        $('#image_preview_remove'+clickedid).show();
                       reader.readAsDataURL(file[0]);
                    }
                     
                }
           
        }
    }
		
		
		
	function addgrid()
	{
		var count=$('#randomnum').val();
		// alert(count)
	// event.preventDefault();
	if(count<11){

	
	var html ='<div class="row mt-2 mjrowtrack" id="row_'+count+'"><div class="col-lg-11"><div class="grid-bg mx-4 px-4 py-2 mb-4"><div class="row"><div class="col-8"><h1>STYLEGRID</h1></div><div class="col-4 text-right "><img src="stylist/app-assets/images/icons/Empty-Trash.png" class="img-fluid deletegrid"  value="mybutton1" onclick="removegrid(this)" alt=""/></div></div><div class="row add-item">';
	
	 html +='<div class="col-lg-6 d-flex align-items-center"><div class="row">';
	 
	
	  html +='<div class="showblock_'+count+' d-flex flex-wrap"></div>';
	
	 
	
	
	 html +='</div></div>';
	 
	  html +='<div class="col-lg-2 px-0 text-lg-left text-center mjaddanother" id="addanother'+count+'"><button type="submit" class="px-3 form-border addblock" onclick="addblock('+count+')"  ><img src="stylist/app-assets/images/icons/plus.png" alt=""><br>Add another block</button></div>';
	 
	  html +='<div class="col-lg-6 px-lg-5"><div class="Neon Neon-theme-dragdropbox mt-5"><input name="files[]" id="filer_input2" multiple="multiple" type="file"><div class="Neon-input-dragDrop py-5 px-4 mx-lg-3"><div class="Neon-input-inner py-2"><div class="Neon-input-text"><h3>Add your feature image here...</h3></div><a class="Neon-input-choose-btn blue"><imgsrc="stylist/app-assets/images/icons/plus.png" alt=""></a></div></div></div></div></div></div></div><div class="col-lg-1"></div></div>';


	$('.appendrowhere').append(html);
	var number='<a href=""><div class="blue-bg mt-lg-2 mt-1 mx-lg-0 mx-2">'+count+'</div></a>';
	$('.numbering').append(number);
	createnextinnerblock(count)
	if(count==10){$('.plussign').hide();}
	count++;
	
	}else{
	$('.plussign').hide();	 
	}
	checknumberng();
	
	}
		
		function modaladd(modalappendcount,rowid,count,data=null){
		// alert(modalappendcount)
		// alert(rowid)
		// alert(count)
		// $('.appendrowhere').on('click',  '.mjrowtrack_inner', function(e,f){
		// var mj=$(this).attr('data-target');
		// var grid=$(this).attr('grid');
		// alert(grid)
		// const myArray = mj.split('#');
		// const myArray = val;
		console.log("modal data")
		console.log(data)
		if(data){
		var block_id = data.block_id;
		var prd_name = data.prd_name;
		var brand_name = data.brand_name;
		var prd_price = data.prd_price;
		var prd_type = data.prd_type;
		var prd_size = data.prd_size;
		var block_image = data.block_image;
		}else{
		var block_id ='';
		var prd_name ='';
		var brand_name ='';
		var prd_price ='';
		var prd_type ='';
		var prd_size ='';
		var block_image ='';
		}
		var blockimg=constants.base_url+'/stylist/grid_block/'+block_image;
		// var countmodallength=0;
		// $('.showmodal').find('div #'+myArray[1]).each(function()
		// {
		// countmodallength++;
		// });
		// if(countmodallength>0)
		// {
		// $('#'+myArray[1]).modal('show');	
		// }else{
	var	myArray ='row_'+rowid+'_gridmodal_'+count+'';
	var	grid_block ='row_'+data.grid_id+'_gridmodal_'+data.block_id+'';
		var modal='<div class="modal grid_modal"  id="'+myArray+'" class="mjmodal" tabindex="-1" role="dialog" aria-labelledby="acceptLabel" aria-hidden="true" style=""><div class="modal-dialog" role="document"><div class="modal-content pt-1"><div class="mr-2"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body py-2"><h1 class="text-center modal-submit-request">Submit Sourcing Request</h1><div id="browse-soursing" class="mt-2">';

				    modal +=' <form id="submitrequest_'+myArray+'" action="client-submit-request-complete.html" class=" ">';
                   modal +='<div class="row align-items-center" id="fulfill-request"><div class="col-lg-6" ><div class="Neon Neon-theme-dragdropbox mt-3"><div class="Neon-input-dragDrop py-5 px-4"><div class="Neon-input-inner py-4"><div class="Neon-input-text "><h3 class="mb-5 pb-5">Upload an image of the product here</h3></div><a class="Neon-input-choose-btn blue mjcheckatag"><img src="stylist/app-assets/images/icons/plus.png" class="mt-4" alt="" id="image_preview'+myArray+'"><input  class="mjcheckinput "  name="prdimg" idattr="'+myArray+'" id="prd_img'+myArray+'" onchange="mjtest1(this)" type="file" multiple="multiple" ><input type="hidden" name="previous_img" value="'+block_image+'"></a>';
				    modal +=' <div id="image_error'+myArray+'" class="error"></div><div id="commonclick'+myArray+'"><div id="divImageMediaPreview'+myArray+'"></div><a href="javascript:void(0)" style="display: none;" id="image_preview_remove'+myArray+'" newatr='+myArray+' onclick="image_preview_remove(this)">Remove</a><img src="'+blockimg+'" id="savedimg'+myArray+'" alt="" width="100%" height="50%" ></div>';
					
				      modal +='  </div></div></div></div>';
                      modal +='<div class="col-lg-6"><div class="p-3 lg-border-left ">';
					 
					  modal +='<div class="form-group">';
					  modal +='<label for="">Enter the name of the product here:</label>';
					  modal +='<input type="text" class="form-control submit-input"aria-describedby="emailHelp" name="prdname" id="prd_name'+myArray+'" placeholder="Enter product name..." value="'+prd_name+'" required><input type="hidden" name="grid_block" value="'+grid_block+'"></div>';
					  modal +='<div class="form-group">';
					  modal +='<label for="">Tell us the brand of the product:</label>';
					  modal +='<input type="text" class="form-control submit-input"aria-describedby="emailHelp" name="brand_name" id="brand_name'+myArray+'" placeholder="Enter brand name..." value="'+brand_name+'"></div>';
					  modal +='<div class="form-group">';
					  modal +='<label for="">What is the Price? </label>';
					  modal +='<input type="text" class="form-control submit-input"aria-describedby="emailHelp" name="prd_price" id="prd_price'+myArray+'" placeholder="Enter product Price..." value="'+prd_price+'"></div>';
					  modal +='<div class="form-group">';
					  modal +='<label for="">What is the product type? (Bag, Dress, Heels etc)</label>';
					  modal +='<input type="text" class="form-control submit-input"aria-describedby="emailHelp" name="prd_type" id="prd_type'+myArray+'" placeholder="Enter product type..." value="'+prd_type+'"></div>';
					  modal +='<div class="form-group">';
					  modal +='<label for="">Does the product have a size? Leave blank if none.</label>';
					  modal +='<input type="text" class="form-control submit-input"aria-describedby="emailHelp" name="prd_size" id="prd_size'+myArray+'" placeholder="Enter product size..." value="'+prd_size+'"></div>';
					  modal +='</div></div></div><div class="row justify-content-center"><button type="button" class="submit-request px-3  mjmodalsubmit" id="'+myArray+'" onclick="formvalidation(this)">Submit request</button><div><button class="back-btn ml-2" type="button" class="close" data-dismiss="modal" aria-label="Close">Go Back</button></div></div></form>';
					  modal +='</div></div></div></div></div></div>';
		
		// $('.modal').attr("id", myArray[1]);
		// $('#'+myArray[1]).modal('show');
		// $('.showmodal').append(modal);
		$('.showblock_'+modalappendcount).append(modal);
		 // $('#'+myArray[1]).modal('show');
		 
		 // mjtest1(myArray[1])
		
		// }
	// });
	// $('.mjmodalsubmit').on('click', function(){
		
		
	// });
	}
		
		function createnextinnerblock(rowid)
	{
		// alert("createnextinnerblock");
		// alert(rowid);
		
	var mjblock='<div class="mjrowtrack_inner col-6" grid="'+rowid+'" id="row_'+rowid+'_block_1" data-toggle="modal"  data-target="#row_'+rowid+'_gridmodal_1"><div class="Neon Neon-theme-dragdropbox "><div class="Neon-input-dragDrop "><div class="Neon-input-inner py-3"><div class="Neon-input-text"><h3>Add an item here</h3></div><a class="Neon-input-choose-btn blue"><imgsrc="stylist/app-assets/images/icons/plus.png" alt=""></a></div></div></div><img src="stylist/app-assets/images/icons/Empty-Trash.png" class="img-fluid deletegrid" value="'+rowid+'" onclick="removeblock(this)" alt="" style="position: absolute;top: 0;">';
		
		 // mjblock +='</div>';
		
		$('.showblock_'+rowid+'').append(mjblock);
		modaladd(rowid,rowid,'1');

		checkanother_block(rowid)	
	}


	function checkanother_block(rowid)
	{
	// alert("checkanother_block_"+rowid)
	var countstart=1;
	// $(".mjrowtrack_inner_"+rowid).each(function(){

	// countstart++;
	// });

	$(".showblock_"+rowid).each(function() {
	// $(this) = single ul element
	$(this).children('div').each(function(idx, el){
	countstart++;
	// alert(countstart)
	});
	});


	if(countstart>1){
	// alert('counterabove_'+countstart)
	$('#randomnum_inner').val(countstart);
	}
	if(countstart==1){
	$('#randomnum_inner').val(1);
	}
	if(countstart<7){$('#addanother'+rowid).css("display", "block");}

	}


function removegrid(value)
	{ 
	// console.log(value)
	$(value).closest('.mjrowtrack').remove();
	// $(value).closest('.showmodal').remove();
	// var row =$(value).attr("id");
	 // var row =$(value).closest('.mjrowtrack').attr("id");
	// alert(row)
	var newcounter=1;
	// const myArray = row.split('row_');
	// $(".grid_modal_"+myArray[1]).each(function(e,f){
		// (this).remove();
		// console.log(e)
		// console.log(f)
	// });
	$(".mjrowtrack").each(function(e,f){
		console.log(e)
		console.log(f)
    $(this).attr("id","row_"+newcounter);
	// $("#row_"+newcounter).load(location.href + " #row_"+newcounter);
	<!-- block seraialize-->
	$('#row_'+newcounter).closest('div').find('img').attr("value",newcounter)
	$('#row_'+newcounter).closest('div').find('.addblock').attr("onclick","addblock("+newcounter+")" )
	$('#row_'+newcounter).closest('div').find('.mjaddanother').attr("id","addanother"+newcounter)
	$('#row_'+newcounter).closest('div').find('.flex-wrap').attr("class","showblock_"+newcounter+ " d-flex flex-wrap" )
	
	$(".showblock_"+newcounter).each(function() {
	// $(this) = single ul element
	$(this).children('div .mjrowtrack_inner').each(function(idx, el){
		// alert(idx)
		idx++;
		// alert(idx)
	$(this).attr("id","row_"+newcounter+"_block_"+idx);
	$(this).attr("data-target","row_"+newcounter+"_gridmodal_"+idx);
	// alert(countstart)
	});
	$(this).children('div .grid_modal').each(function(idx, el){
		// alert(idx)
		idx++;
		// alert(idx)
	
	$(this).attr("id","row_"+newcounter+"_gridmodal_"+idx)
	// alert(countstart)
	});
	});
	
	
	<!-- block seraialize-->
	
	newcounter++;
	});
	
	checknumberng();

	}


function removeblock(value)
	{ 
	// console.log(value)
	// alert(value)
	$(value).closest('.mjrowtrack_inner').remove();
	// $(value).closest('.grid_modal').remove();
	var attribute=$(value).closest('.mjrowtrack_inner').attr('data-target');
	 const myArray = attribute.split('#');
	// alert(myArray[1])
	// $('#'+myArray[1]).remove();
	// $('#row_1_gridmodal_2').find('.grid_modal').remove();
	// $(value).next().find('.grid_modal').remove();
	var rowid=$(value).attr('value');
	
	
	$(".showblock_"+rowid).each(function() {
	// $(this) = single ul element
	$(this).children('div .mjrowtrack_inner').each(function(idx, el){
		// alert(idx)
		idx++;
		// alert(idx)
	$(this).attr("id","row_"+rowid+"_block_"+idx);
	$(this).attr("data-target","row_"+rowid+"_gridmodal_"+idx);
	
	});
	$(this).children('div .grid_modal').each(function(idx, el){
		// alert(idx)
		idx++;
		// alert(idx)
	
	$(this).attr("id","row_"+rowid+"_gridmodal_"+idx)
	// alert(countstart)
	});
	});
	checkanother_block(rowid)
	
	

	}
		function checknumberng()
	{
	
	var countstart=1;
	$('.numbering').html('');
	$(".mjrowtrack").each(function(){
	
	
	var number='<div class="blue-bg mt-lg-2 mt-1 mx-lg-0 mx-2">'+countstart+'</div>';
	$('.numbering').append(number);
	countstart++;
	});
	if(countstart>1){
	$('#randomnum').val(countstart);
	}
	if(countstart==1){
	$('#randomnum').val(1);
	}
	if(countstart<11){$('.plussign').show();}

	}

	function addblock(rowid){
		
		// alert(rowid)
	
		
			var count1=1;
		$(".showblock_"+rowid).each(function() {
		
		$(this).children('div .mjrowtrack_inner').each(function(idx, el){
		count1++;
		
		});
		});
		
		if(count1<7){
		var mjblock='<div class="mjrowtrack_inner col-6" grid="'+rowid+'" data-toggle="modal" id="row_'+rowid+'_block_'+count1+'"  data-target="#row_'+rowid+'_gridmodal_'+count1+'"><div class="Neon Neon-theme-dragdropbox "><div class="Neon-input-dragDrop "><div class="Neon-input-inner py-3"><div class="Neon-input-text"><h3>Add an item here</h3></div><a class="Neon-input-choose-btn blue"><imgsrc="stylist/app-assets/images/icons/plus.png" alt=""></a></div></div></div><img src="stylist/app-assets/images/icons/Empty-Trash.png" class="img-fluid deletegrid" value="'+rowid+'" onclick="removeblock(this)" alt="" style="position: absolute;top: 0;">';
		
		
		
		$('.showblock_'+rowid+'').append(mjblock);
		modaladd(rowid,rowid,count1);
	
		if(count1==6){
			
			console.log($('#addanother'+rowid))
			$('#addanother'+rowid).css("display", "none");
			}
	
	}else{
	$('#addanother'+rowid).css("display", "none");	 
	}
	checkanother_block(rowid)
	}
</script>
