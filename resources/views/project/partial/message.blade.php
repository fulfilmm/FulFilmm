<div class="chat chat-left">
    <div class="chat-avatar">
        <a href="profile" class="avatar">
            <img alt="" src="img/profiles/avatar-02.jpg">
        </a>
    </div>
    <div class="chat-body">
        <div class="chat-bubble">
            <div class="chat-content">
                <span class="task-chat-user">{{$name}}</span>

                <span
                    class="chat-time">at {{$date}}</span>
                <ul class="attach-list">
                    @if ($file)
                        <li><i class="fa fa-file"></i> <a
                                href="{{$file}}">{{$file->name}}</a></li>
                        <img src="{{$file}}" class="img-fluid w-25" alt="">
                    @endif
                    <p>{{$msg}}</p>
                </ul>
            </div>
        </div>
    </div>
</div>
