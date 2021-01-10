<template>
    <b-modal
        id="new-task-modal"
        title="Cadastrar tarefa"
        @show="resetModal"
        @hidden="closeModal"
        @ok="handleOk"
        ok-title="Salvar"
        cancel-title="Cancelar"
    >
        <div v-show="loading" class="text-center text-primary my-2">
            <b-spinner class="align-middle"></b-spinner>
            <strong>Carregando...</strong>
        </div>
        <b-form v-show="!loading">
            <b-form-group
                id="task_cod_group"
                label="Código identificador"
                label-for="task_cod"
                label-class="required"
            >
                <b-form-input
                    id="task_cod"
                    v-model="$v.form.cod.$model"
                    :state="validateState('cod')"
                ></b-form-input>
            </b-form-group>

            <b-form-group
                id="task_title_group"
                label="Título"
                label-for="task_title"
                label-class="required"
            >
                <b-form-input
                    id="task_title"
                    v-model="$v.form.title.$model"
                    :state="validateState('title')"
                ></b-form-input>
            </b-form-group>

            <b-form-group
                id="task_description_group"
                label="Descrição"
                label-for="task_description"
            >
                <b-form-textarea
                    id="task_description"
                    v-model="$v.form.description.$model"
                    :state="validateState('description')"
                    rows="3"
                ></b-form-textarea>
            </b-form-group>
        </b-form>
    </b-modal>
</template>

<script>
import { required } from "vuelidate/lib/validators";

const initialState = () => {
    return {
        form: {
            cod: "",
            title: "",
            description: "",
        },
        loading: false,
    };
};

export default {
    props: {
        taskId: {
            type: Number
        },
    },
    data() {
        return initialState();
    },
    validations: {
        form: {
            cod: {
                required,
            },
            title: {
                required,
            },
            description: {}
        },
    },
    methods: {
        validateState(name) {
            const { $dirty, $error } = this.$v.form[name];
            return $dirty ? !$error : null;
        },
        resetModal() {
            Object.assign(this.$data, initialState());
            this.$v.$reset();
            if(this.taskId) {
                this.getTask(this.taskId);
            }
        },
        closeModal() {
            this.$emit('setTaskId', null);
            this.$nextTick(() => {
                this.$bvModal.hide("new-task-modal");
            });
        },
        handleOk(bvModalEvt) {
            bvModalEvt.preventDefault();
            this.handleSubmit();
        },
        handleSubmit() {
            this.$v.$touch();

            if (this.$v.$invalid) {
                return;
            }

            let url = '/api/task/save';
            if(this.taskId) {
                url += '/'+this.taskId;
            }

            axios.post(url, this.form)
                .then(res => {
                    this.$emit('reloadTable');
                    this.makeToast('Sucesso!', 'Dados salvos com sucesso!', 'success');
                    this.closeModal();
                }).catch(err => {
                    this.makeToast('Erro! '+err.response.status, err.response.data.message, 'danger');
                })
        },
        getTask(id) {
            this.loading = true;
            axios.get('/api/task/'+id)
				.then(res => {
                    let taskData = res.data.data;
                    this.form.cod = taskData.cod;
                    this.form.title = taskData.title;
                    this.form.description = taskData.description;
                    this.loading = false;
				}).catch(err => {
					this.makeToast('Erro!', 'Houve um problema ao tentar carregar os dados!', 'danger');
				})
        }
    },
};
</script>