<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Image Manager</title>
    </head>
    <body>
        <div class='container'>
            <h3>Image Manager</h3>
            <hr>
            <div class='row'>
                <div class='col-lg-3'>
                    <h4>Upload</h4>
                    <div id='container-upload'>
                        <button id="pickfiles" class="btn btn-primary">Select files</button>
                        <button id="uploadfiles" class="btn btn-primary">Upload files</button>
                        <div id="filelist"></div>
                    </div>
                </div>
                <div class='col-lg-9'>
                    <h4 class="pull-left">Select from library</h4>
                    <div class="pull-right">
                        <button id="addSelectedFiles" class="btn btn-primary btn-block hidden" data-action="add-selected-files">Add Selected Files</button>
                    </div>
                    <div class="row">
                        <div id="image-loader" class="col-md-12"></div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            window.ImageManagerData = {
                url: '{{url("upload-image")}}',
                flash: '{{asset("/vendor/image-manager/vendors/plupload/Moxie.swf")}}',
                silverlight: '{{asset("/vendor/image-manager/vendors/plupload/Moxie.xap")}}',
                maxFileSize: '{{config("image-manager.maxFileSize")}}',
                imagesUrl: '@if(isset($multiple)){{ url("image-manager-multiple-images") }} @else{{ url("image-manager-images") }}@endif',
                csfr: '{{csrf_token()}}'
            };
        </script>
    </body>
</html>
