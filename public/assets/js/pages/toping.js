const inputSearch = document.getElementById("search");
const addToping = document.querySelector('.btn-add');
const inputName = document.querySelector('.input-name');
const inputPrice = document.querySelector('.input-price');
const category = document.querySelector('.category');
let priceEdit = document.querySelector('.price-edit');


function getToping(){
  fetch(url+'api/toping').then(res => res.json()).then(res => updateUI(res.data));
}

function getTopingDetail(id){
  return fetch(url+'api/toping/'+id, {
    headers: { 'Authorization' : 'Bearer '+apiToken }
  })
  .then(res => res.json()).then(res => res.data);
  // alert("hahaha")
}

function storeToping(data){
  return fetch(url+'api/toping', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json','Authorization' : 'Bearer '+apiToken },
    body: JSON.stringify(data)
  }).then(res => res.json())
  .then(res => {
    const success = "Toping "+data.name+" berhasil ditambahkan";
    if(res.status){
      Swal.fire({ title: "Berhasil",text: success,type: "success"})
      getToping()
    }else {
      console.log(res.errors);
      Swal.fire({ title: "Gagal",text: res.errors,type: "error"})
    }
  })
}

function updateCategory(id, data){
  return fetch(url+'api/category/'+id, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json',
    'Authorization' : 'Bearer '+apiToken
  },
    body: JSON.stringify(data)
  }).then(res => res.json())
  .then(res => {
    const success = "Kategori "+data.name+" berhasil diubah";
    if(res.status){
      Swal.fire({ title: "Berhasil",text: success,type: "success"})
      getToping()
    }else {
      Swal.fire({ title: "Gagal",text: res.errors,type: "error"})
    }
  })
}

function searchToping(keyword){
  return fetch(url+'api/category/search/'+keyword).then(res => res.json())
  .then(res => res.data);
}

function deleteToping(id, name){
  return fetch(url+'api/toping/'+id, {
    method: 'DELETE',
    headers: { 'Authorization' : 'Bearer '+apiToken },
  }).then(res => res.json())
  .then(res => {
    // console.log(res);
    const success = "Toping "+name+" berhasil dihapus";
    if(res.status){
      Swal.fire({ title: "Berhasil",text: success,type: "success"})
      getToping()
    }else {
      Swal.fire({ title: "Gagal",text: res.errors,type: "error"})
    }
  })
}

addToping.addEventListener('click', function(){
  const inputErr = document.querySelector('.input-error');
  const inputErrPrice = document.querySelector('.input-error-price');
  const inputErrCategory = document.querySelector('.input-error-category');

  let err;
  if(inputName.value == ''){
    inputName.classList.add('is-invalid')
    err = `<strong><p style="color: red">Nama toping tidak boleh kosong</p></strong>`
    inputErr.innerHTML = err
  }else if(inputName.value.length < 3) {
    inputName.classList.add('is-invalid')
    err = `<strong><p style="color: red">Nama toping terlalu pendek</p></strong>`
    inputErr.innerHTML = err
  }else if(inputPrice.value == '') {
    inputPrice.classList.add('is-invalid')
    err = `<strong><p style="color: red">Harga tidak boleh kosong</p></strong>`
    inputErrPrice.innerHTML = err
  }else if(inputPrice.value.replace('.','') < 500) {
    inputPrice.classList.add('is-invalid')
    err = `<strong><p style="color: red">Harga minimal 500</p></strong>`
    inputErrPrice.innerHTML = err
  }else if(category.value == '') {
    err = `<strong><p style="color: red">Pilih kategori</p></strong>`
    inputErrCategory.innerHTML = err
  }else {
    const data = {name: inputName.value, category: category.value, price: inputPrice.value.replace('.','')}
    storeToping(data);
    console.log(data);
    inputName.classList.remove('is-invalid')
    inputPrice.classList.remove('is-invalid')
    inputName.value = ''
    inputPrice.value = ''
    category.value = ''
    inputErr.innerHTML = ''
    inputErrPrice.innerHTML = ''
    inputErrCategory.innerHTML = ''

  }
})

inputSearch.addEventListener('change', async function(){
  const keyword = inputSearch.value;
  if (keyword) {
    const searchData = await searchToping(keyword);
    return updateUI(searchData);
  }else {
    return getToping()
  }
})

document.addEventListener('click', async function(e){
  let modalTitle = document.querySelector('.modal-title');
  const id = e.target.dataset.id;
  if(e.target.classList.contains('btn-edit')){
    const categoryDetail = await getTopingDetail(id);
    updateUIDetail(categoryDetail);
    modalTitle.innerHTML = "Edit Kategori"
  }
  if(e.target.classList.contains('btn-form-edit')){
    const inputNameEdit = document.querySelector('.name-edit');
    const inputErr = document.querySelector('.input-error-edit');
    let err;
    if(inputNameEdit.value == ''){
      inputNameEdit.classList.add('is-invalid')
      err = `<strong><p style="color: red">Nama kategori tidak boleh kosong</p></strong>`
      inputErr.innerHTML = err
    }
    else if(inputNameEdit.value.length < 3) {
      inputNameEdit.classList.add('is-invalid')
      err = `<strong><p style="color: red">Nama kategori terlalu pendek</p></strong>`
      inputErr.innerHTML = err
    }else {
      const data = {name: inputNameEdit.value}
      updateCategory(id, data);
      document.querySelector('.close').click();
    }
  }
  if(e.target.classList.contains('btn-delete')){
    const name = e.target.dataset.name;
    Swal.fire({
                title: "Hapus Toping",
                text: "Apakah anda yakin menghapus toping "+name+"?",
                type: "warning",
                showCancelButton: !0,
                cancelButtonText: "Batal",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Hapus"
            }).then(t => {
              if(t.value){
                deleteToping(id, name);
                getToping();
              }
            })
  }
})

async function updateUIDetail(data){
    const modalBody = document.querySelector('.modal-body');
    const categories = await getCategory();
    const topDetail = await showToping(data, categories);
    modalBody.innerHTML = topDetail
    priceEdit = document.querySelector('.price-edit');
    priceEdit.addEventListener('keyup', function(e){
      priceEdit.value = formatRupiah(this.value);
    });
}


  function showTable(t, no){
    return ` <tr>
         <td>${no}</td>
         <td>${t.name}</td>
         <td>${t.category}</td>
         <td>Rp. ${rupiah(t.price)}</td>
         <td>
         <button type="button" data-id="${t.id}" data-toggle="modal" data-target=".bs-example-modal-sm" class="btn-edit btn btn-warning btn-xs waves-effect waves-light">
         Edit
         </button>
         <button type="button" data-id="${t.id}" data-name="${t.name}" class="btn-delete btn btn-danger btn-xs waves-effect waves-light">
         Hapus
         </i></button>
         </td>
     </tr>`
  };

  function getCategory(){
    return fetch(url+'api/category').then(res => res.json()).then(res => res.data);
  }

  function showToping(t, categories){
    return `<div class="row">
      <div class="col-8">
          <div class="form-group">
              <input type="text" class="name-edit form-control" id="field-1" placeholder="" value="${t.name}">
          </div>
          <div class="input-error-edit"></div>
      </div>
      <div class="col-8">
          <div class="form-group">
              <input type="text" class="price-edit form-control" id="field-1" placeholder="" value="${rupiah(t.price)}">
          </div>
          <div class="input-error-edit"></div>
      </div>
      <div class="col-8">
          <div class="form-group">
          <select class="category-edit custom-select">
          ${categories.map(c => {
            return `<option value="${c.id}" ${t.category_id == c.id ? 'selected' : ''}>${c.name}</option>`
          }).join("")}
          </select>
          </div>
          <div class="input-error-edit"></div>
      </div>
      <div class="col-4 pull-right">
          <div class="form-group">
          <button type="button" data-id="${t.id}" class="btn-form-edit btn btn-warning waves-effect waves-light">
          Edit
          </button>
          </div>
      </div>
  </div>`
  }

  function updateUI(categories){
    let tr = ``;
    let no = 1;
    categories.forEach(c => {
      tr += showTable(c,no)
      no++
    });
    const categoryTable = document.querySelector(".category-table");
    categoryTable.innerHTML = tr
  }

  function rupiah(angka){
    var reverse = angka.toString().split('').reverse().join(''),
    ribuan = reverse.match(/\d{1,3}/g);
    ribuan = ribuan.join('.').split('').reverse().join('');
    return ribuan;
  }

  inputPrice.addEventListener('keyup', function(e){
    inputPrice.value = formatRupiah(this.value);
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

  getToping();
