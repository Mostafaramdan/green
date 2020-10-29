<div class="modal fade addEdit-new-modal" id="addEdit-new-modal" tabindex="-1" role="dialog" aria-labelledby="addEdit-new-modal"aria-hidden="true">
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
                    <label for="name" class="col-form-label">المحتوي بالعربي:</label>
                    <textarea  class="form-control" name="content_ar"></textarea>
                </div>
                <div class="form-group">
                    <label for="name" class="col-form-label">المحتوي بالإنجليزي:</label>
                    <textarea  class="form-control" name="content_en"></textarea>
                </div>
                <div class="form-group" >
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck1" name ="checkType"checked>
                        <label class="custom-control-label" for="customCheck1" >جميع المستخدمين</label>
                    </div>
                </div>
                <div class="form-group d-none usersTypeSelect" >
                    <label for="users_type" class="col-form-label">اختر النوع:</label>
                    <select  class="form-control" name="users_type" >
                        <option value="users">المستخدمين </option>
                        <option value="visitors">الزوار </option>
                    </select>
                </div>
                </form>
                <div class="alert">
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