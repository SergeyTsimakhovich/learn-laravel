<template>
    <div>
        
        <a v-if="canAccept" title="Mark this answer as best answer" :class="classes" @click.prevent="accept">
            <i class="fas fa-check fa-2x"></i>
        </a>
        
        <a v-if="accepted" title="Author this question accept this answer as best answer" :class="classes">
            <i class="fas fa-check fa-2x"></i>
        </a>
        
    </div>
</template>

<script>

import EventBus from '../event-bus';

export default {
    props: ['answer'],

    data () {
        return {
            status: this.answer.status,
            id: this.answer.id,
            isBest: this.answer.is_best
        }
    },

    created () {
        EventBus.$on('accepted', id => {
            this.isBest = (id === this.id)
        })
    },

    computed: {
        endpoint() {
            return `/answers/${this.id}/accept`
        },

        canAccept() {
            return this.authorize('accept', this.answer)
        },

        accepted() { 
            return !this.canAccept && this.isBest
        },

        classes() {
            return [
                'mt-2',
                this.isBest ? 'vote-accepted' : ''
            ]
        }
    },

    methods: {
        accept() {
            axios.post(this.endpoint)
            .then(response => {
                this.isBest = true
                EventBus.$emit('accepted', this.id)
            })
            .catch(error => {
                this.$toast.error(error.response.data.message, 'Error', { 
                    timeout: 3000, 
                    position: 'topRight' 
                })
            })
        }
    }
}
</script>