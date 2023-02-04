@extends('admin.layouts.default')
@section('content')
<div class="app-content content bg-white">
    <div class="content-wrapper">

        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Revenue, Hit Rate & Deals -->
            <div class=" mt-lg-3 ">
                <div class="message" id="message_box"></div>
                <div class="">
                    <h1>Review Stylist Applications</h1>
                    <h3>Approve or deny current applications to join our stylist network.</h3>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-6">
                        <div class="search-container-member">
                            <form action="/action_page.php">
                                <input type="text" placeholder="Search by name..." name="search" id="search-box"
                                    class="px-2 search-top">
                                <button type="submit"><img src="app-assets/images/icons/Search-right.png"
                                        alt=""></button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6 mt-lg-0 mt-2">
                        <div class="row justify-content-lg-end justify-content-center mr-lg-5">
                           <div class="dropdown mx-2">
                                    <button class="sort-by dropdown-toggle px-2 " type="button"
                                        data-toggle="dropdown" aria-expanded="false">
                                        Sort By
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#">Name A-Z</a>
                                        <a class="dropdown-item" href="#">Gender</a>
                                        <a class="dropdown-item" href="#">Status</a>
                                        <a class="dropdown-item" href="#">Date</a>
                                        <a class="dropdown-item" href="#">Spend</a>
                                    </div>
                                </div>
                            <button class="filter-by px-2">Filter By</button>
                        </div>
                    </div>
                </div>
                <div class="text-center add-table-border mt-3">
                    <table class="table  w-100 table-responsive" id="stylist_list_table">
                        <thead>
                            <tr>
                                <th scope="col" ></th>
                                <th scope="col" class="text-left pl-4">FULL NAME</th>
                                <th scope="col">LOCATION</th>
                                <th scope="col">APPLIED TO COVER</th>
                                <th scope="col">EMAIL</th>
                                <th scope="col">PHONE</th>
                                <th scope="col">DATE APPLIED</th>
                                <th scope="col">STATUS</th>
                                <th scope="col">APPLICATION</th>
                                <th scope="col">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>                            
                        </tbody>
                    </table>
                </div>
                 
            </div>
        </div>
    </div>
</div>
@include('admin.includes.footer')
<script>
    var stylist_list_table_html='';
    $(function(){
        $('#search-box').keyup(function(){
            stylist_list_table_html.search(this.value).draw();
            })
            stylist_list_table_html = $('#stylist_list_table').DataTable({
             "processing": true,
             "bLengthChange": false,
             "pageLength":20,
             "serverSide": true,
             "searching": false,
             "sortable": true,
             "lengthMenu": [[10,20, 30, 50,100], [10,20, 30, 50,100]],
             "language": {
                "emptyTable": "Data Not Found"
             },
            "oLanguage": {
                "sProcessing": "<img src='{{ asset('admin-section/assets/images/ajax-loader.gif')}}' style='width:100px;height:100px;'>"
            },
             "order": [
                [6, "desc"]
             ],
             "ajax":{
                url :"/admin-review-stylist-ajax", 
                type: "post", 
                data: function (d) {    
                    d._token = "{{ csrf_token() }}";
                    d.search = $('#search-box').val();
                 } 
             } ,
             "columns": [ 
                {data: 'id',"orderable":false},
                {data: 'full_name'},
                {data: 'country_name',},
                {data: 'applied_to_cover'},
                {data: 'email'},
                {data: 'phone'},
                {data: 'applied_date'},
                {data: 'status'},
                {data: 'id',"orderable":false},
                {data: 'id',"orderable":false},
             ], 
             "columnDefs": [
               
               {
                "render": function ( data, type, row ) {
                    if(row['status']==2){
                        return '<span style="color:red">●</span>';
                    }else{
                        return '<span style="color:green">●</span>'; 
                    }
                },
               "targets":0 
              },
              {
                "render": function ( data, type, row ) {
                   return data;
                },
               "targets":1 
              },
              {
                "render": function ( data, type, row ) {
                   return data;
                },
               "targets":2 
              },
              {
                "render": function ( data, type, row ) {
                   return data;
                },
               "targets": 3 
              },
              {
                "render": function ( data, type, row ) {
                   return data;
                },
               "targets": 4 
              },
              {
                "render": function ( data, type, row ) {
                   return data;
                },
               "targets": 5 
              },
              {
                "render": function ( data, type, row ) {
                   return data;
                },
               "targets": 6
              },
              {
                "render": function ( data, type, row ) {
                   return viewStylistStatus(data);
                },
               "targets": 7
              },
              {
                "render": function ( data, type, row ) {
                    var html ='';
                    html +='<a href="<?php echo url('admin-review-stylist-details');?>/'+row['slug']+'" target="_blank"><button class="">View Application</button></a>';
                   return html;
                },
               "targets": 8
              },
              {
                "render": function ( data, type, row ) {
                    if(!row['status']){
                        var html ='';
                        html +='<a href="javascript:void(0)"><button class="btn btn-success update-status" onClick="updateStylistStatus('+row['id']+',1)" data-id="'+row['id']+'">Approve</button></a> ';
                        html +='<a href="javascript:void(0)" ><button class="btn btn-danger update-status" data-id="'+row['id']+'" onClick="updateStylistStatus('+row['id']+',2)" >Decline</button></a>';
                        return html;
                    }else{
                        return "COMPLETE";
                    }
                },
               "targets": 9
              },
              
          ],
          //"dom": "<<'dt-toolbar'<'col-xs-12 col-sm-6'><'col-sm-6 col-xs-12'l>>"+
          //"t"+"<'dt-toolbar-footer row'<'col-md-5'i><'col-md-7'p>>r","autoWidth" : true,
          "footerCallback": function ( row, data, start, end, display ) {
          }
        });
         
    })
    function updateStylistStatus(id,status){
        if(id>0){
            $.ajax({
                url : '/admin-update-stylist-status',
                method : "POST",
                async: false,
                data : {
                    'stylist_id':id,
                    'status':status,
                    '_token': constants.csrf_token
                },
                success : function (ajaxresponse){
                    response = JSON.parse(ajaxresponse);
                    if (response['status']) {
                        $('#message_box').html('<div class="alert alert-success">'+response['message']+'</div>');
                        setTimeout(function(){
                            stylist_list_table_html.ajax.reload();
                        }, 500);
                    }else{
                        $('#message_box').html('<div class="alert alert-danger">'+response['message']+'</div>');
                    }
                }
            })
        }
    }
</script>
 @stop




