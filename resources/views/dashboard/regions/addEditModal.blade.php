<div class="modal fade addEdit-new-modal" id="addEdit-new-modal" tabindex="-1" role="dialog" aria-labelledby="addEdit-new-modal"aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form  id="createUpdate" action="{{route('dashboard.'.Request::segment(2).'.createUpdate')}}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="">
                <div class="form-group">
                    <label for="name_ar" class="col-form-label">الاسم بالعربي :</label>
                    <input type="text" class="form-control" name="name_ar">
                </div>
                <div class="form-group">
                    <label for="name_en" class="col-form-label">الاسم بالانجليزية :</label>
                    <input type="text" class="form-control" name="name_en">
                </div>
                <div class="form-group">
                    <label for="currency" class="col-form-label">العملة  :</label>
                    <input type="text" class="form-control" name="currency">
                </div>
                <div class="form-group">
                    <label for="stateKey" class="col-form-label"> مفتاح الدولة :</label>
                    <input type="text" class="form-control" name="stateKey">
                </div>
                <div class="form-group">
                    <label for="deliveryPrice" class="col-form-label">سعر التوصيل  :</label>
                    <input type="text" class="form-control" name="deliveryPrice">
                </div>
                <div class="row mr-10" >
                    <div class="form-group col-md-12">
                        <button class="btn btn-primary " onClick="event.preventDefault();$(this).parents('.row').find('input:file').click();">اختر صورة <i class="fas fa-image"></i></button>
                    </div>
                    <div class="col-md-12">
                        <input type="file" id="img"  accept="image/*" hidden data-image="logo_image" >
                        <input type="hidden"  name="logo_image" hidden  >
                        <img id="logo_image" class="img-thumbnail" hidden style="border-radius: 50%;height: 50%;max-width: 50%;max-height: 200px;min-height: 200px;"/>
                        <hr/>
                    </div>
                </div>
                <div class="form-group" >
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck1" name ="check"checked>
                        <label class="custom-control-label" for="customCheck1" >دولة</label>
                    </div>
                </div>
                <div class="form-group regions_id_select d-none"  >
                    <label for="regions_id" class="col-form-label">اختر الدولة:</label>
                        <select  class="form-control" name="regions_id">
                            <option value="" selected disabled></option>
                            @foreach(\App\Models\regions::where('regions_id',null)->get() as $region)
                                <option value="{{$region->id}}">{{$region->name_ar}}</option>
                            @endforeach
                        </select>
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