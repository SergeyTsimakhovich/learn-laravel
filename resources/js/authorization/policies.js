export default {
    modify (user, model) {
        return user.id === model.user.id;
    },

    deleteQuestion (user, model) {
        return user.id === model.user.id && model.answers_count < 1;
    },

    accept (user, answer) {
        return user.id === answer.question_user_id;
    }
}