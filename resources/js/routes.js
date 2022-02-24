export const routes = [
    {
        path: '/users',
        component: require('./components/users/index.vue').default
    },
    {
        path: '/profile/:id',
        component: require('./components/users/profile.vue').default
    }, {
        path: '/profile/:id/edit',
        component: require('./components/users/editprofile.vue').default
    },
    {
        path: '/payments/:user_id',
        component: require('./components/transactions/index.vue').default
    }
];
