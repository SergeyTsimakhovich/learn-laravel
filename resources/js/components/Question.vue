<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <div class="d-flex align-items-center">
                            <h1>{{ title }}</h1>
                            <div class="ml-auto">
                                <router-link :to="{name:'questions'}" class="btn btn-outline-secondary">Back to all Questions</router-link>
                            </div>
                        </div>
                    </div>

                    <hr>
    
                    <div class="media">

                        <vote :model="question" name="question"></vote>
                        
                        <div class="media-body">

                             <form v-if="editing" @submit.prevent="update">
                                <div class="form-group">
                                    <input type="text" class="form-control" v-model="title">
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" v-model="body" rows="7"></textarea>
                                </div>
                                <button type="submit" class="btn btn-sm btn-outline-info mt-2" :disabled="isInvalid">Update</button>
                                <button type="button" @click="cancel" class="btn btn-sm btn-outline-default mt-2">Cancel</button>
                            </form>

                            <div v-else>
                                <div v-html="bodyHtml"></div>
                                
                                <div class="col-4">
                                    <a v-if="authorize('modify', question)" @click.prevent="edit" class="btn btn-sm btn-outline-info">Edit</a>
                                    <button v-if="authorize('deleteQuestion', question)" type="button" @click="destroy" class="btn btn-sm btn-outline-danger">Delete</button>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-4 offset-4 align-content-end">
                                        <user-info :model="question" label="Asked"></user-info>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
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
import EventBus from '../event-bus';

export default {
    props: ['question'],

    mixins: [modifications],

    data () {
        return {
            // editing: false,
            title: this.question.title,
            body: this.question.body,
            bodyHtml: this.question.body_html,
            id: this.question.id,
            beforeEditCache: {}
        }
    },

    components: {
        Vote,
        UserInfo,
    },

    mounted () {
        EventBus.$on('answers-count-changed', (count) => {
            this.question.answers_count = count;
        })
    },

    computed: {
        isInvalid() {
            return this.body.length < 10 || this.title.length < 10
        },

        endpoint() {
            return `/questions/${this.id}`
        },
    },

    methods: {
        setEditCache() {
            this.beforeEditCache = {
                body: this.body,
                title: this.title
            }
        },

        restoreEditCache() {
            this.body = this.beforeEditCache.body
            this.title = this.beforeEditCache.title
        },

        payload() {
            return {
                body: this.body,
                title: this.title
            }
        },

        delete() {
            axios.delete(this.endpoint)
            .then(({data}) => {
                this.$toast.success(data.message, 'Success', { timeout: 3000, position: 'topRight' })
                this.$router.push({ name: 'questions' });
            })
            .catch(error => {
                this.$toast.error(error.response.data.message, 'Error', { timeout: 3000, position: 'topRight' })
            })
        }
    }
}
</script>