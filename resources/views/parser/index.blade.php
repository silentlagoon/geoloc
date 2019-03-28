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
        <form style="position: relative; padding: 1rem; margin: 1rem -15px 0; border: solid #f8f9fa; border-width: .2rem 0 0;">
            <div class="form-group">
                <label for="address_col">Буква колонки с адресом</label>
                <input name="address_col" type="text" class="form-control" id="address_col" aria-describedby="addressHelp" placeholder="Буква колонки с адресом">
                <small id="addressHelp" class="form-text text-muted">Укажите букву колонки где хранится адрес на который нужны геоданные</small>
            </div>
            <div class="form-group">
                <label for="lat_output_col">Буква ячейки куда записывать широту</label>
                <input name="lat_output_col" type="text" class="form-control" id="lat_output_col" aria-describedby="lat_output_colHelp" placeholder="Буква ячейки куда записывать широту">
                <small id="lat_output_colHelp" class="form-text text-muted">Укажите букву колонки куда будет записываться широта</small>
            </div>
            <div class="form-group">
                <label for="long_output_col">Буква ячейки куда записывать долготу</label>
                <input name="long_output_col" type="text" class="form-control" id="long_output_col" aria-describedby="long_output_colHelp" placeholder="Буква ячейки куда записывать долготу">
                <small id="long_output_colHelp" class="form-text text-muted">Укажите букву колонки куда будет записываться долгота</small>
            </div>
            <div class="form-group">
                <label for="row_start_index">Номер строки с которой начинать</label>
                <input value="2" name="row_start_index" type="text" class="form-control" id="row_start_index" aria-describedby="row_start_indexHelp" placeholder="Номер строки с которой начинать">
                <small id="row_start_indexHelp" class="form-text text-muted">Укажите номер строки с которой начинать, обычно это вторая строка (оглавление тоже считается строкой)</small>
            </div>
            <div class="form-group">
                <label for="api_key">Google API Key</label>
                <input value="AIzaSyBldjHDJrh_or4xDnM22MAbOACBySMYUi4" name="api_key" type="text" class="form-control" id="api_key" aria-describedby="api_keyHelp" placeholder="Google API Key">
                <small id="api_keyHelp" class="form-text text-muted">Если возникли проблемы с ключом или вы хотите использовать другой, укажите его</small>
            </div>
            <div class="form-group">
                <label for="output_filename">Имя файла результатов</label>
                <input value="result.xlsx" name="output_filename" type="text" class="form-control" id="output_filename" aria-describedby="output_filenameHelp" placeholder="Имя файла результатов">
                <small id="output_filenameHelp" class="form-text text-muted">Укажите имя файла для результатов</small>
            </div>
            <div class="form-group">
                <label for="excelFile">Excel-файл для обработки</label>
                <input name="file" type="file" class="form-control-file" id="excelFile">
            </div>
            <button type="submit" class="btn btn-primary">Начать</button>
        </form>
    </div>

</body>
</html>