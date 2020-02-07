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
                    <form class="form-inline">
                        <div class="form-group">
                            <input type="search" class="form-control" id="inputPassword2" placeholder="Cari">
                        </div>
                        <div class="form-group mx-sm-3">
                            <select class="category-select custom-select">
                                <option selected="">Semua</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4">
                    <div class="text-lg-right mt-3 mt-lg-0">
                        <a href="javascript: void(0);" class="btn btn-info waves-effect waves-light"><i class="mdi mdi-plus-circle mr-1"></i>Tambah</a>
                    </div>
                </div><!-- end col-->
            </div> <!-- end row -->
        </div> <!-- end card-box -->
    </div> <!-- end col-->
</div>
<!-- end row-->

<div class="product-container row">

</div>
<!-- end row-->

<div class="row">
    <div class="col-12">
        <ul class="pagination pagination-rounded justify-content-center mb-3">
            <li class="page-item">
                <button class="prev-page page-link" data-num="1" aria-label="Previous"><span class="prev-page" aria-hidden="true">«</span></button>
            </li>
            <ul class="number-paginate pagination">
            </ul>
            <li class="page-item">
                <button class="next-page page-link" data-num="1"><span class="next-page" aria-hidden="true">»</span></button>
            </li>
        </ul>
    </div> <!-- end col-->
</div>
<script>
const urlImages = url+"images/";
const productContainer = document.querySelector('.product-container');
const numberPaginate = document.querySelector('.number-paginate');
const selectCategory = document.querySelector('.category-select');
const nextPage = document.querySelector('.next-page');
const prevPage = document.querySelector('.prev-page');


function getProduct(){
    return fetch(url+'api/product').then(res => res.json())
    .then(res => {
      updateUI(res);
      paginate(res.paginate);
    });
}

function getCategory(){
  return fetch(url+'api/category').then(res => res.json())
  .then(res => {
    let option = `<option value="" selected="">Semua</option>`;
    res.data.forEach(c => {
      option += showCategory(c);
    })
    selectCategornerHTML = option
  })
}


function paginateNumber(page){
  return fetch(url+'api/product?page='+page).then(res => res.json())
  .then(res => res)
}

function updateUI(products){
  let container = ``;
  products.data.forEach(p => container += showProduct(p))
  productContainer.innerHTML = container
}

function paginate(p){
  let firstPage = 1;
  let lastPage = 0;
  let num;
  lastPage = p.last_page;
  if(lastPage >= 5){
    lastPage = 5
  }
  for (firstPage; firstPage <= lastPage; firstPage++) {
    numberPaginate.innerHTML += showNumberPaginate(firstPage)
  }
  const pages = Array.from(document.querySelectorAll('.page-number'));
  if(p.first_page == 1){
    pages[0].classList.add("active")
  }

  nextPage.addEventListener('click', async function(){
    const pageLink = await paginateNumber(num+1);
    if(pageLink.paginate.current_page > 5){
      firstPage = lastPage-4;
      lastPage = pageLink.paginate.last_page;
      for (firstPage; firstPage <= lastPage; firstPage++) {
        numberPaginate.innerHTML = showNumberPaginate(firstPage)
      }
    }
    if(pageLink.paginate.next_page){
      updateUI(pageLink);
      num = pageLink.paginate.current_page
      if (num == pageLink.paginate.current_page) {
        pages.forEach(p => p.classList.remove("active"))
        pages[num-1].classList.add("active");
      }
    }
  })

  prevPage.addEventListener('click', async function(){
    const pageLink = await paginateNumber(num-1);
    updateUI(pageLink);
    num = pageLink.paginate.current_page
    if (num == pageLink.paginate.current_page) {
      pages.forEach(p => p.classList.remove("active"))
      pages[num-1].classList.add("active");
      }
  })

  pages.forEach(button => {
    button.addEventListener('click', async function(e){
      const page = e.target.dataset.link;
      const pageLink = await paginateNumber(page);
      updateUI(pageLink);
      num = pageLink.paginate.current_page;
      if (page == pageLink.paginate.current_page) {
        pages.forEach(p => p.classList.remove("active"))
        pages[page-1].classList.add("active");
      }
    })
  })

}


function showNumberPaginate(i){
  return `<li class="page-number page-item" data-number="${i}">
  <button class="page-link" data-link="${i}" href="javascript: void(0);">${i}</button>
  </li>`
}

function showCategory(c){
  return `<option value="${c.id}">${c.name}</option>`
}

function showProduct(p){
  return `<div class="col-md-6 col-xl-3">
      <div class="card-box product-box">
          <div class="product-action">
              <a href="javascript: void(0);" class="btn btn-success btn-xs waves-effect waves-light"><i class="mdi mdi-pencil"></i></a>
              <a href="javascript: void(0);" class="btn btn-danger btn-xs waves-effect waves-light"><i class="mdi mdi-close"></i></a>
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
</script>
@endsection
