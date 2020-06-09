<template>
    <div>
        <form @submit.prevent="handleSubmit">
            <div class="form-group">
                <label for="question-title">Question Title</label>
                <input type="text" v-model="title" id="question-title" :class="errorClass('title')">

                <div v-if="showError('title')" class="invalid-feedback">
                    <strong>{{ errors['title'][0] }}</strong>
                </div>
                
            </div>
            <div class="form-group">
                <label for="question-body">Explain you question</label>
                <textarea v-model="body" id="question-body" rows="6" :class="errorClass('body')"></textarea>
                
                <div v-if="showError('body')" class="invalid-feedback">
                    <strong>{{ errors['body'][0] }}</strong>
                </div>
               
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-outline-primary btn-lg">
                    <spinner :small="true" v-if="$root.loading"></spinner>
                    <span v-else>{{ buttonText }}</span>
                </button>
            </div>
        </form>
    </div>
</template>

<script>

import EventBus from '../event-bus';

export default {
    props: {
        isEdit: {
            type: Boolean,
            default: false
        }
    },

    data () {
        return {
            title: '',
            body: '',
            errors: {
                title: [],
                body: []
            }
        }
    },

    computed: {
        buttonText () {
            return this.isEdit ? 'Update Question' : 'Ask Question'
        }
    },

    mounted() {
        EventBus.$on('error', errors => console.log(this.errors = errors))

        if (this.isEdit) {
            this.fetchQuestion();
        }
    },

    methods: {
        handleSubmit() {
            this.$emit('submitted', {
                title: this.title,
                body: this.body
            })
        },

        fetchQuestion () {
            axios.get(`/questions/${this.$route.params.id}`)
            .then(({ data }) => {
                this.title = data.title
                this.body = data.body
            })
            .catch(error => {
                //console.log(error.response);
            })
        },

        showError(column) {
            return this.errors[column] ? this.errors[column][0] : false
        },

        errorClass(column) {
            return [
                'form-control',
                this.errors[column] && this.errors[column][0] ? 'is-invalid' : ''
            ]
        }
    }
}
</script>