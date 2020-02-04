const inputSearch = document.getElementById("search");
// const url = "http://localhost:8000/";
const url = "https://juice-apps.herokuapp.com/"
const addCategory = document.querySelector('.btn-add');
const inputCategory = document.querySelector('.input-add');
const apiToken = document.querySelector('.api-token').dataset.token;

function getCategory(){
  fetch(url+'api/category').then(res => res.json()).then(res => updateUI(res.data));
}

function getCategoryDetail(id){
  return fetch(url+'api/category/'+id, {
    headers: { 'Authorization' : 'Bearer '+apiToken }
  })
  .then(res => res.json()).then(res => res.data);
}

function storeCategory(data){
  return fetch(url+'api/category', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json',
    'Authorization' : 'Bearer '+apiToken
  },
    body: JSON.stringify(data)
  }).then(res => res.json())
  .then(res => {
    const success = "Kategori "+data.name+" berhasil ditambahkan";
    if(res.status){
      Swal.fire({ title: "Berhasil",text: success,type: "success"})
      getCategory()
    }else {
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
      getCategory()
    }else {
      Swal.fire({ title: "Gagal",text: res.errors,type: "error"})
    }
  })
}

function searchCategory(keyword){
  return fetch(url+'api/category/search/'+keyword).then(res => res.json())
  .then(res => res.data);
}

function deleteCategory(id, name){
  return fetch(url+'api/category/'+id, {
    method: 'DELETE',
    headers: { 'Authorization' : 'Bearer '+apiToken },
  }).then(res => res.json())
  .then(res => {
    // console.log(res);
    const success = "Kategori "+name+" berhasil dihapus";
    if(res.status){
      Swal.fire({ title: "Berhasil",text: success,type: "success"})
      getCategory()
    }else {
      Swal.fire({ title: "Gagal",text: res.errors,type: "error"})
    }
  })
}

addCategory.addEventListener('click', function(){
  const inputErr = document.querySelector('.input-error');
  let err;
  if(inputCategory.value == ''){
    inputCategory.classList.add('is-invalid')
    err = `<strong><p style="color: red">Masukan nama kategori</p></strong>`
    inputErr.innerHTML = err
  }else if(inputCategory.value.length < 3) {
    inputCategory.classList.add('is-invalid')
    err = `<strong><p style="color: red">Nama kategori minimal 3 huruf</p></strong>`
    inputErr.innerHTML = err
  }
  else {
    const data = {name: inputCategory.value}
    storeCategory(data);
    inputCategory.classList.remove('is-invalid')
    inputCategory.value = ''
    inputErr.innerHTML = ''
  }
})

inputSearch.addEventListener('change', async function(){
  const keyword = inputSearch.value;
  if (keyword) {
    const searchData = await searchCategory(keyword);
    return updateUI(searchData);
  }else {
    return getCategory()
  }
})

document.addEventListener('click', async function(e){
  let modalTitle = document.querySelector('.modal-title');
  const id = e.target.dataset.id;
  if(e.target.classList.contains('btn-edit')){
    const categoryDetail = await getCategoryDetail(id);
    updateUIDetail(categoryDetail);
    modalTitle.innerHTML = "Edit Kategori"
  }
  if(e.target.classList.contains('btn-form-edit')){
    const inputNameEdit = document.querySelector('.name-edit');
    const inputErr = document.querySelector('.input-error-edit');
    let err;
    if(inputNameEdit.value == ''){
      inputNameEdit.classList.add('is-invalid')
      err = `<strong><p style="color: red">Masukan nama kategori</p></strong>`
      inputErr.innerHTML = err
    }

    if(inputNameEdit.value.length < 3) {
      inputNameEdit.classList.add('is-invalid')
      err = `<strong><p style="color: red">Nama kategori minimal 3 huruf</p></strong>`
      inputErr.innerHTML = err
    }else {
      const data = {name: inputNameEdit.value}
      updateCategory(id, data);
    }
  }
  if(e.target.classList.contains('btn-delete')){
    const name = e.target.dataset.name;
    Swal.fire({
                title: "Hapus Kategori",
                text: "Apakah anda yakin menghapus kategori "+name+"?",
                type: "warning",
                showCancelButton: !0,
                cancelButtonText: "Batal",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Hapus"
            }).then(t => {
              deleteCategory(id, name);
              getCategory();
            })
  }
})

function updateUIDetail(data){
    const catDetail = showCategory(data);
    const modabBody = document.querySelector('.modal-body');
    modabBody.innerHTML = catDetail
}


  function showTable(c, no){
    return ` <tr>
         <td>${no}</td>
         <td>${c.name}</td>
         <td>
         <button type="button" data-id="${c.id}" data-toggle="modal" data-target=".bs-example-modal-sm" class="btn-edit btn btn-warning btn-sm waves-effect waves-light">
         Edit
         </button>
         <button type="button" data-id="${c.id}" data-name="${c.name}" class="btn-delete btn btn-danger btn-sm waves-effect waves-light">Hapus</i></button>
         </td>
     </tr>`
  };

  function showCategory(c){
    return `<div class="row">
      <div class="col-8">
          <div class="form-group">
              <input type="text" class="name-edit form-control" id="field-1" placeholder="" value="${c.name}">
          </div>
          <div class="input-error-edit"></div>
      </div>
      <div class="col-4 pull-right">
          <div class="form-group">
          <button type="button" data-id="${c.id}" data-dismiss="modal" class="btn-form-edit btn btn-warning waves-effect waves-light">
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

  getCategory();
