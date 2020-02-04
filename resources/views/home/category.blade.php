@extends('templates.default')

@section('content')
<div class="row">
 <div class="col-12">
     <div class="page-title-box">
         <h4 class="page-title">Kategori</h4>
     </div>
 </div>
</div>
  <div class="row">
    <div class="col-12">
      <div class="card-box">
        <div class="row">
          <div class="col-6">
             <form class="form-inline">
                 <div class="form-group">
                     <input type="text" class="input-add form-control" placeholder="Masukan Kategori">
                 </div>
                  <div class="input-error"></div>
             </form>
         </div>
        <div class="col-6">
          <div class="text-lg-right mt-lg-0">
            <a href="javascript: void(0);" class="btn-add btn btn-info waves-effect waves-light"><i class="mdi mdi-plus-circle mr-1"></i> Tambah</a>
           </div>
         </div><!-- end col-->
       </div> <!-- end row -->
     </div> <!-- end card-box -->
   </div> <!-- end col-->
 </div>
 <div class="row">
     <div class="col-12">
         <div class="card">
             <div class="card-body">
               <div class="row">
                 <div class="col-6 mb-2">
                    <div class="form-group">
                        <input type="text" class="form-control" id="search" placeholder="Cari kategori">
                    </div>
                </div>
               </div>
               <div class="table-responsive">
                   <table class="table mb-0">
                       <thead>
                       <tr>
                           <th>No</th>
                           <th>Kategori</th>
                           <th>Aksi</th>
                       </tr>
                       </thead>
                       <tbody class="category-table">
                       </tbody>
                   </table>
               </div> <!-- end table-responsive-->
             </div> <!-- end card body-->
         </div> <!-- end card -->
     </div><!-- end col-->
 </div>
 <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-sm modal-dialog-centered">
     <div class="modal-content">
       <div class="modal-header">
         <h4 class="modal-title"></h4>
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
       </div>
       <div class="modal-body">
       </div>
     </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
 </div><!-- /.modal -->
 <!-- end row-->
<script src="{{asset('assets/js/pages/category.js')}}"></script>
@endsection
