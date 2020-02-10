
const urlImages = url+"images/";
const productContainer = document.querySelector('.product-container');
const numberPaginate = document.querySelector('.number-paginate');
const selectCategory = document.querySelector('.category-select');
const paginationContainer = document.querySelector('.pagination');
const pageCount = document.querySelector('.page-count');
const productSearch = document.querySelector('.product-search');

let num = 1;

function getProduct(){
    return fetch(url+'api/admin/product').then(res => res.json())
    .then(res => {
      if(res.data.length > 0){
        updateUI(res)
        const pc = `<strong>${res.paginate.current_page} dari ${res.paginate.last_page} halaman</strong>`;
        pageCount.innerHTML = pc
        if(res.paginate.last_page > 1){
          paginationContainer.innerHTML = showPagination()
        }
      }else{
        const noProduct = `<div class="col-12 text-center mt-5">
        <h3><b>Belum ada produk</b></h3>
        </div>`
        productContainer.innerHTML = noProduct
        pageCount.innerHTML = ''
        paginationContainer.innerHTML = ''
      }
    });
}

function getCategory(){
  return fetch(url+'api/category').then(res => res.json())
  .then(res => {
    let option = `<option value="all">Semua</option>`;
    res.data.forEach(c => {
      option += showCategory(c);
    })
    selectCategory.innerHTML = option
  })
}

function getProductCategory(id){
  return fetch(url+'api/admin/product/category/'+id).then(res => res.json())
  .then(res => {
    if(res.data.length > 0){
      updateUI(res)
      const pc = `<strong>${res.paginate.current_page} dari ${res.paginate.last_page} halaman</strong>`;
      pageCount.innerHTML = pc
      paginationContainer.innerHTML = ''
      if(res.paginate.last_page > 1){
        paginationContainer.innerHTML = showPagination()
      }
    }else{
      const noProduct = `<div class="col-12 text-center mt-5">
      <h3><b>Tidak ada produk</b></h3>
      </div>`
      productContainer.innerHTML = noProduct
      pageCount.innerHTML = ''
      paginationContainer.innerHTML = ''
    }
  });
}


function paginateNumber(page){
  return fetch(url+'api/admin/product?page='+page).then(res => res.json())
  .then(res => res)
}

function searchProduct(keyword){
  return fetch(url+'api/admin/product/search/'+keyword).then(res => res.json())
  .then(res => {
    if(res.data.length > 0){
      updateUI(res)
      const pc = `<strong>${res.paginate.current_page} dari ${res.paginate.last_page} halaman</strong>`;
      pageCount.innerHTML = pc
      paginationContainer.innerHTML = ''
      if(res.paginate.last_page > 1){
        paginationContainer.innerHTML = showPagination()
      }
    }else{
      const noProduct = `<div class="col-12 text-center mt-5">
      <h3><b>Produk tidak ditemukan</b></h3>
      </div>`
      productContainer.innerHTML = noProduct
      pageCount.innerHTML = ''
      paginationContainer.innerHTML = ''
    }
  });
}

function updateUI(products){
  let container = ``;
  products.data.forEach(p => container += showProduct(p))
  productContainer.innerHTML = container
}

selectCategory.addEventListener('change', async function(){
  console.log(selectCategory.value);
  if(selectCategory.value == 'all'){
    getProduct()
  }else {
    await getProductCategory(selectCategory.value)
  }
})

productSearch.addEventListener('change', async function(){
  if(productSearch.value == ''){
    getProduct()
  }else{
    await searchProduct(productSearch.value)
  }
})

async function nextPage(){
  const pageLink = await paginateNumber(num+1);
  if(pageLink.data.length > 0){
    num = pageLink.paginate.current_page
    updateUI(pageLink);
    const pc = `<strong>${pageLink.paginate.current_page} dari ${pageLink.paginate.last_page} halaman</strong>`;
    pageCount.innerHTML = pc
  }
}

async function prevPage(){
  const pageLink = await paginateNumber(num-1);
    num = pageLink.paginate.current_page
    updateUI(pageLink);
    const pc = `<strong>${pageLink.paginate.current_page} dari ${pageLink.paginate.last_page} halaman</strong>`;
    pageCount.innerHTML = pc
}

function showCategory(c){
  return `<option value="${c.id}">${c.name}</option>`
}

function showPagination(){
  return `<li class="page-item">
      <button class="page-link" onclick="prevPage()"><span>«</span></button>
  </li>
  <li class="page-item">
      <button class="page-link" onclick="nextPage()"><span>»</span></button>
  </li>`
}

function showProduct(p){
  return `<div class="col-md-6 col-xl-3">
      <div class="card-box product-box">
          <div class="product-action">
              <button onclick="window.location='/kategori'" class="btn-edit btn btn-success btn-xs waves-effect waves-light"><i class="mdi mdi-pencil"></i></button>
              <button onclick="window.location='/kategori'" class="btn btn-danger btn-xs waves-effect waves-light"><i class="mdi mdi-close"></i></button>
          </div>

          <div>
              <img src="${urlImages}${p.image}" alt="product-pic" width="270px" height="230px" />
          </div>

          <div class="product-info">
              <div class="row align-items-center">
                  <div class="col">
                      <h5 class="font-16 mt-0 sp-line-1 text-dark">${p.name}</h5>
                      <h5 class="m-0"> <span class="text-muted">${p.category}</span></h5>
                  </div>
                  <div class="col">
                      <div class="product-price-tag">
                          Rp. ${rupiah(p.price)}
                      </div>
                  </div>
              </div> <!-- end row -->
          </div> <!-- end product info-->
      </div> <!-- end card-box-->
  </div> <!-- end col-->`
}

function rupiah(angka){
  var reverse = angka.toString().split('').reverse().join(''),
  ribuan = reverse.match(/\d{1,3}/g);
  ribuan = ribuan.join('.').split('').reverse().join('');
  return ribuan;
}

getCategory()
getProduct()
