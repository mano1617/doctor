<footer class="app-footer">
    <div>
        <strong>@lang('labels.general.copyright') &copy; {{ date('Y') }}
            <a href="{{ url('/') }}">
                {{ env('APP_NAME') }}
            </a>
        </strong> @lang('strings.backend.general.all_rights_reserved')
    </div>
</footer>
