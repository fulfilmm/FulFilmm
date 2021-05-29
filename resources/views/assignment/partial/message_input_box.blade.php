<div class="message-bar">
    <div class="message-inner">
        <a class="link attach-icon" href="#"><img src="img/attachment.png" alt=""></a>
        <div class="message-area">
            <img src="#" id="image_preview" class="mb-3 mx-3 w-25" alt="">
            <div id="upload-message"></div>

            <form enctype="multipart/form-data" action="{{route('comments.store')}}" method="POST">
                @csrf
                <div class="input-group">
                    <textarea name="message" class="form-control" placeholder="Type message..."></textarea>


                    <span class="input-group-append">
                    <input type="hidden" name="assignment_id"
                           value="{{request()->route()->parameters['assignment']}}">
                    <input type="file" id="file" class="d-none" name="file">


                    <button onclick="triggerFile()" class="btn btn-primary" type="button"><i
                            class="fa fa-paperclip"></i></button>
                    </span>
                    <span class="input-group-append">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-send"></i></button>
                            </span>
                </div>
                @error('message')
                <br>
                <small class="text-danger">{{$message}}</small>
                @enderror

                @error('file')
                <br>
                <small class="text-danger">{{$message}}</small>
                @enderror
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        file.onchange = evt => {
            const [form_file] = file.files
            if (form_file) {
                const validImageTypes = ['image/gif', 'image/jpeg', 'image/png'];
                if (validImageTypes.includes(form_file.type)){
                    image_preview.src = URL.createObjectURL(form_file)
                }

                var tag = document.createElement("p");
                var text = document.createTextNode(`"${form_file.name}" has been uploaded`);
                tag.appendChild(text);
                var element = document.getElementById("upload-message");
                console.log(element.childElementCount)
                if (element.childElementCount > 0){
                    element.innerHTML = '';
                }
                element.appendChild(tag);
            }
        }
    </script>
@endpush
