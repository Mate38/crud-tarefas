<template>
  <b-modal
    id="new-task-modal"
    title="Cadastrar tarefa"
    @show="resetModal"
    @hidden="resetModal"
    @ok="handleOk"
  >
    <b-form v-if="show">
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
        <b-form-input
          id="task_description"
          v-model="form.description"
        ></b-form-input>
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
		show: true,
	}
};

export default {
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
    },
  },
  methods: {
    validateState(name) {
      const { $dirty, $error } = this.$v.form[name];
      return $dirty ? !$error : null;
    },
    checkFormValidity() {
      const valid = this.$refs.form.checkValidity();
      this.nameState = valid;
      return valid;
    },
    resetModal() {
	  Object.assign(this.$data, initialState());
	  this.$v.$reset();
    },
    handleOk(bvModalEvt) {
      // Prevent modal from closing
      bvModalEvt.preventDefault();
      // Trigger submit handler
      this.handleSubmit();
    },
    handleSubmit() {
		this.$v.$touch();
		if (this.$v.$invalid) {
			alert("ERROR");
			return;
		} 
		
		alert("OK");
      

      //   // Exit when the form isn't valid
      //   if (!this.checkFormValidity()) {
      //     return;
      //   }
      //   // Push the name to submitted names
      //   this.submittedNames.push(this.name);
      //   // Hide the modal manually
      //   this.$nextTick(() => {
      //     this.$bvModal.hide("modal-prevent-closing");
      //   });
    },
  },
};
</script>