@if(session('toast-success'))

    <section class="toast position-fixed flex-row-reverse rounded" style="z-index:99999999;left:0;top:3rem;width:26rem;max-width:80%" data-delay="5000">
    <section class="toast-header bg-success text-white">
    <strong class="me-auto">آمازون</strong>
    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="toast">&times;</button>
</section>
        <section class="toast-body py-3 d-flex bg-success text-white">
            <strong class="ml-auto">{{ session('toast-success') }}</strong>
        </section>
    </section>

    <script>
        $(document).ready(function () {
            $('.toast').toast('show');
        })
    </script>


@endif
