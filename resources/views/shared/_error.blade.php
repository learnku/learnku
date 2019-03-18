@if (count($errors) > 0)
    <div class="ui error message">
        <i class="close icon"></i>
        <div class="header">
            有错误发生:
        </div>

        <div class="ui bulleted list">
            @foreach ($errors->all() as $error)
                <div class="item">{{ $error }}</div>
            @endforeach
        </div>
    </div>
@endif
