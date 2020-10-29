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
                    <div class="row mr-10" >
                        <div class="form-group col-md-12">
                            <button class="btn btn-primary " onClick="event.preventDefault();$(this).parents('.row').find('input:file').click();">اختر صورة <i class="fas fa-image"></i></button>
                        </div>
                        <div class="col-md-12">
                          <input type="file" id="img"  accept="image/*" hidden data-image="image" >
                          <input type="hidden"  name="image" hidden  >
                          <img id="image" class="img-thumbnail" hidden style="border-radius: 50%;height: 50%;max-width: 50%;max-height: 200px;min-height: 200px;"/>
                          <hr/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="url" class="col-form-label">الرابط الالكتروني :</label>
                        <input type="text" class="form-control" name="url">
                    </div>
                    <div class="form-group ">
                        <label for="startAt" class="col-form-label">ادخال تاريخ البداية :  <input type="text"  name="startAt" readonly disabled></label>
                        <input type="datetime-local" class="form-control" name="startAt" >
                    </div>
                    <div class="form-group ">
                        <label for="endAt" class="col-form-label">ادخال تاريخ النهاية : <input type="text"  name="endAt" readonly disabled></label>
                        <input type="datetime-local" class="form-control " name="endAt" >
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
                <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                <button type="button"  class="btn btn-success submit" id="submit">حفظ</button>
            </div>

        </div>
    </div>
</div>
</div>