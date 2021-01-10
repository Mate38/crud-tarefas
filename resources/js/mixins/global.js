Vue.mixin({
	methods: {
		makeToast(title = '', content = '', variant) {
			this.$bvToast.toast(content, {
			  title: title,
			  variant: variant,
			  solid: true
			})
		}
	}
})