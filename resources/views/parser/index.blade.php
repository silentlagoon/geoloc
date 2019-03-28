<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Scripts -->
    <script src="{{ asset('js/main.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/flag-icon-css/css/flag-icon.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <form method="POST" action="{{ route('post.parse.excel') }}" enctype="multipart/form-data" style="position: relative; padding: 1rem; margin: 1rem -15px 0; border: solid #f8f9fa; border-width: .2rem 0 0;">
            @csrf
            <div class="form-group{{ $errors->has('address_col') ? ' has-error' : '' }}">
                <label for="address_col">Буква колонки с адресом</label>
                <input name="address_col" type="text" class="form-control" id="address_col" aria-describedby="addressHelp" placeholder="Буква колонки с адресом">
                @if ($errors->has('address_col'))
                    <span style="display: block;" class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('address_col') }}</strong>
                    </span>
                @endif
                <small id="addressHelp" class="form-text text-muted">Укажите букву колонки где хранится адрес на который нужны геоданные</small>
            </div>
            <div class="form-group {{ $errors->has('lat_output_col') ? ' has-error' : '' }}">
                <label for="lat_output_col">Буква ячейки куда записывать широту</label>
                <input name="lat_output_col" type="text" class="form-control" id="lat_output_col" aria-describedby="lat_output_colHelp" placeholder="Буква ячейки куда записывать широту">
                @if ($errors->has('lat_output_col'))
                    <span style="display: block;" class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('lat_output_col') }}</strong>
                    </span>
                @endif
                <small id="lat_output_colHelp" class="form-text text-muted">Укажите букву колонки куда будет записываться широта</small>
            </div>
            <div class="form-group {{ $errors->has('long_output_col') ? ' has-error' : '' }}">
                <label for="long_output_col">Буква ячейки куда записывать долготу</label>
                <input name="long_output_col" type="text" class="form-control" id="long_output_col" aria-describedby="long_output_colHelp" placeholder="Буква ячейки куда записывать долготу">
                @if ($errors->has('long_output_col'))
                    <span style="display: block;" class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('long_output_col') }}</strong>
                    </span>
                @endif
                <small id="long_output_colHelp" class="form-text text-muted">Укажите букву колонки куда будет записываться долгота</small>
            </div>
            <div class="form-group {{ $errors->has('row_start_index') ? ' has-error' : '' }}">
                <label for="row_start_index">Номер строки с которой начинать</label>
                <input value="2" name="row_start_index" type="text" class="form-control" id="row_start_index" aria-describedby="row_start_indexHelp" placeholder="Номер строки с которой начинать">
                @if ($errors->has('row_start_index'))
                    <span style="display: block;" class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('row_start_index') }}</strong>
                    </span>
                @endif
                <small id="row_start_indexHelp" class="form-text text-muted">Укажите номер строки с которой начинать, обычно это вторая строка (оглавление тоже считается строкой)</small>
            </div>
            <div class="form-group {{ $errors->has('api_key') ? ' has-error' : '' }}">
                <label for="api_key">Google API Key</label>
                <input value="{{ config('gmaps.api_key') }}" name="api_key" type="text" class="form-control" id="api_key" aria-describedby="api_keyHelp" placeholder="Google API Key">
                @if ($errors->has('api_key'))
                    <span style="display: block;" class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('api_key') }}</strong>
                    </span>
                @endif
                <small id="api_keyHelp" class="form-text text-muted">Если возникли проблемы с ключом или вы хотите использовать другой, укажите его</small>
            </div>
            <div class="form-group {{ $errors->has('output_filename') ? ' has-error' : '' }}">
                <label for="output_filename">Имя файла результатов</label>
                <input value="result.xlsx" name="output_filename" type="text" class="form-control" id="output_filename" aria-describedby="output_filenameHelp" placeholder="Имя файла результатов">
                @if ($errors->has('output_filename'))
                    <span style="display: block;" class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('output_filename') }}</strong>
                    </span>
                @endif
                <small id="output_filenameHelp" class="form-text text-muted">Укажите имя файла для результатов</small>
            </div>
            <div class="form-group {{ $errors->has('file') ? ' has-error' : '' }}">
                <label for="excelFile">Excel-файл для обработки</label>
                <input name="file" type="file" class="form-control-file" id="excelFile">
                @if ($errors->has('file'))
                    <span style="display: block;" class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('file') }}</strong>
                    </span>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Начать</button>
        </form>
    </div>

</body>
</html>