@extends('common.common')

@section('title')
    添加照片
@stop

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('dropzone/dropzone.css')}}">
<style type="text/css">

</style>
@stop

@section('content')
<div class="tpl-content-page-title">
    添加照片
</div>
<ol class="am-breadcrumb">
    <li><a href="{{ url('/admin/index') }}" class="am-icon-home">首页</a></li>
    <li><a href="{{ url('/admin/photo_manage/photo_album') }}">相册管理</a></li>
    <li class="am-active">
        添加照片
    </li>
</ol>
<div class="tpl-portlet-components" >
        <form class="dropzone" action="{{ url('/admin/photo_manage/picture') }}" method="post" style="border:4px dashed lightblue;min-height:300px" enctype="multipart/form-data" files="true">
             <div class="fallback">
                <input name="file" type="file" multiple />
                <input type="hidden" name="photo_album_id" value="{{ Request::get('photo_album_id')}}">
              </div>
            <div class="dz-message" style="line-height:300px" "am-icon-cloud-uploads">
                将文件拖至此处或点击上传.<br>
            </div>
        </form>
 </div>
@stop


@section('javascript')
<script type="text/javascript" src="{{ asset('dropzone/dropzone.js')}}"></script>
<script>
Dropzone.autoDiscover = false;
var photo_album_id = "{{ Request::get('photo_album') }}";
$(".dropzone").dropzone({ 
        url: "{{ url('/admin/photo_manage/picture') }}",
        addRemoveLinks: true,
        dictRemoveLinks: "x",
        dictCancelUpload: "x",
        dictRemoveFile: 'Remove',
        dictFileTooBig: 'Image is bigger than 8MB',
        maxFiles: 100,
        maxFilesize: 8,
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        init: function() {
            this.on("success", function(file,response) {
                $.ajax({
                    type: 'post',
                    url: "{{ url('/admin/photo_manage/picture') }}",
                    data: {id: file.name,photo_album_id:photo_album_id},
                    dataType: 'json',
                    success: function(data){
                        console.log(data);

                    }
                });
            });
            this.on("removedfile", function(file) {
                 $.ajax({
                    type: 'delete',
                    url: "{{ url('/admin/photo_manage/picture') }}"+'/'+file.name,
                    data: {id: file.name},
                    dataType: 'html',
                    success: function(data){
                        console.log(1);

                    }
                });
            });
        },
        error: function(file, response) {
            if($.type(response) === "string")
                var message = response; //dropzone sends it's own error messages in string
            else
                var message = response.message;
            file.previewElement.classList.add("dz-error");
            _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                node = _ref[_i];
                _results.push(node.textContent = message);
            }
            return _results;
        },
      
});
</script>
@stop
