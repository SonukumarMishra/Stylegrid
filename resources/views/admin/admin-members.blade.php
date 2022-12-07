@extends('admin.layouts.default')
@section('content')
<div class="app-content content bg-white">
    <div class="content-wrapper">

        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Revenue, Hit Rate & Deals -->
            <div class=" mt-lg-3 ">
                <div class="">
                    <h1>Member Overview</h1>
                    <h3>Browse all StyleGrid members.</h3>
                    <!-- <a href=""><button class="grid-btn">Create Grid</button></a> -->
                </div>
                <div class="row mt-3">
                    <div class="col-lg-6">
                        <div class="search-container-member">
                            <form action="/action_page.php">
                                <input type="text" placeholder="Search by name..." name="search" id="search-box"
                                    class="px-2 search-top">
                                <button type="submit"><img src="<?php echo asset('admin-section/app-assets/images/icons/Search-right.png');?>"
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
                    <table class="table  w-100 table-responsive" id="member_list_table">
                        <thead>
                            <tr>
                                <th scope="col" class="text-left pl-4">MEMBER NAME</th>
                                <th scope="col">GENDER</th>
                                <th scope="col">LOCATION</th>
                                <th scope="col">EMAIL</th>
                                <th scope="col">PHONE</th>
                                <th scope="col">DATE JOINED</th>
                                <th scope="col">SPEND</th>
                                <th scope="col">STATUS</th>
                                <th scope="col"></th>
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
    $(function(){
        var member_list_table_html='';
            member_list_table_html = $('#member_list_table').DataTable({
            "bLengthChange": false,
             "processing": true,
             "searching": false,
             "pageLength":20,
             "serverSide": true,
             "sortable": true,
             "lengthMenu": [[10,20, 30, 50,100], [10,20, 30, 50,100]],
             "language": {
                "emptyTable": "Data Not Found"
             },
            "oLanguage": {
                "sProcessing": "<img src='{{ asset('admin-section/assets/images/ajax-loader.gif')}}' style='width:100px;height:100px;'>"
            },
             "order": [
                [2, "desc"]
             ],
             "ajax":{
                url :"/admin-member-list-ajax", 
                type: "post", 
                data: function (d) {    
                    d._token = "{{ csrf_token() }}";
                    //d.search = $( "input[type*='search']" ).val();
                    d.search = $('#search-box').val();
                 } 
             } ,
             "columns": [ 
                {data: 'full_name'},
                {data: 'gender',},
                {data: 'country_name'},
                {data: 'email'},
                {data: 'phone'},
                {data: 'added_date'},
                {data: 'spend'},
                {data: 'subscription'},
                {data: 'id',"orderable":false},
             ], 
             "columnDefs": [
               
               {
                "render": function ( data, type, row ) {
                   return data;
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
               "targets": 2 
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
                   return ' £'+data;
                },
               "targets": 6
              },
              {
                "render": function ( data, type, row ) {
                    if(row['membership_cancelled']){
                        return "<span class='red-color'>Cancelled</span>";
                    }else{
                        if(row['subscription']=='Trial'){
                            return "<span class='orange-color'>"+row['subscription']+"</span>";
                        }
                        else if(row['subscription']=='Gold Tier'){
                            return "<span class='gold-color'>"+row['subscription']+"</span>";
                        }
                        else{
                            return data;
                        }
                        
                    }
                },
               "targets": 7
              },
              {
                "render": function ( data, type, row ) {
                    var html ='';
                    html +='<a href="<?php echo url('admin-member-details');?>/'+row['slug']+'"><button class="">View Profile</button></a>';
                   return html;
                },
               "targets": 8
              },
              
          ],
          //"dom": "<<'dt-toolbar'<'col-xs-12 col-sm-6'><'col-sm-6 col-xs-12'l>>"+
          //"t"+"<'dt-toolbar-footer row'<'col-md-5'i><'col-md-7'p>>r","autoWidth" : true,
          "footerCallback": function ( row, data, start, end, display ) {
          }
        });
        $('#search-box').keyup(function(){
            member_list_table_html.search(this.value).draw();
            })
    })
</script>
 @stop




