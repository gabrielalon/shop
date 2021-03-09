<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <p class="text-muted text-light">
                    <small>{{ date('Y-m-d H:i:s') }} &copy; Net Tech Marek Rode Sp. z o.o.</small>
                </p>
            </div>
            <div class="col-md-6 text-right">
                <p class="text-muted text-light">
                    <small>
                        Laravel: {{ app()->version() }}
                        PHP: {{ phpversion() }}
                        MySQL: {{ \Illuminate\Support\Facades\DB::selectOne('SHOW VARIABLES LIKE "version"')->Value }}
                    </small>
                </p>
            </div>
        </div>
    </div>
</footer>
