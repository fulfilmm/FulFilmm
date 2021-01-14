<div class="message-bar">
    <div class="message-inner">
        <a class="link attach-icon" href="#"><img src="img/attachment.png" alt=""></a>
        <div class="message-area">
            <form enctype="multipart/form-data" action="{{route('comments.store')}}" method="POST">
                @csrf
            <div class="input-group">
                <textarea name="message" required class="form-control" placeholder="Type message..."></textarea>
                <span class="input-group-append">
                    <input type="hidden" name="activity_id"   
                    value="{{request()->route()->parameters['activity']}}">
                    <input  type="file" id="file" class="d-none" name="file" id="">
                    <button onclick="triggerFile()"  class="btn btn-primary" type="button"><i
                            class="fa fa-paperclip"></i></button>
                </span>
                <span class="input-group-append">
                                <button type="submit" class="btn btn-primary" ><i
                                        class="fa fa-send"></i></button>
                            </span>
            </div>
        </form>
        </div>
    </div>
</div>