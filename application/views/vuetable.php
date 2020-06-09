<!doctype html>
<html lang="en">
<head>
   <!-- Required meta tags -->
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">

   <title><?php echo $title ?></title>

   <style>
      .modal-mask {
         position: fixed;
         z-index: 9998;
         top: 0;
         left: 0;
         width: 100%;
         height: 100%;
         background-color: rgba(0, 0, 0, .5);
         display: table;
         transition: opacity .9s ease;
      }

      .modal-wrapper {
         display: table-cell;
         vertical-align: middle;
      }
   </style>

</head>
<body>

<div class="container" id="app">

   <h1 class="text-center my-3">Vue Table Demo</h1>

   <div class="row">
      
      <div class="col">
         <div class="card">
            <div class="card-header">
               <h6 class="card-title mb-0">Produk</h6>
            </div>

            <div class="card-body">

               <div class="form-group mb-4">				
                  <div class="input-group">                
                     <input type="text" class="form-control" v-model="searchFor" @keyup="setFilter" placeholder="Search Something">                    		
                     <span class="input-group-append">
                        <button @click="resetFilter" class="btn btn-primary" type="button">Reset Search</button>
                     </span>
                  </div>
               </div>

               <div :class="[{'data-table': true}, loading]">					
                  <vuetable ref="vuetable"
                     api-url="<?php echo site_url('vuetable/product_data/') ?>"
                     :fields="columns"
                     pagination-path=""
                     :sort-order="sortOrder"
                     :per-page="perPage"
                     :append-params="moreParams"                        
                     @vuetable:cell-clicked="onCellClicked"
                     @vuetable:load-success="onLoadSuccess"                     
                     :css="css.table"
                     track-by="barang_kode"
                     @vuetable:pagination-data="onPaginationData"
                     @vuetable:loading="showLoader"
                     @vuetable:loaded="hideLoader">

                     <template slot="actions" slot-scope="props">
                           <div class="btn-group">					
                              <button class="btn btn-warning btn-xs" @click="edit(props.rowData)">Edit</button>			
                              <button class="btn btn-primary btn-xs" @click="del(props.rowData)">Delete</button>                        
                           </div>
                     </template>
                     
                  </vuetable>					
               </div>
         
               <div class="data-table-pagination text-center">
                  <vuetable-pagination-info ref="paginationInfo"
                     :info-template="paginationInfoTemplate">
                  </vuetable-pagination-info>
                  <vuetable-pagination ref="pagination"
                     @vuetable-pagination:change-page="onChangePage"
                     :css="css.pagination">
                  </vuetable-pagination>			
               </div>

            </div>

         </div>

         
               
      </div>
   </div>

<!-- Show Modal -->	
<div v-if="showModal">
   <transition name="modal fade">
      <div class="modal-mask">
         <div class="modal-wrapper">
            <div class="modal-dialog">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title"><strong>{{ modalTitle }}</strong>?</h5>
                  </div>
                  <form action="">
                  <div class="modal-body">
                     
                     <form action="">

                        <div class="form-group">
                           <label>Kode</label>
                           <input type="text" class="form-control" v-model="field.barang_kode" placeholder="Kode">
                        </div>
                        <div class="form-group">
                           <label>Nama</label>
                           <input type="text" class="form-control" v-model="field.barang_nama" placeholder="Nama Barang">
                        </div>
                        <div class="form-group">
                           <label>Harga</label>
                           <input type="text" class="form-control" v-model="field.barang_harga" placeholder="Harga Barang">
                        </div>

                     </form>

                     
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-secondary rounded-0" @click="showModal = false">Cancel</button>
                     <button type="submit" class="btn btn-primary rounded-0">{{ custom.label }}</button>
                  </div>
                  </form>
                  
               </div>
            </div>
         </div>
      </div>
   </transition>
</div>	
<!-- /Show Modal -->

</div>

<!-- Script dari starter template Bootstrap 4 -->   
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<!-- /Script dari starter template Bootstrap 4 -->

<!-- Script untuk Vuetable (vuejs, axios, vuetable-2, sweetalert untuk modal) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/df-number-format/2.1.6/jquery.number.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://unpkg.com/vuetable-2@next"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<!-- /Script untuk Vuetable -->

<script>
Vue.use(Vuetable);
var vm = new Vue({
	el: '#app',	
	data: {
		custom: {
			button: 'btn btn-primary btn-lg',
			label: 'Save',
			cardBorder: 'card'
		},
		field: {
			barang_kode: '',
			barang_nama: '',
			barang_harga: ''
		},
      showModal: false,
      modalTitle: '',
		loading: '',
		searchFor: '',
		columns: [
			{
				name: 'barang_kode',
				title: 'Product Code',
				sortField: 'barang_kode'
			},			
         {
				name: 'barang_nama',
				title: 'Nama Barang',
				sortField: 'barang_nama'
			},
         {
				name: 'barang_harga',
				title: 'Harga',
				sortField: 'barang_harga'
			},
         {
				name: 'kategori_nama',
				title: 'Kategori',			
            sortField: 'kategori_nama'
			},         
			{
				name: 'actions',
				title: 'Actions',
			}
		],		
		moreParams: [],
		sortOrder: [{
			field: 'barang_kode',
			direction: 'asc'
		}],				
		css: {
			table: {
				tableClass: 'table table-xs',
				ascendingIcon: 'lnr lnr-chevron-up',
				descendingIcon: 'lnr lnr-chevron-down',
				detailRowClass: 'detail-row',
			},		
			pagination: {
				wrapperClass: "btn-group",
				activeClass: "active",
				disabledClass: "disabled",
				pageClass: "btn btn-outline-light btn-xs",
				linkClass: "btn btn-outline-light btn-xs",
				icons: {
					first: "lnr lnr-chevron-left-circle",
					prev: "lnr lnr-chevron-left",
					next: "lnr lnr-chevron-right",
					last: "lnr lnr-chevron-right-circle"
				}
			}
		},
		//paginationComponent: 'vuetable-pagination',
		perPage: 15,
		paginationInfoTemplate: '<strong>Showing record</strong> {from} to {to} from {total} item(s)',
		
	},	
	methods: {		
		resetForm(){
			this.field.barang_kode = '';
			this.field.barang_nama = '';
			this.field.barang_harga = '';
			this.custom.button = 'btn btn-primary btn-lg';
			this.custom.label = 'Save';
			this.custom.cardBorder = 'card';
		},

		setFilter () {
			this.moreParams = {
				'filter': this.searchFor
			}
			this.$nextTick(function() {
				this.$refs.vuetable.refresh()
			})
		},
		
		formatNumber(value, fmt) {
			if (value == null) return ''
			return $.number(value, fmt)
		},
				
		resetFilter () {
			this.searchFor = ''
			this.setFilter()
		},
		showLoader () {
			this.loading = 'loading'
		},
		hideLoader () {
			this.loading = ''
		},

		edit(rowData){         
         this.showModal = true;
         console.log(this.showModal);
			this.field.barang_kode = rowData.barang_kode;
			this.field.barang_nama = rowData.barang_nama;
			this.field.barang_harga = rowData.barang_harga;
         this.modalTitle = rowData.barang_nama;
			this.custom.button = 'btn btn-warning btn-lg';
			this.custom.label = 'Update';
			this.custom.cardBorder = 'card border-warning'
		},
												
		del(rowData){
			axios.get('{{ site_url("room/delete/") }}' + rowData.id)
			.then(function(res){	
				let data = res.data
				swal.fire({
					title: data.response.title,   
					text: data.response.message, 
					icon: data.response.type,                        
					onClose: function(){
						vm.$refs.vuetable.reload();	
					}
				})
			})
			.catch(function(error){
				console.log(error)
				// swal.fire({
				// 	title: 'Internal Error',   
				// 	text: 'Sorry Interal Server Error', 
				// 	icon: 'error',                        
				// 	onClose: function(){
				// 		this.$refs.vuetable.reload();	
				// 	}
				// })
			});
		},			
		
		onPaginationData (tablePagination) {
			this.$refs.paginationInfo.setPaginationData(tablePagination)
			this.$refs.pagination.setPaginationData(tablePagination)
		},
		onChangePage (page) {
			console.log(page)
			this.$refs.vuetable.changePage(page)
		},
		
		onInitialized (fields) {
			console.log('onInitialized', fields)
			this.vuetableFields = fields
		},
		
		onCellClicked (data, field, event) {
			console.log('cellClicked: ', data.data.barang_kode)
			//this.$refs.vuetable.toggleDetailRow(data.data.id)
		},
		
		onLoadSuccess (response) {
			//console.log('Loaded: ', response)
			//this.$refs.vuetable.showDetailRow()
		},		
		
		onDataReset () {
			console.log('onDataReset')
			this.$refs.paginationInfo.resetData()
			this.$refs.pagination.resetData()
		},
		
	},
	
})
</script>

</body>
</html>