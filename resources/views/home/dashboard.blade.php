@extends('templates.default')

@section('content')
<div class="row">
 <div class="col-12">
     <div class="page-title-box">
         <h4 class="page-title">Beranda</h4>
     </div>
 </div>
</div>
<div class="row">
   <div class="col-md-6 col-xl-4">
       <div class="widget-rounded-circle card-box">
           <div class="row">
               <div class="col-6">
                   <div class="avatar-lg rounded bg-soft-primary">
                       <i class="dripicons-basket font-24 avatar-title text-primary"></i>
                   </div>
               </div>
               <div class="col-6">
                   <div class="text-right">
                       <h3 class="text-dark mt-1"><span data-plugin="counterup">{{count($products)}}</span></h3>
                       <p class="text-muted mb-1 text-truncate">Produk</p>
                   </div>
               </div>
           </div> <!-- end row-->
       </div> <!-- end widget-rounded-circle-->
   </div> <!-- end col-->

   <div class="col-md-6 col-xl-4">
       <div class="widget-rounded-circle card-box">
           <div class="row">
               <div class="col-6">
                   <div class="avatar-lg rounded bg-soft-info">
                       <i class="dripicons-store font-24 avatar-title text-info"></i>
                   </div>
               </div>
               <div class="col-6">
                   <div class="text-right">
                       <h3 class="text-dark mt-1"><span data-plugin="counterup">{{count($branches)}}</span></h3>
                       <p class="text-muted mb-1 text-truncate">Cabang</p>
                   </div>
               </div>
           </div> <!-- end row-->
       </div> <!-- end widget-rounded-circle-->
   </div> <!-- end col-->
   <div class="col-md-6 col-xl-4">
       <div class="widget-rounded-circle card-box">
           <div class="row">
               <div class="col-6">
                   <div class="avatar-lg rounded bg-soft-success">
                       <i class="dripicons-clipboard font-24 avatar-title text-success"></i>
                   </div>
               </div>
               <div class="col-6">
                   <div class="text-right">
                       <h3 class="text-dark mt-1"><span data-plugin="counterup">{{count($orders)}}</span></h3>
                       <p class="text-muted mb-1 text-truncate">Pesanan</p>
                   </div>
               </div>
           </div> <!-- end row-->
       </div> <!-- end widget-rounded-circle-->
   </div> <!-- end col-->
  </div>

@endsection
@section('script')

@endsection
