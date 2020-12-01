
@php
$paths = explode('/', request()->path());
$currentPath=  count($paths)-1;
@endphp
<div class="page-header">
    <div class="row">
        <div class="col">
            <h3 class="page-title">{{$header}}</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item active"><a href="/">Dashboard</a></li>
                
                @foreach ($paths as $key=>$path)
                @if ($currentPath === $key)
                <li class="breadcrumb-item active">
                    
                    {{$path}}
                </li>
                @else
                <li class="breadcrumb-item ">
                    <a href="/{{$path}}">
                        {{$path}}
                    </a>  
                </li>
                @endif
                
                @endforeach
            </ul>
        </div>
    </div>
</div>



</li>
