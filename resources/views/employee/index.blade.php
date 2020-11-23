<head>
    @livewireStyles
</head>

<body>
    @if(session()->has('success'))
    <div class="">
        {{ session()->get('success') }}
    </div>
@endif
    <livewire:employee-table />

    @livewireScripts
  
</body>
