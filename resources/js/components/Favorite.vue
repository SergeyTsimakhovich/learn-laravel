<template>
    <div>
        <a title="Click to mark as favorite question (Click again to undo)" 
            :class="classes" @click.prevent="toggle">
            <i class="fas fa-star fa-2x"></i>
            <span class="favorites-count">{{ count }}</span>
        </a>
    </div>
</template>

<script>
export default {
    props: ['question'],

    data () {
        return {
            isFavorited: this.question.is_favorited,
            count: this.question.favorites_count,
        }
    },

    computed: {
        classes() {
            return [
                'favorite', 'mt-2', !this.signedIn ? 'off' : this.isFavorited
            ]
        },

        endpoint() {
            return `/questions/${this.question.id}/favorites`
        },

        // signedIn() {
        //     return window.Auth.signedIn
        // }
    },

    methods: {
        toggle() {
            if (this.signedIn) {
                this.isFavorited ? this.destroy() : this.store()
            } else {
                this.$toast.warning('Please login to favorite this questions', 'Warning', { timeout: 3000, position: 'topRight' })
            }
        },

        store() {
            axios.post(this.endpoint)
            .then(respone => {
                this.count++
                this.isFavorited = 'favorited'
            })
            .catch(error => {
                this.$toast.error(error.response.data.message, 'Error', { timeout: 3000, position: 'topRight' })
            })
        },

        destroy() {
            axios.delete(this.endpoint)
            .then(respone => {
                this.count--
                this.isFavorited = ''
            })
            .catch(error => {
                this.$toast.error(error.response.data.message, 'Error', { timeout: 3000, position: 'topRight' })
            })
        }
    }
}
</script>