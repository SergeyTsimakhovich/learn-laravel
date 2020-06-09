<template>
    <div class="container">

        <question :question="question" v-if="question.id"></question>

        <answers :question="question" v-if="question.id"></answers>

    </div>
</template>

<script>

import Question from '../components/Question';
import Answers from '../components/Answers';

export default {
    props: ['slug'],

    data() {
        return {
            question: {}
        }
    },

    components: {
        Question,
        Answers,
    },

    mounted () {
        this.fetchQuestion()
    },

    methods: {
        fetchQuestion() {
            axios.get(`/questions/${this.slug}`)
                .then(({ data }) => {
                    this.question = data.data
                })
                .catch(error => {
                    console.log(error)
                })
        }
    }
}
</script>