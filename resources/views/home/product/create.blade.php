@extends('templates.default')

@section('content')
<div class="row">
  <div class="col-12">
      <div class="page-title-box">
          <h4 class="page-title">Tambah Produk</h4>
      </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
      <div class="card">
          <div class="card-body">
              <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="simpleinput">Nama Produk</label>
                        <input type="text" class="product-name form-control" autofocus>
                    </div>
                    <div class="form-group mb-3">
                      <label for="simpleinput">Kategori</label>
                    <select class="category custom-select ">
                        <option value="" selected>Pilih Kategori</option>
                        @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="form-group mb-3">
                    <label for="simpleinput">Harga</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                          <span class="input-group-text">Rp.</span>
                      </div>
                      <input type="text" class="product-price form-control">
                    </div>
                  </div>
                    <div class="form-group mb-3">
                        <label for="example-textarea">Deskripsi</label>
                        <textarea class="product-description form-control" rows="5"></textarea>
                    </div>
                    <div class="form-group mb-2">
                       <img alt="" id="preview_image" width="60%" height="60%">
                    </div>
                    <div class="form-group mb-3">
                      <label>Gambar</label>
                       <div class="input-group">
                           <div class="custom-file">
                               <input type="file" class="product-image custom-file-input" id="image" accept="image/png,image/jpg,image/jpeg" >
                               <label class="custom-file-label" for="image">Pilih Gambar</label>
                           </div>
                       </div>
                    </div>
                    <div class="text-center">
                      <button type="button" class="btn-create btn btn-primary waves-effect waves-light">Simpan</button>
                    </div>
                  </div> <!-- end col -->
                </div>
              </div>
            </div>
          </div>
        </div>

@endsection
@section('script')
<script>
const btnCreate = document.querySelector('.btn-create');
const productName = document.querySelector('.product-name');
const category = document.querySelector('.category');
const productDescription = document.querySelector('.product-description');
const productImage = document.querySelector('.product-image');
const productPrice = document.querySelector('.product-price');

function store(data){
   // await fetch('http://localhost:8000/api/admin/product', {
     return fetch(url+'api/admin/product', {
          method: 'POST',
          body: data,
          headers: {'Authorization': 'Bearer '+apiToken, 'Accept' : 'application/json'}
      })
      .then(res => res.json())
      .then(res => res)
      .catch(err => console.error(err));
}

function readURL(input) {
   if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
     $('#preview_image').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
   }
  }

  $(document).ready(function(){
     $('#image').change(function(){
       readURL(this);
     });

    });

productPrice.addEventListener('keyup', function(e){
  productPrice.value = formatRupiah(this.value);
});

function formatRupiah(angka, prefix){
  var number_string = angka.replace(/[^,\d]/g, '').toString(),
  split    = number_string.split(','),
  sisa     = split[0].length % 3,
  rupiah     = split[0].substr(0, sisa),
  ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
  if (ribuan) {
    separator = sisa ? '.' : '';
    rupiah += separator + ribuan.join('.');
  }

  rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
  return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
}


  btnCreate.addEventListener('click', async function(){
    if(productName.value == ''){
      Swal.fire({ title: "Gagal",text: "Nama produk tidak boleh kosong",type: "error", timer: 2000,showConfirmButton: false})
      productName.style.borderColor = "red";
    }else if(productName.value.length < 3){
      Swal.fire({ title: "Gagal",text: "Nama produk terlalu pendek",type: "error", timer: 2000,showConfirmButton: false})
      productName.style.borderColor = "red";
    }else if(category.value == ''){
      Swal.fire({ title: "Gagal",text: "Pilih Kategori",type: "error", timer: 2000,showConfirmButton: false})
      category.style.borderColor = "red";
    }else if(productPrice.value == ''){
      Swal.fire({ title: "Gagal",text: "Harga produk tidak boleh kosong",type: "error", timer: 2000,showConfirmButton: false})
      productPrice.style.borderColor = "red";
    }else if(productPrice.value.replace('.','') < 1000){
      Swal.fire({ title: "Gagal",text: "Harga produk minimal 1000",type: "error", timer: 2000,showConfirmButton: false})
      productPrice.style.borderColor = "red";
    }else if(productDescription.value == ''){
      Swal.fire({ title: "Gagal",text: "Deskripsi produk tidak boleh kosong",type: "error", timer: 2000,showConfirmButton: false})
      productDescription.style.borderColor = "red";
    }else if(productDescription.value.length < 10){
      Swal.fire({ title: "Gagal",text: "Deskripsi minimal 10",type: "error", timer: 2000,showConfirmButton: false})
      productDescription.style.borderColor = "red";
    }else if(productImage.value == ''){
      Swal.fire({ title: "Gagal",text: "Gambar tidak boleh kosong",type: "error", timer: 2000,showConfirmButton: false})
      productImage.style.borderColor = "red";
    }else{
      const data = new FormData()
      data.append('name', productName.value),
      data.append('category_id', category.value),
      data.append('price', productPrice.value.replace('.','')),
      data.append('description', productDescription.value),
      data.append('image', productImage.files[0]);
      const storeProduct = await store(data);
      if(storeProduct.status){
        await Swal.fire({ title: "Berhasil",text: "Produk berhasil ditambah",type: "success", timer: 2000,showConfirmButton: false})
        window.location.href = "/produk"
      }else {
        if(storeProduct.errors.name){
          Swal.fire({ title: "Gagal",text: storeProduct.errors.name[0],type: "error", timer: 2000,showConfirmButton: false})
          productName.style.borderColor = "red";
        }else if (storeProduct.errors.image) {
          Swal.fire({ title: "Gagal",text: storeProduct.errors.image[0],type: "error", timer: 2000,showConfirmButton: false})
        }
      }
    }
  })
</script>
@endsection
