import TasksList from './components/Task/List.vue';
import TagsList from './components/Tag/List.vue';

export const routes = [
    {
        name: '',
        path: '/home',
        component: TasksList
    },
    {
        name: 'tasks',
        path: '/tasks',
        component: TasksList
    },
    {
        name: 'tags',
        path: '/tags',
        component: TagsList
    }
];