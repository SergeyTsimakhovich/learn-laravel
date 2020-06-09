<template>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3>Your Answer</h3>
                    </div>
                    <hr>
                    <form @submit.prevent="create">
                        <div class="form-group">
                            <textarea v-model="body" class="form-control" name="body" required rows="7"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" :disabled="isInvalid" class="btn btn-lg btn-outline-primary">
                                <spinner :small="true" v-if="$root.loading" :min-width="59.22"></spinner>
                                <span v-else>Submit</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['questionId'],

    data () {
        return {
            body: ''
        }
    },

    computed: {
        isInvalid () {
            return !this.signedIn || this.body.length < 10
        },

        endpoint() {
            return `/questions/${this.questionId}/answers`
        }
    },

    methods: {
        create() {
            axios.post(this.endpoint, {
                body: this.body
            })
            .then(({data}) => {
                this.$toast.success(data.message, 'Success', { timeout: 3000, position: 'topRight' })
                this.body = ''
                this.$emit('created', data.answer)
            })
            .catch(error => {
                this.$toast.error(error.response.data.message, 'Error', { timeout: 3000, position: 'topRight' })
            })
        }
    }
}
</script>