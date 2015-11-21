<div class='row' id="images-container">
    @foreach($files as $f)
    <div class='col-lg-4' id="imageManager_{{$f->id}}">
        <div class="thumbnail">
            <p>{{$f->originalName}}</p>
            <img src="{{route('showthumb', $f->id)}}" alt="">
            <div class="caption">
                @if(!isset($multiple))
                    <button class="btn btn-default" data-file-id='{{$f->id}}' data-preview-url="{{route('showthumb', $f->id)}}" data-action="use-file"><i class="fa fa-check-circle"></i> Use</button>
                @else
                    <button class="btn btn-default" data-file-id='{{$f->id}}' data-preview-url="{{route('showthumb', $f->id)}}" data-action="select-file"><i class="fa fa-check-circle"></i> Select</button>
                @endif
                <button type="button" class="btn btn-default popover-dismiss" data-container="body" data-toggle="popover" data-placement="top" data-content='Are you sure you want to delete the file?<br /><button class="btn btn-danger" data-file-id="{{$f->id}}" data-delete-url="{{route('ImageManagerDelete', $f->id)}}" data-action="delete-file"><i class="fa fa-trash-o"></i> Delete</button>'>
                    Delete File
                </button>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="row">
    <div class="center-block images-paginator" style="text-align: center">
        {!!$files->render()!!}
    </div>
</div>
