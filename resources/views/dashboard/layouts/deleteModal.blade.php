<!-- Modal -->
<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <input type="hidden" value="" id="id">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-trash fa-1x text-danger"></i></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       هل أنت متأكد من مسح هذا العنصر  ؟
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger " onClick="confirmDelete()">Delete</button>
      </div>
    </div>
  </div>
</div>
@push('script')
    <script type="text/javascript">     

        function deleteRecord ($id)
        {
            $('#delete-modal').find('#id').val($id); 
        }

        function confirmDelete()
        {
          var id = $('#delete-modal').find('#id').val(); 
          $.ajax({
            type: 'GET',
            url:"/dashboard/{{Request::segment(2)}}/delete/"+id,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend:function(){
                $("#delete-modal .btn-danger").prop('disabled', true);
            },
            success: function(data){
                if(data.status == 200 ){

                    $("#delete-modal .btn-danger").prop('disabled', false);
                    $(".record-"+id).remove();
                    $("#delete-modal").modal('toggle');
                }
            },error:function(data){
                $("#delete-modal .btn-danger").prop('disabled', false);
                console.log(data.responseText);
                alert(404);
            }
          });    
        }
        
        function showMore($id ,$colName,$modelName='@php echo \Request::segment(2);@endphp'){
            
                    $modelName= $modelName=='call_us'? 'contacts':$modelName;
                    $.get( "/Get/"+$modelName+"/"+$id,function( record ) {
                        
                        // $("#"+$colName+$id).
                        console.log("#"+$colName+$id);
                        $("#"+$colName+$id).html(record[$colName]);
                            // $("#"+$colName+$id).parent("td").$(".fa-plus").remove();
                            $("#"+$colName+$id).parent("td").find('.fa-plus').remove();
                        
                        
                        
                    });
        }


    </script>
@endpush