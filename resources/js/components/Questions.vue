<template>
    <div>
        <div class="card-body">

            <spinner v-if="$root.loading"></spinner>

            <div v-else-if="questions.length">
                <question-excerpt @deleted="remove(index)" v-for="(question, index) in questions" :question="question" :key="question.id"></question-excerpt>
            </div>

            <div v-else class="alert alert-warning">
                <strong>Sorry</strong> There are no question avaliable :(
            </div>

        </div>

        <div class="card-footer">
            <pagination :meta="meta" :links="links"></pagination>
        </div>
    </div>
</template>

<script>

import QuestionExcerpt from './QuestionExcerpt.vue';
import Pagination from './Pagination.vue';

export default {
     data() {
        return {
            questions: [],
            meta: {},
            links: {},
        }
    },

    components: {
        QuestionExcerpt,
        Pagination
    },

    mounted () {
        this.fetchQuestions()
    },

    methods: {
        fetchQuestions() {
            axios.get(`/questions`, { params: this.$route.query })
            .then(({data}) => {
                this.questions = data.data
                this.meta = data.meta
                this.links = data.links
            })
        },

        remove (index) {
            this.questions.splice(index, 1)
           // this.count--
        }
    },

    watch: {
        "$route": 'fetchQuestions'
    },
}
</script>