               <div class="col-sm-2">
                   @foreach ($list_menu as $row_menu)
                       <x-footer-item :menuitem="$row_menu" />
                   @endforeach
               </div>
