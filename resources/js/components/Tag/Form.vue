<template>
    <b-modal
        id="new-tag-modal"
        title="Cadastrar categoria"
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
                id="tag_cod_group"
                label="Código identificador"
                label-for="tag_cod"
                label-class="required"
            >
                <b-form-input
                    id="tag_cod"
                    v-model="$v.form.cod.$model"
                    :state="validateState('cod')"
                ></b-form-input>
            </b-form-group>

            <b-form-group
                id="tag_title_group"
                label="Título"
                label-for="tag_title"
                label-class="required"
            >
                <b-form-input
                    id="tag_title"
                    v-model="$v.form.title.$model"
                    :state="validateState('title')"
                ></b-form-input>
            </b-form-group>

            <b-form-group
                id="tag_description_group"
                label="Descrição"
                label-for="tag_description"
            >
                <b-form-textarea
                    id="tag_description"
                    v-model="$v.form.description.$model"
                    :state="validateState('description')"
                    rows="3"
                ></b-form-textarea>
            </b-form-group>
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
        },
        loading: false,
    };
};

export default {
    props: {
        tagId: {
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
            if(this.tagId) {
                this.getTag(this.tagId);
            }
        },
        closeModal() {
            this.$emit('setTagId', null);
            this.$nextTick(() => {
                this.$bvModal.hide("new-tag-modal");
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

            let url = '/api/tag/save';
            if(this.tagId) {
                url += '/'+this.tagId;
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
        getTag(id) {
            this.loading = true;
            axios.get('/api/tag/'+id)
				.then(res => {
                    let tagData = res.data.data;
                    this.form.cod = tagData.cod;
                    this.form.title = tagData.title;
                    this.form.description = tagData.description;
                    this.loading = false;
				}).catch(err => {
					this.makeToast('Erro!', 'Houve um problema ao tentar carregar os dados!', 'danger');
				})
        }
    },
};
</script>