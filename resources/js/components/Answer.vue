<template>
    <div class="media post">
                        
        <vote :model="answer" name="answer"></vote>

        <div class="media-body">
            <form v-if="editing" @submit.prevent="update">
                <div class="form-group">
                    <textarea class="form-control" v-model="body" rows="7"></textarea>
                </div>
                <button type="submit" class="btn btn-sm btn-outline-info mt-2" :disabled="isInvalid">Update</button>
                <button type="button" @click="cancel" class="btn btn-sm btn-outline-default mt-2">Cancel</button>
            </form>
            <div v-else>
                <div v-html="bodyHtml"></div>

                <div class="row">
                    <div class="col-4">
                        
                        <a v-if="authorize('modify', answer)" @click.prevent="edit" class="btn btn-sm btn-outline-info">Edit</a>
                        <button v-if="authorize('modify', answer)" type="button" @click="destroy" class="btn btn-sm btn-outline-danger">Delete</button>
                        
                    </div>
        
                    <div class="col-4 offset-4 align-content-end">
                        <user-info :model="answer" label="Answered"></user-info>
                    </div>

                </div>    
            </div>
            
        </div>
    </div>
</template>

<script>

import Vote from './Vote.vue';
import UserInfo from './UserInfo.vue';
import modifications from '../mixins/modifications.js'

export default {
    props: ['answer'],

    mixins: [modifications],

    data () {
        return {
            // editing: false,
            body: this.answer.body,
            bodyHtml: this.answer.body_html,
            id: this.answer.id,
            questionId: this.answer.question_id,
            beforeEditCache: null
        }
    },

    components: {
        Vote,
        UserInfo,
    },

    computed: {
        isInvalid() {
            return this.body.length < 10
        },

        endpoint() {
            return `/questions/${this.questionId}/answers/${this.id}`
        },
    },

    methods: {
        setEditCache() {
            this.beforeEditCache = this.body
        },

        restoreEditCache() {
            this.body = this.beforeEditCache
        },

        payload() {
            return {
                body: this.body 
            }
        },

        delete() {
            axios.delete(this.endpoint)
            .then(response => {
                this.$toast.success(response.data.message, 'Success', { timeout: 3000, position: 'topRight' })
                this.$emit('deleted')
            })
        }
    }
}
</script>