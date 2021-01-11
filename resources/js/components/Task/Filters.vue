<template>
	<b-form>
		<div class="row">
			<div class="col-md-2">
				<b-form-group
					id="task_cod_group"
					label="Código"
					label-for="task_cod"
					label-class="required"
				>
					<b-form-input
						id="task_cod"
						v-model="form.cod"
						placeholder="Digite todo ou parte do código"
					></b-form-input>
				</b-form-group>
			</div>
			<div class="col-md-4">
				<b-form-group
					id="task_title_group"
					label="Título"
					label-for="task_title"
					label-class="required"
				>
					<b-form-input
						id="task_title"
						v-model="form.title"
						placeholder="Digite todo ou parte do título"
					></b-form-input>
				</b-form-group>
			</div>
			<div class="col-md-3">
				<b-form-group
					id="task_created_group"
					label="Data de cadastro"
					label-for="task_created"
					label-class="required"
				>
					<b-form-datepicker
						id="task_created"
						v-model="form.created"
						:date-format-options="{ day: 'numeric', month: 'numeric', year: 'numeric' }"
						placeholder="Nenhuma data selecionada"
						locale="pt-BR"
					></b-form-datepicker>
				</b-form-group>
			</div>
			<div class="col-md-3">
				<b-form-group
					id="task_status_group"
					label="Status"
					label-for="task_status"
					label-class="required"
				>
					<b-form-select
						id="task_status"
						v-model="form.status"
						:options="statusOptions"
					></b-form-select>
				</b-form-group>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-12">
				<b-button
					@click="$emit('filter', form)"
					variant="primary"
					v-b-toggle.filters-collapse
					class="float-right"
					><i class="fas fa-search"></i> Filtrar
				</b-button>
				<b-button
					@click="cleanFilters"
					variant="link"
					>Limpar filtros
				</b-button>
			</div>
		</div>
	</b-form>
</template>

<script>
const initialState = () => {
    return {
        form: {
            cod: "",
            title: "",
            created: "",
            status: null,
		},
		statusOptions: [
			{ value: null, text: 'Selecione um status' },
			{ value: 1, text: 'Ativa' },
			{ value: 2, text: 'Concluída' },
			{ value: 3, text: 'Arquivada' },
		]
    };
};

export default {
    data() {
        return initialState();
	},
	mounted() {
		this.form.created = this.todayAsDatepickerFormat();
	},
    methods: {
		cleanFilters() {
            Object.assign(this.$data, initialState());
        },
    },
};
</script>