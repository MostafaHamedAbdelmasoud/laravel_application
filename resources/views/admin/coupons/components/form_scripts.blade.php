
@section('scripts')

    <script type="text/javascript">
        // (function () {

        $(document).ready(function () {
            $('#myForm').change(function () {
                $check_type_percentage_discount = $('input[name=type]:checked').val();
                if ($check_type_percentage_discount === 'percentage_discount') {
                    $('.percentage_discount').show(500);

                    /******* hide ****/
                    $('#fixed_discount').val("0" );
                    $('.fixed_discount').hide(500).prop('required',false);
                } else {
                    $('.fixed_discount').show(500);

                    /******* hide ****/
                    $('#percentage_discount').val("0");
                    $('.percentage_discount').hide(500).prop('required',false);
                }
            });
            $check_type_percentage_discount = $('input[name=type]:checked').val();
            if ($check_type_percentage_discount === 'percentage_discount') {
                $('.percentage_discount').show(500);

                /******* hide ****/
                $('#fixed_discount').val("0" );
                $('.fixed_discount').hide(500).prop('required',false);
            } else {
                $('.fixed_discount').show(500);

                /******* hide ****/
                $('#percentage_discount').val("0" );
                $('.percentage_discount').hide(500).prop('required',false);
            }
        });



    </script>

@endsection
