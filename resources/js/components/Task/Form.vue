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

            <div class="row">
                <div class="col-5">
                    <b-form-group
                        id="task_tags_select_group"
                        label="Categorias"
                        label-for="task_tags_select"
                    >
                        <b-form-select
                            id="task_tags_select"
                            v-model="selectTags"
                            :options="tagsOptions"
                            multiple
                        ></b-form-select>
                    </b-form-group>
                </div>
                <div class="col-2" >
                    <div class="row btn_select_tag">
                        <b-button
                            @click="selectTagsMethod"
                            variant="outline-primary"
                            ><i class="fas fa-arrow-right"></i>
                        </b-button>
                    </div>
                    <div class="row btn_deselect_tag">
                        <b-button
                            @click="deselectTagsMethod"
                            variant="outline-primary"
                            ><i class="fas fa-arrow-left"></i>
                        </b-button>
                    </div>
                </div>
                <div class="col-5">
                    <b-form-group
                        id="task_tags_deselect_group"
                        label="Selecionadas"
                        label-for="task_tags_deselect"
                    >
                        <b-form-select
                            id="task_tags_deselect"
                            v-model="deselectTags"
                            :options="selectedTagsOptions"
                            multiple
                        ></b-form-select>
                    </b-form-group>
                </div> 
            </div>

        </b-form>
    </b-modal>
</template>

<script>
import { required, minLength, maxLength } from "vuelidate/lib/validators";

const initialState = () => {
    return {
        form: {
            cod: "",
            title: "",
            description: "",
            tags: []
        },
        loading: false,
        tagsOptions: [],
        selectedTagsOptions: [],
        selectTags: [],
        deselectTags: []
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
				minLength: minLength(3),
				maxLength: maxLength(20),
            },
            title: {
				required,
				minLength: minLength(3),
				maxLength: maxLength(50),
            },
            description: {
				maxLength: maxLength(100),
			}
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
            this.getTagsOptions();
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

            this.form.tags = this.selectedTagsOptions.map(tag => {
                return tag.value;
            })

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

                    this.selectTags = taskData.tags.map(tag => {
                        return tag.value;
                    });
                    this.selectTagsMethod();

                    this.loading = false;
				}).catch(err => {
					this.makeToast('Erro!', 'Houve um problema ao tentar carregar os dados!', 'danger');
				})
        },
        async getTagsOptions() {
            await axios.get('/api/tag/options')
				.then(res => {
                    this.tagsOptions = res.data.data;
				}).catch(err => {
					this.makeToast('Erro!', 'Houve um problema ao tentar retornar as categorias', 'danger');
				})
        },
        selectTagsMethod() {
            this.selectedTagsOptions.push(...this.tagsOptions.filter(tag => {
                return this.selectTags.includes(tag.value);
            }))
            this.tagsOptions = this.tagsOptions.filter(tag => {
                return !this.selectTags.includes(tag.value);
            })
        },
        deselectTagsMethod() {
            this.tagsOptions.push(...this.selectedTagsOptions.filter(tag => {
                return this.deselectTags.includes(tag.value);
            }))
            this.selectedTagsOptions = this.selectedTagsOptions.filter(tag => {
                return !this.deselectTags.includes(tag.value);
            })
        }
    },
};
</script>

<style scoped>
    .btn_select_tag {
        padding-top: 35px;
        justify-content: space-around;
    }
    .btn_deselect_tag {
        padding-top: 15px;
        justify-content: space-around;
    }
</style>