
</div>

<script src="{{asset('dashboard/jquery.js')}}"></script>
<script type="text/javascript" src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script src="{{asset('dashboard/bootstrap.min.js')}}"></script>
<script src="{{asset('dashboard/popper.min.js')}}"></script>
<script src="{{asset('dashboard/vedors/tagsinput.js')}}"></script>
<script src="{{asset('dashboard/imageuploadify.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $(".loading-container").toggleClass("d-none d-flix");
        $('input[name="image[]"]').imageuploadify();
        $('#submit').on('click', function(e) {
            e.preventDefault();
            let form = $("#createUpdate");
            let url  = form.attr('action');
            let data = new FormData(form[0]);
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            percentComplete = parseInt(percentComplete * 100);
                            $('.progress-bar').text(percentComplete + '%');
                            $('.progress-bar').css('width', percentComplete + '%');
                        }
                    }, false);
                      return xhr;
                },beforeSend: function(){
                        $(".addEdit-new-modal .submit").attr("disabled",true).append(` <i class="fas fa-cog fa-spin"></i>`);
                },
                success: function(response) {
                    $(".addEdit-new-modal .submit").attr("disabled",false).find("i").remove();
                    if(response.status!= 200 ){
                        $(".modal .alert").attr("hidden",false);
                        $(".alert").html(`
                            <div class="alert alert-danger alert-dismissible fade show" role="alert"  >
                                <p >${response.message}</p>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>  
                            </div>
                        `);

                    }else {
                        $(".toast .toast-body").html(`
                            <i  class="fas fa-check-circle fa-2x"></i> 
                            <span style="margin-right:100px;font-size:20px;font-weight:bold">
                                ${response.message} 
                            </span>
                        `);
                        $(".toast").toast("show");
                        setTimeout(function(){  $(".toast .toast-body").html(""); },  $(".toast ").data("delay"));


                        $(".modal .alert").attr("hidden",true).find("p").html("");
                        $('.progress-bar').text(0 + '%');
                        $('.progress-bar').css('width', 0 + '%');
                        getRecords($(".pagination .active").find("a").attr("href"));
                        form[0].reset();
                        $('#openImage').attr('src', "");
                        $("#addEdit-new-modal").modal("toggle")
                    }
                   
                },
                error: function(response) {
                    $(".addEdit-new-modal .submit").attr("disabled",false);
                    $('#custom-message').show();
                    $('#custom-message ul').empty();
                    $('#custom-message').addClass('custom-message-error');
                    console.log(data.responseText);
                    $('#progressBar').text('0%');
                    $('#progressBar').css('width', '0%');
                }
            });
        });
        $(document).on("click", '.page-link', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var currentPage=$(this).attr("href");
            if(currentPage!= "#"){

                let formData = new FormData($('#getOptions')[0]);
                formData.append('currentPage',currentPage);
                formData.append('_token', $('input[name=_token]').val());
                $.ajax({
                    url: "{{route('dashboard.'.Request::segment(2).'.indexPageing')}}",
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $(".loading-container").toggleClass("d-none d-flix");
                    },
                    success: function(response) {
                        $(".loading-container").toggleClass("d-none d-flix");
                        $('.tableInfo').html(response.tableInfo);
                        $('.paging').html(response.paging);
                    },
                    error: function(response) {
                        $(".loading-container").toggleClass("d-none d-flix");
                        alert('error');
                    }
                });
            }

        });
        var typingTimer;                //timer identifier
        var doneTypingInterval = 1000;  //time in ms, 1 second for example
        var $input = $('input[name="search"]');

        //on keyup, start the countdown
        $input.on('keyup', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });

        //on keydown, clear the countdown 
        $input.on('keydown', function () {
            clearTimeout(typingTimer);
        });

        $input.on('search', function (e) {
            e.preventDefault();
            doneTyping();
        });

        //user is "finished typing," do something
        function doneTyping () {
            getRecords(1);
        }

        $( "select[name='sortBy'] ,select[name='sortType'] ,select[name='filter']").on("change",function(){
            getRecords(1);
        });

        $(document).on("click",'.slider-check-box input',function(e){
            let type= $(this).data('type');
            $.ajax({
                url: "/dashboard/{{Request::segment(2)}}/check/"+type+"/"+$(this).parents('tr').data("id"),
                type: 'GET',
                cache: false,
                contentType: false,
                processData: false,
                error: function(response) {
                    alert('error');
                }
            });
        });

        function permissions() {
            if("{{Auth::guard('dashboard')->user()->isSuperAdmin}}" != "1"){
                var permissionsAuth = JSON.parse("{{Auth::guard('dashboard')->user()->permissions}}".replace(/&quot;/g, '\"'));
                for( var k in permissionsAuth){
                    if(permissionsAuth[k]['view']==0){
                        $("aside ."+k).addClass('d-none');
                    }
                    if( typeof(permissionsAuth["{{Request::segment(2)}}"]) !== 'undefined' && permissionsAuth["{{Request::segment(2)}}"]['add']==0){
                        $(".add").addClass('d-none');
                    }                    
                    if(typeof(permissionsAuth["{{Request::segment(2)}}"]) !== 'undefined' &&  permissionsAuth["{{Request::segment(2)}}"]['edit']==0){
                        $(" .edit").addClass('d-none');
                        $(" .slider-check-box input[type='checkbox']").attr('disabled',true);
                    }
                    if( typeof(permissionsAuth["{{Request::segment(2)}}"]) !== 'undefined' &&  permissionsAuth["{{Request::segment(2)}}"]['delete']==0){
                        $('[data-target="#delete-modal"]').addClass('d-none');
                    }   
                }
            }
        }
        permissions() ;

         $(":file").change(function() {
            let input= this; 
            let INPUT= $(this); 
            if (this.files && this.files[0] && this.files[0].name.match(/.(jpg|JPG|jpeg|JPEG|png|PNG|gif)$/) ) {
                if(this.files[0].size>1048576) {
                    alert('حجم الصورة اكبر من 1 ميجا ');
                    $(':file').val("");
                }else{
                    if (this.files && input.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function (e) {
                            $('#'+INPUT.data('image')).attr('src', e.target.result).attr("hidden",false);
                            $("input[name='"+INPUT.data('image')+"']").val( reader.result.split(",")[1]);
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }
            }
            else {
                alert('يجب ادخال صورة حقيقية');
                $(':file').val("");
            }
        });

    });

    $("body").on("click",".edit",function(){
        $(".modal .alert").attr("hidden",true).find("p").html("");
    });

    function getRecords(page){
        let formData = new FormData($('#getOptions')[0]);
            formData.append('currentPage',page);
            formData.append('_token', $('input[name=_token]').val());

            $.ajax({
                url: "{{route('dashboard.'.Request::segment(2).'.indexPageing')}}",
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".loading-container").toggleClass("d-none d-flix");
                },
                success: function(response) {
                    $(".loading-container").toggleClass("d-none d-flix");
                    $('.tableInfo').html(response.tableInfo);
                    $('.paging').html(response.paging);
                },
                error: function(response) {
                    $(".loading-container").toggleClass("d-none d-flix");
                    alert('error');
                }
            });

    }
    $("input:file").change(function(){
        let input= this; 
        let INPUT= $(this); 
        if (this.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                $('#'+INPUT.data('image')).attr('src', e.target.result).attr("hidden",false);
            }
            reader.readAsDataURL(input.files[0]);
        }
    });

    $(".add").on("click",function(){
        let form = $("#createUpdate");
        form[0].reset();
        $('.addEdit-new-modal img').attr('src', null).attr("hidden",true);
        $(".addEdit-new-modal .modal-title").html("إضافة جديد");
        $(".addEdit-new-modal input[name='id']").val(null);
    });
    function deleteImagefromDragDrop(model,id,element){
        $.ajax({
        url: model+"/delete/"+id,
        type: 'GET',
        processData: false,
        contentType: false,
        beforeSend: function(){
            element.html(`
            <div class="spinner-grow text-primary"></div>
            `);
        },
        success: function() {
            element.remove();
        }
        });
    }
  </script>
@stack('script')
</body>
</html>