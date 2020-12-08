
    <script type="text/javascript">


        $(document).ready(function () {

            getGategories();

            function getGategories() {
                var valueOFselectCategory = $("#category_id").val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "Authorization": "Bearer " + '{!! $token !!}'
                    }
                });
                $.ajax({
                    type: 'GET',
                    url: location.origin + '/public/index.php/api/v1/get_categories_ajax/' + valueOFselectCategory,
                    {{--data: 'api_token={!! \Auth::user()->api_token !!}',--}}
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

            $("#category_id").on('change', function (e) {
                getGategories();
            });

            function fullTable(hos) {
                var allData = "";
                var old_id = {!! $sub_category_id !!};
                var selected = 'selected';
                var notselected = '';
                for (var j = 0; j < hos.length; j++) {
                    allData += ' <option value="' + hos[j].id + '"  ';
                    allData += old_id===hos[j].id? selected:notselected  ;
                    allData+= '>'+hos[j].name + '</option>\n';
                }
                document.getElementById("sub_category_id").innerHTML = allData;
            }

        });
    </script>
