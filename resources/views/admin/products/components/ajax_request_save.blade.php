<script type="text/javascript">


    $(document).ready(function () {
        $('.alert').alert()



        function make_ajax_request() {
            {{--var formName = $('{!! $form !!}');--}}
            var formName = new FormData(document.getElementById('{!! $form !!}')[0]);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "Authorization": "Bearer " + '{!! $token !!}'
                }
            });
            $.ajax({
                type: 'POST',
                url: location.origin + '{!! $api_url !!}',
                data: formName.serialize(),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                },
                success: function (msg) {
                    alert(msg.data);
                    $('#alert_custom_field').html('<div class="alert alert-success alert-dismissible fade show" role="alert" >تم الحفظ بنجاخ<button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                        '                                <span aria-hidden="true">&times;</span>\n' +
                        '                            </button></div>');
                    // get_custom_field();
                }
            });
        }

        $('#form_create').click(  (e) =>{
            alert('hello');
            make_ajax_request();
            e.preventDefault();

        });

        // $('#form_create ').on('submit', function (e) {
        //     make_ajax_request();
        //     e.preventDefault();
        //
        // });

    });
</script>
