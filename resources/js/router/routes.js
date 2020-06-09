import NotFoundPage from '../pages/NotFoundPage.vue';

import QuestionsPage from '../pages/QuestionsPage.vue';
import QuestionPage from '../pages/QuestionPage.vue';
import MyPostsPage from '../pages/MyPostsPage.vue';
import QuestionCreatePage from '../pages/QuestionCreatePage.vue';
import QuestionEditPage from '../pages/QuestionEditPage.vue';


const routes = [
    {
        path: '/',
        component: QuestionsPage,
        name: 'home'
    },
    {
        path: '/questions',
        component: QuestionsPage,
        name: 'questions'
    },
    {
        path: '/questions/create',
        component: QuestionCreatePage,
        name: 'questions.create'
    },
    {
        path: '/questions/:id/edit',
        component: QuestionEditPage,
        name: 'questions.edit'
    },
    {
        path: '/my-posts',
        component: MyPostsPage,
        name: 'my-posts',
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/questions/:slug',
        component: QuestionPage,
        name: 'questions.show',
        props: true
    },
    

    {
        path: '*',
        component: NotFoundPage,
        name: 'questions.show'
    },
]

export default routes