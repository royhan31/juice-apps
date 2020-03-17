@extends('templates.default')

@section('content')
<div class="row">
 <div class="col-12">
     <div class="page-title-box">
         <h4 class="page-title">Laporan</h4>
     </div>
 </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card-box">
      <div class="row">
        <div class="col-12">
          <h4 class="header-title mb-5">Tabel Laporan</h4>
             <div class="table-responsive">
                 <table class="table mb-0" >
                     <thead>
                     <tr>
                         <th></th>
                         <th>No</th>
                         <th>Nama Pembeli</th>
                         <th>Tanggal</th>
                         <th>Total Produk</th>
                         <th>Total Harga</th>
                     </tr>
                     </thead>
                     <tbody id="order-table">

                     </tbody>
                 </table>
             </div> <!-- end table-responsive-->
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  // console.log(url);
  const order = fetch(url+'api/admin/order').then(res => res.json()).then(res => res.data);
  const orderTable = document.querySelector('#order-table');

  async function showData(){
    const orderData = await order
    let rowTable = ``;
    orderData.map((o, i) => {
      rowTable += showRow(o,i)
    })
  orderTable.innerHTML = rowTable
  const info = document.querySelectorAll('#info');
  const childInfo = document.querySelectorAll('.table-info');
  if(info !== null){
    [...info].map(i => {
      i.addEventListener('click', function(){
        const row = [...childInfo].map(c => c).filter(c => c.dataset.id === i.dataset.id);
        const rowHidden = [...childInfo].map(c => c).filter(c => c.dataset.id !== i.dataset.id);
        const autoHidden = [...info].map(i => i).filter(i => i.dataset.id !== this.dataset.id)
        autoHidden.map(a => {
          a.classList.remove('fe-minus-circle');
          a.classList.add('fe-plus-circle');
          a.style.color = 'green';
          rowHidden.map(r => r.style.display = 'none')
        })
        if(i.classList[0] === 'fe-plus-circle'){
          this.classList.remove('fe-plus-circle');
          this.classList.add('fe-minus-circle');
          this.style.color = 'red';
          row.map(r => r.style.display = '')
        }else{
          this.classList.remove('fe-minus-circle');
          this.classList.add('fe-plus-circle');
          this.style.color = 'green';
          row.map(r => r.style.display = 'none')
        }
      })
    })
  }
  }

  function getDate(d){
    const created_at = new Date(d);
    return created_at.toLocaleString("id-ID", {timeZone: "Asia/Jakarta"})
  }

  function priceTotalProducts(products){
    const priceProduct = products.map(p => p.price).reduce((a, b) => a+b, 0);
    const topings = products.map((p, i) => p.topings).filter(t => t.length > 0).map(t => t);
    const priceToping = topings.map(t => {
      let price = t.map(t => t.price).reduce((a,b) => a + b)
      return price
    }).reduce((a,b) => a + b);
    return priceProduct+priceToping
  }

  function priceTotalToping(p,t){
    if(t.length > 0){
      let total = t.map(t => t.price).reduce((a,b) => a+b)
      return total
    }else {
      return 0
    }

  }

  function showRow(o,i) {
    return `<tr>
     <th width="30"> <i id="info" style="color: green" data-id="${i}" class="fe-plus-circle"></i> </th>
       <th scope="row">${i+1}</th>
       <td>${o.name}</td>
       <td>${getDate(o.created_at)}</td>
       <td>${o.products.length}</td>
       <td><b>Rp. ${rupiah(priceTotalProducts(o.products))}</b></td>
       </tr> ${childRow(o.products, i)}`
  }

  function rupiah(angka){
    var reverse = angka.toString().split('').reverse().join(''),
    ribuan = reverse.match(/\d{1,3}/g);
    ribuan = ribuan.join('.').split('').reverse().join('');
    return ribuan;
  }

  function childRow(products, i){
    let row = ``;
    products.map(p => {
        row += showChildRow(p, i);
    })
    return row
  }

  function showChildRow(p, i){
    return `<tr class="table-info" data-id="${i}" style="display: none">
    <th scope="row"></th>
    <th scope="row">${p.name}</th>
    <th scope="row">${p.price}</th>
    <td colspan="2">${p.topings.map(t => `${t.name} ${t.price}`)}</td>
    <td>Rp. ${rupiah(priceTotalToping(p, p.topings) + p.price)}</td>
    </tr>`
  }



  showData()
   </script>
@endsection
