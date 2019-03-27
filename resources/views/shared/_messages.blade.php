{{--
session()->flash('success', 'This is a success alert—check it out!');
session()->flash('danger', 'This is a danger alert—check it out!');
session()->flash('warning', 'This is a warning alert—check it out!');
session()->flash('info', 'This is a info alert—check it out!');
session()->flash('error', 'This is a info alert—check it out!');
--}}
@foreach (['danger', 'warning', 'success', 'info', 'error', 'status', 'message'] as $msg)
  @if(session()->has($msg))
    @php
      $flag_class = '';
      switch ($msg){
          case 'danger':
              $flag_class = 'error';
              break;
          case 'status':
          case 'message':
              $flag_class = 'success';
              break;
      }
    @endphp
    <div class="ui container {{ $msg }} message {{ $flag_class }}">
      <i class="close icon"></i>
      <div class="header">
        提示:
      </div>
      <p>{{ session()->get($msg) }}</p>
    </div>
  @endif
@endforeach
