<script type="text/javascript">
    let name_of_component = '{!! $name !!}';
    {{--let value_of_component = '{!! $value !!}';--}}
    Dropzone.options.{!! $nameofclass !!} = {
        url: '{{ route('admin.products.storeMedia') }}',
        maxFilesize: 5, // MB
        acceptedFiles: '.jpeg,.jpg,.png,.gif',
        maxFiles: 1,
        addRemoveLinks: true,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
            size: 5,
            width: 4096,
            height: 4096
        },
        success: function (file, response) {
            $('form').find('input[name="'+name_of_component+'"]').remove()
            $('form').append('<input type="hidden" name="'+name_of_component+'" value="' + response.name + '">')
        },
        removedfile: function (file) {
            file.previewElement.remove()
            if (file.status !== 'error') {
                $('form').find('input[name="'+name_of_component+'"]').remove()
                this.options.maxFiles = this.options.maxFiles + 1
            }
        },
        init: function () {
            @if(isset($product) && $product->ProductVariants->first()->variant->image)
            var file = {!! json_encode($product->ProductVariants->first()->variant->image) !!}
                this.options.addedfile.call(this, file)
            this.options.thumbnail.call(this, file, file.preview)
            file.previewElement.classList.add('dz-complete')
            $('form').append('<input type="hidden" name="'+name_of_component+'" value="' + file.file_name + '">')
            this.options.maxFiles = this.options.maxFiles - 1
            @endif
        },
        error: function (file, response) {
            if ($.type(response) === 'string') {
                var message = response //dropzone sends it's own error messages in string
            } else {
                var message = response.errors.file
            }
            file.previewElement.classList.add('dz-error')
            _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
            _results = []
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                node = _ref[_i]
                _results.push(node.textContent = message)
            }

            return _results
        }
    }
</script>


