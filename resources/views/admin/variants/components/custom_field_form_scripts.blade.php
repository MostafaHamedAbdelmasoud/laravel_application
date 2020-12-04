<script type="text/javascript">


    function get_custom_field() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + '{!! $token !!}'
            }
        });
        $.ajax({
            type: 'GET',
            url: location.origin + '{!! $api_url !!}',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
            },
            success: function (msg) {
                var ho = [];
                msg = msg.data;
                for (var i = 0; i < msg.length; i++) {
                    var records = {
                        id: msg[i].id, type: msg[i].type
                    };
                    ho.push(records);
                }
                fullTable(ho);
            }
        });
    }


    function fullTable(hos) {
        var allData = "";

        var old_id = {!! $component_id !!};
        var selected = 'selected';
        var notselected = '';
        $('#custom_field_id').find('option').each(function(){
            console.log($(this).val());
        });

        var dataArray = Object.keys(hos).map(function(k){return hos[k].id});
        for (var j = 0; j < hos.length; j++) {
            allData += ' <option value="' + hos[j].id + '"  ';
            // allData += dataArray.includes(hos[j].id)  ? selected : notselected;
            allData += hos[j].id== id  ? selected : notselected;
            allData += '>' + hos[j].type + '</option>\n';
            // old_id === hos[j].id
        }
        document.getElementById('{!! $sub_name_id !!}').innerHTML = (allData) ;
    }


    /////// load the page first ///
    $(document).ready(function () {

        get_custom_field();


        $('{!! $main_name_id !!}').on('change', function (e) {
            get_custom_field();
            e.preventDefault();
        });


    });
</script>
