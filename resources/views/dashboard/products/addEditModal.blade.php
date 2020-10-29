<div class="modal fade addEdit-new-modal" id="addEdit-new-modal" tabindex="-1" role="dialog" aria-labelledby="addEdit-new-modal"aria-hidden="true">
    <div class="loading-container"  >
      <div class="spinner-border text-primary" role="status">
      </div>
    </div>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form  id="createUpdate" action="{{route('dashboard.'.Request::segment(2).'.createUpdate')}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="">
                    <div class="form-group" >
                        <label for="categories_id" class="col-form-label">اختر القسم:</label>
                        <select  class="form-control" name="categories_id">
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name_ar }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name_ar" class="col-form-label"> الاسم بالعربي:</label>
                        <input type="text" class="form-control" name="name_ar">
                    </div>
                    <div class="form-group">
                        <label for="name_en" class="col-form-label"> الاسم بالانجليزي:</label>
                        <input type="text" class="form-control" name="name_en">
                    </div>
                    <div class="form-group">
                        <label for="description_ar" class="col-form-label"> الوصف بالعربي:</label>
                        <input type="text" class="form-control" name="description_ar">
                    </div>
                    <div class="form-group">
                        <label for="description_en" class="col-form-label"> الوصف بالانجليزي:</label>
                        <input type="text" class="form-control" name="description_en">
                    </div>
                    <div class="form-group">
                        <label for="quantity" class="col-form-label">  الكمية:</label>
                        <input type="number" class="form-control" name="quantity">
                    </div>
                    <div class="form-group">
                        <label for="price_KWD" class="col-form-label"> السعر بالكويتي :</label>
                        <input type="number" class="form-control" name="price_KWD">
                    </div>
                    <div class="form-group">
                        <label for="price_EGP" class="col-form-label"> السعر بالمصري :</label>
                        <input type="number" class="form-control" name="price_EGP">
                    </div>
                    <div class="form-group">
                        <label for="price_SAR" class="col-form-label"> السعر بالسعودي :</label>
                        <input type="number" class="form-control" name="price_SAR">
                    </div>
                    <div class="form-group">
                        <label for="price_AED" class="col-form-label"> السعر بالاماراتي :</label>
                        <input type="number" class="form-control" name="price_AED">
                    </div>
                    <div class="form-group">
                        <label for="serial" class="col-form-label"> رقم المسلسل  :</label>
                        <input type="number" class="form-control" name="serial">
                    </div>
                        <div class="form-group" >
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck2" name ="isShipment"  value="true">
                                <label class="custom-control-label" for="customCheck2" >خدمة التوصيل  </label>
                            </div>
                        </div>
                    <div class="form-group" >
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck1" name ="offer"  value="1">
                            <label class="custom-control-label" for="customCheck1" >عرض</label>
                        </div>
                    </div>
                     <div class="offer_Info  d-none">
                         <div class="form-group ">
                            <label for="discountPercentage" class="col-form-label">ادخال نسبة الخصم  %:</label>
                            <input type="number" class="form-control" name="discountPercentage">
                        </div>
                        <div class="form-group ">
                            <label for="maximumDeduction" class="col-form-label"> ادخال اكبر عدد للخصم:</label>
                            <input type="number" class="form-control" name="maximumDeduction">
                        </div>
                        <div class="form-group ">
                            <label for="startAt" class="col-form-label">ادخال تاريخ البداية :  <input type="text"  name="startAt" readonly disabled></label>
                            <input type="datetime-local" class="form-control" name="startAt" >
                        </div>
                        <div class="form-group ">
                            <label for="endAt" class="col-form-label">ادخال تاريخ النهاية : <input type="text"  name="endAt" readonly disabled></label>
                            <input type="datetime-local" class="form-control " name="endAt" >
                            </div>
                    </div>
                    <div class="row mr-10" >
                        <div class="form-group col-md-12">
                            <button class="btn btn-primary " onClick="event.preventDefault();$(this).parents('.row').find('input:file').click();">اختر صورة <i class="fas fa-image"></i></button>
                        </div>
                        <div class="col-md-12">
                          <input type="file" id="img"  accept="image/*" hidden data-image="mainImage" >
                          <input type="hidden"  name="mainImage" hidden  >
                          <img id="mainImage" class="img-thumbnail"  style="border-radius: 50%;height: 50%;max-width: 50%;max-height: 200px;min-height: 200px;"/>
                          <hr/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="image">اختر صور المنتج </label>
                            <input type="file" id="image" name="image[]" accept="image/*" multiple max="15">
                        </div>
                    </div>
                    <div class="form-group" >
                        <div class="progress " >
                            <div class="progress-bar"  role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">0%</div>
                        </div> 
                    </div>
                </form>
                <div class="alert " >
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button"  class="btn btn-success submit" id="submit">save</button>
            </div>

        </div>
    </div>
</div>
</div>