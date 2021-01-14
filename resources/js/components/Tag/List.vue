<template>
  <div>

	<div class="row mb-3">
		<div class="col-md-12">
			<b-button
				variant="primary"
				v-b-modal.new-tag-modal
				class="float-right ml-2"
				><i class="fas fa-plus"></i> Nova categoria
			</b-button>
		</div>
	</div>

    <TagFormModal
		@reloadTable="getTags"
		@setTagId="setTagId"
		:tagId="tagId"
		:viewMode="viewMode"
	></TagFormModal>

    <b-table 
		id="tags-table" 
		striped 
		hover 
		:items="items" 
		:fields="fields" 
		:busy="loading"
		:per-page="perPage"
		:current-page="currentPage"
		small
	>
		<template #table-busy>
			<div class="text-center my-2">
				<b-spinner class="align-middle"></b-spinner>
				<strong>Carregando...</strong>
			</div>
      	</template>
		<template #cell(status_custom)="data">
			<span>{{getStatusText(data.item.status)}}</span>
        </template>
		<template #cell(actions)="data">
			<b-button
				@click="setTagId(data.item.id, true)"
				variant="success"
				v-b-modal.new-tag-modal
				class="btn-sm"
				title="Visualizar"
				><i class="far fa-eye"></i>
			</b-button>
			<b-button
				@click="setTagId(data.item.id)"
				variant="primary"
				v-b-modal.new-tag-modal
				class="btn-sm"
				title="Editar"
				><i class="far fa-edit"></i>
			</b-button>
			<b-button
				@click="deleteTag(data.item.id)"
				variant="danger"
				class="btn-sm"
				title="Excluir"
				><i class="far fa-trash-alt"></i>
			</b-button>
		</template>
	</b-table>

	<b-pagination
		v-model="currentPage"
		:total-rows="rows"
		:per-page="perPage"
      	aria-controls="tags-table"
    ></b-pagination>

  </div>
</template>

<script>
import TagFormModal from './Form';
export default {
	components: {TagFormModal},
	data() {
		return {
			currentPage: 1,
			perPage: 10,
			fields: [
				{
					key: 'cod', 
					label: 'Código'
				},
				{
					key: 'title', 
					label: 'Título'
				},
				{
					key: 'description',
					label: 'Descrição'
				},
				{
					key: 'created', 
					label: 'Data de cadastro'
				},
				{
					key: 'actions',
					label: 'Ações',
					tdClass: 'no_wrap'
				}, 
			],
			items: [],
			tagId: null,
			loading: false,
			viewMode: false
		};
	},
	computed: {
		rows() {
			return this.items.length;
		}
  	},
	mounted() {
		this.getTags();
	},
	methods: {
		getTags(filters = []) {
			this.loading = true;
			axios.post('/api/tag/list')
				.then(res => {
					this.items = res.data.data;
					this.loading = false;
				}).catch(err => {
					this.makeToast('Erro!', 'Houve um problema ao tentar carregar os dados!', 'danger');
					this.loading = false;
				})
		},
		setTagId(id, viewMode = false) {
			this.tagId = id;
			this.setViewMode(viewMode);
		},
		deleteTag(id) {
			this.$bvModal.msgBoxConfirm('Deseja mesmo excluir esta categoria?', {
				title: 'Confirme antes de prosseguir',
				size: 'sm',
				buttonSize: 'sm',
				okVariant: 'danger',
				okTitle: 'Confirmar',
				cancelTitle: 'Cancelar',
				footerClass: 'p-2',
				hideHeaderClose: false,
				centered: true
			})
			.then(value => {
				if(value) {
					axios.post('/api/tag/delete/'+id)
						.then(res => {
							this.getTags();
							this.makeToast('Sucesso!', 'Categoria excluida com sucesso!', 'success');
						}).catch(err => {
							this.makeToast('Erro!', 'Houve um problema ao tentar excluir a categoria!', 'danger');
						})
				}
			})
		},
		setViewMode(viewMode) {
			this.viewMode = viewMode;
		}
	}
};
</script>
