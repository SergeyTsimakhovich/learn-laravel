<template>
    <div class="d-flex flex-column vote-controls">
       <a :title="title('up')" @click.prevent="vote(1)" class="vote-up" :class="classes">
            <i class="fas fa-caret-up fa-3x"></i>
        </a>

        <span class="votes-count">
            {{ count }}
        </span>

        <a :title="title('down')" @click.prevent="vote(-1)" class="vote-down" :class="classes">
            <i class="fas fa-caret-down fa-3x"></i>
        </a>
 
        <favorite v-if="name === 'question'" :question="model"></favorite>
        <accept v-if="name === 'answer'" :answer="model"></accept>
       
    </div>
</template>

<script>

import Favorite from './Favorite.vue';
import Accept from './Accept.vue';

export default {
    props: ['model', 'name'],

    data() {
        return {
            count: this.model.votes_count ?? 0,
            id: this.model.id
        }
    },

    components: {
        Favorite,
        Accept,
    },

    computed: {
        classes () {
            return [
                !this.signedIn ? 'off' : ''
            ]
        },

        endpoint () {
            return `/${this.name}s/${this.id}/vote`
        }
    },

    methods: {
        title(type) {
            let titles = {
                up: `This ${this.name} is useful`,
                down: `This ${this.name} is not useful`,
            }  

            return titles[type]
        },

        vote(value) {
            if (this.signedIn) {
                axios.post(this.endpoint, {
                    vote: value
                })
                .then(response => {
                    this.count = response.data.votesCount;
                })
                .catch(error => {
                    this.$toast.error(error.response.data.message, 'Error', { timeout: 3000, position: 'topRight' })
                })
            } else {
                this.$toast.warning(`Please login to vote this ${this.name}`, 'Warning', { timeout: 3000, position: 'topRight' })
            }
        }
    }
}
</script>