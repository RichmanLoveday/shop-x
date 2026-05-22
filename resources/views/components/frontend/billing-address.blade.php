   @props(['address', 'class' => 'col-md-6 col-lg-4 col-xl-4', 'showEditDelete' => false])
   @push('styles')
       <style>
           .wsus__shipping_address_item .form-check-input {
               width: 18px;
               height: 18px;
               cursor: pointer;
               border: 2px solid #d1d5db;
               accent-color: var(--colorSecondary);
           }

           /* checked state */
           .wsus__shipping_address_item .form-check-input:checked {
               background-color: var(--colorSecondary);
               border-color: var(--colorSecondary);
           }

           /* focus */
           .wsus__shipping_address_item .form-check-input:focus {
               box-shadow: 0 0 0 0.2rem rgba(var(--colorSecondary-rgb, 59, 183, 126), 0.25);
               border-color: var(--colorSecondary);
           }
       </style>
   @endpush
   <div class="{{ $class }}">
       <div class="wsus__shipping_address_item address-card" data-id="{{ $address->id }}">
           <div class="form-check form-check-inline">
               <input class="form-check-input default-address" data-id="{{ $address->id }}" type="radio"
                   @checked($address->is_default) name="inlineRadioOptions" value="option1">
               <label class="form-check-label" for="inlineRadio1">{{ $address->address }},
                   {{ $address->city?->name }}, {{ $address->state?->name }},
                   {{ $address->country }}
               </label>
           </div>
           <div class="wsus__shipping_mail_address">
               <a href="javascript:void(0)">{{ $address->email }}</a>
               <a href="javascript:void(0)">{{ $address->phone }}</a>
           </div>

           @if ($showEditDelete)
               <ul class="btn_list">
                   <li>
                       <a href="{{ route('address.edit', $address->id) }}">
                           <i class="fa-solid fa-pen-to-square"></i>
                       </a>
                   </li>
                   <li>
                       <a class="delete-item text-decoration-none text-danger"
                           href="{{ route('address.destroy', [$address->id]) }}">
                           <i class="fa-solid fa-trash-can"></i>
                       </a>
                   </li>
               </ul>
           @endif
       </div>
   </div>
