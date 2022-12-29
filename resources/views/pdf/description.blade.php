@include('pdf.master')
<body>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <!-- /.card-header -->
                    <div class="card-body">
                        {{$item->name}}
{{--                        <div class="container p-3 mx-auto">--}}
{{--                            <h1 class="text-2xl font-semibold text-center text-gray-800 capitalize lg:text-3xl pb-2 dark:text-white">{{$item->name}}</h1>--}}
{{--                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">--}}
{{--                                {!!$item->description!!}--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</body>
</html>
