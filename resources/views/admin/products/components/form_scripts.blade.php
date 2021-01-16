<script type="text/javascript">


    $(document).ready(function () {

        getGategories();

        function getGategories() {
            var lolId = '{!! $main_name_id !!}';
            var valueOFselectCategory = $(lolId).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "Authorization": "Bearer " + '{!! $token !!}'
                }
            });
            $.ajax({
                type: 'GET',
                url: location.origin + '{!! $api_url !!}' + valueOFselectCategory,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                },
                success: function (msg) {
                    var ho = [];
                    msg = msg[0];
                    for (var i = 0; i < msg.length; i++) {
                        var records = {
                            id: msg[i].id, name: msg[i].name
                        };
                        ho.push(records);
                    }
                    fullTable(ho);
                }
            });
        }

        $('{!! $main_name_id !!}').on('change', function (e) {
            getGategories();
        });

        function fullTable(hos) {
            var allData = "";
            var old_id = '{!! $component_id !!}' ?? 0;
            var selected = 'selected';
            var notselected = '';
            allData += '<option selected value="">يرجى الإختيار</option> ';
            for (var j = 0; j < hos.length; j++) {
                allData += ' <option value="' + hos[j].id + '"  ';
                allData += old_id == hos[j].id ? selected : notselected;
                allData += '>' + hos[j].name + '</option>\n';
            }
            document.getElementById('{!! $sub_name_id !!}').innerHTML = allData;
        }

    });
</script>
