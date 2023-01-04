<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <meta name="x-apple-disable-message-reformatting" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        <title></title>
        @include('common.pdf_common_styles')
        <style>

            body {
               margin: 0;
               font-family: "Silk Serif", -apple-system, BlinkMacSystemFont, "Genos", 'Roboto', "Genos-Light", 'Silk Serif Medium', 'Avenir';
               font-size: 1rem;
               font-weight: 400;
               line-height: 1.45;
               color: #6b6f80;
               text-align: left;
               background-color: #F9FAFD;
            }

            @page { 
                size: landscape;
                margin: 0px;
            }
            table,
            td,
            div,
            h1,
            p {
                font-family: Arial, sans-serif;
                font-size: 14px;
            }
            th {
                border: 0;
            }

            .stylegrid-cards {
               display: grid;
               grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
               grid-gap: 10px;
            }

            .stylegrid-product-img {
               width:250px; 
               margin: 10px; 
               height:200px;
               object-fit: cover;
            }
            .img_preview {
               width: 100%;
               height: 100%;
               object-fit: cover;
            }
            .height_400 {
               height: 400px !important;
            }

            @media print {
             
                body {
                    font-size: 10px !important;
                }
    
                p {
                    font-size: 10px !important;
                } 
            }

            .height_500{
               height: 500px !important;
            }

            .main-grid-title{
               font-family: 'Silk Serif Medium';
               font-style: normal;
               font-weight: 400;
               font-size: 36px;
               line-height: 54px;
               color: #000000;
               margin-top: 57px;
            }

            .main-grid-sub-title{
               margin-bottom: 0.5rem;
               font-family: "Comfortaa", cursive, "Times New Roman", Times, serif;
               font-weight: 400;
               line-height: 1.2;
               color: white;
            }

            .main-grid-div{
               background-size: cover !important;
               background-repeat: no-repeat !important;
               height: 700px;
            }

           
        </style>
    </head>
    <body style="margin: 0; padding: 0;">
        
      <table class="w-100">
         <tbody>
         <tr>
             <td align="center" style="padding: 0;">
               <table class="w-100">
                  <tr>
                     <td>
                        <div class="main-grid-div m-1" style="background: url('https://cdn.pixabay.com/photo/2016/10/26/19/00/domain-names-1772243_960_720.jpg')">
                           <h1 class="main-grid-title">STYLEGRID</h1>
                           <h4 class="main-grid-sub-title">{{ $style_grid_dtls->title }}</h4>
                        </div>
                     </td>
                    
                  </tr>

                 
               </table>

               @if (count($style_grid_dtls->grids))

                  @foreach ($style_grid_dtls->grids as $g_key => $grid)
            
                     @php
                        $TotalNoOfRecords = count($grid->items);
                        $Count = 0;
                        
                     @endphp
                     
                     <table class="w-100">
                        <tr>
                           <td>
                              <div class="mx-lg-4 mx-2 mb-2 px-lg-4 py-2" style="page-break-before:always;">
                                 <div class="col-12">
                                    <div class="row">
                                       <div class="col-12">
                                             <h1>STYLEGRID {{ $g_key+1 }}</h1>
                                       </div>
                                    </div>
                                    <div class="row add-item d-flex align-items-center">

                                       <table class="w-100">
                                          <tr>
                                             <td style="width: 50%;">
                                                <div class="col-12">

                                                   <div class="row imgs-container" style="">
                                                         @foreach ($grid->items as $item)
                                                            @if ($Count % 6 == 0 && $Count != $TotalNoOfRecords)
                                                               {{-- <p style='page-break-after:always'></p> --}}
                                                               {{-- <div style="height: 100px;">
                                                
                                                               </div> --}}
                                                            @endif
                                                
                                                            {{-- For local --}}
                                                            {{-- <img src="https://cdn.pixabay.com/photo/2016/10/26/19/00/domain-names-1772243_960_720.jpg" class="stylegrid-product-img"> --}}
                                                            
                                                            {{-- For live --}}
                                                            <img class="stylegrid-product-img" src="{{asset($item->product_image)}}" alt=" " />

                                                            @php
                                                               $Count++;
                                                            @endphp
                                                         @endforeach
                                                   </div>
                                             </td>
                                             <td  style="width: 50%;">                                                
                                                <div class="col-12">
                                                   <div class="row imgs-container" style="margin-right: 10px;">

                                                      {{-- For local --}}
                                                      {{-- <img src="https://cdn.pixabay.com/photo/2016/10/26/19/00/domain-names-1772243_960_720.jpg" class="img-fluid w-100 height_400 img_preview p-1"> --}}
                                                      
                                                      {{-- For live --}}         
                                                      <img src="{{asset($grid->feature_image)}}" class="img-fluid w-100 height_400 img_preview p-1">
                                             
                                                   </div>
                                                </div> 
                                             </td>
                                          </tr>
                                       </table>                  
                                       
                                    </div>
                                 </div>
                             </div>
                           </td>
                        
                        </tr>
                     </table>
   
            
                  @endforeach
            
               @endif
             </td>
         </tr>
         </tbody>
      </table>
     
   </body>
</html>
