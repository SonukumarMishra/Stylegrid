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
                size: A4 portrait;
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
               height: 595px;
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
                     </td>
                    
                  </tr>
               </table>
               <table class="w-100">
                  <tr>
                     <td>
                        <div class="mx-lg-4 mx-2 mt-3 mb-2 px-lg-4 px-2 py-2 main-grid-div" style="background: url('https://qammapi.softcube.co.in/images/0405c84f-f784-4e60-9d72-6e54a26b22d6/profile/PR_1662027763.jpeg')">
                           <h1 class="main-grid-title">STYLEGRID</h1>
                           <h4 class="main-grid-sub-title">{{ $style_grid_dtls->title }}</h4>
                        </div>
                     </td>
                    
                  </tr>

                 
               </table>

               @if (count($style_grid_dtls->grids))

                  @foreach ($style_grid_dtls->grids as $g_key => $grid)
            
                     <table class="w-100">
                        <tr>
                           <td>
                              <div class="row mt-2">
                                 <div class="col-lg-12">
                                    <div class="new-grid-bg mx-lg-4 mx-2 px-lg-3 mx-2 py-2">
                                       <div class="row">
                                          <div class="col-8">
                                                <h1>STYLEGRID {{ $g_key+1 }}</h1>
                                          </div>
                                       </div>
                                       <div class="row add-item d-flex align-items-center">
                                          <div class="col-lg-7">
                  
                                                <section class="stylegrid-cards">
                                                   
                                                   @if (count($grid->items))
            
                                                      @foreach ($grid->items as $i_key => $item)
            
                                                            <div class="grid-item-inner-input-block" data-stylegrid-dtls-id="{{ $item->stylegrid_dtls_id }}"  data-stylegrid-product-id="{{ $item->stylegrid_product_id }}">
            
                                                               <img class="stylegrid-product-img" src="{{asset($item->product_image)}}" alt=" " />
            
                                                            </div>
            
                                                      @endforeach
                                                   
                                                   @endif
                                                                           
                                                </section>
                  
                                          </div>
                                          <div class="col-lg-5 px-2">
                                                <img src={{asset($grid->feature_image)}} class="img-fluid w-100 height_400 img_preview" alt="">
                                          </div>
                                       </div>
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
     
   @endif
   </body>
</html>
