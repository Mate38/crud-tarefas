Vue.mixin({
	methods: {
		makeToast(title = '', content = '', variant) {
			this.$bvToast.toast(content, {
			  title: title,
			  variant: variant,
			  solid: true
			})
		},
		todayAsDatepickerFormat() {
			const now = new Date().toLocaleDateString();
			date = now.split(/\D/);
    		return date.reverse().join('-');
		}
	}
})