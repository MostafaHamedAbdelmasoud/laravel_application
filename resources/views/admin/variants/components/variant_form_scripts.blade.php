<script type="text/javascript">


    function add_variant() {
        fullTable();
    }


    function fullTable() {
        var t = document.getElementById('dashTable');
        var r = '\n' +
            '    <form  id="form_create1"\n' +
            '    enctype="multipart/form-data">\n' +
            '        @csrf\n' +
            '\n' +
            '        <div class="form-group">\n' +
            '        <label for="price">{{ trans("cruds.variant.title") }}</label>\n' +
            '        <table class="table table-bordered text-center table-responsive" id="dashTable">\n' +
            '        <thead>\n' +
            '        <tr>\n' +
            '        <th scope="col">{{trans("cruds.variant.fields.color")}}</th>\n' +
            '        <th scope="col">{{trans("cruds.variant.fields.size")}}</th>\n' +
            '        <th scope="col">{{trans("cruds.variant.fields.count")}}</th>\n' +
            '        <th scope="col">{{trans("cruds.variant.fields.price")}}</th>\n' +
            '        <th scope="col">{{trans("cruds.variant.fields.image")}}</th>\n' +
            '        {{--                            <th scope="col">الصور المُضافة مسبقا</th>--}}\n' +
            '        </tr>\n' +
            '        </thead>\n' +
            '        <tbody>\n' +
            '        <tr>\n' +
            '        <td><input class="search" type="text" name="colors"\n' +
            '    \n' +
            '    placeholder="{{ trans("global.add") }}"></td>\n' +
            '        <td><input class="search" type="text" name="sizes"\n' +
            '    \n' +
            '    placeholder="{{ trans("global.add") }}"></td>\n' +
            '        <td><input class="search" type="number" name="counts"\n' +
            '    \n' +
            '    placeholder="{{ trans("global.add") }}"></td>\n' +
            '        <td><input class="search" type="text" name="prices"\n' +
            '    \n' +
            '    placeholder="{{ trans("global.add") }}"></td>\n' +
            '        <td>\n' +
            '\n' +
            '        <input class="search" type="file" name="images"\n' +
            '\n' +
            '    placeholder="{{ trans("global.add") }}"\n' +
            '    >\n' +

            '        </td>\n' +
            '        </tr>\n' +
            '\n' +
            '        </tbody>\n' +
            '        </table>\n' +
            '\n' +
            '        </div>\n' +
            '\n' +

            '  <div id="alert_custom_field">\n' +
            '\n' +
            '                    </div>   ' +
            '<div class="form-group">\n' +
            '        </div>\n' +
            '        </form>'+
            '<button class="btn btn-danger"  id="form_create">\n' +
                '        {{ trans("global.save") }}\n' +
            '        </button>\n' ;

        t.innerHTML += r;
    }


    /////// load the page first ///
    $(document).ready(function () {

        $('{!! $main_name_id !!}').on('click', function (e) {
            console.log()
            add_variant();
            // console.log($('#form_create'));
            // $('#form_create').click((e)=>{
            //     e.preventDefault();
            // });
            e.preventDefault();
        });


    });
</script>


