@extends('templates.default')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">Produk</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-12">
        <div class="card-box">
            <div class="row">
                <div class="col-lg-8">
                    <div class="form-inline">
                        <div class="form-group">
                            <input type="text" class="product-search form-control" placeholder="Cari">
                        </div>
                        <div class="form-group mx-sm-3 ml-2">
                            <select class="category-select custom-select">
                                <option selected="">Semua</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="text-lg-right mt-3 mt-lg-0">
                        <a href="" class="btn btn-info waves-effect waves-light"><i class="mdi mdi-plus-circle mr-1"></i>Tambah</a>
                    </div>
                </div><!-- end col-->
            </div> <!-- end row -->
        </div> <!-- end card-box -->
    </div> <!-- end col-->
</div>
<!-- end row-->
<!-- <div class="row">
  <div class="col-lg-12"> -->

  <!-- </div>
</div> -->

<div class="product-container row">

</div>
<!-- end row-->
<div class="page-count text-lg-right mt-3 mb-2 mt-lg-0">

</div>
<div class="row">
    <div class="col-12">
        <ul class="pagination pagination-rounded justify-content-center mb-3">

        </ul>
    </div> <!-- end col-->
</div>
@endsection
@section('script')
<script src="{{asset('assets/js/pages/product.js')}}"></script>
@endsection
