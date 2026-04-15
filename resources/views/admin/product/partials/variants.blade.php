 <div class="accordion-item">
     <div class="accordion-header">
         <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-1-default"
             aria-expanded="true">
             Red / M
             <div class="accordion-button-toggle">
                 <!-- Download SVG icon from http://tabler.io/icons/icon/chevron-down -->
                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="icon icon-1">
                     <path d="M6 9l6 6l6 -6"></path>
                 </svg>
             </div>
         </button>
     </div>
     <div id="collapse-1-default" class="accordion-collapse collapse" data-bs-parent="#accordion-default">
         <form action=""></form>
         <form action="" method="POST">
             @csrf
             <div class="accordion-body">
                 <div class="row">
                     <div class="col-md-6">
                         <label for="" class="form-label">Name</label>
                         <input type="text" class="form-control" name="attribute_name" value="" id="">
                         <input type="hidden" value="" name="attribute_id">
                     </div>
                 </div>

                 <div class="mt-2">
                     <button class="btn btn-sm btn-primary add-row-btn" type="button">Add Row</button>
                     <button class="btn btn-sm btn-success save-btn">Save</button>
                 </div>
             </div>
         </form>

     </div>
 </div>
