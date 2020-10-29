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
                <div class="form-group">
                        <label for="name_ar" class="col-form-label">الاسم بالعربي:</label>
                        <input type="text" class="form-control" name="name_ar">
                    </div>
                    <div class="form-group">
                        <label for="name_en" class="col-form-label">الاسم بالانجليزي  :</label>
                        <input type="text" class="form-control" name="name_en">
                    </div>
                    <div class="form-group" >
                        <label for="gender" class="col-form-label">اختر النوع:</label>
                        <select  class="form-control" name="gender">
                                <option value="male">رجالي</option>
                                <option value="female">حريمي</option>
                                <option value="all">الكل</option>
                        </select>
                    </div>
                    <div class="form-group" >
                        <label for="categories_id" class="col-form-label">اختر القسم:</label>
                        <select  class="form-control" name="categories_id">
                            @foreach(\App\Models\categories::allActiveOnly() as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
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