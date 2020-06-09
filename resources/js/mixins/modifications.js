import destroy from './destroy';

export default {
    data () {
        return {
            editing: false
        }
    },

    mixins: [destroy],

    methods: {
        edit() {
            this.setEditCache();
            this.editing = true
        },

        cancel() {
            this.restoreFromCache();
            this.editing = false
        },

        setEditCache () {},

        restoreFromCache () {},

        update() {
            axios.put(this.endpoint, this.payload())
            .then(({data}) => {
                
                this.bodyHtml = data.body_html

                this.editing = false
                this.$toast.success(data.message, 'Success', { timeout: 3000, position: 'topRight' })
            })
            .catch(error => {
                this.$toast.error(error.response.data.message, 'Error', { timeout: 3000, position: 'topRight' })
            })
        },

        payload () {},

    },
}