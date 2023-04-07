 <div class="row">
     <div class="col-md-6">
         <div class="mb-3">
             <label for="name1">Tên thuộc tính</label>
             <input type="text" name="name1" value="{{ old('name1') }}" id="name1" class="form-control"
                 placeholder="Nhập tên ">
             @if ($errors->has('name1'))
                 <div class="text-danger">
                     {{ $errors->first('name1') }}
                 </div>
             @endif

         </div>
         <div class="mb-3">
             <label for="metakey1">Mô tả</label>
             <textarea name="metakey1" id="metakey1" class="form-control" placeholder="Chi tiết sản phẩm">{{ old('metakey1') }}</textarea>
             @if ($errors->has('metakey1'))
                 <div class="text-danger">
                     {{ $errors->first('metakey1') }}
                 </div>
             @endif
         </div>
     </div>
     <div class="col-md-6">
         <div class="mb-3">
             <label for="name2">Giá trị</label>
             <input type="text" name="name2" value="{{ old('name2') }}" id="name2" class="form-control"
                 placeholder="Nhập tên ">
             @if ($errors->has('name2'))
                 <div class="text-danger">
                     {{ $errors->first('name2') }}
                 </div>
             @endif
         </div>
         <div class="mb-3">
             <label for="metakey1">Thứ tự</label>
             <textarea name="metakey1" id="metake1" class="form-control" placeholder="Chi tiết sản phẩm">{{ old('metakey1') }}</textarea>
             @if ($errors->has('metakey1'))
                 <div class="text-danger">
                     {{ $errors->first('metakey1') }}
                 </div>
             @endif
         </div>
     </div>
 </div>
