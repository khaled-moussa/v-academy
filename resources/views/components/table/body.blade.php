<div class="table-scroll">
    <table class="table">

        @if(isset($head))
            <thead>
                <tr>{{ $head }}</tr>
            </thead>
        @endif

        <tbody>
            {{ $slot }}
        </tbody>

    </table>
</div>