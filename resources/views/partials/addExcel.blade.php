{{--<div style="margin-bottom: 10px;" class="row ">--}}


<div class="col-md-6 text-right ">

    <form class="text-center border-dark" enctype="multipart/form-data" action="{{route('admin.'.$route_name)}}"
          method="post">
        @csrf

        <div class="py-2 w-100 form-group btn btn-success py-2">
            <span>ملف الإكسل </span>
            <br>
            <input type="file" name="excel_file">
        </div>
        <button class="btn btn-outline-primary">حفظ</button>
    </form>

</div>

<div class="col-md-6 text-right ">

    @if(session('success'))
        <div class="alert alert-success">تم الإضافة</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{!! \Session::get('error') !!}</div>
    @endif
</div>

{{--</div>--}}
