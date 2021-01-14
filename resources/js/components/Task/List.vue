<template>
  <div>

	<div class="row mb-3">
		<div class="col-md-12">
			<b-button
				variant="primary"
				v-b-modal.new-task-modal
				class="float-right ml-2"
				><i class="fas fa-plus"></i> Nova tarefa
			</b-button>
			<b-button 
				variant="outline-primary"
				v-b-toggle.filters-collapse
				class="float-right"
				><i class="fas fa-filter"></i> Filtros
			</b-button>
		</div>
	</div>
		
	<div class="row">
		<div class="col-md-12">
			<b-collapse id="filters-collapse" class="mb-3">
				<b-card>
					<TaskFilters
						@filter="getTasks"
					></TaskFilters>
				</b-card>
			</b-collapse>
		</div>
	</div>

    <TaskFormModal
		@reloadTable="getTasks"
		@setTaskId="setTaskId"
		:taskId="taskId"
	></TaskFormModal>

    <b-table 
		id="tasks-table" 
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
		<template #cell(cod_custom)="data">
			<span :class="getTdClassByStatus(data.item.status)">{{data.item.cod}}</span>
        </template>
		<template #cell(title_custom)="data">
			<span :class="getTdClassByStatus(data.item.status)">{{data.item.title}}</span>
        </template>
		<!-- <template #cell(description_custom)="data">
			<span :class="getTdClassByStatus(data.item.status)">{{data.item.description}}</span>
        </template> -->
		<template #cell(created_custom)="data">
			<span :class="getTdClassByStatus(data.item.status)">{{data.item.created}}</span>
        </template>
		<template #cell(status_custom)="data">
			<span class="badge badge-pill text-uppercase" :class="getStatusClass(data.item.status)" >{{getStatusText(data.item.status)}}</span>
        </template>
		<template #cell(actions)="data">
			<b-button
				v-if="!isStatusArchived(data.item.status) && !isStatusConcluded(data.item.status)"
				@click="concludeTask(data.item.id)"
				variant="success"
				class="btn-sm"
				title="Concluir"
				><i class="fas fa-check"></i>
			</b-button>
			<b-button
				v-if="!isStatusArchived(data.item.status)"
				@click="setTaskId(data.item.id)"
				variant="primary"
				v-b-modal.new-task-modal
				class="btn-sm"
				title="Editar"
				><i class="far fa-edit"></i>
			</b-button>
			<b-button
				v-if="!isStatusArchived(data.item.status) && !isStatusConcluded(data.item.status)"
				@click="archiveTask(data.item.id)"
				variant="warning"
				class="btn-sm"
				title="Arquivar"
				><i class="fas fa-archive"></i>
			</b-button>
			<b-button
				v-if="isStatusArchived(data.item.status)"
				@click="activeTask(data.item.id)"
				variant="success"
				class="btn-sm"
				title="Desarquivar"
				><i class="fas fa-archive"></i>
			</b-button>
		</template>
	</b-table>

	<b-pagination
		v-model="currentPage"
		:total-rows="rows"
		:per-page="perPage"
      	aria-controls="tasks-table"
    ></b-pagination>

  </div>
</template>

<script>
import TaskFormModal from './Form';
import TaskFilters from './Filters';
export default {
	components: {TaskFormModal, TaskFilters},
	data() {
		return {
			currentPage: 1,
			perPage: 10,
			fields: [
				{
					key: 'cod_custom', 
					label: 'Código'
				},
				{
					key: 'title_custom', 
					label: 'Título'
				},
				// {
				// 	key: 'description_custom',
				// 	label: 'Descrição'
				// },
				{
					key: 'created_custom', 
					label: 'Data de cadastro'
				},
				{
					key: 'status_custom',
					label: 'Situação'
				},
				{
					key: 'actions',
					label: 'Ações',
					tdClass: 'no_wrap'
				}, 
			],
			items: [],
			taskId: null,
			loading: false
		};
	},
	computed: {
		rows() {
			return this.items.length;
		}
    },
	mounted() {
		this.getTasks();
	},
	methods: {
		getTasks(filters = []) {
			this.loading = true;
			axios.post('/api/task/list', filters)
				.then(res => {
					this.items = res.data.data;
					this.loading = false;
				}).catch(err => {
					this.makeToast('Erro!', 'Houve um problema ao tentar carregar os dados!', 'danger');
					this.loading = false;
				})
		},
		setTaskId(id) {
			this.taskId = id;
		},
		concludeTask(id) {
			this.$bvModal.msgBoxConfirm('Deseja mesmo concluir esta tarefa?', {
				title: 'Confirme antes de prosseguir',
				size: 'sm',
				buttonSize: 'sm',
				okVariant: 'success',
				okTitle: 'Confirmar',
				cancelTitle: 'Cancelar',
				footerClass: 'p-2',
				hideHeaderClose: false,
				centered: true
			})
			.then(value => {
				if(value) {
					axios.post('/api/task/conclude/'+id)
						.then(res => {
							this.getTasks();
							this.makeToast('Sucesso!', 'Dados salvos com sucesso!', 'success');
						}).catch(err => {
							this.makeToast('Erro! '+err.response.status, err.response.data.message, 'danger');
						})
				}
			})
		},
		archiveTask(id) {
			this.$bvModal.msgBoxConfirm('Deseja mesmo arquivar esta tarefa?', {
				title: 'Confirme antes de prosseguir',
				size: 'sm',
				buttonSize: 'sm',
				okVariant: 'warning',
				okTitle: 'Confirmar',
				cancelTitle: 'Cancelar',
				footerClass: 'p-2',
				hideHeaderClose: false,
				centered: true
			})
			.then(value => {
				if(value) {
					axios.post('/api/task/archive/'+id)
					.then(res => {
						this.getTasks();
						this.makeToast('Sucesso!', 'Dados salvos com sucesso!', 'success');
					}).catch(err => {
						this.makeToast('Erro! '+err.response.status, err.response.data.message, 'danger');
					})
				}
			})
		},
		activeTask(id) {
			this.$bvModal.msgBoxConfirm('Deseja mesmo dearquivar esta tarefa?', {
				title: 'Confirme antes de prosseguir',
				size: 'sm',
				buttonSize: 'sm',
				okVariant: 'warning',
				okTitle: 'Confirmar',
				cancelTitle: 'Cancelar',
				footerClass: 'p-2',
				hideHeaderClose: false,
				centered: true
			})
			.then(value => {
				if(value) {
					axios.post('/api/task/active/'+id)
					.then(res => {
						this.getTasks();
						this.makeToast('Sucesso!', 'Dados salvos com sucesso!', 'success');
					}).catch(err => {
						this.makeToast('Erro! '+err.response.status, err.response.data.message, 'danger');
					})
				}
			})
		},
		isStatusArchived(status) {
			return status == 3;
		},
		isStatusConcluded(status) {
			return status == 2;
		},
		getTdClassByStatus(status) {
			switch(status) {
				case 2:
					return 'line_through';
				case 3:
					return 'dark_gray';
				default:
					return '';
			}
		},
		getStatusText(status) {
			switch (status) {
				case 1:
					return 'Ativa';
				case 2:
					return 'Concluída';
				case 3:
					return 'Arquivada';
				default:
					return '';
			}
		},
		getStatusClass(status) {
			switch (status) {
				case 1:
					return 'badge-primary';
				case 2:
					return 'badge-success';
				case 3:
					return 'badge-warning';
				default:
					return '';
			}
		},
	}
};
</script>

<style>
	.no_wrap {
		white-space: nowrap;
	}
	.line_through {
		text-decoration: line-through;
	}
	.dark_gray {
		color: darkgray;
	}
</style>